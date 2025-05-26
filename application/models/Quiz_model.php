<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get quizzes by module ID
     * 
     * @param int $module_id
     * @return array
     */
    public function get_quizzes_by_module($module_id) {
        $this->db->where('module_id', $module_id);
        $this->db->order_by('order', 'ASC');
        $query = $this->db->get('quizzes');
        return $query->result_array();
    }
    
    /**
     * Get quiz by ID
     * 
     * @param int $quiz_id
     * @return array
     */
    public function get_quiz_by_id($quiz_id) {
        $this->db->where('id', $quiz_id);
        $query = $this->db->get('quizzes');
        return $query->row_array();
    }
    
    /**
     * Create a new quiz
     * 
     * @param array $data
     * @return int|bool The inserted ID or FALSE on failure
     */
    public function create_quiz($data) {
        $this->db->insert('quizzes', $data);
        return $this->db->insert_id() ?: FALSE;
    }
    
    /**
     * Update a quiz
     * 
     * @param int $quiz_id
     * @param array $data
     * @return bool
     */
    public function update_quiz($quiz_id, $data) {
        $this->db->where('id', $quiz_id);
        return $this->db->update('quizzes', $data);
    }
    
    /**
     * Delete a quiz
     * 
     * @param int $quiz_id
     * @return bool
     */
    public function delete_quiz($quiz_id) {
        $this->db->where('id', $quiz_id);
        return $this->db->delete('quizzes');
    }
    
    /**
     * Get quiz questions by quiz ID
     * 
     * @param int $quiz_id
     * @return array
     */
    public function get_questions_by_quiz($quiz_id) {
        $this->db->where('quiz_id', $quiz_id);
        $this->db->order_by('order', 'ASC');
        $query = $this->db->get('quiz_questions');
        return $query->result_array();
    }
    
    /**
     * Get question by ID
     * 
     * @param int $question_id
     * @return array
     */
    public function get_question_by_id($question_id) {
        $this->db->where('id', $question_id);
        $query = $this->db->get('quiz_questions');
        return $query->row_array();
    }
    
    /**
     * Create a new question
     * 
     * @param array $data
     * @return int|bool The inserted ID or FALSE on failure
     */
    public function create_question($data) {
        $this->db->insert('quiz_questions', $data);
        return $this->db->insert_id() ?: FALSE;
    }
    
    /**
     * Update a question
     * 
     * @param int $question_id
     * @param array $data
     * @return bool
     */
    public function update_question($question_id, $data) {
        $this->db->where('id', $question_id);
        return $this->db->update('quiz_questions', $data);
    }
    
    /**
     * Delete a question
     * 
     * @param int $question_id
     * @return bool
     */
    public function delete_question($question_id) {
        $this->db->where('id', $question_id);
        return $this->db->delete('quiz_questions');
    }
    
    /**
     * Get answers by question ID
     * 
     * @param int $question_id
     * @return array
     */
    public function get_answers_by_question($question_id) {
        $this->db->where('question_id', $question_id);
        $this->db->order_by('order', 'ASC');
        $query = $this->db->get('quiz_answers');
        return $query->result_array();
    }
    
    /**
     * Get answer by ID
     * 
     * @param int $answer_id
     * @return array
     */
    public function get_answer_by_id($answer_id) {
        $this->db->where('id', $answer_id);
        $query = $this->db->get('quiz_answers');
        return $query->row_array();
    }
    
    /**
     * Create a new answer
     * 
     * @param array $data
     * @return int|bool The inserted ID or FALSE on failure
     */
    public function create_answer($data) {
        $this->db->insert('quiz_answers', $data);
        return $this->db->insert_id() ?: FALSE;
    }
    
    /**
     * Update an answer
     * 
     * @param int $answer_id
     * @param array $data
     * @return bool
     */
    public function update_answer($answer_id, $data) {
        $this->db->where('id', $answer_id);
        return $this->db->update('quiz_answers', $data);
    }
    
    /**
     * Delete an answer
     * 
     * @param int $answer_id
     * @return bool
     */
    public function delete_answer($answer_id) {
        $this->db->where('id', $answer_id);
        return $this->db->delete('quiz_answers');
    }
    
    /**
     * Create a quiz attempt
     * 
     * @param array $data
     * @return int|bool The inserted ID or FALSE on failure
     */
    public function create_attempt($data) {
        $this->db->insert('quiz_attempts', $data);
        return $this->db->insert_id() ?: FALSE;
    }
    
    /**
     * Update a quiz attempt
     * 
     * @param int $attempt_id
     * @param array $data
     * @return bool
     */
    public function update_attempt($attempt_id, $data) {
        $this->db->where('id', $attempt_id);
        return $this->db->update('quiz_attempts', $data);
    }
    
    /**
     * Get quiz attempt by ID
     * 
     * @param int $attempt_id
     * @return array
     */
    public function get_attempt_by_id($attempt_id) {
        $this->db->where('id', $attempt_id);
        $query = $this->db->get('quiz_attempts');
        return $query->row_array();
    }
    
    /**
     * Get quiz attempts by user and quiz
     * 
     * @param int $user_id
     * @param int $quiz_id
     * @return array
     */
    public function get_attempts_by_user_quiz($user_id, $quiz_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('quiz_id', $quiz_id);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('quiz_attempts');
        return $query->result_array();
    }
    
    /**
     * Save a quiz response
     * 
     * @param array $data
     * @return int|bool The inserted ID or FALSE on failure
     */
    public function save_response($data) {
        $this->db->insert('quiz_responses', $data);
        return $this->db->insert_id() ?: FALSE;
    }
    
    /**
     * Get responses by attempt ID
     * 
     * @param int $attempt_id
     * @return array
     */
    public function get_responses_by_attempt($attempt_id) {
        $this->db->where('attempt_id', $attempt_id);
        $query = $this->db->get('quiz_responses');
        return $query->result_array();
    }
    
    /**
     * Count total questions in a quiz
     * 
     * @param int $quiz_id
     * @return int
     */
    public function count_questions($quiz_id) {
        $this->db->where('quiz_id', $quiz_id);
        return $this->db->count_all_results('quiz_questions');
    }
    
    /**
     * Get total points in a quiz
     * 
     * @param int $quiz_id
     * @return int
     */
    public function get_total_points($quiz_id) {
        $this->db->select_sum('points');
        $this->db->where('quiz_id', $quiz_id);
        $query = $this->db->get('quiz_questions');
        $result = $query->row_array();
        return $result['points'] ?? 0;
    }
    
    /**
     * Calculate quiz score
     * 
     * @param int $attempt_id
     * @return float
     */
    public function calculate_score($attempt_id) {
        // Get total points earned
        $this->db->select_sum('points_earned');
        $this->db->where('attempt_id', $attempt_id);
        $query = $this->db->get('quiz_responses');
        $result = $query->row_array();
        $points_earned = $result['points_earned'] ?? 0;
        
        // Get attempt to find quiz ID
        $attempt = $this->get_attempt_by_id($attempt_id);
        
        if (!$attempt) {
            return 0;
        }
        
        // Get total possible points
        $total_points = $this->get_total_points($attempt['quiz_id']);
        
        if ($total_points == 0) {
            return 0;
        }
        
        // Calculate percentage
        return ($points_earned / $total_points) * 100;
    }
    
    /**
     * Get correct answer for a question
     * 
     * @param int $question_id
     * @return array
     */
    public function get_correct_answer($question_id) {
        $this->db->where('question_id', $question_id);
        $this->db->where('is_correct', 1);
        $query = $this->db->get('quiz_answers');
        return $query->row_array();
    }
    
    /**
     * Get attempt start time
     * 
     * @param int $attempt_id
     * @return string
     */
    public function get_attempt_start_time($attempt_id) {
        $this->db->select('start_time');
        $this->db->where('id', $attempt_id);
        $query = $this->db->get('quiz_attempts');
        $result = $query->row_array();
        return $result ? $result['start_time'] : NULL;
    }
    
    /**
     * Get quiz performance statistics by course
     * 
     * @param int $course_id
     * @return array
     */
    public function get_quiz_performance_by_course($course_id) {
        // Get all quizzes for this course
        $this->db->select('quizzes.id, quizzes.title');
        $this->db->from('quizzes');
        $this->db->join('modules', 'modules.id = quizzes.module_id');
        $this->db->where('modules.course_id', $course_id);
        $this->db->order_by('modules.order', 'ASC');
        $this->db->order_by('quizzes.order', 'ASC');
        $query = $this->db->get();
        $quizzes = $query->result_array();
        
        // Get performance data for each quiz
        foreach ($quizzes as &$quiz) {
            // Get total attempts
            $this->db->select('COUNT(*) as total_attempts, AVG(score) as average_score');
            $this->db->from('quiz_attempts');
            $this->db->where('quiz_id', $quiz['id']);
            $this->db->where('status', 'completed');
            $query = $this->db->get();
            $result = $query->row_array();
            
            $quiz['total_attempts'] = $result['total_attempts'];
            $quiz['average_score'] = $result['average_score'];
            
            // Get pass rate
            $this->db->select('COUNT(*) as passed_count');
            $this->db->from('quiz_attempts');
            $this->db->where('quiz_id', $quiz['id']);
            $this->db->where('status', 'completed');
            $this->db->where('score >=', $this->db->select('pass_percentage')->from('quizzes')->where('id', $quiz['id'])->get()->row()->pass_percentage);
            $query = $this->db->get();
            $result = $query->row_array();
            
            $quiz['passed_count'] = $result['passed_count'];
            $quiz['pass_rate'] = ($quiz['total_attempts'] > 0) ? ($quiz['passed_count'] / $quiz['total_attempts'] * 100) : 0;
        }
        
        return $quizzes;
    }
}
