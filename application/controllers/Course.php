<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Course Controller
 *
 * This controller handles operations related to courses in the application.
 */
class Course extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Course_model');
        $this->load->model('Module_model');
        $this->load->model('Lesson_model');
        $this->load->model('Quiz_model');
        $this->load->model('Category_model');
        $this->load->model('User_model');
        $this->load->helper('lms_helper');
        $this->load->library('pagination'); // Explicitly load pagination library
    }
    
    /**
     * Display all courses with optional filtering
     */
    public function index() {
        // Get filter parameters
        $category_slug = $this->input->get('category');
        $search = $this->input->get('search');
        $sort = $this->input->get('sort', TRUE) ?: 'latest';
        
        // Get category ID if slug is provided
        $category_id = null;
        if ($category_slug) {
            $category = $this->Category_model->get_category_by_slug($category_slug);
            if ($category) {
                $category_id = $category['id'];
            }
        }
        
        // Pagination configuration
        $config['base_url'] = site_url('courses');
        $config['total_rows'] = $this->Course_model->get_total_courses($category_id, $search);
        $config['per_page'] = 12;
        $config['uri_segment'] = 2;
        $config['use_page_numbers'] = TRUE;
        
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
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 1;
        $offset = ($page - 1) * $config['per_page'];
        
        // Get courses based on filters
        if ($category_id) {
            $data['courses'] = $this->Course_model->get_courses_by_category($category_id, $config['per_page'], $offset, $sort);
            $data['category'] = $this->Category_model->get_category_by_id($category_id);
        } elseif ($search) {
            $data['courses'] = $this->Course_model->search_courses($search, $config['per_page'], $offset, $sort);
            $data['search'] = $search;
        } else {
            $data['courses'] = $this->Course_model->get_all_courses($config['per_page'], $offset, $sort);
        }
        
        // Get categories for filter sidebar
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Add course count to each category
        foreach ($data['categories'] as &$category) {
            $category['course_count'] = $this->Category_model->count_courses_in_category($category['id']);
        }
        
        // Page metadata
        $data['title'] = 'All Courses';
        $data['pagination'] = $this->pagination->create_links();
        $data['total_courses'] = $config['total_rows'];
        $data['current_sort'] = $sort;
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('course/index', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * View a single course
     */
    public function view($slug = NULL) {
        if (!$slug) {
            show_404();
        }
        
        // Get course details
        $data['course'] = $this->Course_model->get_course_by_slug($slug);
        
        if (!$data['course']) {
            show_404();
        }
        
        // Get modules and lessons
        $data['modules'] = $this->Module_model->get_modules_by_course($data['course']['id']);
        $course_id = $data['course']['id'];
        
        // Get instructor details
        $data['instructor'] = $this->User_model->get_user_by_id($data['course']['instructor_id']);
        
        // Get free preview lessons
        $data['free_lessons'] = $this->Lesson_model->get_free_lessons_by_course($course_id);
        
        // Check if user is enrolled
        $user_id = $this->session->userdata('user_id');
        $data['is_enrolled'] = FALSE;
        
        if ($user_id) {
            $this->load->model('Enrollment_model');
            $data['is_enrolled'] = $this->Enrollment_model->is_user_enrolled($user_id, $course_id);
            
            // If user is enrolled, get progress data
            if ($data['is_enrolled']) {
                $data['progress'] = $this->Enrollment_model->get_course_progress($user_id, $course_id);
            }
        }
        
        // Get related courses
        $data['related_courses'] = $this->Course_model->get_related_courses($data['course']['category_id'], $data['course']['id'], 3);
        
        // Page metadata
        $data['title'] = $data['course']['title'];
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('course/view', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Enroll in a course
     */
    public function enroll($course_id) {
        // Check if user is logged in
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Please login to enroll in this course');
            redirect('auth/login');
        }
        
        // Check if course exists
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) {
            show_404();
        }
        
        $user_id = $this->session->userdata('user_id');
        
        // Check if already enrolled
        $this->load->model('Enrollment_model');
        if ($this->Enrollment_model->is_user_enrolled($user_id, $course_id)) {
            $this->session->set_flashdata('info', 'You are already enrolled in this course');
            redirect('course/learn/' . $course_id);
        }
        
        // If the course is free, enroll directly
        if ($course['price'] == 0) {
            $enrollment_data = [
                'user_id' => $user_id,
                'course_id' => $course_id,
                'enrollment_date' => date('Y-m-d H:i:s'),
                'status' => 'active'
            ];
            
            if ($this->Enrollment_model->enroll($enrollment_data)) {
                // Update total enrollments count for the course
                $this->Course_model->update_enrollment_count($course_id);
                
                $this->session->set_flashdata('success', 'You have successfully enrolled in this course');
                redirect('course/learn/' . $course_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to enroll in this course');
                redirect('course/view/' . $course['slug']);
            }
        } else {
            // If course is paid, redirect to payment page
            redirect('payment/checkout/' . $course_id);
        }
    }
    
    /**
     * Access course learning page (for enrolled users)
     */
    public function learn($course_id, $lesson_id = NULL) {
        // Check if user is logged in
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Please login to access this course');
            redirect('auth/login');
        }
        
        // Check if course exists
        $data['course'] = $this->Course_model->get_course_by_id($course_id);
        if (!$data['course']) {
            show_404();
        }
        
        $user_id = $this->session->userdata('user_id');
        
        // Check if user is enrolled
        $this->load->model('Enrollment_model');
        if (!$this->Enrollment_model->is_user_enrolled($user_id, $course_id)) {
            $this->session->set_flashdata('error', 'You are not enrolled in this course');
            redirect('course/view/' . $data['course']['slug']);
        }
        
        // Get modules and lessons
        $data['modules'] = $this->Module_model->get_modules_by_course($course_id);
        
        // If no specific lesson is requested, get the first one or the last accessed
        if (!$lesson_id) {
            $last_accessed = $this->Enrollment_model->get_last_accessed_lesson($user_id, $course_id);
            
            if ($last_accessed) {
                $lesson_id = $last_accessed['lesson_id'];
            } else {
                // Get first lesson of the first module
                foreach ($data['modules'] as $module) {
                    $lessons = $this->Lesson_model->get_lessons_by_module($module['id']);
                    if (!empty($lessons)) {
                        $lesson_id = $lessons[0]['id'];
                        break;
                    }
                }
            }
        }
        
        // Get current lesson
        if ($lesson_id) {
            $data['current_lesson'] = $this->Lesson_model->get_lesson_by_id($lesson_id);
            
            // Check if lesson belongs to this course
            if (!$this->Lesson_model->is_lesson_in_course($lesson_id, $course_id)) {
                show_404();
            }
            
            // Mark lesson as completed when accessed
            $this->Enrollment_model->mark_lesson_completed($user_id, $lesson_id);
            
            // Update last accessed lesson
            $this->Enrollment_model->update_last_accessed($user_id, $course_id, $lesson_id);
            
            // Get next and previous lessons
            $data['next_lesson'] = $this->Lesson_model->get_next_lesson($lesson_id, $course_id);
            $data['prev_lesson'] = $this->Lesson_model->get_prev_lesson($lesson_id, $course_id);
        } else {
            // No lessons found
            $data['current_lesson'] = NULL;
        }
        
        // Get quizzes for current module
        if (isset($data['current_lesson']) && $data['current_lesson']) {
            $data['quizzes'] = $this->Quiz_model->get_quizzes_by_module($data['current_lesson']['module_id']);
        }
        
        // Get course progress
        $data['progress'] = $this->Enrollment_model->get_course_progress($user_id, $course_id);
        
        // Page metadata
        $data['title'] = 'Learning: ' . $data['course']['title'];
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('course/learn', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Display all courses by category
     */
    public function category($slug) {
        // Get category
        $category = $this->Category_model->get_category_by_slug($slug);
        
        if (!$category) {
            show_404();
        }
        
        // Redirect to courses page with category filter
        redirect('courses?category=' . $category['id']);
    }
    
    /**
     * Search courses
     */
    public function search() {
        $search = $this->input->get('query');
        
        if (!$search) {
            redirect('courses');
        }
        
        // Redirect to courses page with search filter
        redirect('courses?search=' . urlencode($search));
    }
}
