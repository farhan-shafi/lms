<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Payment Controller
 *
 * This controller handles payment processing for course enrollments
 */
class Payment extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Course_model');
        $this->load->model('User_model');
        $this->load->model('Enrollment_model');
    }
    
    /**
     * Checkout page for course purchase
     */
    public function checkout($course_id) {
        // Check if user is logged in
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Please login to purchase this course');
            redirect('auth/login');
        }
        
        // Check if course exists
        $data['course'] = $this->Course_model->get_course_by_id($course_id);
        if (!$data['course']) {
            show_404();
        }
        
        // Check if already enrolled
        $user_id = $this->session->userdata('user_id');
        if ($this->Enrollment_model->is_user_enrolled($user_id, $course_id)) {
            $this->session->set_flashdata('info', 'You are already enrolled in this course');
            redirect('course/learn/' . $course_id);
        }
        
        // If course is free, enroll directly
        if ($data['course']['price'] == 0) {
            redirect('course/enroll/' . $course_id);
        }
        
        // Get user data
        $data['user'] = $this->User_model->get_user_by_id($user_id);
        
        // Get instructor data
        $data['instructor'] = $this->User_model->get_user_by_id($data['course']['instructor_id']);
        
        // Page metadata
        $data['title'] = 'Checkout - ' . $data['course']['title'];
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('payment/checkout', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Process payment and enroll user
     */
    public function process() {
        // Check if user is logged in
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Please login to purchase this course');
            redirect('auth/login');
        }
        
        // Validate form
        $this->form_validation->set_rules('course_id', 'Course', 'required|numeric');
        $this->form_validation->set_rules('payment_method', 'Payment Method', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('payment/checkout/' . $this->input->post('course_id'));
        }
        
        $course_id = $this->input->post('course_id');
        $payment_method = $this->input->post('payment_method');
        $user_id = $this->session->userdata('user_id');
        
        // Check if course exists
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) {
            show_404();
        }
        
        // Check if already enrolled
        if ($this->Enrollment_model->is_user_enrolled($user_id, $course_id)) {
            $this->session->set_flashdata('info', 'You are already enrolled in this course');
            redirect('course/learn/' . $course_id);
        }
        
        // In a real application, you would process payment with a payment gateway here
        // For demo purposes, we'll just simulate a successful payment
        
        // Record payment
        $payment_data = [
            'user_id' => $user_id,
            'course_id' => $course_id,
            'amount' => $course['price'],
            'payment_method' => $payment_method,
            'transaction_id' => 'TRANS-' . time() . '-' . mt_rand(1000, 9999),
            'payment_date' => date('Y-m-d H:i:s'),
            'status' => 'completed'
        ];
        
        $this->db->insert('payments', $payment_data);
        $payment_id = $this->db->insert_id();
        
        if ($payment_id) {
            // Create enrollment
            $enrollment_data = [
                'user_id' => $user_id,
                'course_id' => $course_id,
                'enrollment_date' => date('Y-m-d H:i:s'),
                'payment_id' => $payment_id,
                'status' => 'active'
            ];
            
            if ($this->Enrollment_model->enroll($enrollment_data)) {
                // Update total enrollments count for the course
                $this->Course_model->update_enrollment_count($course_id);
                
                $this->session->set_flashdata('success', 'Payment successful! You are now enrolled in this course.');
                redirect('course/learn/' . $course_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to enroll in this course. Please contact support.');
                redirect('course/view/' . $course['slug']);
            }
        } else {
            $this->session->set_flashdata('error', 'Payment failed. Please try again.');
            redirect('payment/checkout/' . $course_id);
        }
    }
    
    /**
     * Payment success callback
     */
    public function success() {
        $data['title'] = 'Payment Successful';
        
        $this->load->view('templates/header', $data);
        $this->load->view('payment/success', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Payment cancelled callback
     */
    public function cancel() {
        $data['title'] = 'Payment Cancelled';
        
        $this->load->view('templates/header', $data);
        $this->load->view('payment/cancel', $data);
        $this->load->view('templates/footer');
    }
}
