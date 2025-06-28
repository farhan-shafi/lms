<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enrollment_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Enroll a user in a course
     * 
     * @param array $data
     * @return bool
     */
    public function enroll($data) {
        return $this->db->insert('enrollments', $data);
    }
    
    /**
     * Check if a user is enrolled in a course
     * 
     * @param int $user_id
     * @param int $course_id
     * @return bool
     */
    public function is_user_enrolled($user_id, $course_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $this->db->where('status', 'active');
        $query = $this->db->get('enrollments');
        return $query->num_rows() > 0;
    }
    
    /**
     * Get all enrollments for a user
     * 
     * @param int $user_id
     * @return array
     */
    public function get_enrollments_by_user($user_id) {
        $this->db->select('enrollments.*, courses.title, courses.slug, courses.image');
        $this->db->from('enrollments');
        $this->db->join('courses', 'courses.id = enrollments.course_id');
        $this->db->where('enrollments.user_id', $user_id);
        $this->db->where('enrollments.status', 'active');
        $this->db->order_by('enrollments.enrollment_date', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get all students enrolled in a course
     * 
     * @param int $course_id
     * @return array
     */
    public function get_students_by_course($course_id) {
        $this->db->select('enrollments.*, users.name, users.email, users.profile_image');
        $this->db->from('enrollments');
        $this->db->join('users', 'users.id = enrollments.user_id');
        $this->db->where('enrollments.course_id', $course_id);
        $this->db->where('enrollments.status', 'active');
        $this->db->order_by('enrollments.enrollment_date', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Mark a lesson as completed
     * 
     * @param int $user_id
     * @param int $lesson_id
     * @return bool
     */
    public function mark_lesson_completed($user_id, $lesson_id) {
        // Check if already marked as completed
        $this->db->where('user_id', $user_id);
        $this->db->where('lesson_id', $lesson_id);
        $query = $this->db->get('lesson_progress');
        
        if ($query->num_rows() > 0) {
            // Already marked, update completion time
            $this->db->where('user_id', $user_id);
            $this->db->where('lesson_id', $lesson_id);
            return $this->db->update('lesson_progress', ['completion_date' => date('Y-m-d H:i:s'), 'status' => 'completed']);
        } else {
            // New completion record
            $data = [
                'user_id' => $user_id,
                'lesson_id' => $lesson_id,
                'completion_date' => date('Y-m-d H:i:s'),
                'status' => 'completed'
            ];
            return $this->db->insert('lesson_progress', $data);
        }
    }
    
    /**
     * Get course progress percentage
     * 
     * @param int $user_id
     * @param int $course_id
     * @return array
     */
    public function get_course_progress($user_id, $course_id) {
        // Get all lessons for this course
        $this->db->select('lessons.id');
        $this->db->from('lessons');
        $this->db->join('modules', 'modules.id = lessons.module_id');
        $this->db->where('modules.course_id', $course_id);
        $query = $this->db->get();
        $total_lessons = $query->num_rows();
        
        if ($total_lessons == 0) {
            return [
                'percentage' => 0,
                'completed_lessons' => 0,
                'total_lessons' => 0
            ];
        }
        
        // Get completed lessons
        $this->db->select('lesson_progress.lesson_id');
        $this->db->from('lesson_progress');
        $this->db->join('lessons', 'lessons.id = lesson_progress.lesson_id');
        $this->db->join('modules', 'modules.id = lessons.module_id');
        $this->db->where('lesson_progress.user_id', $user_id);
        $this->db->where('lesson_progress.status', 'completed');
        $this->db->where('modules.course_id', $course_id);
        $query = $this->db->get();
        $completed_lessons = $query->num_rows();
        
        // Calculate percentage
        $percentage = ($completed_lessons / $total_lessons) * 100;
        
        return [
            'percentage' => round($percentage),
            'completed_lessons' => $completed_lessons,
            'total_lessons' => $total_lessons
        ];
    }
    
    /**
     * Update last accessed lesson
     * 
     * @param int $user_id
     * @param int $course_id
     * @param int $lesson_id
     * @return bool
     */
    public function update_last_accessed($user_id, $course_id, $lesson_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        
        $data = [
            'last_accessed_lesson' => $lesson_id,
            'last_accessed_date' => date('Y-m-d H:i:s')
        ];
        
        return $this->db->update('enrollments', $data);
    }
    
    /**
     * Get last accessed lesson
     * 
     * @param int $user_id
     * @param int $course_id
     * @return array
     */
    public function get_last_accessed_lesson($user_id, $course_id) {
        $this->db->select('last_accessed_lesson as lesson_id');
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $query = $this->db->get('enrollments');
        return $query->row_array();
    }
    
    /**
     * Check if a lesson is completed
     * 
     * @param int $user_id
     * @param int $lesson_id
     * @return bool
     */
    public function is_lesson_completed($user_id, $lesson_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('lesson_id', $lesson_id);
        $this->db->where('status', 'completed');
        $query = $this->db->get('lesson_progress');
        return $query->num_rows() > 0;
    }
    
    /**
     * Get all completed lessons for a user in a course
     * 
     * @param int $user_id
     * @param int $course_id
     * @return array
     */
    public function get_completed_lessons($user_id, $course_id) {
        $this->db->select('lesson_progress.lesson_id');
        $this->db->from('lesson_progress');
        $this->db->join('lessons', 'lessons.id = lesson_progress.lesson_id');
        $this->db->join('modules', 'modules.id = lessons.module_id');
        $this->db->where('lesson_progress.user_id', $user_id);
        $this->db->where('lesson_progress.status', 'completed');
        $this->db->where('modules.course_id', $course_id);
        $query = $this->db->get();
        
        $completed = [];
        foreach ($query->result_array() as $row) {
            $completed[] = $row['lesson_id'];
        }
        
        return $completed;
    }
    
    /**
     * Get certificate data for a completed course
     * 
     * @param int $user_id
     * @param int $course_id
     * @return array|bool
     */
    public function get_certificate($user_id, $course_id) {
        // Check if course is completed
        $progress = $this->get_course_progress($user_id, $course_id);
        
        if ($progress['percentage'] < 100) {
            return FALSE;
        }
        
        // Get enrollment info
        $this->db->select('enrollments.*, courses.title as course_title, users.name as student_name');
        $this->db->from('enrollments');
        $this->db->join('courses', 'courses.id = enrollments.course_id');
        $this->db->join('users', 'users.id = enrollments.user_id');
        $this->db->where('enrollments.user_id', $user_id);
        $this->db->where('enrollments.course_id', $course_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 0) {
            return FALSE;
        }
        
        $enrollment = $query->row_array();
        
        // Generate certificate number if not exists
        if (!$enrollment['certificate_number']) {
            $random = substr(uniqid(), -4);
            $certificate_number = 'CERT-' . date('Y') . '-' . $course_id . '-' . $user_id . '-' . $random;
            
            $this->db->where('user_id', $user_id);
            $this->db->where('course_id', $course_id);
            $this->db->update('enrollments', ['certificate_number' => $certificate_number]);
            
            $enrollment['certificate_number'] = $certificate_number;
        }
        
        // Add completion date if not exists
        if (!$enrollment['completion_date']) {
            $this->db->where('user_id', $user_id);
            $this->db->where('course_id', $course_id);
            $this->db->update('enrollments', ['completion_date' => date('Y-m-d H:i:s')]);
            
            $enrollment['completion_date'] = date('Y-m-d H:i:s');
        }
        
        return $enrollment;
    }
    
    /**
     * Get recent enrollments for an instructor
     * 
     * @param int $instructor_id
     * @param int $limit
     * @return array
     */
    public function get_recent_enrollments_by_instructor($instructor_id, $limit = 5) {
        $this->db->select('enrollments.*, courses.title as course_title, users.name as student_name');
        $this->db->from('enrollments');
        $this->db->join('courses', 'courses.id = enrollments.course_id');
        $this->db->join('users', 'users.id = enrollments.user_id');
        $this->db->where('courses.instructor_id', $instructor_id);
        $this->db->order_by('enrollments.enrollment_date', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get lesson completion statistics for a course
     * 
     * @param int $course_id
     * @return array
     */
    public function get_lesson_completion_stats($course_id) {
        // Get all lessons for this course
        $this->db->select('lessons.id, lessons.title');
        $this->db->from('lessons');
        $this->db->join('modules', 'modules.id = lessons.module_id');
        $this->db->where('modules.course_id', $course_id);
        $this->db->order_by('modules.order', 'ASC');
        $this->db->order_by('lessons.order', 'ASC');
        $query = $this->db->get();
        $lessons = $query->result_array();
        
        // Get completion data for each lesson
        foreach ($lessons as &$lesson) {
            $this->db->select('COUNT(DISTINCT user_id) as completion_count');
            $this->db->from('lesson_progress');
            $this->db->where('lesson_id', $lesson['id']);
            $this->db->where('status', 'completed');
            $query = $this->db->get();
            $result = $query->row_array();
            $lesson['completion_count'] = $result['completion_count'];
        }
        
        return $lessons;
    }
    
    /**
     * Get all enrollments in the system
     * 
     * @param string $status Optional enrollment status filter
     * @return array
     */
    public function get_all_enrollments($status = null) {
        $this->db->select('enrollments.*, courses.title as course_title, users.name as student_name, users.email as student_email');
        $this->db->from('enrollments');
        $this->db->join('courses', 'courses.id = enrollments.course_id');
        $this->db->join('users', 'users.id = enrollments.user_id');
        
        if ($status) {
            $this->db->where('enrollments.status', $status);
        }
        
        $this->db->order_by('enrollments.enrollment_date', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get specific enrollment for a user and course
     * 
     * @param int $user_id
     * @param int $course_id
     * @return array|null
     */
    public function get_enrollment($user_id, $course_id) {
        $this->db->select('*');
        $this->db->from('enrollments');
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $query = $this->db->get();
        return $query->row_array();
    }
}
