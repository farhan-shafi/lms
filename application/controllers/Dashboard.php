<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Course_model');
        $this->load->model('Category_model');
        $this->load->helper('time');
        
        // Ensure session is started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in using native PHP session
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== TRUE) {
            redirect('auth/login?error=' . urlencode('Please login to access the dashboard'));
        }
    }
    
    public function index() {
        // Determine user role and redirect to appropriate dashboard
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
        
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
        $data['user_id'] = $_SESSION['user_id'];
        $data['name'] = $_SESSION['name'];
        $data['role'] = $_SESSION['role'];
        
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
        $user_id = $_SESSION['user_id'];
        
        // Get user data
        $data['user'] = $this->User_model->get_user_by_id($user_id);
        
        // If user data cannot be retrieved, fall back to session data
        if (!$data['user']) {
            $data['user'] = [
                'id' => $_SESSION['user_id'],
                'name' => $_SESSION['name'],
                'email' => $_SESSION['email'],
                'role' => $_SESSION['role'],
                'profile_image' => null
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
        $data['title'] = 'Student D	ashboard';
        $user_id = $_SESSION['user_id'];
        // Get user data
        $data['user'] = $this->User_model->get_user_by_id($user_id);
        
        // If user data cannot be retrieved, fall back to session data
        if (!$data['user']) {
            $data['user'] = [
                'id' => $_SESSION['user_id'],
                'name' => $_SESSION['name'],
                'email' => $_SESSION['email'],
                'role' => $_SESSION['role'],
                'profile_image' => null
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
        $user_id = $_SESSION['user_id'];
        
        // Get user data
        $data['user'] = $this->User_model->get_user_by_id($user_id);
        
        // If user data cannot be retrieved, fall back to session data
        if (!$data['user']) {
            $data['user'] = [
                'id' => $_SESSION['user_id'],
                'name' => $_SESSION['name'],
                'email' => $_SESSION['email'],
                'role' => $_SESSION['role'],
                'profile_image' => null
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
