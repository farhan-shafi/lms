<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get certificate by user and course
     * 
     * @param int $user_id
     * @param int $course_id
     * @return array
     */
    public function get_certificate($user_id, $course_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $query = $this->db->get('certificates');
        return $query->row_array();
    }
    
    /**
     * Get certificate by ID
     * 
     * @param int $certificate_id
     * @return array
     */
    public function get_certificate_by_id($certificate_id) {
        $this->db->where('id', $certificate_id);
        $query = $this->db->get('certificates');
        return $query->row_array();
    }
    
    /**
     * Get certificate by number
     * 
     * @param string $certificate_number
     * @return array
     */
    public function get_certificate_by_number($certificate_number) {
        $this->db->where('certificate_number', $certificate_number);
        $query = $this->db->get('certificates');
        return $query->row_array();
    }
    
    /**
     * Create a new certificate
     * 
     * @param array $data
     * @return int|bool The inserted ID or FALSE on failure
     */
    public function create_certificate($data) {
        $this->db->insert('certificates', $data);
        return $this->db->insert_id() ?: FALSE;
    }
    
    /**
     * Update a certificate
     * 
     * @param int $certificate_id
     * @param array $data
     * @return bool
     */
    public function update_certificate($certificate_id, $data) {
        $this->db->where('id', $certificate_id);
        return $this->db->update('certificates', $data);
    }
    
    /**
     * Generate a unique certificate number
     * 
     * @return string
     */
    public function generate_certificate_number() {
        $prefix = 'CERT-';
        $year = date('Y');
        $random = substr(uniqid(), -5);
        
        // Get the next sequential number
        $this->db->select_max('id');
        $query = $this->db->get('certificates');
        $result = $query->row_array();
        $next_id = ($result['id'] ?? 0) + 1;
        
        // Format: CERT-YEAR-ID-RANDOM
        return $prefix . $year . '-' . sprintf('%06d', $next_id) . '-' . $random;
    }
    
    /**
     * Get certificates for a user
     * 
     * @param int $user_id
     * @return array
     */
    public function get_user_certificates($user_id) {
        $this->db->select('c.*, co.title as course_title, co.slug as course_slug');
        $this->db->from('certificates c');
        $this->db->join('courses co', 'c.course_id = co.id');
        $this->db->where('c.user_id', $user_id);
        $this->db->order_by('c.issue_date', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Count certificates for a user
     * 
     * @param int $user_id
     * @return int
     */
    public function count_user_certificates($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results('certificates');
    }
    
    /**
     * Get recently issued certificates
     * 
     * @param int $limit
     * @return array
     */
    public function get_recent_certificates($limit = 10) {
        $this->db->select('c.*, u.name as user_name, co.title as course_title');
        $this->db->from('certificates c');
        $this->db->join('users u', 'c.user_id = u.id');
        $this->db->join('courses co', 'c.course_id = co.id');
        $this->db->order_by('c.issue_date', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result_array();
    }
}
