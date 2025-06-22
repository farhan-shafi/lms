<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Custom controller class that extends CI_Controller
 * Used to load common libraries, models, and helpers
 */
class MY_Controller extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Load common libraries
        $this->load->database();
        $this->load->library('session');
        $this->load->library('form_validation');
        
        // Load common helpers
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('html');
    }
}

/**
 * Controller for authenticated users
 */
class Auth_Controller extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Please login to access this page.');
            redirect('auth/login');
        }
    }
}

/**
 * Controller for admin users
 */
class Admin_Controller extends Auth_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Check if user is an admin
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'You do not have permission to access this page.');
            redirect('dashboard');
        }
    }
}

/**
 * Controller for instructor users
 */
class Instructor_Controller extends Auth_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Check if user is an instructor
        if ($this->session->userdata('role') !== 'instructor') {
            $this->session->set_flashdata('error', 'You do not have permission to access this page.');
            redirect('dashboard');
        }
    }
}
