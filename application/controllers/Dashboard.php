<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Course_model');
        $this->load->model('Module_model');
        $this->load->model('Quiz_model');
        $this->load->model('Category_model');
        
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
        $this->load->view('dashboard/admin_simple');
    }
    
    public function instructor() {
        // Simple message for instructor dashboard
        echo '<h1>Instructor Dashboard</h1>';
        echo '<p>This is a placeholder for the instructor dashboard.</p>';
        echo '<p><a href="'.site_url('auth/logout').'">Logout</a></p>';
    }
    
    public function student() {
        // Simple message for student dashboard
        echo '<h1>Student Dashboard</h1>';
        echo '<p>This is a placeholder for the student dashboard.</p>';
        echo '<p><a href="'.site_url('auth/logout').'">Logout</a></p>';
    }
}
    
    public function student() {
        // Get user information
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_user($user_id);
        
        // Check if user is a student
        if ($data['user']['role'] != 'student') {
            redirect('dashboard');
        }
        
        // Get enrolled courses
        $data['enrolled_courses'] = $this->Course_model->get_enrolled_courses($user_id);
        
        // Get course progress
        $data['course_progress'] = $this->Course_model->get_student_progress($user_id);
        
        // Get recent activities
        $data['recent_activities'] = $this->User_model->get_recent_activities($user_id);
        
        // Get upcoming quizzes
        $data['upcoming_quizzes'] = $this->Quiz_model->get_upcoming_quizzes($user_id);
        
        // Get recommended courses based on enrolled categories
        $data['recommended_courses'] = $this->Course_model->get_recommended_courses($user_id, 4);
        
        // Get certificates
        $data['certificates'] = $this->Course_model->get_student_certificates($user_id);
        
        // Get categories for the navbar
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Page title
        $data['title'] = 'Student Dashboard';
        
        // Load the view
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/student', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function instructor() {
        // Get user information
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_user($user_id);
        
        // Check if user is an instructor
        if ($data['user']['role'] != 'instructor') {
            redirect('dashboard');
        }
        
        // Get instructor courses
        $data['courses'] = $this->Course_model->get_instructor_courses($user_id);
        
        // Get total students enrolled in instructor's courses
        $data['total_students'] = $this->Course_model->get_instructor_total_students($user_id);
        
        // Get total revenue
        $data['total_revenue'] = $this->Course_model->get_instructor_total_revenue($user_id);
        
        // Get average course rating
        $data['average_rating'] = $this->Course_model->get_instructor_average_rating($user_id);
        
        // Get recent reviews
        $data['recent_reviews'] = $this->Course_model->get_instructor_recent_reviews($user_id);
        
        // Get student engagement metrics
        $data['engagement'] = $this->Course_model->get_instructor_engagement_metrics($user_id);
        
        // Get categories for the navbar
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Page title
        $data['title'] = 'Instructor Dashboard';
        
        // Load the view
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/instructor', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function admin() {
        // Simple admin dashboard view for troubleshooting
        $this->load->view('dashboard/admin_simple');
    }
        // Get revenue by month
        $data['monthly_revenue'] = $this->Course_model->get_monthly_revenue();
        
        // Get categories for the navbar
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Page title
        $data['title'] = 'Admin Dashboard';
        
        // Load the view
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/admin', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function profile() {
        // Get user information
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_user($user_id);
        
        // Form validation
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('bio', 'Bio', 'trim');
        
        if ($this->form_validation->run() === TRUE) {
            // Prepare user data for update
            $user_data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'bio' => $this->input->post('bio'),
                'website' => $this->input->post('website'),
                'twitter' => $this->input->post('twitter'),
                'facebook' => $this->input->post('facebook'),
                'linkedin' => $this->input->post('linkedin')
            ];
            
            // Handle profile image upload
            if ($_FILES['profile_image']['name']) {
                $config['upload_path'] = './assets/images/profiles/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = '2048'; // 2MB
                $config['file_name'] = 'profile_' . $user_id . '_' . time();
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('profile_image')) {
                    $upload_data = $this->upload->data();
                    $user_data['profile_image'] = $upload_data['file_name'];
                    
                    // Delete old image if exists
                    if ($data['user']['profile_image'] && $data['user']['profile_image'] != 'default.jpg') {
                        $old_image_path = './assets/images/profiles/' . $data['user']['profile_image'];
                        if (file_exists($old_image_path)) {
                            unlink($old_image_path);
                        }
                    }
                } else {
                    $data['upload_error'] = $this->upload->display_errors();
                }
            }
            
            // Update user profile
            if ($this->User_model->update_user($user_id, $user_data)) {
                $this->session->set_flashdata('success', 'Your profile has been updated successfully.');
            } else {
                $this->session->set_flashdata('error', 'There was an error updating your profile. Please try again.');
            }
            
            // Redirect to prevent form resubmission
            redirect('dashboard/profile');
        }
        
        // Get categories for the navbar
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Page title
        $data['title'] = 'My Profile';
        
        // Load the view
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/profile', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function change_password() {
        // Get user information
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_user($user_id);
        
        // Form validation
        $this->form_validation->set_rules('current_password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
        
        if ($this->form_validation->run() === TRUE) {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');
            
            // Verify current password
            if ($this->User_model->verify_password($user_id, $current_password)) {
                // Update password
                if ($this->User_model->change_password($user_id, $new_password)) {
                    $this->session->set_flashdata('success', 'Your password has been changed successfully.');
                } else {
                    $this->session->set_flashdata('error', 'There was an error changing your password. Please try again.');
                }
            } else {
                $this->session->set_flashdata('error', 'The current password you entered is incorrect.');
            }
            
            // Redirect to prevent form resubmission
            redirect('dashboard/change_password');
        }
        
        // Get categories for the navbar
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Page title
        $data['title'] = 'Change Password';
        
        // Load the view
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/change_password', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function courses() {
        // Get user information
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_user($user_id);
        
        // Get user courses based on role
        if ($data['user']['role'] == 'student') {
            $data['courses'] = $this->Course_model->get_enrolled_courses($user_id);
            $data['page_title'] = 'My Enrolled Courses';
            $data['view'] = 'dashboard/student_courses';
        } elseif ($data['user']['role'] == 'instructor') {
            $data['courses'] = $this->Course_model->get_instructor_courses($user_id);
            $data['page_title'] = 'My Courses';
            $data['view'] = 'dashboard/instructor_courses';
        } else {
            $data['courses'] = $this->Course_model->get_all_courses();
            $data['page_title'] = 'All Courses';
            $data['view'] = 'dashboard/admin_courses';
        }
        
        // Get categories for the navbar
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Page title
        $data['title'] = $data['page_title'];
        
        // Load the view
        $this->load->view('templates/header', $data);
        $this->load->view($data['view'], $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function certificates() {
        // Get user information
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_user($user_id);
        
        // Check if user is a student
        if ($data['user']['role'] != 'student') {
            redirect('dashboard');
        }
        
        // Get student certificates
        $data['certificates'] = $this->Course_model->get_student_certificates($user_id);
        
        // Get categories for the navbar
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Page title
        $data['title'] = 'My Certificates';
        
        // Load the view
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/certificates', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function certificate($certificate_id) {
        // Get user information
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_user($user_id);
        
        // Get certificate information
        $data['certificate'] = $this->Course_model->get_certificate($certificate_id);
        
        // Check if certificate exists and belongs to the user
        if (!$data['certificate'] || $data['certificate']['user_id'] != $user_id) {
            $this->session->set_flashdata('error', 'Certificate not found or you do not have permission to view it.');
            redirect('dashboard/certificates');
        }
        
        // Get course information
        $data['course'] = $this->Course_model->get_course($data['certificate']['course_id']);
        
        // Page title
        $data['title'] = 'Certificate of Completion';
        
        // Load the view
        $this->load->view('dashboard/view_certificate', $data);
    }
    
    public function notifications() {
        // Get user information
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_user($user_id);
        
        // Get notifications
        $data['notifications'] = $this->User_model->get_notifications($user_id);
        
        // Mark notifications as read
        $this->User_model->mark_notifications_as_read($user_id);
        
        // Get categories for the navbar
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Page title
        $data['title'] = 'My Notifications';
        
        // Load the view
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/notifications', $data);
        $this->load->view('templates/footer', $data);
    }
}
