<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Auth_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Load required models
        $this->load->model('Settings_model');
        
        // Only admin can access settings
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'You do not have permission to access settings');
            redirect('dashboard');
        }
    }
    
    /**
     * Display and update general settings
     */
    public function index() {
        // Process form submission
        if ($this->input->post()) {
            $this->form_validation->set_rules('site_name', 'Site Name', 'required|trim');
            $this->form_validation->set_rules('site_description', 'Site Description', 'required|trim');
            $this->form_validation->set_rules('contact_email', 'Contact Email', 'required|valid_email|trim');
            
            if ($this->form_validation->run() === TRUE) {
                $settings = [
                    'site_name' => $this->input->post('site_name'),
                    'site_description' => $this->input->post('site_description'),
                    'contact_email' => $this->input->post('contact_email'),
                    'enable_registration' => $this->input->post('enable_registration') ? 1 : 0,
                    'enable_public_courses' => $this->input->post('enable_public_courses') ? 1 : 0,
                    'maintenance_mode' => $this->input->post('maintenance_mode') ? 1 : 0
                ];
                
                // Update all settings
                foreach ($settings as $key => $value) {
                    $this->Settings_model->update_setting($key, $value);
                }
                
                $this->session->set_flashdata('success', 'Settings updated successfully');
                redirect('settings');
            }
        }
        
        // Get all settings
        $data['settings'] = $this->Settings_model->get_all_settings();
        
        // Load views
        $data['title'] = 'System Settings';
        $this->load->view('templates/header', $data);
        $this->load->view('settings/index', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Display and update payment settings
     */
    public function payment() {
        // Process form submission
        if ($this->input->post()) {
            $this->form_validation->set_rules('currency', 'Currency', 'required|trim');
            $this->form_validation->set_rules('paypal_email', 'PayPal Email', 'valid_email|trim');
            $this->form_validation->set_rules('stripe_public_key', 'Stripe Public Key', 'trim');
            $this->form_validation->set_rules('stripe_secret_key', 'Stripe Secret Key', 'trim');
            
            if ($this->form_validation->run() === TRUE) {
                $settings = [
                    'currency' => $this->input->post('currency'),
                    'currency_symbol' => $this->input->post('currency_symbol'),
                    'enable_paypal' => $this->input->post('enable_paypal') ? 1 : 0,
                    'paypal_email' => $this->input->post('paypal_email'),
                    'paypal_sandbox' => $this->input->post('paypal_sandbox') ? 1 : 0,
                    'enable_stripe' => $this->input->post('enable_stripe') ? 1 : 0,
                    'stripe_public_key' => $this->input->post('stripe_public_key'),
                    'stripe_secret_key' => $this->input->post('stripe_secret_key'),
                    'stripe_test_mode' => $this->input->post('stripe_test_mode') ? 1 : 0,
                    'enable_bank_transfer' => $this->input->post('enable_bank_transfer') ? 1 : 0,
                    'bank_details' => $this->input->post('bank_details')
                ];
                
                // Update all settings
                foreach ($settings as $key => $value) {
                    $this->Settings_model->update_setting($key, $value);
                }
                
                $this->session->set_flashdata('success', 'Payment settings updated successfully');
                redirect('settings/payment');
            }
        }
        
        // Get all settings
        $data['settings'] = $this->Settings_model->get_all_settings();
        
        // Load views
        $data['title'] = 'Payment Settings';
        $this->load->view('templates/header', $data);
        $this->load->view('settings/payment', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Display and update email settings
     */
    public function email() {
        // Process form submission
        if ($this->input->post()) {
            $this->form_validation->set_rules('smtp_host', 'SMTP Host', 'trim');
            $this->form_validation->set_rules('smtp_user', 'SMTP Username', 'trim');
            $this->form_validation->set_rules('smtp_port', 'SMTP Port', 'numeric|trim');
            
            if ($this->form_validation->run() === TRUE) {
                $settings = [
                    'email_from_address' => $this->input->post('email_from_address'),
                    'email_from_name' => $this->input->post('email_from_name'),
                    'smtp_host' => $this->input->post('smtp_host'),
                    'smtp_user' => $this->input->post('smtp_user'),
                    'smtp_pass' => $this->input->post('smtp_pass'),
                    'smtp_port' => $this->input->post('smtp_port'),
                    'smtp_crypto' => $this->input->post('smtp_crypto'),
                    'email_template_header' => $this->input->post('email_template_header'),
                    'email_template_footer' => $this->input->post('email_template_footer')
                ];
                
                // Update all settings
                foreach ($settings as $key => $value) {
                    $this->Settings_model->update_setting($key, $value);
                }
                
                $this->session->set_flashdata('success', 'Email settings updated successfully');
                redirect('settings/email');
            }
        }
        
        // Get all settings
        $data['settings'] = $this->Settings_model->get_all_settings();
        
        // Load views
        $data['title'] = 'Email Settings';
        $this->load->view('templates/header', $data);
        $this->load->view('settings/email', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Display and update appearance settings
     */
    public function appearance() {
        // Process form submission
        if ($this->input->post()) {
            // Process logo upload if file exists
            if (!empty($_FILES['site_logo']['name'])) {
                $config['upload_path'] = './assets/images/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 2048;
                $config['file_name'] = 'site-logo';
                $config['overwrite'] = TRUE;
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('site_logo')) {
                    $upload_data = $this->upload->data();
                    $logo_path = 'assets/images/' . $upload_data['file_name'];
                    $this->Settings_model->update_setting('site_logo', $logo_path);
                } else {
                    $data['upload_error'] = $this->upload->display_errors();
                }
            }
            
            // Process favicon upload if file exists
            if (!empty($_FILES['site_favicon']['name'])) {
                $config['upload_path'] = './assets/images/';
                $config['allowed_types'] = 'ico|png';
                $config['max_size'] = 1024;
                $config['file_name'] = 'favicon';
                $config['overwrite'] = TRUE;
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('site_favicon')) {
                    $upload_data = $this->upload->data();
                    $favicon_path = 'assets/images/' . $upload_data['file_name'];
                    $this->Settings_model->update_setting('site_favicon', $favicon_path);
                } else {
                    $data['upload_error_favicon'] = $this->upload->display_errors();
                }
            }
            
            // Update other appearance settings
            $settings = [
                'primary_color' => $this->input->post('primary_color'),
                'secondary_color' => $this->input->post('secondary_color'),
                'theme' => $this->input->post('theme'),
                'custom_css' => $this->input->post('custom_css'),
                'custom_js' => $this->input->post('custom_js')
            ];
            
            // Update all settings
            foreach ($settings as $key => $value) {
                $this->Settings_model->update_setting($key, $value);
            }
            
            $this->session->set_flashdata('success', 'Appearance settings updated successfully');
            redirect('settings/appearance');
        }
        
        // Get all settings
        $data['settings'] = $this->Settings_model->get_all_settings();
        
        // Load views
        $data['title'] = 'Appearance Settings';
        $this->load->view('templates/header', $data);
        $this->load->view('settings/appearance', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Display and update certificate settings
     */
    public function certificates() {
        // Process form submission
        if ($this->input->post()) {
            // Process certificate template upload if file exists
            if (!empty($_FILES['certificate_background']['name'])) {
                $config['upload_path'] = './assets/images/certificates/';
                $config['allowed_types'] = 'jpg|png|pdf';
                $config['max_size'] = 5120;
                $config['file_name'] = 'certificate-template';
                $config['overwrite'] = TRUE;
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('certificate_background')) {
                    $upload_data = $this->upload->data();
                    $template_path = 'assets/images/certificates/' . $upload_data['file_name'];
                    $this->Settings_model->update_setting('certificate_background', $template_path);
                } else {
                    $data['upload_error'] = $this->upload->display_errors();
                }
            }
            
            // Update other certificate settings
            $settings = [
                'certificate_text' => $this->input->post('certificate_text'),
                'enable_certificates' => $this->input->post('enable_certificates') ? 1 : 0,
                'certificate_signature' => $this->input->post('certificate_signature'),
                'certificate_logo' => $this->input->post('certificate_logo')
            ];
            
            // Update all settings
            foreach ($settings as $key => $value) {
                $this->Settings_model->update_setting($key, $value);
            }
            
            $this->session->set_flashdata('success', 'Certificate settings updated successfully');
            redirect('settings/certificates');
        }
        
        // Get all settings
        $data['settings'] = $this->Settings_model->get_all_settings();
        
        // Load views
        $data['title'] = 'Certificate Settings';
        $this->load->view('templates/header', $data);
        $this->load->view('settings/certificates', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * System maintenance and backup
     */
    public function maintenance() {
        // Handle system backup
        if ($this->input->post('create_backup')) {
            // Create database backup
            $this->load->dbutil();
            $prefs = [
                'format' => 'zip',
                'filename' => 'lms-backup-' . date('Y-m-d') . '.sql'
            ];
            $backup = $this->dbutil->backup($prefs);
            
            // Create backup directory if not exists
            if (!is_dir('./backups')) {
                mkdir('./backups', 0755, true);
            }
            
            // Write backup file
            $backup_file = './backups/lms-backup-' . date('Y-m-d-H-i-s') . '.zip';
            $this->load->helper('file');
            write_file($backup_file, $backup);
            
            // Force download
            $this->load->helper('download');
            force_download(basename($backup_file), $backup);
        }
        
        // Handle clearing cache
        if ($this->input->post('clear_cache')) {
            $this->load->driver('cache');
            $this->cache->clean();
            
            // Clear CodeIgniter cache
            $cache_path = $this->config->item('cache_path');
            $handle = opendir($cache_path);
            while (($file = readdir($handle)) !== FALSE) {
                if ($file != '.' && $file != '..' && $file != 'index.html') {
                    @unlink($cache_path . '/' . $file);
                }
            }
            closedir($handle);
            
            $this->session->set_flashdata('success', 'Cache cleared successfully');
            redirect('settings/maintenance');
        }
        
        // Load views
        $data['title'] = 'System Maintenance';
        $this->load->view('templates/header', $data);
        $this->load->view('settings/maintenance', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Send a test email
     */
    public function test_email() {
        // Check if request is AJAX
        if (!$this->input->is_ajax_request()) {
            show_error('No direct script access allowed');
        }
        
        // Get email settings
        $settings = $this->Settings_model->get_all_settings();
        $test_email = $this->input->post('email');
        
        // Configure email settings
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => $settings['smtp_host'],
            'smtp_user' => $settings['smtp_user'],
            'smtp_pass' => $settings['smtp_pass'],
            'smtp_port' => $settings['smtp_port'],
            'smtp_crypto' => $settings['smtp_crypto'],
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];
        
        $this->load->library('email', $config);
        
        $this->email->from($settings['email_from_address'], $settings['email_from_name']);
        $this->email->to($test_email);
        $this->email->subject('Test Email from ' . $settings['site_name']);
        
        // Build email content
        $message = $settings['email_template_header'] ?? '';
        $message .= '<p>This is a test email from your Learning Management System.</p>';
        $message .= '<p>If you received this email, your email configuration is working correctly.</p>';
        $message .= $settings['email_template_footer'] ?? '';
        
        $this->email->message($message);
        
        // Send the email and return result
        if ($this->email->send()) {
            echo json_encode(['status' => 'success', 'message' => 'Test email sent successfully to ' . $test_email]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send test email. Error: ' . $this->email->print_debugger()]);
        }
    }
    
    /**
     * Display documentation page and provide access to user guides
     */
    public function documentation() {
        // Load views
        $data['title'] = 'System Documentation';
        $this->load->view('templates/header', $data);
        $this->load->view('settings/documentation', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Download the complete documentation package
     */
    public function download_documentation() {
        // Create a ZIP file of all documentation
        $this->load->library('zip');
        
        // Add documentation files to the ZIP
        $documentation_path = FCPATH . 'documentation/';
        
        if (is_dir($documentation_path)) {
            // Recursively add all documentation files
            $this->zip->read_dir($documentation_path, FALSE);
            
            // Create the ZIP file
            $zip_file = 'edulearn_documentation_' . date('Y-m-d') . '.zip';
            $this->zip->download($zip_file);
        } else {
            $this->session->set_flashdata('error', 'Documentation directory not found');
            redirect('settings/documentation');
        }
    }
}
