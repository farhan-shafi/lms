<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Load the User model
        $this->load->model('User_model');
        
        // Ensure session is started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public function index() {
        $this->login();
    }
    
    public function login() {
        $this->load->view('auth/login');
    }
    
    public function login_process() {
        // Get form data directly from $_POST
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        
        // Basic validation
        if (empty($email) || empty($password)) {
            redirect('auth/login?error=' . urlencode('Please enter both email and password'));
            return;
        }
        
        // Verify user credentials against database
        $user = $this->User_model->verify_login($email, $password);
        
        if ($user) {
            // Set session data from database user
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['logged_in'] = TRUE;
            
            // Redirect to dashboard
            redirect('dashboard');
        } else {
            // Invalid credentials
            redirect('auth/login?error=' . urlencode('Invalid email or password'));
        }
    }
    
    public function register() {
        $this->load->view('auth/register');
    }
    
    public function register_process() {
        // Get form data directly from $_POST
        $firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
        $lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirmpassword = isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : '';
        $role = isset($_POST['role']) ? $_POST['role'] : 'student';
        
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
            redirect('auth/register?error=' . urlencode($error_message));
            return;
        }
        
        // Prepare user data for registration
        $user_data = [
            'name' => $firstname . ' ' . $lastname,
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Register the user
        $registered = $this->User_model->register($user_data);
        
        if ($registered) {
            // Registration successful
            redirect('auth/login?success=' . urlencode('Registration successful. You can now log in.'));
        } else {
            // Registration failed
            redirect('auth/register?error=' . urlencode('Registration failed. Please try again.'));
        }
    }
    
    public function logout() {
        // Clear session variables
        $_SESSION = [];
        
        // Destroy session
        session_destroy();
        
        // Redirect to login page
        redirect('auth/login?success=' . urlencode('You have been logged out successfully'));
    }
}
