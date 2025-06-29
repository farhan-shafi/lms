<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Progress Model
 * 
 * Handles tracking student progress through courses, modules, lessons, and quizzes
 */
class Progress_model extends CI_Model {
    
    /**
     * Get user's progress for a specific course
     * 
     * @param int $user_id
     * @param int $course_id
     * @return array Course progress data
     */
    public function get_course_progress($user_id, $course_id) {
        // Get total course items (lessons + quizzes)
        $this->db->select('COUNT(*) as total');
        $this->db->from('lessons');
        $this->db->join('modules', 'modules.id = lessons.module_id');
        $this->db->where('modules.course_id', $course_id);
        $lesson_query = $this->db->get();
        $lesson_count = $lesson_query->row()->total;
        
        $this->db->select('COUNT(*) as total');
        $this->db->from('quizzes');
        $this->db->join('modules', 'modules.id = quizzes.module_id');
        $this->db->where('modules.course_id', $course_id);
        $quiz_query = $this->db->get();
        $quiz_count = $quiz_query->row()->total;
        
        $total_items = $lesson_count + $quiz_count;
        
        // Get completed items
        $this->db->select('COUNT(*) as completed');
        $this->db->from('progress_tracking');
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $this->db->where('status', 'completed');
        $completed_query = $this->db->get();
        $completed_items = $completed_query->row()->completed;
        
        // Calculate percentage
        $percentage = ($total_items > 0) ? round(($completed_items / $total_items) * 100) : 0;
        
        return [
            'total_items' => $total_items,
            'completed_items' => $completed_items,
            'percentage' => $percentage
        ];
    }
    
    /**
     * Get user's progress for a specific module
     * 
     * @param int $user_id
     * @param int $module_id
     * @return array Module progress data
     */
    public function get_module_progress($user_id, $module_id) {
        // Get module details
        $this->db->select('course_id');
        $this->db->from('modules');
        $this->db->where('id', $module_id);
        $module = $this->db->get()->row_array();
        
        // Get total module items (lessons + quizzes)
        $this->db->select('COUNT(*) as total');
        $this->db->from('lessons');
        $this->db->where('module_id', $module_id);
        $lesson_query = $this->db->get();
        $lesson_count = $lesson_query->row()->total;
        
        $this->db->select('COUNT(*) as total');
        $this->db->from('quizzes');
        $this->db->where('module_id', $module_id);
        $quiz_query = $this->db->get();
        $quiz_count = $quiz_query->row()->total;
        
        $total_items = $lesson_count + $quiz_count;
        
        // Get completed items
        $this->db->select('COUNT(*) as completed');
        $this->db->from('progress_tracking');
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $module['course_id']);
        $this->db->where('module_id', $module_id);
        $this->db->where('status', 'completed');
        $completed_query = $this->db->get();
        $completed_items = $completed_query->row()->completed;
        
        // Calculate percentage
        $percentage = ($total_items > 0) ? round(($completed_items / $total_items) * 100) : 0;
        
