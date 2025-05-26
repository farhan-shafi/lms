<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Instructor Controller
 *
 * This controller handles operations related to instructors
 */
class Instructor extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Check if user is logged in and is an instructor
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $this->load->model('User_model');
        $user = $this->User_model->get_user_by_id($this->session->userdata('user_id'));
        
        if (!$user || $user['role'] != 'instructor') {
            $this->session->set_flashdata('error', 'You do not have permission to access the instructor area');
            redirect('dashboard');
        }
        
        // Load models
        $this->load->model('Course_model');
        $this->load->model('Module_model');
        $this->load->model('Lesson_model');
        $this->load->model('Quiz_model');
        $this->load->model('Category_model');
        $this->load->model('Enrollment_model');
    }
    
    /**
     * Instructor dashboard
     */
    public function dashboard() {
        $instructor_id = $this->session->userdata('user_id');
        
        // Get instructor's courses
        $data['courses'] = $this->Course_model->get_courses_by_instructor($instructor_id);
        
        // Get total students enrolled in instructor's courses
        $data['total_students'] = 0;
        $data['total_earnings'] = 0;
        $data['total_reviews'] = 0;
        $data['average_rating'] = 0;
        
        foreach ($data['courses'] as $course) {
            $data['total_students'] += $course['total_enrollments'];
            $data['total_earnings'] += $course['total_enrollments'] * $course['price'];
            $data['total_reviews'] += $course['total_reviews'];
            $data['average_rating'] += $course['average_rating'] * $course['total_reviews'];
        }
        
        if ($data['total_reviews'] > 0) {
            $data['average_rating'] = $data['average_rating'] / $data['total_reviews'];
        }
        
        // Get recent enrollments
        $this->load->model('Enrollment_model');
        $data['recent_enrollments'] = $this->Enrollment_model->get_recent_enrollments_by_instructor($instructor_id, 5);
        
        // Page metadata
        $data['title'] = 'Instructor Dashboard';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/dashboard', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * List instructor's courses
     */
    public function courses() {
        $instructor_id = $this->session->userdata('user_id');
        
        // Get instructor's courses
        $data['courses'] = $this->Course_model->get_courses_by_instructor($instructor_id);
        
        // Page metadata
        $data['title'] = 'My Courses';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/courses', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Create a new course
     */
    public function create_course() {
        $instructor_id = $this->session->userdata('user_id');
        
        // Get categories for dropdown
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Form validation
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');
        $this->form_validation->set_rules('category_id', 'Category', 'required|numeric');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        $this->form_validation->set_rules('level', 'Level', 'required|in_list[beginner,intermediate,advanced]');
        
        if ($this->form_validation->run() === TRUE) {
            $course_data = [
                'title' => $this->input->post('title'),
                'slug' => url_title($this->input->post('title'), 'dash', TRUE) . '-' . uniqid(),
                'description' => $this->input->post('description'),
                'instructor_id' => $instructor_id,
                'category_id' => $this->input->post('category_id'),
                'price' => $this->input->post('price'),
                'level' => $this->input->post('level'),
                'status' => 'draft',
                'created_at' => date('Y-m-d H:i:s'),
                'featured' => 0,
                'total_enrollments' => 0,
                'total_reviews' => 0,
                'average_rating' => 0
            ];
            
            // Process course image if provided
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './assets/images/courses/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('image')) {
                    $upload_data = $this->upload->data();
                    $course_data['image'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('instructor/create_course');
                }
            }
            
            $course_id = $this->Course_model->create_course($course_data);
            
            if ($course_id) {
                $this->session->set_flashdata('success', 'Course created successfully. Now add modules and lessons.');
                redirect('instructor/edit_course/' . $course_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to create course');
            }
        }
        
        // Page metadata
        $data['title'] = 'Create New Course';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/create_course', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Edit course
     */
    public function edit_course($course_id) {
        $instructor_id = $this->session->userdata('user_id');
        
        // Check if course exists and belongs to this instructor
        $data['course'] = $this->Course_model->get_course_by_id($course_id);
        
        if (!$data['course'] || $data['course']['instructor_id'] != $instructor_id) {
            $this->session->set_flashdata('error', 'You do not have permission to edit this course');
            redirect('instructor/courses');
        }
        
        // Get categories for dropdown
        $data['categories'] = $this->Category_model->get_active_categories();
        
        // Get modules and lessons
        $data['modules'] = $this->Module_model->get_modules_by_course($course_id);
        
        // Form validation
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');
        $this->form_validation->set_rules('category_id', 'Category', 'required|numeric');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        $this->form_validation->set_rules('level', 'Level', 'required|in_list[beginner,intermediate,advanced]');
        
        if ($this->form_validation->run() === TRUE) {
            $course_data = [
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'category_id' => $this->input->post('category_id'),
                'price' => $this->input->post('price'),
                'level' => $this->input->post('level'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Process course image if provided
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './assets/images/courses/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('image')) {
                    // Delete old image if exists
                    if ($data['course']['image']) {
                        $old_image_path = './assets/images/courses/' . $data['course']['image'];
                        if (file_exists($old_image_path)) {
                            unlink($old_image_path);
                        }
                    }
                    
                    $upload_data = $this->upload->data();
                    $course_data['image'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('instructor/edit_course/' . $course_id);
                }
            }
            
            if ($this->Course_model->update_course($course_id, $course_data)) {
                $this->session->set_flashdata('success', 'Course updated successfully');
                redirect('instructor/edit_course/' . $course_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to update course');
            }
        }
        
        // Page metadata
        $data['title'] = 'Edit Course: ' . $data['course']['title'];
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/edit_course', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Publish/unpublish course
     */
    public function toggle_course_status($course_id) {
        $instructor_id = $this->session->userdata('user_id');
        
        // Check if course exists and belongs to this instructor
        $course = $this->Course_model->get_course_by_id($course_id);
        
        if (!$course || $course['instructor_id'] != $instructor_id) {
            $this->session->set_flashdata('error', 'You do not have permission to update this course');
            redirect('instructor/courses');
        }
        
        // Toggle status
        $new_status = ($course['status'] == 'published') ? 'draft' : 'published';
        
        // If publishing, check if course has modules and lessons
        if ($new_status == 'published') {
            $modules_count = $this->Module_model->count_modules_in_course($course_id);
            
            if ($modules_count == 0) {
                $this->session->set_flashdata('error', 'Course must have at least one module before publishing');
                redirect('instructor/edit_course/' . $course_id);
            }
        }
        
        if ($this->Course_model->update_course($course_id, ['status' => $new_status])) {
            $this->session->set_flashdata('success', 'Course status updated successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to update course status');
        }
        
        redirect('instructor/courses');
    }
    
    /**
     * Add a new module
     */
    public function add_module($course_id) {
        $instructor_id = $this->session->userdata('user_id');
        
        // Check if course exists and belongs to this instructor
        $course = $this->Course_model->get_course_by_id($course_id);
        
        if (!$course || $course['instructor_id'] != $instructor_id) {
            $this->session->set_flashdata('error', 'You do not have permission to edit this course');
            redirect('instructor/courses');
        }
        
        // Form validation
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        
        if ($this->form_validation->run() === TRUE) {
            // Get the highest order number
            $max_order = $this->db->select_max('order')->where('course_id', $course_id)->get('modules')->row()->order;
            
            $module_data = [
                'course_id' => $course_id,
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'order' => ($max_order === NULL) ? 0 : $max_order + 1
            ];
            
            if ($this->Module_model->create_module($module_data)) {
                $this->session->set_flashdata('success', 'Module added successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to add module');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }
        
        redirect('instructor/edit_course/' . $course_id);
    }
    
    /**
     * Edit module
     */
    public function edit_module($module_id) {
        $instructor_id = $this->session->userdata('user_id');
        
        // Check if module exists
        $module = $this->Module_model->get_module_by_id($module_id);
        
        if (!$module) {
            show_404();
        }
        
        // Check if the course belongs to this instructor
        $course = $this->Course_model->get_course_by_id($module['course_id']);
        
        if (!$course || $course['instructor_id'] != $instructor_id) {
            $this->session->set_flashdata('error', 'You do not have permission to edit this module');
            redirect('instructor/courses');
        }
        
        // Form validation
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        
        if ($this->form_validation->run() === TRUE) {
            $module_data = [
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description')
            ];
            
            if ($this->Module_model->update_module($module_id, $module_data)) {
                $this->session->set_flashdata('success', 'Module updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to update module');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }
        
        redirect('instructor/edit_course/' . $module['course_id']);
    }
    
    /**
     * Delete module
     */
    public function delete_module($module_id) {
        $instructor_id = $this->session->userdata('user_id');
        
        // Check if module exists
        $module = $this->Module_model->get_module_by_id($module_id);
        
        if (!$module) {
            show_404();
        }
        
        // Check if the course belongs to this instructor
        $course = $this->Course_model->get_course_by_id($module['course_id']);
        
        if (!$course || $course['instructor_id'] != $instructor_id) {
            $this->session->set_flashdata('error', 'You do not have permission to delete this module');
            redirect('instructor/courses');
        }
        
        // Check if module has lessons
        $lessons_count = $this->Lesson_model->count_lessons_in_module($module_id);
        
        if ($lessons_count > 0) {
            $this->session->set_flashdata('error', 'Cannot delete module with lessons. Delete the lessons first.');
            redirect('instructor/edit_course/' . $module['course_id']);
        }
        
        if ($this->Module_model->delete_module($module_id)) {
            $this->session->set_flashdata('success', 'Module deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete module');
        }
        
        redirect('instructor/edit_course/' . $module['course_id']);
    }
    
    /**
     * Manage lessons for a module
     */
    public function manage_lessons($module_id) {
        $instructor_id = $this->session->userdata('user_id');
        
        // Check if module exists
        $data['module'] = $this->Module_model->get_module_by_id($module_id);
        
        if (!$data['module']) {
            show_404();
        }
        
        // Check if the course belongs to this instructor
        $data['course'] = $this->Course_model->get_course_by_id($data['module']['course_id']);
        
        if (!$data['course'] || $data['course']['instructor_id'] != $instructor_id) {
            $this->session->set_flashdata('error', 'You do not have permission to manage lessons for this module');
            redirect('instructor/courses');
        }
        
        // Get lessons for this module
        $data['lessons'] = $this->Lesson_model->get_lessons_by_module($module_id);
        
        // Get quizzes for this module
        $data['quizzes'] = $this->Quiz_model->get_quizzes_by_module($module_id);
        
        // Page metadata
        $data['title'] = 'Manage Lessons: ' . $data['module']['title'];
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/manage_lessons', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Add a new lesson
     */
    public function add_lesson($module_id) {
        $instructor_id = $this->session->userdata('user_id');
        
        // Check if module exists
        $module = $this->Module_model->get_module_by_id($module_id);
        
        if (!$module) {
            show_404();
        }
        
        // Check if the course belongs to this instructor
        $course = $this->Course_model->get_course_by_id($module['course_id']);
        
        if (!$course || $course['instructor_id'] != $instructor_id) {
            $this->session->set_flashdata('error', 'You do not have permission to add lessons to this module');
            redirect('instructor/courses');
        }
        
        // Form validation
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('content', 'Content', 'required');
        $this->form_validation->set_rules('lesson_type', 'Lesson Type', 'required|in_list[video,text,pdf,audio]');
        
        if ($this->form_validation->run() === TRUE) {
            // Get the highest order number
            $max_order = $this->db->select_max('order')->where('module_id', $module_id)->get('lessons')->row()->order;
            
            $lesson_data = [
                'module_id' => $module_id,
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'lesson_type' => $this->input->post('lesson_type'),
                'is_free' => $this->input->post('is_free') ? 1 : 0,
                'duration' => $this->input->post('duration') ?: 0,
                'status' => 'published',
                'order' => ($max_order === NULL) ? 0 : $max_order + 1
            ];
            
            // Process video/audio/pdf file if provided
            if (!empty($_FILES['file']['name'])) {
                $config['upload_path'] = './assets/uploads/';
                
                // Set allowed types based on lesson type
                if ($lesson_data['lesson_type'] == 'video') {
                    $config['upload_path'] .= 'videos/';
                    $config['allowed_types'] = 'mp4|webm|ogg';
                    $config['max_size'] = 20480; // 20MB
                } elseif ($lesson_data['lesson_type'] == 'audio') {
                    $config['upload_path'] .= 'audio/';
                    $config['allowed_types'] = 'mp3|wav|ogg';
                    $config['max_size'] = 10240; // 10MB
                } elseif ($lesson_data['lesson_type'] == 'pdf') {
                    $config['upload_path'] .= 'documents/';
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = 5120; // 5MB
                }
                
                $config['encrypt_name'] = TRUE;
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('file')) {
                    $upload_data = $this->upload->data();
                    $lesson_data['file_path'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('instructor/manage_lessons/' . $module_id);
                }
            }
            
            if ($this->Lesson_model->create_lesson($lesson_data)) {
                $this->session->set_flashdata('success', 'Lesson added successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to add lesson');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }
        
        redirect('instructor/manage_lessons/' . $module_id);
    }
    
    /**
     * Edit lesson
     */
    public function edit_lesson($lesson_id) {
        $instructor_id = $this->session->userdata('user_id');
        
        // Check if lesson exists
        $data['lesson'] = $this->Lesson_model->get_lesson_by_id($lesson_id);
        
        if (!$data['lesson']) {
            show_404();
        }
        
        // Get module and course info
        $data['module'] = $this->Module_model->get_module_by_id($data['lesson']['module_id']);
        $data['course'] = $this->Course_model->get_course_by_id($data['module']['course_id']);
        
        // Check if the course belongs to this instructor
        if (!$data['course'] || $data['course']['instructor_id'] != $instructor_id) {
            $this->session->set_flashdata('error', 'You do not have permission to edit this lesson');
            redirect('instructor/courses');
        }
        
        // Form validation
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('content', 'Content', 'required');
        
        if ($this->form_validation->run() === TRUE) {
            $lesson_data = [
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'is_free' => $this->input->post('is_free') ? 1 : 0,
                'duration' => $this->input->post('duration') ?: 0
            ];
            
            // Process video/audio/pdf file if provided
            if (!empty($_FILES['file']['name'])) {
                $config['upload_path'] = './assets/uploads/';
                
                // Set allowed types based on lesson type
                if ($data['lesson']['lesson_type'] == 'video') {
                    $config['upload_path'] .= 'videos/';
                    $config['allowed_types'] = 'mp4|webm|ogg';
                    $config['max_size'] = 20480; // 20MB
                } elseif ($data['lesson']['lesson_type'] == 'audio') {
                    $config['upload_path'] .= 'audio/';
                    $config['allowed_types'] = 'mp3|wav|ogg';
                    $config['max_size'] = 10240; // 10MB
                } elseif ($data['lesson']['lesson_type'] == 'pdf') {
                    $config['upload_path'] .= 'documents/';
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = 5120; // 5MB
                }
                
                $config['encrypt_name'] = TRUE;
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('file')) {
                    // Delete old file if exists
                    if ($data['lesson']['file_path']) {
                        $old_file_path = $config['upload_path'] . $data['lesson']['file_path'];
                        if (file_exists($old_file_path)) {
                            unlink($old_file_path);
                        }
                    }
                    
                    $upload_data = $this->upload->data();
                    $lesson_data['file_path'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('instructor/edit_lesson/' . $lesson_id);
                }
            }
            
            if ($this->Lesson_model->update_lesson($lesson_id, $lesson_data)) {
                $this->session->set_flashdata('success', 'Lesson updated successfully');
                redirect('instructor/manage_lessons/' . $data['lesson']['module_id']);
            } else {
                $this->session->set_flashdata('error', 'Failed to update lesson');
            }
        }
        
        // Page metadata
        $data['title'] = 'Edit Lesson: ' . $data['lesson']['title'];
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/edit_lesson', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Delete lesson
     */
    public function delete_lesson($lesson_id) {
        $instructor_id = $this->session->userdata('user_id');
        
        // Check if lesson exists
        $lesson = $this->Lesson_model->get_lesson_by_id($lesson_id);
        
        if (!$lesson) {
            show_404();
        }
        
        // Get module and course info
        $module = $this->Module_model->get_module_by_id($lesson['module_id']);
        $course = $this->Course_model->get_course_by_id($module['course_id']);
        
        // Check if the course belongs to this instructor
        if (!$course || $course['instructor_id'] != $instructor_id) {
            $this->session->set_flashdata('error', 'You do not have permission to delete this lesson');
            redirect('instructor/courses');
        }
        
        if ($this->Lesson_model->delete_lesson($lesson_id)) {
            // Delete lesson file if exists
            if ($lesson['file_path']) {
                $file_path = './assets/uploads/';
                
                if ($lesson['lesson_type'] == 'video') {
                    $file_path .= 'videos/';
                } elseif ($lesson['lesson_type'] == 'audio') {
                    $file_path .= 'audio/';
                } elseif ($lesson['lesson_type'] == 'pdf') {
                    $file_path .= 'documents/';
                }
                
                $file_path .= $lesson['file_path'];
                
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            
            $this->session->set_flashdata('success', 'Lesson deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete lesson');
        }
        
        redirect('instructor/manage_lessons/' . $lesson['module_id']);
    }
    
    /**
     * Create a new quiz
     */
    public function add_quiz($module_id) {
        $instructor_id = $this->session->userdata('user_id');
        
        // Check if module exists
        $module = $this->Module_model->get_module_by_id($module_id);
        
        if (!$module) {
            show_404();
        }
        
        // Check if the course belongs to this instructor
        $course = $this->Course_model->get_course_by_id($module['course_id']);
        
        if (!$course || $course['instructor_id'] != $instructor_id) {
            $this->session->set_flashdata('error', 'You do not have permission to add quizzes to this module');
            redirect('instructor/courses');
        }
        
        // Form validation
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('time_limit', 'Time Limit', 'numeric');
        $this->form_validation->set_rules('pass_percentage', 'Pass Percentage', 'required|numeric|greater_than[0]|less_than_equal_to[100]');
        
        if ($this->form_validation->run() === TRUE) {
            // Get the highest order number
            $max_order = $this->db->select_max('order')->where('module_id', $module_id)->get('quizzes')->row()->order;
            
            $quiz_data = [
                'module_id' => $module_id,
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'time_limit' => $this->input->post('time_limit') ?: NULL,
                'pass_percentage' => $this->input->post('pass_percentage'),
                'status' => 'published',
                'order' => ($max_order === NULL) ? 0 : $max_order + 1
            ];
            
            $quiz_id = $this->Quiz_model->create_quiz($quiz_data);
            
            if ($quiz_id) {
                $this->session->set_flashdata('success', 'Quiz created successfully. Now add questions.');
                redirect('instructor/manage_questions/' . $quiz_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to create quiz');
                redirect('instructor/manage_lessons/' . $module_id);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect('instructor/manage_lessons/' . $module_id);
        }
    }
    
    /**
     * Manage quiz questions
     */
    public function manage_questions($quiz_id) {
        $instructor_id = $this->session->userdata('user_id');
        
        // Check if quiz exists
        $data['quiz'] = $this->Quiz_model->get_quiz_by_id($quiz_id);
        
        if (!$data['quiz']) {
            show_404();
        }
        
        // Get module and course info
        $data['module'] = $this->Module_model->get_module_by_id($data['quiz']['module_id']);
        $data['course'] = $this->Course_model->get_course_by_id($data['module']['course_id']);
        
        // Check if the course belongs to this instructor
        if (!$data['course'] || $data['course']['instructor_id'] != $instructor_id) {
            $this->session->set_flashdata('error', 'You do not have permission to manage this quiz');
            redirect('instructor/courses');
        }
        
        // Get questions for this quiz
        $data['questions'] = $this->Quiz_model->get_questions_by_quiz($quiz_id);
        
        // For each question, get answers
        foreach ($data['questions'] as &$question) {
            $question['answers'] = $this->Quiz_model->get_answers_by_question($question['id']);
        }
        
        // Page metadata
        $data['title'] = 'Manage Questions: ' . $data['quiz']['title'];
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/manage_questions', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Add a new question to a quiz
     */
    public function add_question($quiz_id) {
        $instructor_id = $this->session->userdata('user_id');
        
        // Check if quiz exists
        $quiz = $this->Quiz_model->get_quiz_by_id($quiz_id);
        
        if (!$quiz) {
            show_404();
        }
        
        // Get module and course info
        $module = $this->Module_model->get_module_by_id($quiz['module_id']);
        $course = $this->Course_model->get_course_by_id($module['course_id']);
        
        // Check if the course belongs to this instructor
        if (!$course || $course['instructor_id'] != $instructor_id) {
            $this->session->set_flashdata('error', 'You do not have permission to manage this quiz');
            redirect('instructor/courses');
        }
        
        // Form validation
        $this->form_validation->set_rules('question_text', 'Question', 'required|trim');
        $this->form_validation->set_rules('question_type', 'Question Type', 'required|in_list[single_choice,multiple_choice,true_false]');
        $this->form_validation->set_rules('points', 'Points', 'required|numeric|greater_than[0]');
        
        if ($this->form_validation->run() === TRUE) {
            // Get the highest order number
            $max_order = $this->db->select_max('order')->where('quiz_id', $quiz_id)->get('quiz_questions')->row()->order;
            
            $question_data = [
                'quiz_id' => $quiz_id,
                'question_text' => $this->input->post('question_text'),
                'question_type' => $this->input->post('question_type'),
                'points' => $this->input->post('points'),
                'explanation' => $this->input->post('explanation'),
                'order' => ($max_order === NULL) ? 0 : $max_order + 1
            ];
            
            $question_id = $this->Quiz_model->create_question($question_data);
            
            if ($question_id) {
                // Process answers
                $answers = $this->input->post('answers');
                $is_correct = $this->input->post('is_correct');
                
                if ($answers && is_array($answers)) {
                    foreach ($answers as $key => $answer_text) {
                        if (trim($answer_text) != '') {
                            $answer_data = [
                                'question_id' => $question_id,
                                'answer_text' => $answer_text,
                                'is_correct' => isset($is_correct[$key]) ? 1 : 0,
                                'order' => $key
                            ];
                            
                            $this->Quiz_model->create_answer($answer_data);
                        }
                    }
                }
                
                $this->session->set_flashdata('success', 'Question added successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to add question');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }
        
        redirect('instructor/manage_questions/' . $quiz_id);
    }
    
    /**
     * Edit a quiz question
     */
    public function edit_question($question_id) {
        $instructor_id = $this->session->userdata('user_id');
        
        // Check if question exists
        $data['question'] = $this->Quiz_model->get_question_by_id($question_id);
        
        if (!$data['question']) {
            show_404();
        }
        
        // Get quiz, module and course info
        $data['quiz'] = $this->Quiz_model->get_quiz_by_id($data['question']['quiz_id']);
        $data['module'] = $this->Module_model->get_module_by_id($data['quiz']['module_id']);
        $data['course'] = $this->Course_model->get_course_by_id($data['module']['course_id']);
        
        // Check if the course belongs to this instructor
        if (!$data['course'] || $data['course']['instructor_id'] != $instructor_id) {
            $this->session->set_flashdata('error', 'You do not have permission to edit this question');
            redirect('instructor/courses');
        }
        
        // Get answers for this question
        $data['answers'] = $this->Quiz_model->get_answers_by_question($question_id);
        
        // Form validation
        $this->form_validation->set_rules('question_text', 'Question', 'required|trim');
        $this->form_validation->set_rules('points', 'Points', 'required|numeric|greater_than[0]');
        
        if ($this->form_validation->run() === TRUE) {
            $question_data = [
                'question_text' => $this->input->post('question_text'),
                'points' => $this->input->post('points'),
                'explanation' => $this->input->post('explanation')
            ];
            
            if ($this->Quiz_model->update_question($question_id, $question_data)) {
                // Process answers
                $answer_ids = $this->input->post('answer_ids');
                $answers = $this->input->post('answers');
                $is_correct = $this->input->post('is_correct');
                
                // Delete existing answers if we're replacing them all
                foreach ($data['answers'] as $answer) {
                    $this->Quiz_model->delete_answer($answer['id']);
                }
                
                // Add new answers
                if ($answers && is_array($answers)) {
                    foreach ($answers as $key => $answer_text) {
                        if (trim($answer_text) != '') {
                            $answer_data = [
                                'question_id' => $question_id,
                                'answer_text' => $answer_text,
                                'is_correct' => isset($is_correct[$key]) ? 1 : 0,
                                'order' => $key
                            ];
                            
                            $this->Quiz_model->create_answer($answer_data);
                        }
                    }
                }
                
                $this->session->set_flashdata('success', 'Question updated successfully');
                redirect('instructor/manage_questions/' . $data['question']['quiz_id']);
            } else {
                $this->session->set_flashdata('error', 'Failed to update question');
            }
        }
        
        // Page metadata
        $data['title'] = 'Edit Question';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/edit_question', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Delete a quiz question
     */
    public function delete_question($question_id) {
        $instructor_id = $this->session->userdata('user_id');
        
        // Check if question exists
        $question = $this->Quiz_model->get_question_by_id($question_id);
        
        if (!$question) {
            show_404();
        }
        
        // Get quiz, module and course info
        $quiz = $this->Quiz_model->get_quiz_by_id($question['quiz_id']);
        $module = $this->Module_model->get_module_by_id($quiz['module_id']);
        $course = $this->Course_model->get_course_by_id($module['course_id']);
        
        // Check if the course belongs to this instructor
        if (!$course || $course['instructor_id'] != $instructor_id) {
            $this->session->set_flashdata('error', 'You do not have permission to delete this question');
            redirect('instructor/courses');
        }
        
        // Delete question (this will also delete associated answers due to foreign key constraints)
        if ($this->Quiz_model->delete_question($question_id)) {
            $this->session->set_flashdata('success', 'Question deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete question');
        }
        
        redirect('instructor/manage_questions/' . $question['quiz_id']);
    }
    
    /**
     * View course analytics
     */
    public function course_analytics($course_id) {
        $instructor_id = $this->session->userdata('user_id');
        
        // Check if course exists and belongs to this instructor
        $data['course'] = $this->Course_model->get_course_by_id($course_id);
        
        if (!$data['course'] || $data['course']['instructor_id'] != $instructor_id) {
            $this->session->set_flashdata('error', 'You do not have permission to view analytics for this course');
            redirect('instructor/courses');
        }
        
        // Get enrollment data
        $this->load->model('Enrollment_model');
        $data['enrollments'] = $this->Enrollment_model->get_students_by_course($course_id);
        $data['total_enrollments'] = count($data['enrollments']);
        
        // Get revenue data
        $this->load->model('Payment_model');
        $data['payments'] = $this->Payment_model->get_payments_by_course($course_id);
        $data['total_revenue'] = 0;
        
        foreach ($data['payments'] as $payment) {
            if ($payment['status'] == 'completed') {
                $data['total_revenue'] += $payment['amount'];
            }
        }
        
        // Get instructor earnings
        $this->load->model('Settings_model');
        $commission_rate = $this->Settings_model->get_setting('instructor_commission_rate', 70); // Default 70%
        $data['instructor_earnings'] = ($data['total_revenue'] * $commission_rate) / 100;
        
        // Get lesson completion data
        $data['lesson_completion'] = $this->Enrollment_model->get_lesson_completion_stats($course_id);
        
        // Get quiz performance data
        $data['quiz_performance'] = $this->Quiz_model->get_quiz_performance_by_course($course_id);
        
        // Page metadata
        $data['title'] = 'Course Analytics: ' . $data['course']['title'];
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/course_analytics', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * View earnings and payouts
     */
    public function earnings() {
        $instructor_id = $this->session->userdata('user_id');
        
        // Load models
        $this->load->model('Payment_model');
        
        // Get instructor's courses
        $data['courses'] = $this->Course_model->get_courses_by_instructor($instructor_id);
        
        // Get earnings data
        $data['payments'] = $this->Payment_model->get_payments_by_instructor($instructor_id);
        $data['total_revenue'] = 0;
        
        foreach ($data['payments'] as $payment) {
            if ($payment['status'] == 'completed') {
                $data['total_revenue'] += $payment['amount'];
            }
        }
        
        // Get instructor commission rate
        $this->load->model('Settings_model');
        $commission_rate = $this->Settings_model->get_setting('instructor_commission_rate', 70); // Default 70%
        $data['commission_rate'] = $commission_rate;
        $data['instructor_earnings'] = ($data['total_revenue'] * $commission_rate) / 100;
        
        // Get payout history
        $data['payouts'] = $this->Payment_model->get_instructor_payouts($instructor_id);
        $data['total_paid'] = 0;
        
        foreach ($data['payouts'] as $payout) {
            if ($payout['status'] == 'completed') {
                $data['total_paid'] += $payout['amount'];
            }
        }
        
        $data['pending_balance'] = $data['instructor_earnings'] - $data['total_paid'];
        
        // Page metadata
        $data['title'] = 'Earnings & Payouts';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/earnings', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Request a payout
     */
    public function request_payout() {
        $instructor_id = $this->session->userdata('user_id');
        
        // Check if instructor has paypal email
        $instructor = $this->User_model->get_user_by_id($instructor_id);
        
        if (!$instructor['paypal_email']) {
            $this->session->set_flashdata('error', 'Please add your PayPal email in your profile before requesting a payout');
            redirect('instructor/earnings');
        }
        
        // Calculate pending balance
        $this->load->model('Payment_model');
        
        // Get earnings data
        $payments = $this->Payment_model->get_payments_by_instructor($instructor_id);
        $total_revenue = 0;
        
        foreach ($payments as $payment) {
            if ($payment['status'] == 'completed') {
                $total_revenue += $payment['amount'];
            }
        }
        
        // Get instructor commission rate
        $this->load->model('Settings_model');
        $commission_rate = $this->Settings_model->get_setting('instructor_commission_rate', 70); // Default 70%
        $instructor_earnings = ($total_revenue * $commission_rate) / 100;
        
        // Get payout history
        $payouts = $this->Payment_model->get_instructor_payouts($instructor_id);
        $total_paid = 0;
        
        foreach ($payouts as $payout) {
            if ($payout['status'] == 'completed') {
                $total_paid += $payout['amount'];
            }
        }
        
        $pending_balance = $instructor_earnings - $total_paid;
        
        // Check if minimum payout threshold is met
        $min_payout = $this->Settings_model->get_setting('min_payout_amount', 50); // Default $50
        
        if ($pending_balance < $min_payout) {
            $this->session->set_flashdata('error', 'Your balance must be at least $' . $min_payout . ' to request a payout');
            redirect('instructor/earnings');
        }
        
        // Create payout request
        $payout_data = [
            'instructor_id' => $instructor_id,
            'amount' => $pending_balance,
            'payout_method' => 'paypal',
            'paypal_email' => $instructor['paypal_email'],
            'request_date' => date('Y-m-d H:i:s'),
            'status' => 'pending'
        ];
        
        if ($this->Payment_model->record_payout($payout_data)) {
            $this->session->set_flashdata('success', 'Payout request submitted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to submit payout request');
        }
        
        redirect('instructor/earnings');
    }
}
 