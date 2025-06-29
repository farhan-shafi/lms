<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussion extends Auth_Controller {
    
    public function __construct() {
        parent::__construct();
        // Load models
        $this->load->model('Course_model');
        $this->load->model('User_model');
        $this->load->model('Enrollment_model');
        
        // Custom model for discussions
        $this->load->model('Discussion_model');
    }
    
    /**
     * View all discussions for a course
     * 
     * @param int $course_id
     */
    public function index($course_id) {
        // Verify course exists
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) {
            $this->session->set_flashdata('error', 'Course not found');
            redirect('courses');
        }
        
        // Verify user is enrolled or is the instructor or admin
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        if ($user_role !== 'admin' && $course['instructor_id'] !== $user_id) {
            $this->load->model('Enrollment_model');
            if (!$this->Enrollment_model->is_user_enrolled($user_id, $course_id)) {
                $this->session->set_flashdata('error', 'You must be enrolled in this course to view discussions');
                redirect('course/' . $course['slug']);
            }
        }
        
        // Get discussions
        $data['discussions'] = $this->Discussion_model->get_discussions_by_course($course_id);
        $data['course'] = $course;
        
        // Load view
        $data['title'] = 'Course Discussions: ' . $course['title'];
        $this->load->view('templates/header', $data);
        $this->load->view('discussion/index', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * View a single discussion thread
     * 
     * @param int $discussion_id
     */
    public function view($discussion_id) {
        // Verify discussion exists
        $discussion = $this->Discussion_model->get_discussion_by_id($discussion_id);
        if (!$discussion) {
            $this->session->set_flashdata('error', 'Discussion not found');
            redirect('courses');
        }
        
        // Get course info
        $course = $this->Course_model->get_course_by_id($discussion['course_id']);
        
        // Verify user is enrolled or is the instructor or admin
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        if ($user_role !== 'admin' && $course['instructor_id'] !== $user_id) {
            $this->load->model('Enrollment_model');
            if (!$this->Enrollment_model->is_user_enrolled($user_id, $course['id'])) {
                $this->session->set_flashdata('error', 'You must be enrolled in this course to view discussions');
                redirect('course/' . $course['slug']);
            }
        }
        
        // Get discussion replies
        $data['replies'] = $this->Discussion_model->get_replies_by_discussion($discussion_id);
        $data['discussion'] = $discussion;
        $data['course'] = $course;
        
        // Load view
        $data['title'] = $discussion['title'];
        $this->load->view('templates/header', $data);
        $this->load->view('discussion/view', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Create a new discussion
     * 
     * @param int $course_id
     */
    public function create($course_id) {
        // Verify course exists
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) {
            $this->session->set_flashdata('error', 'Course not found');
            redirect('courses');
        }
        
        // Verify user is enrolled or is the instructor or admin
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        if ($user_role !== 'admin' && $course['instructor_id'] !== $user_id) {
            $this->load->model('Enrollment_model');
            if (!$this->Enrollment_model->is_user_enrolled($user_id, $course_id)) {
                $this->session->set_flashdata('error', 'You must be enrolled in this course to create discussions');
                redirect('course/' . $course['slug']);
            }
        }
        
        // Process form submission
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim');
            $this->form_validation->set_rules('message', 'Message', 'required|trim');
            
            if ($this->form_validation->run() === TRUE) {
                $discussion_data = [
                    'course_id' => $course_id,
                    'user_id' => $user_id,
                    'title' => $this->input->post('title'),
                    'message' => $this->input->post('message'),
                    'status' => 'active',
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                $discussion_id = $this->Discussion_model->create_discussion($discussion_data);
                
                if ($discussion_id) {
                    $this->session->set_flashdata('success', 'Discussion created successfully');
                    redirect('discussion/view/' . $discussion_id);
                } else {
                    $this->session->set_flashdata('error', 'Failed to create discussion');
                }
            }
        }
        
        // Load view
        $data['course'] = $course;
        $data['title'] = 'Create Discussion - ' . $course['title'];
        $this->load->view('templates/header', $data);
        $this->load->view('discussion/create', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Reply to a discussion
     * 
     * @param int $discussion_id
     */
    public function reply($discussion_id) {
        // Verify discussion exists
        $discussion = $this->Discussion_model->get_discussion_by_id($discussion_id);
        if (!$discussion) {
            $this->session->set_flashdata('error', 'Discussion not found');
            redirect('courses');
        }
        
        // Get course info
        $course = $this->Course_model->get_course_by_id($discussion['course_id']);
        
        // Verify user is enrolled or is the instructor or admin
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        if ($user_role !== 'admin' && $course['instructor_id'] !== $user_id) {
            $this->load->model('Enrollment_model');
            if (!$this->Enrollment_model->is_user_enrolled($user_id, $course['id'])) {
                $this->session->set_flashdata('error', 'You must be enrolled in this course to reply to discussions');
                redirect('course/' . $course['slug']);
            }
        }
        
        // Process form submission
        if ($this->input->post()) {
            $this->form_validation->set_rules('message', 'Reply', 'required|trim');
            
            if ($this->form_validation->run() === TRUE) {
                $reply_data = [
                    'discussion_id' => $discussion_id,
                    'user_id' => $user_id,
                    'message' => $this->input->post('message'),
                    'is_solution' => ($user_id == $course['instructor_id'] && $this->input->post('is_solution')) ? 1 : 0,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                $result = $this->Discussion_model->create_reply($reply_data);
                
                if ($result) {
                    $this->session->set_flashdata('success', 'Reply added successfully');
                } else {
                    $this->session->set_flashdata('error', 'Failed to add reply');
                }
                
                redirect('discussion/view/' . $discussion_id);
            }
        }
        
        // Get discussion details for the form
        $data['discussion'] = $discussion;
        $data['course'] = $course;
        
        // Load view
        $data['title'] = 'Reply to: ' . $discussion['title'];
        $this->load->view('templates/header', $data);
        $this->load->view('discussion/reply', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Mark a reply as solution
     * 
     * @param int $reply_id
     * @param int $discussion_id
     */
    public function mark_solution($reply_id, $discussion_id) {
        // Verify discussion exists
        $discussion = $this->Discussion_model->get_discussion_by_id($discussion_id);
        if (!$discussion) {
            $this->session->set_flashdata('error', 'Discussion not found');
            redirect('courses');
        }
        
        // Get course info
        $course = $this->Course_model->get_course_by_id($discussion['course_id']);
        
        // Only instructor or admin can mark solutions
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        if ($user_role !== 'admin' && $course['instructor_id'] !== $user_id && $discussion['user_id'] !== $user_id) {
            $this->session->set_flashdata('error', 'You do not have permission to mark solutions');
            redirect('discussion/view/' . $discussion_id);
        }
        
        // Mark reply as solution
        $result = $this->Discussion_model->mark_as_solution($reply_id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Reply marked as solution');
        } else {
            $this->session->set_flashdata('error', 'Failed to mark reply as solution');
        }
        
        redirect('discussion/view/' . $discussion_id);
    }
    
    /**
     * Close a discussion (mark as resolved)
     * 
     * @param int $discussion_id
     */
    public function close($discussion_id) {
        // Verify discussion exists
        $discussion = $this->Discussion_model->get_discussion_by_id($discussion_id);
        if (!$discussion) {
            $this->session->set_flashdata('error', 'Discussion not found');
            redirect('courses');
        }
        
        // Get course info
        $course = $this->Course_model->get_course_by_id($discussion['course_id']);
        
        // Only instructor, admin, or discussion creator can close
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        if ($user_role !== 'admin' && $course['instructor_id'] !== $user_id && $discussion['user_id'] !== $user_id) {
            $this->session->set_flashdata('error', 'You do not have permission to close this discussion');
            redirect('discussion/view/' . $discussion_id);
        }
        
        // Close discussion
        $result = $this->Discussion_model->update_discussion($discussion_id, ['status' => 'closed']);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Discussion closed successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to close discussion');
        }
        
        redirect('discussion/view/' . $discussion_id);
    }
    
    /**
     * View all discussions for a specific course
     * 
     * @param int $course_id
     */
    public function course($course_id) {
        // Redirect to index method with course_id
        redirect('discussion/index/' . $course_id);
    }
}
