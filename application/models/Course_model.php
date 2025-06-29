<?php
class Course_model extends CI_Model {
    public function create_course($data) {
        return $this->db->insert('courses', $data);
    }

    public function get_courses_by_instructor($instructor_id) {
        return $this->db->get_where('courses', ['instructor_id' => $instructor_id])->result_array();
    }
    
    /**
     * Get a course by its ID
     * 
     * @param int $id
     * @return array
     */
    public function get_course_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('courses');
        return $query->row_array();
    }
    
    /**
     * Get a course by its slug
     * 
     * @param string $slug
     * @return array
     */
    public function get_course_by_slug($slug) {
        $this->db->where('slug', $slug);
        $query = $this->db->get('courses');
        return $query->row_array();
    }
    
    /**
     * Update a course
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update_course($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('courses', $data);
    }
    
    /**
     * Delete a course
     * 
     * @param int $id
     * @return bool
     */
    public function delete_course($id) {
        $this->db->where('id', $id);
        return $this->db->delete('courses');
    }
    
    /**
     * Get featured courses
     * 
     * @param int $limit
     * @return array
     */
    public function get_featured_courses($limit = 6) {
        $this->db->where('featured', 1);
        $this->db->where('status', 'published');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('courses');
        return $query->result_array();
    }
    
    /**
     * Get latest courses
     * 
     * @param int $limit
     * @return array
     */
    public function get_latest_courses($limit = 8) {
        $this->db->where('status', 'published');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('courses');
        return $query->result_array();
    }
    
    /**
     * Get popular courses based on enrollments
     * 
     * @param int $limit
     * @return array
     */
    public function get_popular_courses($limit = 8) {
        $this->db->where('status', 'published');
        $this->db->order_by('total_enrollments', 'DESC');
        $this->db->order_by('average_rating', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('courses');
        return $query->result_array();
    }
    
    /**
     * Get all courses with pagination and sorting
     * 
     * @param int $limit
     * @param int $offset
     * @param string $sort Sorting option (latest, popular, price_low, price_high)
     * @return array
     */
    public function get_all_courses($limit = null, $offset = null, $sort = 'latest') {
        $this->db->where('status', 'published');
        
        // Apply sorting
        switch ($sort) {
            case 'popular':
                $this->db->order_by('total_enrollments', 'DESC');
                $this->db->order_by('average_rating', 'DESC');
                break;
            case 'price_low':
                $this->db->order_by('price', 'ASC');
                break;
            case 'price_high':
                $this->db->order_by('price', 'DESC');
                break;
            case 'latest':
            default:
                $this->db->order_by('created_at', 'DESC');
                break;
        }
        
        if ($limit && $offset) {
            $this->db->limit($limit, $offset);
        } elseif ($limit) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get('courses');
        return $query->result_array();
    }
    
    /**
     * Get courses by category with sorting
     * 
     * @param int $category_id
     * @param int $limit
     * @param int $offset
     * @param string $sort Sorting option (latest, popular, price_low, price_high)
     * @return array
     */
    public function get_courses_by_category($category_id, $limit = null, $offset = null, $sort = 'latest') {
        $this->db->where('category_id', $category_id);
        $this->db->where('status', 'published');
        
        // Apply sorting
        switch ($sort) {
            case 'popular':
                $this->db->order_by('total_enrollments', 'DESC');
                $this->db->order_by('average_rating', 'DESC');
                break;
            case 'price_low':
                $this->db->order_by('price', 'ASC');
                break;
            case 'price_high':
                $this->db->order_by('price', 'DESC');
                break;
            case 'latest':
            default:
                $this->db->order_by('created_at', 'DESC');
                break;
        }
        
        if ($limit && $offset) {
            $this->db->limit($limit, $offset);
        } elseif ($limit) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get('courses');
        return $query->result_array();
    }
    
    /**
     * Search courses
     * 
     * @param string $search_term
     * @param int $limit
     * @param int $offset
     * @param string $sort Sorting option (latest, popular, price_low, price_high)
     * @return array
     */
    public function search_courses($search_term, $limit = null, $offset = null, $sort = 'latest') {
        $this->db->where('status', 'published');
        $this->db->group_start();
        $this->db->like('title', $search_term);
        $this->db->or_like('description', $search_term);
        $this->db->group_end();
        
        // Apply sorting
        switch ($sort) {
            case 'popular':
                $this->db->order_by('total_enrollments', 'DESC');
                $this->db->order_by('average_rating', 'DESC');
                break;
            case 'price_low':
                $this->db->order_by('price', 'ASC');
                break;
            case 'price_high':
                $this->db->order_by('price', 'DESC');
                break;
            case 'latest':
            default:
                $this->db->order_by('created_at', 'DESC');
                break;
        }
        
        if ($limit && $offset) {
            $this->db->limit($limit, $offset);
        } elseif ($limit) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get('courses');
        return $query->result_array();
    }
    
    /**
     * Get total courses
     * 
     * @param int $category_id Optional category filter
     * @param string $search Optional search term
     * @return int
     */
    public function get_total_courses($category_id = NULL, $search = NULL) {
        $this->db->where('status', 'published');
        
        if ($category_id) {
            $this->db->where('category_id', $category_id);
        }
        
        if ($search) {
            $this->db->group_start();
            $this->db->like('title', $search);
            $this->db->or_like('description', $search);
            $this->db->group_end();
        }
        
        return $this->db->count_all_results('courses');
    }
    
    /**
     * Get total enrollments across all courses
     * 
     * @return int
     */
    public function get_total_enrollments() {
        return $this->db->count_all_results('enrollments');
    }
    
    /**
     * Get instructor name for a course
     * 
     * @param int $course_id
     * @return string
     */
    public function get_instructor_name($course_id) {
        $course = $this->get_course_by_id($course_id);
        if ($course) {
            $this->db->select('name');
            $this->db->where('id', $course['instructor_id']);
            $query = $this->db->get('users');
            $instructor = $query->row_array();
            return $instructor ? $instructor['name'] : 'Unknown Instructor';
        }
        return 'Unknown Instructor';
    }
    
    /**
     * Get category name for a course
     * 
     * @param int $course_id
     * @return string
     */
    public function get_category_name($course_id) {
        $course = $this->get_course_by_id($course_id);
        if ($course) {
            $this->db->select('name');
            $this->db->where('id', $course['category_id']);
            $query = $this->db->get('categories');
            $category = $query->row_array();
            return $category ? $category['name'] : 'Uncategorized';
        }
        return 'Uncategorized';
    }
    
    /**
     * Get related courses based on category
     * 
     * @param int $category_id
     * @param int $current_course_id Course to exclude
     * @param int $limit
     * @return array
     */
    public function get_related_courses($category_id, $current_course_id, $limit = 3) {
        $this->db->where('status', 'published');
        $this->db->where('category_id', $category_id);
        $this->db->where('id !=', $current_course_id);
        $this->db->order_by('RAND()');
        $this->db->limit($limit);
        $query = $this->db->get('courses');
        return $query->result_array();
    }
    
    /**
     * Update enrollment count for a course
     * 
     * @param int $course_id
     * @return bool
     */
    public function update_enrollment_count($course_id) {
        $this->db->where('course_id', $course_id);
        $total_enrollments = $this->db->count_all_results('enrollments');
        
        $this->db->where('id', $course_id);
        return $this->db->update('courses', ['total_enrollments' => $total_enrollments]);
    }
    
    /**
     * Get courses enrolled by a user
     * 
     * @param int $user_id
     * @return array
     */
    public function get_enrolled_courses($user_id) {
		$this->db->select('c.*, e.enrollment_date, e.status as enrollment_status, e.last_accessed_date, e.completion_date, u.name as instructor_name, cat.name as category_name');
		$this->db->from('courses c');
		$this->db->join('enrollments e', 'c.id = e.course_id');
		$this->db->join('users u', 'c.instructor_id = u.id', 'left');
		$this->db->join('categories cat', 'c.category_id = cat.id', 'left');
		$this->db->where('e.user_id', $user_id);
		$this->db->order_by('e.enrollment_date', 'DESC');
		$query = $this->db->get();
		
		return $query->result_array();
    }
    
    /**
     * Get courses created by an instructor
     * 
     * @param int $instructor_id
     * @return array
     */
    public function get_instructor_courses($instructor_id) {
        $this->db->where('instructor_id', $instructor_id);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('courses');
        return $query->result_array();
    }
    
    /**
     * Get recommended courses for a user
     * 
     * @param int $user_id
     * @param int $limit
     * @return array
     */
    public function get_recommended_courses($user_id, $limit = 6) {
        // Get user's enrolled course categories
        $this->db->select('DISTINCT c.category_id');
        $this->db->from('courses c');
        $this->db->join('enrollments e', 'c.id = e.course_id');
        $this->db->where('e.user_id', $user_id);
        $enrolled_categories = $this->db->get()->result_array();
        
        $category_ids = array_column($enrolled_categories, 'category_id');
        
        if (empty($category_ids)) {
            // If no enrolled courses, return popular courses
            return $this->get_popular_courses($limit);
        }
        
        // Get courses from user's preferred categories
        $this->db->select('c.*, u.name as instructor_name, cat.name as category_name');
        $this->db->from('courses c');
        $this->db->join('users u', 'c.instructor_id = u.id', 'left');
        $this->db->join('categories cat', 'c.category_id = cat.id', 'left');
        $this->db->where('c.status', 'published');
        $this->db->where_in('c.category_id', $category_ids);
        
        // Exclude already enrolled courses
        $this->db->where('c.id NOT IN (
            SELECT course_id FROM enrollments WHERE user_id = ' . $this->db->escape($user_id) . '
        )', NULL, FALSE);
        
        $this->db->order_by('c.total_enrollments', 'DESC');
        $this->db->order_by('c.average_rating', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Get recent activities for a user
     * 
     * @param int $user_id
     * @param int $limit
     * @return array
     */
    public function get_recent_activities($user_id, $limit = 10) {
        $activities = [];
        
        // Get recent enrollments
        $this->db->select('e.enrollment_date as created_at, c.title as course_title, "course_enrolled" as type');
        $this->db->from('enrollments e');
        $this->db->join('courses c', 'e.course_id = c.id');
        $this->db->where('e.user_id', $user_id);
        $this->db->order_by('e.enrollment_date', 'DESC');
        $this->db->limit($limit);
        $enrollments = $this->db->get()->result_array();
        
        foreach ($enrollments as $enrollment) {
            $activities[] = [
                'type' => $enrollment['type'],
                'description' => 'Enrolled in "' . $enrollment['course_title'] . '"',
                'created_at' => $enrollment['created_at']
            ];
        }
        
        // Get recent lesson completions
        $this->db->select('pt.updated_at as created_at, l.title as lesson_title, c.title as course_title, "lesson_completed" as type');
        $this->db->from('progress_tracking pt');
        $this->db->join('lessons l', 'pt.lesson_id = l.id');
        $this->db->join('modules m', 'l.module_id = m.id');
        $this->db->join('courses c', 'm.course_id = c.id');
        $this->db->where('pt.user_id', $user_id);
        $this->db->where('pt.status', 'completed');
        $this->db->where('pt.lesson_id IS NOT NULL');
        $this->db->order_by('pt.updated_at', 'DESC');
        $this->db->limit($limit);
        $lesson_completions = $this->db->get()->result_array();
        
        foreach ($lesson_completions as $completion) {
            $activities[] = [
                'type' => $completion['type'],
                'description' => 'Completed lesson "' . $completion['lesson_title'] . '" in "' . $completion['course_title'] . '"',
                'created_at' => $completion['created_at']
            ];
        }
        
        // Get recent quiz completions
        $this->db->select('pt.updated_at as created_at, q.title as quiz_title, c.title as course_title, pt.score, "quiz_completed" as type');
        $this->db->from('progress_tracking pt');
        $this->db->join('quizzes q', 'pt.quiz_id = q.id');
        $this->db->join('modules m', 'q.module_id = m.id');
        $this->db->join('courses c', 'm.course_id = c.id');
        $this->db->where('pt.user_id', $user_id);
        $this->db->where('pt.status', 'completed');
        $this->db->where('pt.quiz_id IS NOT NULL');
        $this->db->order_by('pt.updated_at', 'DESC');
        $this->db->limit($limit);
        $quiz_completions = $this->db->get()->result_array();
        
        foreach ($quiz_completions as $completion) {
            $score_text = isset($completion['score']) ? ' with ' . round($completion['score'], 1) . '% score' : '';
            $activities[] = [
                'type' => $completion['type'],
                'description' => 'Completed quiz "' . $completion['quiz_title'] . '" in "' . $completion['course_title'] . '"' . $score_text,
                'created_at' => $completion['created_at']
            ];
        }
        
        // Sort all activities by date and return the most recent
        usort($activities, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
        return array_slice($activities, 0, $limit);
    }
}
