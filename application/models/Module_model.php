<?php
class Module_model extends CI_Model {
    public function get_modules_by_course($course_id) {
        $this->db->where('course_id', $course_id);
        $this->db->order_by('order', 'ASC');
        return $this->db->get('modules')->result_array();
    }
    
    /**
     * Get a module by its ID
     * 
     * @param int $id
     * @return array
     */
    public function get_module_by_id($id) {
        return $this->db->get_where('modules', ['id' => $id])->row_array();
    }
    
    /**
     * Create a new module
     * 
     * @param array $data
     * @return bool
     */
    public function create_module($data) {
        return $this->db->insert('modules', $data);
    }
    
    /**
     * Update a module
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update_module($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('modules', $data);
    }
    
    /**
     * Delete a module
     * 
     * @param int $id
     * @return bool
     */
    public function delete_module($id) {
        $this->db->where('id', $id);
        return $this->db->delete('modules');
    }
    
    /**
     * Get the count of modules in a course
     * 
     * @param int $course_id
     * @return int
     */
    public function count_modules_in_course($course_id) {
        $this->db->where('course_id', $course_id);
        return $this->db->count_all_results('modules');
    }
    
    /**
     * Reorder modules
     * 
     * @param array $module_order Array of module IDs in the desired order
     * @return bool
     */
    public function reorder_modules($module_order) {
        $success = true;
        
        foreach ($module_order as $position => $module_id) {
            $data = ['order' => $position];
            $this->db->where('id', $module_id);
            $success = $this->db->update('modules', $data) && $success;
        }
        
        return $success;
    }
 }
 