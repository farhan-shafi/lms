<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container-fluid">
    <div class="row">
        <!-- Settings Sidebar -->
        <div class="col-md-3 col-lg-2">
            <div class="card">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="<?= site_url('settings') ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-cog mr-2"></i> General Settings
                        </a>
                        <a href="<?= site_url('settings/payment') ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-credit-card mr-2"></i> Payment Settings
                        </a>
                        <a href="<?= site_url('settings/email') ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-envelope mr-2"></i> Email Settings
                        </a>
                        <a href="<?= site_url('settings/appearance') ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-palette mr-2"></i> Appearance
                        </a>
                        <a href="<?= site_url('settings/certificates') ?>" class="list-group-item list-group-item-action active">
                            <i class="fas fa-certificate mr-2"></i> Certificates
                        </a>
                        <a href="<?= site_url('settings/maintenance') ?>" class="list-group-item list-group-item-action">
                            <i class="fas fa-tools mr-2"></i> Maintenance
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Certificate Settings</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($upload_error)): ?>
                        <div class="alert alert-danger"><?= $upload_error ?></div>
                    <?php endif; ?>
                    
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                    <?php endif; ?>
                    
                    <?= form_open_multipart('settings/certificates'); ?>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="enable_certificates" name="enable_certificates" value="1" <?= isset($settings['enable_certificates']) && $settings['enable_certificates'] == 1 ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="enable_certificates">Enable Course Completion Certificates</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="certificate_text">Certificate Text Template</label>
                            <textarea class="form-control" id="certificate_text" name="certificate_text" rows="4"><?= isset($settings['certificate_text']) ? $settings['certificate_text'] : 'This is to certify that {student_name} has successfully completed the course {course_name} on {completion_date}.' ?></textarea>
                            <small class="form-text text-muted">
                                Available variables: {student_name}, {course_name}, {completion_date}, {instructor_name}, {course_duration}, {certificate_id}
                            </small>
                        </div>
                        
                        <div class="form-group">
                            <label for="certificate_background">Certificate Background Template</label>
                            <?php if (isset($settings['certificate_background']) && !empty($settings['certificate_background'])): ?>
                                <div class="mb-2">
                                    <img src="<?= base_url($settings['certificate_background']) ?>" alt="Certificate Background" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                            <?php endif; ?>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="certificate_background" name="certificate_background">
                                <label class="custom-file-label" for="certificate_background">Choose file</label>
                            </div>
                            <small class="form-text text-muted">Recommended size: 1920x1080px. Supported formats: JPG, PNG, PDF</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="certificate_signature">Signature Image URL</label>
                            <input type="text" class="form-control" id="certificate_signature" name="certificate_signature" value="<?= isset($settings['certificate_signature']) ? $settings['certificate_signature'] : '' ?>">
                            <small class="form-text text-muted">Enter the URL to your signature image or upload one and paste the URL here</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="certificate_logo">Certificate Logo URL</label>
                            <input type="text" class="form-control" id="certificate_logo" name="certificate_logo" value="<?= isset($settings['certificate_logo']) ? $settings['certificate_logo'] : '' ?>">
                            <small class="form-text text-muted">Enter the URL to your logo image or upload one and paste the URL here</small>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Certificate Preview</h5>
                            </div>
                            <div class="card-body text-center">
                                <div id="certificate-preview" class="border p-4 position-relative" style="min-height: 300px; background-size: cover; background-position: center;">
                                    <div class="certificate-content p-4" style="position: relative; z-index: 10;">
                                        <h2 class="mb-4 text-center">Certificate of Completion</h2>
                                        <p class="certificate-text text-center">This is to certify that <strong>John Doe</strong> has successfully completed the course <strong>Introduction to Web Development</strong> on <strong>January 1, 2023</strong>.</p>
                                        
                                        <div class="row mt-5">
                                            <div class="col-6 text-center">
                                                <div id="signature-preview" class="mb-2" style="min-height: 60px;">
                                                    <?php if (isset($settings['certificate_signature']) && !empty($settings['certificate_signature'])): ?>
                                                    <img src="<?= $settings['certificate_signature'] ?>" alt="Signature" style="max-height: 60px;">
                                                    <?php endif; ?>
                                                </div>
                                                <div class="border-top pt-2">Instructor Signature</div>
                                            </div>
                                            <div class="col-6 text-center">
                                                <div class="mb-2">
                                                    <span class="font-weight-bold">Certificate ID:</span><br>
                                                    ABC123456789
                                                </div>
                                                <div class="border-top pt-2">Verification Code</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save Certificate Settings</button>
                        </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Update file input label with filename
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
    
    // Update certificate preview background
    <?php if (isset($settings['certificate_background']) && !empty($settings['certificate_background'])): ?>
    $('#certificate-preview').css('background-image', 'url("<?= base_url($settings['certificate_background']) ?>")');
    <?php endif; ?>
    
    // Update certificate text on change
    $('#certificate_text').on('input', function() {
        var text = $(this).val();
        text = text.replace('{student_name}', '<strong>John Doe</strong>');
        text = text.replace('{course_name}', '<strong>Introduction to Web Development</strong>');
        text = text.replace('{completion_date}', '<strong>January 1, 2023</strong>');
        text = text.replace('{instructor_name}', '<strong>Jane Smith</strong>');
        text = text.replace('{course_duration}', '<strong>6 weeks</strong>');
        text = text.replace('{certificate_id}', '<strong>ABC123456789</strong>');
        $('.certificate-text').html(text);
    });
    
    // Update signature preview on change
    $('#certificate_signature').on('input', function() {
        var url = $(this).val();
        if (url) {
            $('#signature-preview').html('<img src="' + url + '" alt="Signature" style="max-height: 60px;">');
        } else {
            $('#signature-preview').html('');
        }
    });
    
    // Update logo preview on change
    $('#certificate_logo').on('input', function() {
        var url = $(this).val();
        if (url) {
            // Add logo to the preview if not already present
            if ($('#logo-preview').length === 0) {
                $('#certificate-preview').prepend('<div id="logo-preview" class="text-center mb-3"><img src="' + url + '" alt="Logo" style="max-height: 80px;"></div>');
            } else {
                $('#logo-preview img').attr('src', url);
            }
        } else {
            $('#logo-preview').remove();
        }
    });
    
    // Trigger logo preview on page load
    if ($('#certificate_logo').val()) {
        $('#certificate_logo').trigger('input');
    }
});
</script>
