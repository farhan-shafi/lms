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
		#TODO fix it later
		// $this->db->select('c.*, e.enrollment_date, e.status as enrollment_status, e.last_accessed_date, e.completion_date, u.name as instructor_name, cat.name as category_name');
		// $this->db->from('courses c');
		// $this->db->join('enrollments e', 'c.id = e.course_id');
		// $this->db->join('users u', 'c.instructor_id = u.id', 'left');
		// $this->db->join('categories cat', 'c.category_id = cat.id', 'left');
		// $this->db->where('e.instructor_id', $user_id);
		// $this->db->order_by('e.enrollment_date', 'DESC');
		// $query = $this->db->get();
		
		// return $query->result_array();
		$this->db->where('instructor_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('courses');
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
}
