<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Load the User model
        $this->load->model('User_model');
        $this->load->library('upload');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }
    
    public function index() {
        $this->login();
    }
    
    public function login() {
        $this->load->view('auth/login');
    }
    
    public function login_process() {
        // Get form data using CodeIgniter's input class
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        
        // Basic validation
        if (empty($email) || empty($password)) {
            $this->session->set_flashdata('error', 'Please enter both email and password');
            redirect('auth/login');
            return;
        }
        
        // Verify user credentials against database
        $user = $this->User_model->verify_login($email, $password);
        
        if ($user) {
            // Set session data using both methods for compatibility
            $session_data = [
                'user_id' => $user['id'],
                'role' => $user['role'],
                'name' => $user['name'],
                'email' => $user['email'],
                'profile_image' => $user['profile_image'] ?? 'default.png',
                'logged_in' => TRUE
            ];
            
            // Set CodeIgniter session
            $this->session->set_userdata($session_data);
            
            // Also set PHP session for compatibility
            $_SESSION = $session_data;
            
            // Redirect to dashboard
            redirect('dashboard');
        } else {
            // Invalid credentials
            $this->session->set_flashdata('error', 'Invalid email or password');
            redirect('auth/login');
        }
    }
    
    public function register() {
        $data = array(); // Initialize empty data array
		$this->load->view('templates/header', $data);
		$this->load->view('auth/register');
		$this->load->view('templates/footer');
    }
    
    public function register_process() {
        // Get form data using CodeIgniter's input class
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $confirmpassword = $this->input->post('confirmpassword');
        $role = $this->input->post('role') ?: 'student';
        
        // Basic validation
        $errors = [];
        
        if (empty($firstname)) {
            $errors[] = 'First name is required';
        }
        
        if (empty($lastname)) {
            $errors[] = 'Last name is required';
        }
        
        if (empty($email)) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }
        
        if (empty($password)) {
            $errors[] = 'Password is required';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters long';
        }
        
        if ($password !== $confirmpassword) {
            $errors[] = 'Passwords do not match';
        }
        
        // Check if email already exists
        $existing_user = $this->User_model->get_user_by_email($email);
        if ($existing_user) {
            $errors[] = 'Email is already registered';
        }
        
        // If there are validation errors, redirect back with error message
        if (!empty($errors)) {
            $error_message = implode(', ', $errors);
            $this->session->set_flashdata('error', $error_message);
            redirect('auth/register');
            return;
        }
        
        // Process profile image upload if file is selected
        $profile_image = '';
        if (!empty($_FILES['profile_image']['name'])) {
            // Create profiles directory if it doesn't exist
            $profile_dir = FCPATH . 'assets/images/profiles';
            if (!is_dir($profile_dir)) {
                mkdir($profile_dir, 0755, true);
            }
            
            // Set upload configuration
            $config['upload_path'] = $profile_dir;
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE; // For unique filenames
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('profile_image')) {
                $upload_data = $this->upload->data();
                $profile_image = $upload_data['file_name'];
            } else {
                // If upload fails, add error message but continue registration
                $errors[] = 'Profile image upload failed: ' . $this->upload->display_errors('', '');
            }
        }
        
        // Prepare user data for registration
        $user_data = [
            'name' => $firstname . ' ' . $lastname,
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'profile_image' => $profile_image ?: 'default.png',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Register the user
        $registered = $this->User_model->register($user_data);
        
        if ($registered) {
            // Registration successful
            $this->session->set_flashdata('success', 'Registration successful. You can now log in.');
            redirect('auth/login');
        } else {
            // Registration failed
            $this->session->set_flashdata('error', 'Registration failed. Please try again.');
            redirect('auth/register');
        }
    }
    
    public function logout() {
        // Clear both session types for compatibility
        $this->session->sess_destroy();
        $_SESSION = array();
        session_destroy();
        
        // Redirect to login page
        $this->session->set_flashdata('success', 'You have been logged out successfully');
        redirect('auth/login');
    }
}
