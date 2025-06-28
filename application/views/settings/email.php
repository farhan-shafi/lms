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
                </div>
            </div>
        </div>
        
        <!-- Settings Content -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Email Settings</h5>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success">
                            <?php echo $this->session->flashdata('success'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?php echo $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php echo form_open('settings/email'); ?>
                        <h6 class="mb-3">Email Identity</h6>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email_from_address">From Email Address</label>
                                    <input type="email" name="email_from_address" id="email_from_address" class="form-control" 
                                           value="<?php echo isset($settings['email_from_address']) ? $settings['email_from_address'] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email_from_name">From Name</label>
                                    <input type="text" name="email_from_name" id="email_from_name" class="form-control" 
                                           value="<?php echo isset($settings['email_from_name']) ? $settings['email_from_name'] : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <h6 class="mb-3">SMTP Settings</h6>
                        <div class="form-group mb-3">
                            <label for="smtp_host">SMTP Host</label>
                            <input type="text" name="smtp_host" id="smtp_host" class="form-control" 
                                   value="<?php echo isset($settings['smtp_host']) ? $settings['smtp_host'] : ''; ?>">
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="smtp_user">SMTP Username</label>
                                    <input type="text" name="smtp_user" id="smtp_user" class="form-control" 
                                           value="<?php echo isset($settings['smtp_user']) ? $settings['smtp_user'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="smtp_pass">SMTP Password</label>
                                    <input type="password" name="smtp_pass" id="smtp_pass" class="form-control" 
                                           value="<?php echo isset($settings['smtp_pass']) ? $settings['smtp_pass'] : ''; ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="smtp_port">SMTP Port</label>
                                    <input type="number" name="smtp_port" id="smtp_port" class="form-control" 
                                           value="<?php echo isset($settings['smtp_port']) ? $settings['smtp_port'] : '587'; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="smtp_crypto">SMTP Encryption</label>
                                    <select name="smtp_crypto" id="smtp_crypto" class="form-control">
                                        <option value="">None</option>
                                        <option value="tls" <?php echo (isset($settings['smtp_crypto']) && $settings['smtp_crypto'] == 'tls') ? 'selected' : ''; ?>>TLS</option>
                                        <option value="ssl" <?php echo (isset($settings['smtp_crypto']) && $settings['smtp_crypto'] == 'ssl') ? 'selected' : ''; ?>>SSL</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <h6 class="mb-3">Email Templates</h6>
                        <div class="form-group mb-3">
                            <label for="email_template_header">Email Template Header</label>
                            <textarea name="email_template_header" id="email_template_header" class="form-control" rows="5"><?php echo isset($settings['email_template_header']) ? $settings['email_template_header'] : ''; ?></textarea>
                            <div class="form-text">HTML code for the email header. Use {site_name} as a placeholder for your site name.</div>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="email_template_footer">Email Template Footer</label>
                            <textarea name="email_template_footer" id="email_template_footer" class="form-control" rows="5"><?php echo isset($settings['email_template_footer']) ? $settings['email_template_footer'] : ''; ?></textarea>
                            <div class="form-text">HTML code for the email footer. Use {site_name}, {site_url}, and {contact_email} as placeholders.</div>
                        </div>
                        
                        <div class="form-group mb-4">
                            <button type="button" id="test-email-btn" class="btn btn-info mb-3">
                                <i class="fa fa-paper-plane me-2"></i> Send Test Email
                            </button>
                            <div id="test-email-form" class="border p-3 rounded" style="display:none;">
                                <div class="form-group mb-3">
                                    <label for="test_email">Email Address</label>
                                    <input type="email" id="test_email" class="form-control" placeholder="Enter email address to send test">
                                </div>
                                <button type="button" id="send-test-email" class="btn btn-sm btn-primary">Send Test</button>
                                <button type="button" id="cancel-test-email" class="btn btn-sm btn-secondary">Cancel</button>
                                <div id="test-email-result" class="mt-2"></div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Test email functionality
        $('#test-email-btn').on('click', function() {
            $('#test-email-form').slideDown();
        });
        
        $('#cancel-test-email').on('click', function() {
            $('#test-email-form').slideUp();
            $('#test-email-result').html('');
        });
        
        $('#send-test-email').on('click', function() {
            var email = $('#test_email').val();
            if (!email) {
                $('#test-email-result').html('<div class="alert alert-danger">Please enter an email address</div>');
                return;
            }
            
            $('#test-email-result').html('<div class="alert alert-info">Sending test email...</div>');
            
            // AJAX request to send test email
            $.ajax({
                url: '<?php echo base_url("settings/test_email"); ?>',
                type: 'POST',
                data: {
                    email: email
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#test-email-result').html('<div class="alert alert-success">' + response.message + '</div>');
                    } else {
                        $('#test-email-result').html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                },
                error: function() {
                    $('#test-email-result').html('<div class="alert alert-danger">Failed to send test email. Please check your SMTP settings.</div>');
                }
            });
        });
    });
</script>
