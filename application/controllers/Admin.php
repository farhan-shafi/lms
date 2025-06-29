<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Controller
 *
 * This controller handles administrative operations
 */
class Admin extends Admin_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Load models
        $this->load->model('User_model');
        $this->load->model('Course_model');
        $this->load->model('Category_model');
        $this->load->model('Enrollment_model');
        
        // Load pagination library
        $this->load->library('pagination');
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
     * Create new user
     */
    public function create_user() {
        // Form validation
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[student,instructor,admin]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[active,inactive]');
        
        if ($this->form_validation->run() === TRUE) {
            $user_data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'role' => $this->input->post('role'),
                'status' => $this->input->post('status'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            // Handle profile image upload if provided
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
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('profile_image')) {
                    $upload_data = $this->upload->data();
                    $user_data['profile_image'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', 'Profile image upload failed: ' . $this->upload->display_errors('', ''));
                }
            }
            
            if ($this->User_model->register($user_data)) {
                $this->session->set_flashdata('success', 'User created successfully');
                redirect('admin/users');
            } else {
                $this->session->set_flashdata('error', 'Failed to create user');
            }
        }
        
        // Page metadata
        $data['title'] = 'Create User';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/create_user', $data);
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
            
            // Handle profile image upload if provided
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
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('profile_image')) {
                    $upload_data = $this->upload->data();
                    $update_data['profile_image'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', 'Profile image upload failed: ' . $this->upload->display_errors('', ''));
                }
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

    /**
     * Add/Edit course
     */
    public function edit_course($course_id = NULL) {
        // Check if editing or adding
        $data['is_edit'] = ($course_id !== NULL);
        
        if ($data['is_edit']) {
            // Check if course exists
            $data['course'] = $this->Course_model->get_course_by_id($course_id);
            if (!$data['course']) {
                show_404();
            }
        }
        
        // Get all instructors for dropdown
        $data['instructors'] = $this->User_model->get_users_by_role('instructor');
        
        // Get all categories for dropdown
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Form validation
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('short_description', 'Short Description', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');
        $this->form_validation->set_rules('instructor_id', 'Instructor', 'required|numeric');
        $this->form_validation->set_rules('category_id', 'Category', 'required|numeric');
        $this->form_validation->set_rules('level', 'Level', 'required|in_list[beginner,intermediate,advanced]');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[draft,published,pending]');
        
        if ($this->form_validation->run() === TRUE) {
            $course_data = [
                'title' => $this->input->post('title'),
                'short_description' => $this->input->post('short_description'),
                'description' => $this->input->post('description'),
                'instructor_id' => $this->input->post('instructor_id'),
                'category_id' => $this->input->post('category_id'),
                'level' => $this->input->post('level'),
                'price' => $this->input->post('price'),
                'is_free' => $this->input->post('is_free') ? 1 : 0,
                'status' => $this->input->post('status'),
                'language' => $this->input->post('language'),
                'duration' => $this->input->post('duration'),
                'outcomes' => $this->input->post('outcomes'),
                'requirements' => $this->input->post('requirements')
            ];
            
            // Generate slug if not editing
            if (!$data['is_edit']) {
                $course_data['slug'] = url_title($course_data['title'], 'dash', TRUE);
                $course_data['created_at'] = date('Y-m-d H:i:s');
            } else {
                $course_data['updated_at'] = date('Y-m-d H:i:s');
            }
            
            // Process thumbnail upload if provided
            if (!empty($_FILES['thumbnail']['name'])) {
                // Create directory if it doesn't exist
                $upload_path = './assets/images/courses/';
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0755, true);
                }
                
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('thumbnail')) {
                    $upload_data = $this->upload->data();
                    $course_data['thumbnail'] = 'assets/images/courses/' . $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect($data['is_edit'] ? 'admin/edit_course/'.$course_id : 'admin/edit_course');
                }
            }
            
            if ($data['is_edit']) {
                // Update existing course
                if ($this->Course_model->update_course($course_id, $course_data)) {
                    $this->session->set_flashdata('success', 'Course updated successfully');
                    redirect('admin/courses');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update course');
                }
            } else {
                // Create new course
                if ($this->Course_model->create_course($course_data)) {
                    $this->session->set_flashdata('success', 'Course created successfully');
                    redirect('admin/courses');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create course');
                }
            }
        }
        
        // Page metadata
        $data['title'] = $data['is_edit'] ? 'Edit Course' : 'Add Course';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/edit_course', $data);
        $this->load->view('templates/footer');
    }
}
