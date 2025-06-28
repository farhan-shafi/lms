<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Create a new announcement
     * 
     * @param array $data
     * @return int|bool The inserted ID or FALSE on failure
     */
    public function create_announcement($data) {
        $this->db->insert('announcements', $data);
        return $this->db->insert_id() ?: FALSE;
    }
    
    /**
     * Get announcement by ID
     * 
     * @param int $announcement_id
     * @return array
     */
    public function get_announcement_by_id($announcement_id) {
        $this->db->where('id', $announcement_id);
        $query = $this->db->get('announcements');
        return $query->row_array();
    }
    
    /**
     * Get announcements for a course
     * 
     * @param int $course_id
     * @param int $limit Optional limit
     * @return array
     */
    public function get_announcements_by_course($course_id, $limit = NULL) {
        $this->db->select('a.*, u.name as instructor_name, u.profile_image');
        $this->db->from('announcements a');
        $this->db->join('users u', 'a.user_id = u.id');
        $this->db->where('a.course_id', $course_id);
        $this->db->order_by('a.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Update an announcement
     * 
     * @param int $announcement_id
     * @param array $data
     * @return bool
     */
    public function update_announcement($announcement_id, $data) {
        $this->db->where('id', $announcement_id);
        return $this->db->update('announcements', $data);
    }
    
    /**
     * Delete an announcement
     * 
     * @param int $announcement_id
     * @return bool
     */
    public function delete_announcement($announcement_id) {
        $this->db->where('id', $announcement_id);
        return $this->db->delete('announcements');
    }
    
    /**
     * Get recent announcements for a student
     * 
     * @param int $user_id
     * @param int $limit
     * @return array
     */
    public function get_recent_announcements_for_student($user_id, $limit = 5) {
        // Get courses the student is enrolled in
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
        
        // Get announcements for these courses
        $this->db->select('a.*, u.name as instructor_name, c.title as course_title');
        $this->db->from('announcements a');
        $this->db->join('users u', 'a.user_id = u.id');
        $this->db->join('courses c', 'a.course_id = c.id');
        $this->db->where_in('a.course_id', $course_ids);
        $this->db->order_by('a.created_at', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Count announcements for a course
     * 
     * @param int $course_id
     * @return int
     */
    public function count_announcements($course_id) {
        $this->db->where('course_id', $course_id);
        return $this->db->count_all_results('announcements');
    }
}
