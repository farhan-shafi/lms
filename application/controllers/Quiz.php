<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Quiz Controller
 *
 * This controller handles quiz operations including taking quizzes and viewing results
 */
class Quiz extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Quiz_model');
        $this->load->model('Course_model');
        $this->load->model('Module_model');
        $this->load->model('Enrollment_model');
    }
    
    /**
     * Take a quiz
     */
    public function take($quiz_id) {
        // Check if user is logged in
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Please login to take this quiz');
            redirect('auth/login');
        }
        
        // Check if quiz exists
        $data['quiz'] = $this->Quiz_model->get_quiz_by_id($quiz_id);
        if (!$data['quiz']) {
            show_404();
        }
        
        // Get module and course info
        $data['module'] = $this->Module_model->get_module_by_id($data['quiz']['module_id']);
        $data['course'] = $this->Course_model->get_course_by_id($data['module']['course_id']);
        
        // Check if user is enrolled in the course
        $user_id = $this->session->userdata('user_id');
        if (!$this->Enrollment_model->is_user_enrolled($user_id, $data['course']['id'])) {
            $this->session->set_flashdata('error', 'You must be enrolled in this course to take the quiz');
            redirect('course/view/' . $data['course']['slug']);
        }
        
        // Check if attempt is in progress
        $this->load->library('session');
        $current_attempt = $this->session->userdata('quiz_attempt');
        
        if ($current_attempt && $current_attempt['quiz_id'] == $quiz_id) {
            // Resume existing attempt
            $data['attempt'] = $current_attempt;
            $data['current_question'] = $current_attempt['current_question'];
            $data['questions'] = $this->Quiz_model->get_questions_by_quiz($quiz_id);
            $data['total_questions'] = count($data['questions']);
            
            if ($data['current_question'] > $data['total_questions']) {
                // All questions answered, redirect to submit
                redirect('quiz/submit/' . $quiz_id);
            }
            
            $data['question'] = $data['questions'][$data['current_question'] - 1];
            $data['answers'] = $this->Quiz_model->get_answers_by_question($data['question']['id']);
        } else {
            // Start new attempt
            $data['questions'] = $this->Quiz_model->get_questions_by_quiz($quiz_id);
            $data['total_questions'] = count($data['questions']);
            
            if ($data['total_questions'] == 0) {
                $this->session->set_flashdata('error', 'This quiz has no questions');
                redirect('course/learn/' . $data['course']['id']);
            }
            
            // Create new attempt
            $attempt_data = [
                'quiz_id' => $quiz_id,
                'user_id' => $user_id,
                'start_time' => date('Y-m-d H:i:s'),
                'status' => 'in_progress'
            ];
            
            $attempt_id = $this->Quiz_model->create_attempt($attempt_data);
            
            if (!$attempt_id) {
                $this->session->set_flashdata('error', 'Failed to start quiz attempt');
                redirect('course/learn/' . $data['course']['id']);
            }
            
            // Store attempt info in session
            $attempt = [
                'id' => $attempt_id,
                'quiz_id' => $quiz_id,
                'current_question' => 1,
                'answers' => []
            ];
            
            $this->session->set_userdata('quiz_attempt', $attempt);
            
            $data['attempt'] = $attempt;
            $data['current_question'] = 1;
            $data['question'] = $data['questions'][0];
            $data['answers'] = $this->Quiz_model->get_answers_by_question($data['question']['id']);
        }
        
        // Page metadata
        $data['title'] = 'Quiz: ' . $data['quiz']['title'];
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('quiz/take', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Process quiz answer
     */
    public function answer() {
        // Check if user is logged in
        if (!$this->session->userdata('user_id')) {
            $this->output->set_status_header(403);
            echo json_encode(['error' => 'Please login to continue']);
            return;
        }
        
        // Validate form
        $this->form_validation->set_rules('question_id', 'Question', 'required|numeric');
        $this->form_validation->set_rules('answer_id', 'Answer', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_status_header(400);
            echo json_encode(['error' => validation_errors()]);
            return;
        }
        
        // Get current attempt
        $attempt = $this->session->userdata('quiz_attempt');
        
        if (!$attempt) {
            $this->output->set_status_header(400);
            echo json_encode(['error' => 'No active quiz attempt found']);
            return;
        }
        
        // Process answer
        $question_id = $this->input->post('question_id');
        $answer_id = $this->input->post('answer_id');
        
        // Check if the answer is correct
        $question = $this->Quiz_model->get_question_by_id($question_id);
        $correct_answer = $this->Quiz_model->get_correct_answer($question_id);
        
        $is_correct = ($correct_answer && $correct_answer['id'] == $answer_id);
        $points_earned = $is_correct ? $question['points'] : 0;
        
        // Save response
        $response_data = [
            'attempt_id' => $attempt['id'],
            'question_id' => $question_id,
            'answer_id' => $answer_id,
            'is_correct' => $is_correct ? 1 : 0,
            'points_earned' => $points_earned
        ];
        
        $this->Quiz_model->save_response($response_data);
        
        // Update attempt session data
        $attempt['answers'][$question_id] = [
            'answer_id' => $answer_id,
            'is_correct' => $is_correct
        ];
        
        $attempt['current_question']++;
        $this->session->set_userdata('quiz_attempt', $attempt);
        
        // Get next question or finish
        $questions = $this->Quiz_model->get_questions_by_quiz($attempt['quiz_id']);
        $total_questions = count($questions);
        
        if ($attempt['current_question'] > $total_questions) {
            // All questions answered
            echo json_encode([
                'status' => 'completed',
                'redirect' => site_url('quiz/submit/' . $attempt['quiz_id'])
            ]);
        } else {
            // Move to next question
            $next_question = $questions[$attempt['current_question'] - 1];
            $next_answers = $this->Quiz_model->get_answers_by_question($next_question['id']);
            
            echo json_encode([
                'status' => 'next',
                'current_question' => $attempt['current_question'],
                'total_questions' => $total_questions,
                'question' => $next_question,
                'answers' => $next_answers
            ]);
        }
    }
    
    /**
     * Submit quiz
     */
    public function submit($quiz_id) {
        // Check if user is logged in
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Please login to continue');
            redirect('auth/login');
        }
        
        // Get current attempt
        $attempt = $this->session->userdata('quiz_attempt');
        
        if (!$attempt || $attempt['quiz_id'] != $quiz_id) {
            $this->session->set_flashdata('error', 'No active quiz attempt found');
            redirect('course/learn');
        }
        
        // Get quiz info
        $data['quiz'] = $this->Quiz_model->get_quiz_by_id($quiz_id);
        if (!$data['quiz']) {
            show_404();
        }
        
        // Calculate score
        $score = $this->Quiz_model->calculate_score($attempt['id']);
        $end_time = date('Y-m-d H:i:s');
        
        // Update attempt
        $attempt_data = [
            'end_time' => $end_time,
            'score' => $score,
            'status' => 'completed'
        ];
        
        $this->Quiz_model->update_attempt($attempt['id'], $attempt_data);
        
        // Clear session
        $this->session->unset_userdata('quiz_attempt');
        
        // Get responses for review
        $data['responses'] = $this->Quiz_model->get_responses_by_attempt($attempt['id']);
        $data['questions'] = [];
        $data['correct_answers'] = [];
        
        foreach ($data['responses'] as $response) {
            $data['questions'][$response['question_id']] = $this->Quiz_model->get_question_by_id($response['question_id']);
            $data['correct_answers'][$response['question_id']] = $this->Quiz_model->get_correct_answer($response['question_id']);
        }
        
        // Get module and course info
        $data['module'] = $this->Module_model->get_module_by_id($data['quiz']['module_id']);
        $data['course'] = $this->Course_model->get_course_by_id($data['module']['course_id']);
        
        // Pass attempt data to view
        $data['attempt'] = [
            'id' => $attempt['id'],
            'score' => $score,
            'start_time' => $this->Quiz_model->get_attempt_start_time($attempt['id']),
            'end_time' => $end_time
        ];
        
        // Page metadata
        $data['title'] = 'Quiz Results: ' . $data['quiz']['title'];
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('quiz/results', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * View quiz result history
     */
    public function history($quiz_id) {
        // Check if user is logged in
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Please login to view your quiz history');
            redirect('auth/login');
        }
        
        // Check if quiz exists
        $data['quiz'] = $this->Quiz_model->get_quiz_by_id($quiz_id);
        if (!$data['quiz']) {
            show_404();
        }
        
        // Get module and course info
        $data['module'] = $this->Module_model->get_module_by_id($data['quiz']['module_id']);
        $data['course'] = $this->Course_model->get_course_by_id($data['module']['course_id']);
        
        // Check if user is enrolled in the course
        $user_id = $this->session->userdata('user_id');
        if (!$this->Enrollment_model->is_user_enrolled($user_id, $data['course']['id'])) {
            $this->session->set_flashdata('error', 'You must be enrolled in this course to view quiz history');
            redirect('course/view/' . $data['course']['slug']);
        }
        
        // Get attempt history
        $data['attempts'] = $this->Quiz_model->get_attempts_by_user_quiz($user_id, $quiz_id);
        
        // Page metadata
        $data['title'] = 'Quiz History: ' . $data['quiz']['title'];
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('quiz/history', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * View a specific quiz attempt
     */
    public function review($attempt_id) {
        // Check if user is logged in
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Please login to view quiz results');
            redirect('auth/login');
        }
        
        // Get attempt info
        $data['attempt'] = $this->Quiz_model->get_attempt_by_id($attempt_id);
        if (!$data['attempt']) {
            show_404();
        }
        
        // Check if this attempt belongs to the user
        $user_id = $this->session->userdata('user_id');
        if ($data['attempt']['user_id'] != $user_id) {
            $this->session->set_flashdata('error', 'You do not have permission to view this attempt');
            redirect('dashboard');
        }
        
        // Get quiz info
        $data['quiz'] = $this->Quiz_model->get_quiz_by_id($data['attempt']['quiz_id']);
        
        // Get module and course info
        $data['module'] = $this->Module_model->get_module_by_id($data['quiz']['module_id']);
        $data['course'] = $this->Course_model->get_course_by_id($data['module']['course_id']);
        
        // Get responses for review
        $data['responses'] = $this->Quiz_model->get_responses_by_attempt($attempt_id);
        $data['questions'] = [];
        $data['correct_answers'] = [];
        
        foreach ($data['responses'] as $response) {
            $data['questions'][$response['question_id']] = $this->Quiz_model->get_question_by_id($response['question_id']);
            $data['correct_answers'][$response['question_id']] = $this->Quiz_model->get_correct_answer($response['question_id']);
        }
        
        // Page metadata
        $data['title'] = 'Quiz Review: ' . $data['quiz']['title'];
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('quiz/review', $data);
        $this->load->view('templates/footer');
    }
}
