<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all settings as an associative array
     * 
     * @return array
     */
    public function get_all_settings() {
        $query = $this->db->get('settings');
        $settings = [];
        
        foreach ($query->result_array() as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        
        return $settings;
    }
    
    /**
     * Get a single setting value by key
     * 
     * @param string $key
     * @param mixed $default Default value if setting doesn't exist
     * @return mixed
     */
    public function get_setting($key, $default = NULL) {
        $query = $this->db->get_where('settings', ['setting_key' => $key]);
        $result = $query->row_array();
        
        return $result ? $result['setting_value'] : $default;
    }
    
    /**
     * Update multiple settings
     * 
     * @param array $settings Associative array of key => value pairs
     * @return bool
     */
    public function update_settings($settings) {
        $success = TRUE;
        
        foreach ($settings as $key => $value) {
            $success = $this->update_setting($key, $value) && $success;
        }
        
        return $success;
    }
    
    /**
     * Update a single setting
     * 
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function update_setting($key, $value) {
        // Check if setting exists
        $query = $this->db->get_where('settings', ['setting_key' => $key]);
        
        if ($query->num_rows() > 0) {
            // Update existing setting
            $this->db->where('setting_key', $key);
            return $this->db->update('settings', ['setting_value' => $value]);
        } else {
            // Create new setting
            return $this->db->insert('settings', [
                'setting_key' => $key,
                'setting_value' => $value
            ]);
        }
    }
}
