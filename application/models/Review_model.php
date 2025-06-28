<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Create a new review
     * 
     * @param array $data
     * @return bool
     */
    public function create_review($data) {
        return $this->db->insert('course_reviews', $data);
    }
    
    /**
     * Get reviews for a course
     * 
     * @param int $course_id
     * @param string $status Filter by status (approved, pending, rejected)
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get_course_reviews($course_id, $status = 'approved', $limit = NULL, $offset = NULL) {
        $this->db->select('cr.*, u.name, u.profile_image');
        $this->db->from('course_reviews cr');
        $this->db->join('users u', 'cr.user_id = u.id');
        $this->db->where('cr.course_id', $course_id);
        
        if ($status) {
            $this->db->where('cr.status', $status);
        }
        
        $this->db->order_by('cr.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get a review by ID
     * 
     * @param int $review_id
     * @return array
     */
    public function get_review_by_id($review_id) {
        $this->db->where('id', $review_id);
        $query = $this->db->get('course_reviews');
        return $query->row_array();
    }
    
    /**
     * Check if user has already reviewed a course
     * 
     * @param int $user_id
     * @param int $course_id
     * @return bool
     */
    public function has_user_reviewed($user_id, $course_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $query = $this->db->get('course_reviews');
        return $query->num_rows() > 0;
    }
    
    /**
     * Get a user's review for a course
     * 
     * @param int $user_id
     * @param int $course_id
     * @return array
     */
    public function get_user_review($user_id, $course_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $query = $this->db->get('course_reviews');
        return $query->row_array();
    }
    
    /**
     * Update a review
     * 
     * @param int $review_id
     * @param array $data
     * @return bool
     */
    public function update_review($review_id, $data) {
        $this->db->where('id', $review_id);
        return $this->db->update('course_reviews', $data);
    }
    
    /**
     * Delete a review
     * 
     * @param int $review_id
     * @return bool
     */
    public function delete_review($review_id) {
        $this->db->where('id', $review_id);
        return $this->db->delete('course_reviews');
    }
    
    /**
     * Get average rating for a course
     * 
     * @param int $course_id
     * @return float
     */
    public function get_average_rating($course_id) {
        $this->db->select_avg('rating');
        $this->db->where('course_id', $course_id);
        $this->db->where('status', 'approved');
        $query = $this->db->get('course_reviews');
        $result = $query->row_array();
        return round($result['rating'] ?? 0, 1);
    }
    
    /**
     * Count reviews for a course
     * 
     * @param int $course_id
     * @param string $status Filter by status
     * @return int
     */
    public function count_reviews($course_id, $status = NULL) {
        $this->db->where('course_id', $course_id);
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        return $this->db->count_all_results('course_reviews');
    }
    
    /**
     * Get rating distribution for a course
     * 
     * @param int $course_id
     * @return array
     */
    public function get_rating_distribution($course_id) {
        $distribution = [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0
        ];
        
        $this->db->select('rating, COUNT(*) as count');
        $this->db->where('course_id', $course_id);
        $this->db->where('status', 'approved');
        $this->db->group_by('rating');
        $query = $this->db->get('course_reviews');
        $results = $query->result_array();
        
        foreach ($results as $row) {
            $distribution[$row['rating']] = $row['count'];
        }
        
        return $distribution;
    }
    
    /**
     * Update course average rating
     * 
     * @param int $course_id
     * @return bool
     */
    public function update_course_rating($course_id) {
        $avg_rating = $this->get_average_rating($course_id);
        
        $this->db->where('id', $course_id);
        return $this->db->update('courses', ['average_rating' => $avg_rating]);
    }
}
