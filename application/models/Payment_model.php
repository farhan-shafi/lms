<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all payments with optional date filters
     * 
     * @param string $start_date Optional start date (Y-m-d)
     * @param string $end_date Optional end date (Y-m-d)
     * @return array
     */
    public function get_payments($start_date = NULL, $end_date = NULL) {
        $this->db->select('payments.*, users.name as user_name, courses.title as course_title');
        $this->db->from('payments');
        $this->db->join('users', 'users.id = payments.user_id');
        $this->db->join('courses', 'courses.id = payments.course_id');
        
        // Apply date filters if provided
        if ($start_date) {
            $this->db->where('DATE(payments.payment_date) >=', $start_date);
        }
        
        if ($end_date) {
            $this->db->where('DATE(payments.payment_date) <=', $end_date);
        }
        
        $this->db->order_by('payments.payment_date', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get payments for a specific user
     * 
     * @param int $user_id
     * @return array
     */
    public function get_payments_by_user($user_id) {
        $this->db->select('payments.*, courses.title as course_title');
        $this->db->from('payments');
        $this->db->join('courses', 'courses.id = payments.course_id');
        $this->db->where('payments.user_id', $user_id);
        $this->db->order_by('payments.payment_date', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get payments for a specific course
     * 
     * @param int $course_id
     * @return array
     */
    public function get_payments_by_course($course_id) {
        $this->db->select('payments.*, users.name as user_name');
        $this->db->from('payments');
        $this->db->join('users', 'users.id = payments.user_id');
        $this->db->where('payments.course_id', $course_id);
        $this->db->order_by('payments.payment_date', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Get payments for a specific instructor
     * 
     * @param int $instructor_id
     * @return array
     */
    public function get_payments_by_instructor($instructor_id) {
        $this->db->select('payments.*, users.name as user_name, courses.title as course_title');
        $this->db->from('payments');
        $this->db->join('users', 'users.id = payments.user_id');
        $this->db->join('courses', 'courses.id = payments.course_id');
        $this->db->where('courses.instructor_id', $instructor_id);
        $this->db->order_by('payments.payment_date', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * Calculate instructor earnings for a specific payment
     * 
     * @param int $payment_id
     * @return float
     */
    public function calculate_instructor_earnings($payment_id) {
        $this->db->select('payments.amount, settings.setting_value as commission_rate');
        $this->db->from('payments');
        $this->db->join('settings', 'settings.setting_key = "instructor_commission_rate"', 'left');
        $this->db->where('payments.id', $payment_id);
        $query = $this->db->get();
        $result = $query->row_array();
        
        if (!$result) {
            return 0;
        }
        
        $commission_rate = isset($result['commission_rate']) ? (float)$result['commission_rate'] : 70; // Default 70%
        return ($result['amount'] * $commission_rate) / 100;
    }
    
    /**
     * Record instructor payout
     * 
     * @param array $data
     * @return bool
     */
    public function record_payout($data) {
        return $this->db->insert('instructor_payouts', $data);
    }
    
    /**
     * Get instructor payouts
     * 
     * @param int $instructor_id
     * @return array
     */
    public function get_instructor_payouts($instructor_id) {
        $this->db->where('instructor_id', $instructor_id);
        $this->db->order_by('payout_date', 'DESC');
        $query = $this->db->get('instructor_payouts');
        
        return $query->result_array();
    }
    
    /**
     * Get payout by ID
     * 
     * @param int $payout_id
     * @return array
     */
    public function get_payout_by_id($payout_id) {
        $this->db->where('id', $payout_id);
        $query = $this->db->get('instructor_payouts');
        
        return $query->row_array();
    }
    
    /**
     * Update payout status
     * 
     * @param int $payout_id
     * @param string $status
     * @return bool
     */
    public function update_payout_status($payout_id, $status) {
        $this->db->where('id', $payout_id);
        return $this->db->update('instructor_payouts', ['status' => $status]);
    }
}
