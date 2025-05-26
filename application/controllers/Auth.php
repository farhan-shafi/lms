<?php
class Auth extends CI_Controller {
	public function register() {
	    $this->load->model('User_model');
 
	    if ($this->input->server('REQUEST_METHOD') === 'POST') {
		   $data = [
			  'name' => $this->input->post('name'),
			  'email' => $this->input->post('email'),
			  'password' => $this->input->post('password'),
			  'role' => 'student' // Default role
		   ];
 
		   if ($this->User_model->register($data)) {
			  $this->session->set_flashdata('success', 'Registration successful. Please login.');
			  redirect('auth/login');
		   } else {
			  $this->session->set_flashdata('error', 'Registration failed.');
		   }
	    }
 
	    $this->load->view('auth/register');
	}
 
	public function login() {
	    $this->load->model('User_model');
 
	    if ($this->input->server('REQUEST_METHOD') === 'POST') {
		   $email = $this->input->post('email');
		   $password = $this->input->post('password');
 
		   $user = $this->User_model->get_user_by_email($email);
 
		   if ($user && password_verify($password, $user['password'])) {
			  $this->session->set_userdata(['user_id' => $user['id'], 'role' => $user['role']]);
			  redirect('dashboard');
		   } else {
			  $this->session->set_flashdata('error', 'Invalid credentials');
		   }
	    }
 
	    $this->load->view('auth/login');
	}
 
	public function logout() {
	    $this->session->unset_userdata(['user_id', 'role']);
	    $this->session->set_flashdata('success', 'Logged out successfully.');
	    redirect('auth/login');
	}
 }
 