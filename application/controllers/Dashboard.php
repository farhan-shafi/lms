<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Auth_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Course_model');
        $this->load->model('Category_model');
        $this->load->helper('time');
    }
    
    public function index() {
        // Determine user role and redirect to appropriate dashboard
        $role = $this->session->userdata('role');
        
        if ($role == 'admin') {
            redirect('dashboard/admin');
        } elseif ($role == 'instructor') {
            redirect('dashboard/instructor');
        } else {
            redirect('dashboard/student');
        }
    }
    
    public function admin() {
        // Simple admin dashboard view for troubleshooting
        $data['title'] = 'Admin Dashboard';
        $data['user_id'] = $this->session->userdata('user_id') ?: $_SESSION['user_id'] ?? null;
        $data['name'] = $this->session->userdata('name') ?: $_SESSION['name'] ?? null;
        $data['role'] = $this->session->userdata('role') ?: $_SESSION['role'] ?? null;
        
        try {
            $data['categories'] = $this->Category_model->get_active_categories();
        } catch (Exception $e) {
            $data['categories'] = [];
            $data['error'] = $e->getMessage();
        }
        

        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/admin', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function instructor() {
        $data['title'] = 'Instructor Dashboard';
        $user_id = $this->session->userdata('user_id') ?: $_SESSION['user_id'] ?? null;
        
        // Get user data
        $data['user'] = $this->User_model->get_user_by_id($user_id);
        
        // If user data cannot be retrieved, fall back to session data
        if (!$data['user']) {
            $data['user'] = [
                'id' => $this->session->userdata('user_id') ?: $_SESSION['user_id'] ?? null,
                'name' => $this->session->userdata('name') ?: $_SESSION['name'] ?? null,
                'email' => $this->session->userdata('email') ?: $_SESSION['email'] ?? null,
                'role' => $this->session->userdata('role') ?: $_SESSION['role'] ?? null,
                'profile_image' => $this->session->userdata('profile_image') ?: $_SESSION['profile_image'] ?? 'default.png'
            ];
        }
        
        try {
            // Get instructor courses
            $data['courses'] = $this->Course_model->get_instructor_courses($user_id);
        } catch (Exception $e) {
            $data['courses'] = [];
            $data['error_courses'] = $e->getMessage();
        }
        
        try {
            // Get categories for the navbar
            $data['categories'] = $this->Category_model->get_active_categories();
        } catch (Exception $e) {
            $data['categories'] = [];
            $data['error_categories'] = $e->getMessage();
        }
        
        // Load the view with proper templates
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/instructor', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function student() {
        $data['title'] = 'Student Dashboard';
        $user_id = $this->session->userdata('user_id') ?: $_SESSION['user_id'] ?? null;
        
        // Load additional models
        $this->load->model('Progress_model');
        $this->load->model('Quiz_model');
        $this->load->model('Certificate_model');
        
        // Get user data
        $data['user'] = $this->User_model->get_user_by_id($user_id);
        
        // If user data cannot be retrieved, fall back to session data
        if (!$data['user']) {
            $data['user'] = [
                'id' => $this->session->userdata('user_id') ?: $_SESSION['user_id'] ?? null,
                'name' => $this->session->userdata('name') ?: $_SESSION['name'] ?? null,
                'email' => $this->session->userdata('email') ?: $_SESSION['email'] ?? null,
                'role' => $this->session->userdata('role') ?: $_SESSION['role'] ?? null,
                'profile_image' => $this->session->userdata('profile_image') ?: $_SESSION['profile_image'] ?? 'default.png'
            ];
        }
        
        try {
            // Get enrolled courses
            $data['enrolled_courses'] = $this->Course_model->get_enrolled_courses($user_id);
        } catch (Exception $e) {
            $data['enrolled_courses'] = [];
            $data['error_courses'] = $e->getMessage();
        }
        
        try {
            // Get course progress for all enrolled courses
            $data['course_progress'] = $this->Progress_model->get_all_course_progress($user_id);
        } catch (Exception $e) {
            $data['course_progress'] = [];
            $data['error_progress'] = $e->getMessage();
        }
        
        try {
            // Get upcoming quizzes
            $data['upcoming_quizzes'] = $this->Quiz_model->get_upcoming_quizzes($user_id, 5);
        } catch (Exception $e) {
            $data['upcoming_quizzes'] = [];
            $data['error_quizzes'] = $e->getMessage();
        }
        
        try {
            // Get recent activities
            $data['recent_activities'] = $this->Course_model->get_recent_activities($user_id, 10);
        } catch (Exception $e) {
            $data['recent_activities'] = [];
            $data['error_activities'] = $e->getMessage();
        }
        
        try {
            // Get recommended courses
            $data['recommended_courses'] = $this->Course_model->get_recommended_courses($user_id, 6);
        } catch (Exception $e) {
            $data['recommended_courses'] = [];
            $data['error_recommended'] = $e->getMessage();
        }
        
        try {
            // Get user certificates
            $data['certificates'] = $this->Certificate_model->get_user_certificates($user_id);
        } catch (Exception $e) {
            $data['certificates'] = [];
            $data['error_certificates'] = $e->getMessage();
        }
        
        try {
            // Get categories for the navbar
            $data['categories'] = $this->Category_model->get_active_categories();
        } catch (Exception $e) {
            $data['categories'] = [];
            $data['error_categories'] = $e->getMessage();
        }
        
        // Load the view with proper templates
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/student', $data);
        $this->load->view('templates/footer', $data);
    }
    
    // Helper methods for accessing course categories
    public function course_categories() {
        $data['title'] = 'Course Categories';
        $user_id = $this->session->userdata('user_id') ?: $_SESSION['user_id'] ?? null;
        
        // Get user data
        $data['user'] = $this->User_model->get_user_by_id($user_id);
        
        // If user data cannot be retrieved, fall back to session data
        if (!$data['user']) {
            $data['user'] = [
                'id' => $this->session->userdata('user_id') ?: $_SESSION['user_id'] ?? null,
                'name' => $this->session->userdata('name') ?: $_SESSION['name'] ?? null,
                'email' => $this->session->userdata('email') ?: $_SESSION['email'] ?? null,
                'role' => $this->session->userdata('role') ?: $_SESSION['role'] ?? null,
                'profile_image' => $this->session->userdata('profile_image') ?: $_SESSION['profile_image'] ?? 'default.png'
            ];
        }
        
        try {
            $data['categories'] = $this->Category_model->get_active_categories();
        } catch (Exception $e) {
            $data['categories'] = [];
            $data['error'] = $e->getMessage();
        }
        
        // Load the view with proper templates
        $this->load->view('templates/header', $data);
        echo '<div class="container mt-5">';
        echo '<h1>Course Categories</h1>';
        
        if (!empty($data['categories'])) {
            echo '<div class="list-group mt-4">';
            foreach ($data['categories'] as $category) {
                echo '<a href="'.site_url('course/category/'.$category['slug']).'" class="list-group-item list-group-item-action">';
                echo htmlspecialchars($category['name']);
                echo '</a>';
            }
            echo '</div>';
        } else {
            echo '<div class="alert alert-info mt-4">No categories found.</div>';
        }
        
        echo '<div class="mt-4">';
        echo '<a href="'.site_url('dashboard').'" class="btn btn-primary">Back to Dashboard</a>';
        echo '</div>';
        echo '</div>';
        
        $this->load->view('templates/footer', $data);
    }
}
