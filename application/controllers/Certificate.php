<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate extends Auth_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Course_model');
        $this->load->model('Enrollment_model');
        $this->load->model('Certificate_model');
    }
    
    /**
     * Generate a certificate for a completed course
     * 
     * @param int $course_id
     */
    public function generate($course_id) {
        $user_id = $this->session->userdata('user_id');
        
        // Check if course exists
        $course = $this->Course_model->get_course_by_id($course_id);
        if (!$course) {
            $this->session->set_flashdata('error', 'Course not found');
            redirect('dashboard/certificates');
        }
        
        // Check if user is enrolled and has completed the course
        $enrollment = $this->Enrollment_model->get_enrollment($user_id, $course_id);
        
        if (!$enrollment || $enrollment['status'] !== 'completed') {
            $this->session->set_flashdata('error', 'You must complete the course to get a certificate');
            redirect('course/learn/' . $course_id);
        }
        
        // Check if certificate already exists
        $existing_certificate = $this->Certificate_model->get_certificate($user_id, $course_id);
        
        if ($existing_certificate) {
            // Certificate already exists, just view it
            redirect('certificate/view/' . $existing_certificate['id']);
        }
        
        // Generate new certificate
        $certificate_number = $this->Certificate_model->generate_certificate_number();
        $certificate_data = [
            'user_id' => $user_id,
            'course_id' => $course_id,
            'certificate_number' => $certificate_number,
            'issue_date' => date('Y-m-d'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Create the certificate
        $certificate_id = $this->Certificate_model->create_certificate($certificate_data);
        
        if ($certificate_id) {
            // Generate the PDF file
            $this->generate_certificate_pdf($certificate_id);
            
            $this->session->set_flashdata('success', 'Certificate generated successfully');
            redirect('certificate/view/' . $certificate_id);
        } else {
            $this->session->set_flashdata('error', 'Failed to generate certificate');
            redirect('dashboard/certificates');
        }
    }
    
    /**
     * View a certificate
     * 
     * @param int $certificate_id
     */
    public function view($certificate_id) {
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        // Get certificate details
        $certificate = $this->Certificate_model->get_certificate_by_id($certificate_id);
        
        if (!$certificate) {
            $this->session->set_flashdata('error', 'Certificate not found');
            redirect('dashboard/certificates');
        }
        
        // Security check - only owner or admin can view
        if ($certificate['user_id'] != $user_id && $user_role != 'admin') {
            $this->session->set_flashdata('error', 'You do not have permission to view this certificate');
            redirect('dashboard/certificates');
        }
        
        // Get course and user details
        $course = $this->Course_model->get_course_by_id($certificate['course_id']);
        $user = $this->User_model->get_user_by_id($certificate['user_id']);
        
        $data['certificate'] = $certificate;
        $data['course'] = $course;
        $data['user'] = $user;
        $data['title'] = 'Certificate - ' . $course['title'];
        
        $this->load->view('templates/header', $data);
        $this->load->view('certificate/view', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Download a certificate
     * 
     * @param int $certificate_id
     */
    public function download($certificate_id) {
        $user_id = $this->session->userdata('user_id');
        $user_role = $this->session->userdata('role');
        
        // Get certificate details
        $certificate = $this->Certificate_model->get_certificate_by_id($certificate_id);
        
        if (!$certificate) {
            $this->session->set_flashdata('error', 'Certificate not found');
            redirect('dashboard/certificates');
        }
        
        // Security check - only owner or admin can download
        if ($certificate['user_id'] != $user_id && $user_role != 'admin') {
            $this->session->set_flashdata('error', 'You do not have permission to download this certificate');
            redirect('dashboard/certificates');
        }
        
        // Check if PDF exists or generate it
        $file_path = FCPATH . 'assets/certificates/' . $certificate['file_path'];
        
        if (!file_exists($file_path)) {
            $this->generate_certificate_pdf($certificate_id);
        }
        
        // Force download
        $this->load->helper('download');
        $data = file_get_contents($file_path);
        $name = 'certificate_' . $certificate['certificate_number'] . '.pdf';
        
        force_download($name, $data);
    }
    
    /**
     * Generate PDF for a certificate
     * 
     * @param int $certificate_id
     * @return bool
     */
    private function generate_certificate_pdf($certificate_id) {
        // Get certificate details
        $certificate = $this->Certificate_model->get_certificate_by_id($certificate_id);
        
        if (!$certificate) {
            return false;
        }
        
        // Get course and user details
        $course = $this->Course_model->get_course_by_id($certificate['course_id']);
        $user = $this->User_model->get_user_by_id($certificate['user_id']);
        
        // Load PDF library
        $this->load->library('pdf');
        
        // Initialize PDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // Set document information
        $pdf->SetCreator('EduLearn LMS');
        $pdf->SetAuthor('EduLearn LMS');
        $pdf->SetTitle('Course Completion Certificate');
        $pdf->SetSubject('Certificate for ' . $course['title']);
        
        // Remove header and footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        
        // Add a page
        $pdf->AddPage('L', 'A4');
        
        // Set background image
        $pdf->Image(FCPATH . 'assets/images/certificate-bg.jpg', 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);
        
        // Certificate content
        $html = '
        <style>
            h1 { font-size: 28pt; font-weight: bold; text-align: center; color: #333; margin-top: 40px; }
            h2 { font-size: 18pt; text-align: center; color: #555; margin-top: 10px; }
            .main-text { font-size: 14pt; text-align: center; margin-top: 20px; }
            .name { font-size: 24pt; font-weight: bold; text-align: center; color: #000; margin: 20px 0; }
            .course { font-size: 18pt; font-weight: bold; text-align: center; color: #333; margin: 10px 0; }
            .details { font-size: 12pt; text-align: center; color: #555; }
            .certificate-number { font-size: 10pt; text-align: left; color: #777; position: absolute; bottom: 10px; left: 10px; }
            .date { font-size: 12pt; text-align: center; margin-top: 30px; }
            .signature { text-align: center; margin-top: 50px; }
        </style>
        
        <h1>CERTIFICATE OF COMPLETION</h1>
        <h2>This is to certify that</h2>
        <div class="name">' . $user['name'] . '</div>
        <div class="main-text">has successfully completed the course</div>
        <div class="course">' . $course['title'] . '</div>
        <div class="details">with a total duration of ' . $course['duration'] . ' hours</div>
        <div class="date">Issued on: ' . date('F j, Y', strtotime($certificate['issue_date'])) . '</div>
        
        <div class="signature">
            <img src="' . FCPATH . 'assets/images/signature.png" width="150" height="60"><br>
            _________________________<br>
            Course Instructor
        </div>
        
        <div class="certificate-number">Certificate No: ' . $certificate['certificate_number'] . '</div>
        ';
        
        $pdf->writeHTML($html, true, false, true, false, '');
        
        // Create directory if not exists
        $certificates_dir = FCPATH . 'assets/certificates/';
        if (!is_dir($certificates_dir)) {
            mkdir($certificates_dir, 0755, true);
        }
        
        // Generate filename
        $filename = 'certificate_' . $certificate['id'] . '_' . $certificate['user_id'] . '.pdf';
        $file_path = $certificates_dir . $filename;
        
        // Save PDF
        $pdf->Output($file_path, 'F');
        
        // Update certificate with file path
        $this->Certificate_model->update_certificate($certificate_id, ['file_path' => $filename]);
        
        return true;
    }
    
    /**
     * Verify a certificate
     */
    public function verify() {
        $certificate_number = $this->input->get('number');
        
        if ($certificate_number) {
            $certificate = $this->Certificate_model->get_certificate_by_number($certificate_number);
            
            if ($certificate) {
                $course = $this->Course_model->get_course_by_id($certificate['course_id']);
                $user = $this->User_model->get_user_by_id($certificate['user_id']);
                
                $data['certificate'] = $certificate;
                $data['course'] = $course;
                $data['user'] = $user;
                $data['verified'] = true;
            } else {
                $data['verified'] = false;
                $data['message'] = 'Certificate not found or invalid.';
            }
        }
        
        $data['title'] = 'Verify Certificate';
        $this->load->view('templates/header', $data);
        $this->load->view('certificate/verify', $data);
        $this->load->view('templates/footer');
    }
}
