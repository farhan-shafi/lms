<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-4">
    <div class="row">
        <!-- Settings Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Settings</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?php echo base_url('settings'); ?>" class="list-group-item list-group-item-action <?php echo ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'index') ? 'active' : ''; ?>">
                        <i class="fa fa-cog me-2"></i> General
                    </a>
                    <a href="<?php echo base_url('settings/payment'); ?>" class="list-group-item list-group-item-action <?php echo ($this->uri->segment(2) == 'payment') ? 'active' : ''; ?>">
                        <i class="fa fa-credit-card me-2"></i> Payment
                    </a>
                    <a href="<?php echo base_url('settings/email'); ?>" class="list-group-item list-group-item-action <?php echo ($this->uri->segment(2) == 'email') ? 'active' : ''; ?>">
                        <i class="fa fa-envelope me-2"></i> Email
                    </a>
                    <a href="<?php echo base_url('settings/appearance'); ?>" class="list-group-item list-group-item-action <?php echo ($this->uri->segment(2) == 'appearance') ? 'active' : ''; ?>">
                        <i class="fa fa-paint-brush me-2"></i> Appearance
                    </a>
                    <a href="<?php echo base_url('settings/certificates'); ?>" class="list-group-item list-group-item-action <?php echo ($this->uri->segment(2) == 'certificates') ? 'active' : ''; ?>">
                        <i class="fa fa-certificate me-2"></i> Certificates
                    </a>
                    <a href="<?php echo base_url('settings/maintenance'); ?>" class="list-group-item list-group-item-action <?php echo ($this->uri->segment(2) == 'maintenance') ? 'active' : ''; ?>">
                        <i class="fa fa-wrench me-2"></i> Maintenance
                    </a>
                    <a href="<?php echo base_url('settings/documentation'); ?>" class="list-group-item list-group-item-action <?php echo ($this->uri->segment(2) == 'documentation') ? 'active' : ''; ?>">
                        <i class="fa fa-book me-2"></i> Documentation
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Settings Content -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">System Documentation</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle me-2"></i> These documentation resources are available for administrators, instructors, and students. They provide comprehensive guides on using all features of the EduLearn LMS.
                    </div>
                    
                    <h6 class="mb-3">User Guides</h6>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fa fa-user me-2"></i> Student Guide</h5>
                                    <p class="card-text">Comprehensive guide for students on using the learning platform.</p>
                                    <a href="<?php echo base_url('documentation/user_guides/student_guide.md'); ?>" target="_blank" class="btn btn-sm btn-primary">View Guide</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fa fa-chalkboard-teacher me-2"></i> Instructor Guide</h5>
                                    <p class="card-text">Complete documentation for course creation and management.</p>
                                    <a href="<?php echo base_url('documentation/user_guides/instructor_guide.md'); ?>" target="_blank" class="btn btn-sm btn-primary">View Guide</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fa fa-user-shield me-2"></i> Administrator Guide</h5>
                                    <p class="card-text">Detailed guide for system administration and management.</p>
                                    <a href="<?php echo base_url('documentation/user_guides/admin_guide.md'); ?>" target="_blank" class="btn btn-sm btn-primary">View Guide</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h6 class="mb-3">Feature Guides</h6>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fa fa-certificate me-2"></i> Certificates</h5>
                                    <p class="card-text">Guide to certificate creation, issuance, and verification.</p>
                                    <a href="<?php echo base_url('documentation/user_guides/certificates_guide.md'); ?>" target="_blank" class="btn btn-sm btn-primary">View Guide</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fa fa-chart-line me-2"></i> Progress Tracking</h5>
                                    <p class="card-text">Comprehensive guide to the progress tracking system.</p>
                                    <a href="<?php echo base_url('documentation/user_guides/progress_tracking.md'); ?>" target="_blank" class="btn btn-sm btn-primary">View Guide</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fa fa-cog me-2"></i> System Settings</h5>
                                    <p class="card-text">Detailed guide to configuring all system settings.</p>
                                    <a href="<?php echo base_url('documentation/user_guides/settings_guide.md'); ?>" target="_blank" class="btn btn-sm btn-primary">View Guide</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h6 class="mb-3">Help Resources</h6>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fa fa-question-circle me-2"></i> Frequently Asked Questions</h5>
                                    <p class="card-text">Answers to common questions about using the LMS.</p>
                                    <a href="<?php echo base_url('documentation/user_guides/faq.md'); ?>" target="_blank" class="btn btn-sm btn-primary">View FAQs</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fa fa-tools me-2"></i> Troubleshooting Guide</h5>
                                    <p class="card-text">Solutions for common issues and technical problems.</p>
                                    <a href="<?php echo base_url('documentation/user_guides/troubleshooting.md'); ?>" target="_blank" class="btn btn-sm btn-primary">View Guide</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h6>Download All Documentation</h6>
                        <p>Download the complete documentation package for offline reference.</p>
                        <a href="<?php echo base_url('settings/download_documentation'); ?>" class="btn btn-success">
                            <i class="fa fa-download me-2"></i> Download Complete Documentation
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
