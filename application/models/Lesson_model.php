<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lesson_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get lessons by module ID
     * 
     * @param int $module_id
     * @return array
     */
    public function get_lessons_by_module($module_id) {
        $this->db->where('module_id', $module_id);
        $this->db->order_by('order', 'ASC');
        $query = $this->db->get('lessons');
        return $query->result_array();
    }
    
    /**
     * Get lesson by ID
     * 
     * @param int $lesson_id
     * @return array
     */
    public function get_lesson_by_id($lesson_id) {
        $this->db->where('id', $lesson_id);
        $query = $this->db->get('lessons');
        return $query->row_array();
    }
    
    /**
     * Create a new lesson
     * 
     * @param array $data
     * @return bool
     */
    public function create_lesson($data) {
        return $this->db->insert('lessons', $data);
    }
    
    /**
     * Update a lesson
     * 
     * @param int $lesson_id
     * @param array $data
     * @return bool
     */
    public function update_lesson($lesson_id, $data) {
        $this->db->where('id', $lesson_id);
        return $this->db->update('lessons', $data);
    }
    
    /**
     * Delete a lesson
     * 
     * @param int $lesson_id
     * @return bool
     */
    public function delete_lesson($lesson_id) {
        $this->db->where('id', $lesson_id);
        return $this->db->delete('lessons');
    }
    
    /**
     * Get the count of lessons in a module
     * 
     * @param int $module_id
     * @return int
     */
    public function count_lessons_in_module($module_id) {
        $this->db->where('module_id', $module_id);
        return $this->db->count_all_results('lessons');
    }
    
    /**
     * Get total duration of lessons in a module (in seconds)
     * 
     * @param int $module_id
     * @return int
     */
    public function get_total_duration_by_module($module_id) {
        $this->db->select_sum('duration');
        $this->db->where('module_id', $module_id);
        $query = $this->db->get('lessons');
        $result = $query->row_array();
        return $result['duration'] ?? 0;
    }
    
    /**
     * Get free lessons by course ID (for preview)
     * 
     * @param int $course_id
     * @return array
     */
    public function get_free_lessons_by_course($course_id) {
        $this->db->select('lessons.*');
        $this->db->from('lessons');
        $this->db->join('modules', 'modules.id = lessons.module_id');
        $this->db->where('modules.course_id', $course_id);
        $this->db->where('lessons.is_free', 1);
        $this->db->where('lessons.status', 'published');
        $this->db->order_by('modules.order', 'ASC');
        $this->db->order_by('lessons.order', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Check if a lesson belongs to a course
     * 
     * @param int $lesson_id
     * @param int $course_id
     * @return bool
     */
    public function is_lesson_in_course($lesson_id, $course_id) {
        $this->db->select('lessons.id');
        $this->db->from('lessons');
        $this->db->join('modules', 'modules.id = lessons.module_id');
        $this->db->where('lessons.id', $lesson_id);
        $this->db->where('modules.course_id', $course_id);
        $query = $this->db->get();
        return $query->num_rows() > 0;
    }
    
    /**
     * Reorder lessons
     * 
     * @param array $lesson_order Array of lesson IDs in the desired order
     * @return bool
     */
    public function reorder_lessons($lesson_order) {
        $success = true;
        
        foreach ($lesson_order as $position => $lesson_id) {
            $data = ['order' => $position];
            $this->db->where('id', $lesson_id);
            $success = $this->db->update('lessons', $data) && $success;
        }
        
        return $success;
    }
    
    /**
     * Get next lesson
     * 
     * @param int $current_lesson_id
     * @param int $course_id
     * @return array|null
     */
    public function get_next_lesson($current_lesson_id, $course_id) {
        // Get current lesson info
        $current_lesson = $this->get_lesson_by_id($current_lesson_id);
        
        if (!$current_lesson) {
            return NULL;
        }
        
        // Check if there's another lesson in the same module
        $this->db->where('module_id', $current_lesson['module_id']);
        $this->db->where('order >', $current_lesson['order']);
        $this->db->order_by('order', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get('lessons');
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        
        // If not, get the first lesson of the next module
        $this->db->select('modules.*');
        $this->db->from('modules');
        $this->db->where('course_id', $course_id);
        $this->db->where('order >', $this->db->get_where('modules', ['id' => $current_lesson['module_id']])->row()->order);
        $this->db->order_by('order', 'ASC');
        $this->db->limit(1);
        $next_module = $this->db->get()->row_array();
        
        if ($next_module) {
            $this->db->where('module_id', $next_module['id']);
            $this->db->order_by('order', 'ASC');
            $this->db->limit(1);
            $query = $this->db->get('lessons');
            
            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
        }
        
        return NULL;
    }
    
    /**
     * Get previous lesson
     * 
     * @param int $current_lesson_id
     * @param int $course_id
     * @return array|null
     */
    public function get_prev_lesson($current_lesson_id, $course_id) {
        // Get current lesson info
        $current_lesson = $this->get_lesson_by_id($current_lesson_id);
        
        if (!$current_lesson) {
            return NULL;
        }
        
        // Check if there's another lesson in the same module
        $this->db->where('module_id', $current_lesson['module_id']);
        $this->db->where('order <', $current_lesson['order']);
        $this->db->order_by('order', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('lessons');
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        
        // If not, get the last lesson of the previous module
        $this->db->select('modules.*');
        $this->db->from('modules');
        $this->db->where('course_id', $course_id);
        $this->db->where('order <', $this->db->get_where('modules', ['id' => $current_lesson['module_id']])->row()->order);
        $this->db->order_by('order', 'DESC');
        $this->db->limit(1);
        $prev_module = $this->db->get()->row_array();
        
        if ($prev_module) {
            $this->db->where('module_id', $prev_module['id']);
            $this->db->order_by('order', 'DESC');
            $this->db->limit(1);
            $query = $this->db->get('lessons');
            
            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
        }
        
        return NULL;
    }
}
