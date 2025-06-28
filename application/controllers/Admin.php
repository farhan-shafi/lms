<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Controller
 *
 * This controller handles administrative operations
 */
class Admin extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Check if user is logged in and is an admin
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $this->load->model('User_model');
        $user = $this->User_model->get_user_by_id($this->session->userdata('user_id'));
        
        if (!$user || $user['role'] != 'admin') {
            $this->session->set_flashdata('error', 'You do not have permission to access the admin area');
            redirect('dashboard');
        }
        
        // Load models
        $this->load->model('Course_model');
        $this->load->model('Category_model');
        $this->load->model('Enrollment_model');
    }
    
    /**
     * Admin dashboard
     */
    public function index() {
        // Get statistics
        $data['total_courses'] = $this->Course_model->get_total_courses();
        $data['total_students'] = $this->User_model->get_total_students();
        $data['total_instructors'] = $this->User_model->get_total_instructors();
        $data['total_enrollments'] = $this->Course_model->get_total_enrollments();
        
        // Get recent users
        $data['recent_users'] = $this->User_model->get_users(null, 'active', 5);
        
        // Get recent courses
        $data['recent_courses'] = $this->Course_model->get_latest_courses(5);
        
        // Page metadata
        $data['title'] = 'Admin Dashboard';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * User management
     */
    public function users() {
        // Pagination configuration
        $config['base_url'] = site_url('admin/users');
        $config['total_rows'] = $this->db->count_all('users');
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;
        
        // Bootstrap 4 pagination styling
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        
        $this->pagination->initialize($config);
        
        // Get current page
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        // Get filter parameters
        $role = $this->input->get('role');
        $status = $this->input->get('status');
        
        // Get users with optional filters
        $data['users'] = $this->User_model->get_users($role, $status, $config['per_page'], $page);
        
        // Page metadata
        $data['title'] = 'User Management';
        $data['pagination'] = $this->pagination->create_links();
        $data['current_role'] = $role;
        $data['current_status'] = $status;
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/users', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Edit user
     */
    public function edit_user($user_id) {
        // Check if user exists
        $data['user'] = $this->User_model->get_user_by_id($user_id);
        if (!$data['user']) {
            show_404();
        }
        
        // Form validation
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[student,instructor,admin]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[active,inactive]');
        
        if ($this->form_validation->run() === TRUE) {
            $update_data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'role' => $this->input->post('role'),
                'status' => $this->input->post('status')
            ];
            
            // Handle password change if provided
            if ($this->input->post('password') && trim($this->input->post('password')) != '') {
                $update_data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            }
            
            if ($this->User_model->update_user($user_id, $update_data)) {
                $this->session->set_flashdata('success', 'User updated successfully');
                redirect('admin/users');
            } else {
                $this->session->set_flashdata('error', 'Failed to update user');
            }
        }
        
        // Page metadata
        $data['title'] = 'Edit User';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/edit_user', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Delete user
     */
    public function delete_user($user_id) {
        // Check if user exists
        $user = $this->User_model->get_user_by_id($user_id);
        if (!$user) {
            show_404();
        }
        
        // Don't allow deleting self
        if ($user_id == $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You cannot delete your own account');
            redirect('admin/users');
        }
        
        if ($this->User_model->delete_user($user_id)) {
            $this->session->set_flashdata('success', 'User deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete user');
        }
        
        redirect('admin/users');
    }
    
    /**
     * Course management
     */
    public function courses() {
        // Pagination configuration
        $config['base_url'] = site_url('admin/courses');
        $config['total_rows'] = $this->db->count_all('courses');
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;
        
        // Bootstrap 4 pagination styling
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        
        $this->pagination->initialize($config);
        
        // Get current page
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        // Get all courses for admin
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($config['per_page'], $page);
        $data['courses'] = $this->db->get('courses')->result_array();
        
        // Get categories for filter
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Page metadata
        $data['title'] = 'Course Management';
        $data['pagination'] = $this->pagination->create_links();
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/courses', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Edit course status
     */
    public function update_course_status($course_id) {
        // Check if course exists
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) {
            show_404();
        }
        
        // Update status
        $status = $this->input->post('status');
        if ($status && in_array($status, ['draft', 'published', 'archived'])) {
            if ($this->Course_model->update_course($course_id, ['status' => $status])) {
                $this->session->set_flashdata('success', 'Course status updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to update course status');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid status');
        }
        
        redirect('admin/courses');
    }
    
    /**
     * Category management
     */
    public function categories() {
        // Get all categories
        $data['categories'] = $this->Category_model->get_all_categories();
        
        // Page metadata
        $data['title'] = 'Category Management';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/categories', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Add/Edit category
     */
    public function edit_category($category_id = NULL) {
        // Check if editing or adding
        $data['is_edit'] = ($category_id !== NULL);
        
        if ($data['is_edit']) {
            // Check if category exists
            $data['category'] = $this->Category_model->get_category_by_id($category_id);
            if (!$data['category']) {
                show_404();
            }
        }
        
        // Form validation
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[active,inactive]');
        
        if ($this->form_validation->run() === TRUE) {
            $category_data = [
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'status' => $this->input->post('status')
            ];
            
            // Generate slug if not editing
            if (!$data['is_edit']) {
                $category_data['slug'] = url_title($category_data['name'], 'dash', TRUE);
            }
            
            // Process icon upload if provided
            if (!empty($_FILES['icon']['name'])) {
                $config['upload_path'] = './assets/images/categories/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|svg';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('icon')) {
                    $upload_data = $this->upload->data();
                    $category_data['icon'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('admin/categories');
                }
            }
            
            if ($data['is_edit']) {
                // Update existing category
                if ($this->Category_model->update_category($category_id, $category_data)) {
                    $this->session->set_flashdata('success', 'Category updated successfully');
                    redirect('admin/categories');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update category');
                }
            } else {
                // Create new category
                if ($this->Category_model->create_category($category_data)) {
                    $this->session->set_flashdata('success', 'Category created successfully');
                    redirect('admin/categories');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create category');
                }
            }
        }
        
        // Page metadata
        $data['title'] = $data['is_edit'] ? 'Edit Category' : 'Add Category';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/edit_category', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Delete category
     */
    public function delete_category($category_id) {
        // Check if category exists
        $category = $this->Category_model->get_category_by_id($category_id);
        if (!$category) {
            show_404();
        }
        
        // Check if category has courses
        $course_count = $this->Category_model->count_courses_in_category($category_id);
        if ($course_count > 0) {
            $this->session->set_flashdata('error', 'Cannot delete category with courses. Move or delete the courses first.');
            redirect('admin/categories');
        }
        
        if ($this->Category_model->delete_category($category_id)) {
            // Delete category icon if exists
            if ($category['icon']) {
                $icon_path = './assets/images/categories/' . $category['icon'];
                if (file_exists($icon_path)) {
                    unlink($icon_path);
                }
            }
            
            $this->session->set_flashdata('success', 'Category deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete category');
        }
        
        redirect('admin/categories');
    }
    
    /**
     * System settings
     */
    public function settings() {
        // Get current settings
        $this->load->model('Settings_model');
        $data['settings'] = $this->Settings_model->get_all_settings();
        
        // Form validation
        $this->form_validation->set_rules('site_name', 'Site Name', 'required|trim');
        $this->form_validation->set_rules('site_description', 'Site Description', 'trim');
        $this->form_validation->set_rules('admin_email', 'Admin Email', 'required|trim|valid_email');
        
        if ($this->form_validation->run() === TRUE) {
            $settings = [
                'site_name' => $this->input->post('site_name'),
                'site_description' => $this->input->post('site_description'),
                'admin_email' => $this->input->post('admin_email'),
                'currency' => $this->input->post('currency'),
                'allow_registrations' => $this->input->post('allow_registrations') ? 1 : 0,
                'enable_instructor_applications' => $this->input->post('enable_instructor_applications') ? 1 : 0,
                'instructor_commission_rate' => $this->input->post('instructor_commission_rate')
            ];
            
            if ($this->Settings_model->update_settings($settings)) {
                $this->session->set_flashdata('success', 'Settings updated successfully');
                redirect('admin/settings');
            } else {
                $this->session->set_flashdata('error', 'Failed to update settings');
            }
        }
        
        // Page metadata
        $data['title'] = 'System Settings';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/settings', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Payment reports
     */
    public function payments() {
        // Get date filters
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        // Load payment model
        $this->load->model('Payment_model');
        
        // Get payments with filters
        $data['payments'] = $this->Payment_model->get_payments($start_date, $end_date);
        
        // Calculate totals
        $data['total_amount'] = 0;
        $data['total_completed'] = 0;
        $data['total_failed'] = 0;
        
        foreach ($data['payments'] as $payment) {
            if ($payment['status'] == 'completed') {
                $data['total_amount'] += $payment['amount'];
                $data['total_completed']++;
            } else if ($payment['status'] == 'failed') {
                $data['total_failed']++;
            }
        }
        
        // Page metadata
        $data['title'] = 'Payment Reports';
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/payments', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Instructor management
     */
    public function instructors() {
       // Get all users with the 'instructor' role
        $data['instructors'] = $this->User_model->get_users_by_role('instructor');
        
        // Page metadata
        $data['title'] = 'Instructor Management';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/instructors', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Student management
     */
    public function students() {
        // Get all users with the 'student' role
        $data['students'] = $this->User_model->get_users_by_role('student');
        
        // Page metadata
        $data['title'] = 'Student Management';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/students', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Enrollment management
     */
    public function enrollments() {
        // Get all enrollments
        $data['enrollments'] = $this->Enrollment_model->get_all_enrollments();
        
        // Page metadata
        $data['title'] = 'Enrollment Management';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/enrollments', $data);
        $this->load->view('templates/footer');
    }
}
