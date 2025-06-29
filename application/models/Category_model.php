<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all active categories
     * 
     * @return array
     */
    public function get_active_categories() {
        $this->db->where('status', 'active');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('categories');
        return $query->result_array();
    }
    
    /**
     * Get a category by its ID
     * 
     * @param int $id
     * @return array
     */
    public function get_category_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('categories');
        return $query->row_array();
    }
    
    /**
     * Get a category by its slug
     * 
     * @param string $slug
     * @return array
     */
    public function get_category_by_slug($slug) {
        $this->db->where('slug', $slug);
        $query = $this->db->get('categories');
        return $query->row_array();
    }
    
    /**
     * Create a new category
     * 
     * @param array $data
     * @return bool
     */
    public function create_category($data) {
        return $this->db->insert('categories', $data);
    }
    
    /**
     * Update a category
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update_category($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('categories', $data);
    }
    
    /**
     * Delete a category
     * 
     * @param int $id
     * @return bool
     */
    public function delete_category($id) {
        $this->db->where('id', $id);
        return $this->db->delete('categories');
    }
    
    /**
     * Count courses in a category
     * 
     * @param int $category_id
     * @return int
     */
    public function count_courses_in_category($category_id) {
        $this->db->where('category_id', $category_id);
        $this->db->where('status', 'published');
        return $this->db->count_all_results('courses');
    }
    
    /**
     * Get all categories (including inactive)
     * 
     * @return array
     */
    public function get_all_categories() {
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('categories');
        return $query->result_array();
    }
    
    /**
     * Get categories with course count
     * 
     * @return array
     */
    public function get_categories_with_count() {
        $this->db->select('categories.*, COUNT(courses.id) as course_count');
        $this->db->from('categories');
        $this->db->join('courses', 'courses.category_id = categories.id AND courses.status = "published"', 'left');
        $this->db->group_by('categories.id');
        $this->db->order_by('categories.name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
}
