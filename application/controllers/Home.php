<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Category_model');
        $this->load->model('Course_model');
    }
    
    public function index() {
        // Get categories for the navbar and featured section
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Get featured courses
        $data['featured_courses'] = $this->Course_model->get_featured_courses(6);
        
        // Get latest courses
        $data['latest_courses'] = $this->Course_model->get_latest_courses(8);
        
        // Get popular courses based on enrollments
        $data['popular_courses'] = $this->Course_model->get_popular_courses(8);
        
        // Get total statistics
        $data['stats'] = [
            'courses' => $this->Course_model->get_total_courses(),
            'students' => $this->User_model->get_total_students(),
            'instructors' => $this->User_model->get_total_instructors(),
            'enrollments' => $this->Course_model->get_total_enrollments()
        ];
        
        // Page title
        $data['title'] = 'Home';
        
        // Load the view
        $this->load->view('templates/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function about() {
        // Get categories for the navbar
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Page title
        $data['title'] = 'About Us';
        
        // Load the view
        $this->load->view('templates/header', $data);
        $this->load->view('home/about', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function contact() {
        // Get categories for the navbar
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Form validation
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('subject', 'Subject', 'required|trim');
        $this->form_validation->set_rules('message', 'Message', 'required|trim');
        
        if ($this->form_validation->run() === TRUE) {
            // Form was submitted and validated
            // In a real application, you would send an email here
            
            // Set success message
            $this->session->set_flashdata('success', 'Your message has been sent successfully. We will get back to you soon.');
            
            // Redirect to prevent form resubmission
            redirect('contact');
        }
        
        // Page title
        $data['title'] = 'Contact Us';
        
        // Load the view
        $this->load->view('templates/header', $data);
        $this->load->view('home/contact', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function terms() {
        // Get categories for the navbar
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Page title
        $data['title'] = 'Terms of Service';
        
        // Load the view
        $this->load->view('templates/header', $data);
        $this->load->view('home/terms', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function privacy() {
        // Get categories for the navbar
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Page title
        $data['title'] = 'Privacy Policy';
        
        // Load the view
        $this->load->view('templates/header', $data);
        $this->load->view('home/privacy', $data);
        $this->load->view('templates/footer', $data);
    }
}
