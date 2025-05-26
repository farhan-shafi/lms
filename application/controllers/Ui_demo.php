<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ui_demo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load necessary models
    }

    public function index() {
        $data['title'] = 'UI Demo';
        
        // Load the view
        $this->load->view('templates/header', $data);
        $this->load->view('ui_demo/index', $data);
        $this->load->view('templates/footer');
    }
}