        return [
            'total_items' => $total_items,
            'completed_items' => $completed_items,
            'percentage' => $percentage
        ];
    }
    
    /**
     * Mark a lesson as completed
     * 
     * @param int $user_id
     * @param int $lesson_id
     * @return bool Success or failure
     */
    public function complete_lesson($user_id, $lesson_id) {
        // Get lesson details
        $this->db->select('lessons.id, modules.id as module_id, modules.course_id');
        $this->db->from('lessons');
        $this->db->join('modules', 'modules.id = lessons.module_id');
        $this->db->where('lessons.id', $lesson_id);
        $lesson = $this->db->get()->row_array();
        
        if (!$lesson) {
            return false;
        }
        
        // Check if progress record already exists
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $lesson['course_id']);
        $this->db->where('module_id', $lesson['module_id']);
        $this->db->where('lesson_id', $lesson_id);
        $existing = $this->db->get('progress_tracking')->row();
        
        if ($existing) {
            // Update existing record
            $this->db->where('id', $existing->id);
            return $this->db->update('progress_tracking', [
                'status' => 'completed',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            // Create new record
            return $this->db->insert('progress_tracking', [
                'user_id' => $user_id,
                'course_id' => $lesson['course_id'],
                'module_id' => $lesson['module_id'],
                'lesson_id' => $lesson_id,
                'status' => 'completed',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
    
    /**
     * Mark a quiz as completed
     * 
     * @param int $user_id
     * @param int $quiz_id
     * @param int $score Optional score percentage
     * @return bool Success or failure
     */
    public function complete_quiz($user_id, $quiz_id, $score = NULL) {
        // Get quiz details
        $this->db->select('quizzes.id, modules.id as module_id, modules.course_id');
        $this->db->from('quizzes');
        $this->db->join('modules', 'modules.id = quizzes.module_id');
        $this->db->where('quizzes.id', $quiz_id);
        $quiz = $this->db->get()->row_array();
        
        if (!$quiz) {
            return false;
        }
        
        // Check if progress record already exists
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $quiz['course_id']);
        $this->db->where('module_id', $quiz['module_id']);
        $this->db->where('quiz_id', $quiz_id);
        $existing = $this->db->get('progress_tracking')->row();
        
        $data = [
            'status' => 'completed',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if ($score !== NULL) {
            $data['score'] = $score;
        }
        
        if ($existing) {
            // Update existing record
            $this->db->where('id', $existing->id);
            return $this->db->update('progress_tracking', $data);
        } else {
            // Create new record
            $data['user_id'] = $user_id;
            $data['course_id'] = $quiz['course_id'];
            $data['module_id'] = $quiz['module_id'];
            $data['quiz_id'] = $quiz_id;
            $data['created_at'] = date('Y-m-d H:i:s');
            
            return $this->db->insert('progress_tracking', $data);
        }
    }
    
    /**
     * Check if a lesson is completed
     * 
     * @param int $user_id
     * @param int $lesson_id
     * @return bool True if completed, false otherwise
     */
    public function is_lesson_completed($user_id, $lesson_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('lesson_id', $lesson_id);
        $this->db->where('status', 'completed');
        $query = $this->db->get('progress_tracking');
        
        return ($query->num_rows() > 0);
    }
    
    /**
     * Check if a quiz is completed
     * 
     * @param int $user_id
     * @param int $quiz_id
     * @return bool True if completed, false otherwise
     */
    public function is_quiz_completed($user_id, $quiz_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('quiz_id', $quiz_id);
        $this->db->where('status', 'completed');
        $query = $this->db->get('progress_tracking');
        
        return ($query->num_rows() > 0);
    }
    
    /**
     * Get quiz score
     * 
     * @param int $user_id
     * @param int $quiz_id
     * @return int|null Score percentage or null if not completed
     */
    public function get_quiz_score($user_id, $quiz_id) {
        $this->db->select('score');
        $this->db->where('user_id', $user_id);
        $this->db->where('quiz_id', $quiz_id);
        $this->db->where('status', 'completed');
        $query = $this->db->get('progress_tracking');
        
        return ($query->num_rows() > 0) ? $query->row()->score : NULL;
    }
    
    /**
     * Get user's progress across all enrolled courses
     * 
     * @param int $user_id
     * @return array Progress data for all courses
     */
    public function get_user_progress_summary($user_id) {
        // Get all enrolled courses
        $this->db->select('enrollments.course_id, courses.title');
        $this->db->from('enrollments');
        $this->db->join('courses', 'courses.id = enrollments.course_id');
        $this->db->where('enrollments.user_id', $user_id);
        $enrolled_courses = $this->db->get()->result_array();
        
        $progress_data = [];
        foreach ($enrolled_courses as $course) {
            $progress_data[$course['course_id']] = [
                'course_title' => $course['title'],
                'progress' => $this->get_course_progress($user_id, $course['course_id'])
            ];
        }
        
        return $progress_data;
    }
    
    /**
     * Reset progress for a user
     * 
     * @param int $user_id
     * @param array $params Reset parameters
     * @return bool
     */
    public function reset_progress($user_id, $params) {
        $conditions = ['user_id' => $user_id];
        
        if (isset($params['course_id'])) {
            $conditions['course_id'] = $params['course_id'];
        }
        
        if (isset($params['module_id'])) {
            $conditions['module_id'] = $params['module_id'];
        }
        
        return $this->db->delete('progress_tracking', $conditions);
    }
    
    /**
     * Get course progress for all enrolled courses of a user
     * 
     * @param int $user_id
     * @return array
     */
    public function get_all_course_progress($user_id) {
        // Get all enrolled courses
        $this->db->select('e.course_id');
        $this->db->from('enrollments e');
        $this->db->where('e.user_id', $user_id);
        $enrolled_courses = $this->db->get()->result_array();
        
        $progress_data = [];
        
        foreach ($enrolled_courses as $enrollment) {
            $course_id = $enrollment['course_id'];
            $progress = $this->get_course_progress($user_id, $course_id);
            
            $progress_data[] = [
                'course_id' => $course_id,
                'progress' => $progress['percentage'],
                'total_items' => $progress['total_items'],
                'completed_items' => $progress['completed_items']
            ];
        }
        
        return $progress_data;
    }
}
