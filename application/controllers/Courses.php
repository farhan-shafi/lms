<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courses extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Course_model');
        $this->load->model('Category_model');
    }
    
    /**
     * Display all courses with minimal code
     */
    public function index() {
        // Get all courses
        $data['courses'] = $this->Course_model->get_latest_courses(20);
        
        // Get categories for filter sidebar
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Page metadata
        $data['title'] = 'All Courses';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('course/index', $data);
        $this->load->view('templates/footer');
    }
}
