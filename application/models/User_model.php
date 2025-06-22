<?php
class User_model extends CI_Model {
    public function register($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return $this->db->insert('users', $data);
    }

    public function get_user_by_email($email) {
        return $this->db->get_where('users', ['email' => $email])->row_array();
    }
    
    /**
     * Get a user by ID
     * 
     * @param int $id
     * @return array
     */
    public function get_user_by_id($id) {
        return $this->db->get_where('users', ['id' => $id])->row_array();
    }
    
    /**
     * Update user profile
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update_user($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }
    
    /**
     * Update user password
     * 
     * @param int $id
     * @param string $password
     * @return bool
     */
    public function update_password($id, $password) {
        $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }
    
    /**
     * Get total students
     * 
     * @return int
     */
    public function get_total_students() {
        $this->db->where('role', 'student');
        $this->db->where('status', 'active');
        return $this->db->count_all_results('users');
    }
    
    /**
     * Get total instructors
     * 
     * @return int
     */
    public function get_total_instructors() {
        $this->db->where('role', 'instructor');
        $this->db->where('status', 'active');
        return $this->db->count_all_results('users');
    }
    
    /**
     * Get all users with optional filters
     * 
     * @param string $role Filter by role (optional)
     * @param string $status Filter by status (optional)
     * @param int $limit Limit results (optional)
     * @param int $offset Offset for pagination (optional)
     * @return array
     */
    public function get_users($role = null, $status = null, $limit = null, $offset = null) {
        if ($role) {
            $this->db->where('role', $role);
        }
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        $this->db->order_by('name', 'ASC');
        
        if ($limit && $offset) {
            $this->db->limit($limit, $offset);
        } elseif ($limit) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get('users');
        return $query->result_array();
    }
    
    /**
     * Delete a user
     * 
     * @param int $id
     * @return bool
     */
    public function delete_user($id) {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }
    
    /**
     * Verify user login credentials
     * 
     * @param string $email
     * @param string $password
     * @return array|bool User data array if verified, false otherwise
     */
    public function verify_login($email, $password) {
        $user = $this->get_user_by_email($email);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
}
