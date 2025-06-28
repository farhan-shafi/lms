<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement extends Auth_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Course_model');
        $this->load->model('Enrollment_model');
        $this->load->model('Announcement_model');
    }
    
    /**
     * View announcements for a course
     * 
     * @param int $course_id
     */
    public function index($course_id) {
        // Check if course exists
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) {
            $this->session->set_flashdata('error', 'Course not found');
            redirect('courses');
        }
        
        // Check if user is enrolled or is instructor/admin
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        if ($user_role !== 'admin' && $course['instructor_id'] != $user_id) {
            // Check enrollment
            if (!$this->Enrollment_model->is_user_enrolled($user_id, $course_id)) {
                $this->session->set_flashdata('error', 'You must be enrolled in this course to view announcements');
                redirect('course/' . $course['slug']);
            }
        }
        
        // Get announcements
        $data['announcements'] = $this->Announcement_model->get_announcements_by_course($course_id);
        $data['course'] = $course;
        $data['title'] = 'Course Announcements - ' . $course['title'];
        
        $this->load->view('templates/header', $data);
        $this->load->view('announcement/index', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Create a new announcement (instructor only)
     * 
     * @param int $course_id
     */
    public function create($course_id) {
        // Check if course exists
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) {
            $this->session->set_flashdata('error', 'Course not found');
            redirect('instructor/courses');
        }
        
        // Check if user is instructor of this course or admin
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        if ($user_role !== 'admin' && $course['instructor_id'] != $user_id) {
            $this->session->set_flashdata('error', 'You do not have permission to create announcements for this course');
            redirect('course/' . $course['slug']);
        }
        
        // Process form submission
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim');
            $this->form_validation->set_rules('message', 'Message', 'required|trim');
            
            if ($this->form_validation->run() === TRUE) {
                $data = [
                    'course_id' => $course_id,
                    'user_id' => $user_id,
                    'title' => $this->input->post('title'),
                    'message' => $this->input->post('message'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                $result = $this->Announcement_model->create_announcement($data);
                
                if ($result) {
                    $this->session->set_flashdata('success', 'Announcement created successfully');
                    redirect('announcement/index/' . $course_id);
                } else {
                    $this->session->set_flashdata('error', 'Failed to create announcement');
                }
            }
        }
        
        $data['course'] = $course;
        $data['title'] = 'Create Announcement - ' . $course['title'];
        
        $this->load->view('templates/header', $data);
        $this->load->view('announcement/create', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Edit an announcement (instructor only)
     * 
     * @param int $announcement_id
     */
    public function edit($announcement_id) {
        // Get announcement
        $announcement = $this->Announcement_model->get_announcement_by_id($announcement_id);
        if (!$announcement) {
            $this->session->set_flashdata('error', 'Announcement not found');
            redirect('instructor/courses');
        }
        
        // Get course
        $course = $this->Course_model->get_course_by_id($announcement['course_id']);
        
        // Check if user is instructor of this course or admin
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        if ($user_role !== 'admin' && $course['instructor_id'] != $user_id) {
            $this->session->set_flashdata('error', 'You do not have permission to edit this announcement');
            redirect('announcement/index/' . $announcement['course_id']);
        }
        
        // Process form submission
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|trim');
            $this->form_validation->set_rules('message', 'Message', 'required|trim');
            
            if ($this->form_validation->run() === TRUE) {
                $data = [
                    'title' => $this->input->post('title'),
                    'message' => $this->input->post('message'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                $result = $this->Announcement_model->update_announcement($announcement_id, $data);
                
                if ($result) {
                    $this->session->set_flashdata('success', 'Announcement updated successfully');
                    redirect('announcement/index/' . $announcement['course_id']);
                } else {
                    $this->session->set_flashdata('error', 'Failed to update announcement');
                }
            }
        }
        
        $data['announcement'] = $announcement;
        $data['course'] = $course;
        $data['title'] = 'Edit Announcement - ' . $course['title'];
        
        $this->load->view('templates/header', $data);
        $this->load->view('announcement/edit', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Delete an announcement (instructor only)
     * 
     * @param int $announcement_id
     */
    public function delete($announcement_id) {
        // Get announcement
        $announcement = $this->Announcement_model->get_announcement_by_id($announcement_id);
        if (!$announcement) {
            $this->session->set_flashdata('error', 'Announcement not found');
            redirect('instructor/courses');
        }
        
        // Get course
        $course = $this->Course_model->get_course_by_id($announcement['course_id']);
        
        // Check if user is instructor of this course or admin
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        if ($user_role !== 'admin' && $course['instructor_id'] != $user_id) {
            $this->session->set_flashdata('error', 'You do not have permission to delete this announcement');
            redirect('announcement/index/' . $announcement['course_id']);
        }
        
        // Delete announcement
        $result = $this->Announcement_model->delete_announcement($announcement_id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Announcement deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete announcement');
        }
        
        redirect('announcement/index/' . $announcement['course_id']);
    }
    
    /**
     * View a single announcement
     * 
     * @param int $announcement_id
     */
    public function view($announcement_id) {
        // Get announcement
        $announcement = $this->Announcement_model->get_announcement_by_id($announcement_id);
        if (!$announcement) {
            $this->session->set_flashdata('error', 'Announcement not found');
            redirect('courses');
        }
        
        // Get course
        $course = $this->Course_model->get_course_by_id($announcement['course_id']);
        
        // Check if user is enrolled or is instructor/admin
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        if ($user_role !== 'admin' && $course['instructor_id'] != $user_id) {
            // Check enrollment
            if (!$this->Enrollment_model->is_user_enrolled($user_id, $announcement['course_id'])) {
                $this->session->set_flashdata('error', 'You must be enrolled in this course to view announcements');
                redirect('course/' . $course['slug']);
            }
        }
        
        // Get instructor info
        $this->load->model('User_model');
        $instructor = $this->User_model->get_user_by_id($announcement['user_id']);
        
        $data['announcement'] = $announcement;
        $data['course'] = $course;
        $data['instructor'] = $instructor;
        $data['title'] = $announcement['title'] . ' - ' . $course['title'];
        
        $this->load->view('templates/header', $data);
        $this->load->view('announcement/view', $data);
        $this->load->view('templates/footer');
    }
}
