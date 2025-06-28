<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussion_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all discussions for a course
     * 
     * @param int $course_id
     * @return array
     */
    public function get_discussions_by_course($course_id) {
        $this->db->select('d.*, u.name as user_name, u.profile_image, COUNT(dr.id) as reply_count');
        $this->db->from('discussions d');
        $this->db->join('users u', 'd.user_id = u.id');
        $this->db->join('discussion_replies dr', 'd.id = dr.discussion_id', 'left');
        $this->db->where('d.course_id', $course_id);
        $this->db->where('d.status !=', 'hidden');
        $this->db->group_by('d.id');
        $this->db->order_by('d.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get a discussion by ID
     * 
     * @param int $discussion_id
     * @return array
     */
    public function get_discussion_by_id($discussion_id) {
        $this->db->select('d.*, u.name as user_name, u.profile_image');
        $this->db->from('discussions d');
        $this->db->join('users u', 'd.user_id = u.id');
        $this->db->where('d.id', $discussion_id);
        
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /**
     * Create a new discussion
     * 
     * @param array $data
     * @return int|bool The inserted ID or FALSE on failure
     */
    public function create_discussion($data) {
        $this->db->insert('discussions', $data);
        return $this->db->insert_id() ?: FALSE;
    }
    
    /**
     * Update a discussion
     * 
     * @param int $discussion_id
     * @param array $data
     * @return bool
     */
    public function update_discussion($discussion_id, $data) {
        $this->db->where('id', $discussion_id);
        return $this->db->update('discussions', $data);
    }
    
    /**
     * Get replies for a discussion
     * 
     * @param int $discussion_id
     * @return array
     */
    public function get_replies_by_discussion($discussion_id) {
        $this->db->select('dr.*, u.name as user_name, u.profile_image, u.role as user_role');
        $this->db->from('discussion_replies dr');
        $this->db->join('users u', 'dr.user_id = u.id');
        $this->db->where('dr.discussion_id', $discussion_id);
        $this->db->order_by('dr.created_at', 'ASC');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Create a new reply
     * 
     * @param array $data
     * @return bool
     */
    public function create_reply($data) {
        return $this->db->insert('discussion_replies', $data);
    }
    
    /**
     * Mark a reply as the solution
     * 
     * @param int $reply_id
     * @return bool
     */
    public function mark_as_solution($reply_id) {
        // Get the discussion ID for this reply
        $reply = $this->db->get_where('discussion_replies', ['id' => $reply_id])->row_array();
        if (!$reply) {
            return false;
        }
        
        $discussion_id = $reply['discussion_id'];
        
        // Reset all other solutions for this discussion
        $this->db->where('discussion_id', $discussion_id);
        $this->db->update('discussion_replies', ['is_solution' => 0]);
        
        // Mark this reply as the solution
        $this->db->where('id', $reply_id);
        $result = $this->db->update('discussion_replies', ['is_solution' => 1]);
        
        // Update discussion status to indicate it has a solution
        if ($result) {
            $this->db->where('id', $discussion_id);
            $this->db->update('discussions', ['has_solution' => 1]);
        }
        
        return $result;
    }
    
    /**
     * Get recent discussions for a user
     * 
     * @param int $user_id
     * @param int $limit
     * @return array
     */
    public function get_recent_discussions_for_user($user_id, $limit = 5) {
        // Get courses the user is enrolled in
        $this->db->select('course_id');
        $this->db->from('enrollments');
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'active');
        $query = $this->db->get();
        $enrollments = $query->result_array();
        
        if (empty($enrollments)) {
            return [];
        }
        
        // Extract course IDs
        $course_ids = array_column($enrollments, 'course_id');
        
        // Get discussions for these courses
        $this->db->select('d.*, u.name as user_name, c.title as course_title');
        $this->db->from('discussions d');
        $this->db->join('users u', 'd.user_id = u.id');
        $this->db->join('courses c', 'd.course_id = c.id');
        $this->db->where_in('d.course_id', $course_ids);
        $this->db->where('d.status', 'active');
        $this->db->order_by('d.created_at', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get count of unresolved discussions for a course
     * 
     * @param int $course_id
     * @return int
     */
    public function count_unresolved_discussions($course_id) {
        $this->db->where('course_id', $course_id);
        $this->db->where('status', 'active');
        $this->db->where('has_solution', 0);
        return $this->db->count_all_results('discussions');
    }
}
