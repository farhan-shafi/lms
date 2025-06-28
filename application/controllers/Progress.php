<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Progress extends Auth_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Load required models
        $this->load->model('Course_model');
        $this->load->model('Module_model');
        $this->load->model('Lesson_model');
        $this->load->model('Quiz_model');
        $this->load->model('Progress_model');
        $this->load->model('Enrollment_model');
    }
    
    /**
     * View progress dashboard for all enrolled courses
     */
    public function index() {
        $user_id = $this->session->userdata('user_id');
        
        // Get progress data for all enrolled courses
        $data['progress_data'] = $this->Progress_model->get_user_progress_summary($user_id);
        
        // Load views
        $data['title'] = 'My Learning Progress';
        $this->load->view('templates/header', $data);
        $this->load->view('progress/index', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * View detailed progress for a specific course
     * 
     * @param int $course_id
     */
    public function course($course_id) {
        // Verify course exists
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) {
            $this->session->set_flashdata('error', 'Course not found');
            redirect('progress');
        }
        
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        // Verify user is enrolled or is instructor/admin
        if ($user_role !== 'admin' && $course['instructor_id'] !== $user_id) {
            if (!$this->Enrollment_model->is_user_enrolled($user_id, $course_id)) {
                $this->session->set_flashdata('error', 'You must be enrolled in this course to view progress');
                redirect('courses');
            }
        }
        
        // Get course progress data
        $data['course_progress'] = $this->Progress_model->get_course_progress($user_id, $course_id);
        
        // Get module progress data
        $modules = $this->Module_model->get_modules_by_course($course_id);
        $modules_progress = [];
        
        foreach ($modules as $module) {
            $module_progress = $this->Progress_model->get_module_progress($user_id, $module['id']);
            
            // Get lessons in this module
            $lessons = $this->Lesson_model->get_lessons_by_module($module['id']);
            $lessons_progress = [];
            
            foreach ($lessons as $lesson) {
                $lessons_progress[] = [
                    'lesson' => $lesson,
                    'completed' => $this->Progress_model->is_lesson_completed($user_id, $lesson['id'])
                ];
            }
            
            // Get quizzes in this module
            $quizzes = $this->Quiz_model->get_quizzes_by_module($module['id']);
            $quizzes_progress = [];
            
            foreach ($quizzes as $quiz) {
                $completed = $this->Progress_model->is_quiz_completed($user_id, $quiz['id']);
                $score = $this->Progress_model->get_quiz_score($user_id, $quiz['id']);
                
                $quizzes_progress[] = [
                    'quiz' => $quiz,
                    'completed' => $completed,
                    'score' => $score
                ];
            }
            
            $modules_progress[] = [
                'module' => $module,
                'progress' => $module_progress,
                'lessons' => $lessons_progress,
                'quizzes' => $quizzes_progress
            ];
        }
        
        $data['modules_progress'] = $modules_progress;
        $data['course'] = $course;
        
        // Load views
        $data['title'] = 'Course Progress: ' . $course['title'];
        $this->load->view('templates/header', $data);
        $this->load->view('progress/course', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Mark a lesson as completed via AJAX
     */
    public function complete_lesson() {
        // Only allow POST requests
        if (!$this->input->is_ajax_request() || !$this->input->post()) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
            return;
        }
        
        $user_id = $this->session->userdata('user_id');
        $lesson_id = $this->input->post('lesson_id');
        
        if (!$lesson_id) {
            echo json_encode(['status' => 'error', 'message' => 'Lesson ID is required']);
            return;
        }
        
        // Get lesson details
        $lesson = $this->Lesson_model->get_lesson($lesson_id);
        if (!$lesson) {
            echo json_encode(['status' => 'error', 'message' => 'Lesson not found']);
            return;
        }
        
        // Get module and course info
        $module = $this->Module_model->get_module($lesson['module_id']);
        
        // Verify user is enrolled or is instructor/admin
        $user_role = $this->session->userdata('role');
        if ($user_role !== 'admin' && $module['course_id'] !== $user_id) {
            if (!$this->Enrollment_model->is_user_enrolled($user_id, $module['course_id'])) {
                echo json_encode(['status' => 'error', 'message' => 'You must be enrolled in this course']);
                return;
            }
        }
        
        // Mark lesson as completed
        $result = $this->Progress_model->complete_lesson($user_id, $lesson_id);
        
        if ($result) {
            // Get updated course progress
            $course_progress = $this->Progress_model->get_course_progress($user_id, $module['course_id']);
            
            echo json_encode([
                'status' => 'success', 
                'message' => 'Lesson marked as completed',
                'progress' => $course_progress['percentage']
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to mark lesson as completed']);
        }
    }
    
    /**
     * Reset progress for a course, module, lesson or quiz
     */
    public function reset() {
        // Only allow POST requests
        if (!$this->input->post()) {
            redirect('progress');
        }
        
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        $course_id = $this->input->post('course_id');
        $module_id = $this->input->post('module_id');
        $lesson_id = $this->input->post('lesson_id');
        $quiz_id = $this->input->post('quiz_id');
        
        // At least one parameter is required
        if (!$course_id && !$module_id && !$lesson_id && !$quiz_id) {
            $this->session->set_flashdata('error', 'Invalid request parameters');
            redirect('progress');
        }
        
        // If course_id is provided, verify user is enrolled or is instructor/admin
        if ($course_id) {
            $course = $this->Course_model->get_course_by_id($course_id);
            
            if (!$course) {
                $this->session->set_flashdata('error', 'Course not found');
                redirect('progress');
            }
            
            if ($user_role !== 'admin' && $course['instructor_id'] !== $user_id) {
                if (!$this->Enrollment_model->is_user_enrolled($user_id, $course_id)) {
                    $this->session->set_flashdata('error', 'You must be enrolled in this course');
                    redirect('progress');
                }
            }
        }
        
        // Prepare parameters for reset
        $params = [];
        if ($course_id) $params['course_id'] = $course_id;
        if ($module_id) $params['module_id'] = $module_id;
        if ($lesson_id) $params['lesson_id'] = $lesson_id;
        if ($quiz_id) $params['quiz_id'] = $quiz_id;
        
        // Reset progress
        $result = $this->Progress_model->reset_progress($user_id, $params);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Progress reset successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to reset progress');
        }
        
        // Determine redirect URL
        if ($course_id) {
            redirect('progress/course/' . $course_id);
        } else {
            redirect('progress');
        }
    }
}
