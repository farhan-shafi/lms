<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends Auth_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Load required models
        $this->load->model('Course_model');
        $this->load->model('Review_model');
        $this->load->model('Enrollment_model');
        $this->load->model('User_model');
    }
    
    /**
     * List all reviews for a course
     * 
     * @param int $course_id
     */
    public function index($course_id) {
        // Verify course exists
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) {
            $this->session->set_flashdata('error', 'Course not found');
            redirect('courses');
        }
        
        // Get all reviews for this course
        $data['reviews'] = $this->Review_model->get_reviews_by_course($course_id);
        $data['course'] = $course;
        
        // Get average rating
        $data['average_rating'] = $this->Review_model->get_average_rating($course_id);
        $data['rating_counts'] = $this->Review_model->get_rating_counts($course_id);
        
        // Check if user is enrolled and can leave a review
        $user_id = $this->session->userdata('user_id');
        $data['user_enrolled'] = $this->Enrollment_model->is_user_enrolled($user_id, $course_id);
        $data['user_has_reviewed'] = $this->Review_model->has_user_reviewed($user_id, $course_id);
        $data['user_review'] = $data['user_has_reviewed'] ? $this->Review_model->get_user_review($user_id, $course_id) : NULL;
        
        // Load views
        $data['title'] = 'Reviews for ' . $course['title'];
        $this->load->view('templates/header', $data);
        $this->load->view('review/index', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Create a new review
     * 
     * @param int $course_id
     */
    public function create($course_id) {
        // Verify course exists
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) {
            $this->session->set_flashdata('error', 'Course not found');
            redirect('courses');
        }
        
        $user_id = $this->session->userdata('user_id');
        
        // Verify user is enrolled in the course
        if (!$this->Enrollment_model->is_user_enrolled($user_id, $course_id)) {
            $this->session->set_flashdata('error', 'You must be enrolled in this course to leave a review');
            redirect('course/view/' . $course_id);
        }
        
        // Check if user has already reviewed this course
        if ($this->Review_model->has_user_reviewed($user_id, $course_id)) {
            $this->session->set_flashdata('error', 'You have already reviewed this course');
            redirect('review/index/' . $course_id);
        }
        
        // Process form submission
        if ($this->input->post()) {
            $this->form_validation->set_rules('rating', 'Rating', 'required|numeric|greater_than[0]|less_than[6]');
            $this->form_validation->set_rules('review', 'Review', 'required|trim');
            
            if ($this->form_validation->run() === TRUE) {
                $review_data = [
                    'course_id' => $course_id,
                    'user_id' => $user_id,
                    'rating' => $this->input->post('rating'),
                    'review' => $this->input->post('review'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                $result = $this->Review_model->create_review($review_data);
                
                if ($result) {
                    $this->session->set_flashdata('success', 'Review submitted successfully');
                } else {
                    $this->session->set_flashdata('error', 'Failed to submit review');
                }
                
                redirect('review/index/' . $course_id);
            }
        }
        
        $data['course'] = $course;
        
        // Load views
        $data['title'] = 'Review ' . $course['title'];
        $this->load->view('templates/header', $data);
        $this->load->view('review/create', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Edit an existing review
     * 
     * @param int $review_id
     */
    public function edit($review_id) {
        // Verify review exists
        $review = $this->Review_model->get_review_by_id($review_id);
        if (!$review) {
            $this->session->set_flashdata('error', 'Review not found');
            redirect('courses');
        }
        
        // Get course info
        $course = $this->Course_model->get_course_by_id($review['course_id']);
        
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        // Check if user owns this review or is admin
        if ($review['user_id'] != $user_id && $user_role != 'admin') {
            $this->session->set_flashdata('error', 'You do not have permission to edit this review');
            redirect('review/index/' . $review['course_id']);
        }
        
        // Process form submission
        if ($this->input->post()) {
            $this->form_validation->set_rules('rating', 'Rating', 'required|numeric|greater_than[0]|less_than[6]');
            $this->form_validation->set_rules('review', 'Review', 'required|trim');
            
            if ($this->form_validation->run() === TRUE) {
                $review_data = [
                    'rating' => $this->input->post('rating'),
                    'review' => $this->input->post('review'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                $result = $this->Review_model->update_review($review_id, $review_data);
                
                if ($result) {
                    $this->session->set_flashdata('success', 'Review updated successfully');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update review');
                }
                
                redirect('review/index/' . $review['course_id']);
            }
        }
        
        $data['review'] = $review;
        $data['course'] = $course;
        
        // Load views
        $data['title'] = 'Edit Review';
        $this->load->view('templates/header', $data);
        $this->load->view('review/edit', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Delete a review
     * 
     * @param int $review_id
     */
    public function delete($review_id) {
        // Verify review exists
        $review = $this->Review_model->get_review_by_id($review_id);
        if (!$review) {
            $this->session->set_flashdata('error', 'Review not found');
            redirect('courses');
        }
        
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        // Check if user owns this review or is admin
        if ($review['user_id'] != $user_id && $user_role != 'admin') {
            $this->session->set_flashdata('error', 'You do not have permission to delete this review');
            redirect('review/index/' . $review['course_id']);
        }
        
        // Delete review
        $result = $this->Review_model->delete_review($review_id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Review deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete review');
        }
        
        redirect('review/index/' . $review['course_id']);
    }
    
    /**
     * Report an inappropriate review (for moderators/admins)
     * 
     * @param int $review_id
     */
    public function report($review_id) {
        // Verify review exists
        $review = $this->Review_model->get_review_by_id($review_id);
        if (!$review) {
            $this->session->set_flashdata('error', 'Review not found');
            redirect('courses');
        }
        
        $user_id = $this->session->userdata('user_id');
        
        // Process form submission
        if ($this->input->post()) {
            $this->form_validation->set_rules('reason', 'Reason', 'required|trim');
            
            if ($this->form_validation->run() === TRUE) {
                $report_data = [
                    'review_id' => $review_id,
                    'user_id' => $user_id,
                    'reason' => $this->input->post('reason'),
                    'status' => 'pending',
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                $result = $this->Review_model->report_review($report_data);
                
                if ($result) {
                    $this->session->set_flashdata('success', 'Review reported successfully');
                } else {
                    $this->session->set_flashdata('error', 'Failed to report review');
                }
                
                redirect('review/index/' . $review['course_id']);
            }
        }
        
        $data['review'] = $review;
        $data['user'] = $this->User_model->get_user($review['user_id']);
        
        // Load views
        $data['title'] = 'Report Review';
        $this->load->view('templates/header', $data);
        $this->load->view('review/report', $data);
        $this->load->view('templates/footer');
    }
}
