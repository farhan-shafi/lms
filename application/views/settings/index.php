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
                    <h5 class="mb-0">General Settings</h5>
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
                    
                    <?php echo form_open('settings'); ?>
                        <div class="form-group mb-3">
                            <label for="site_name">Site Name</label>
                            <input type="text" name="site_name" id="site_name" class="form-control" 
                                   value="<?php echo isset($settings['site_name']) ? $settings['site_name'] : ''; ?>" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="site_description">Site Description</label>
                            <textarea name="site_description" id="site_description" class="form-control" rows="3" required><?php echo isset($settings['site_description']) ? $settings['site_description'] : ''; ?></textarea>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="contact_email">Contact Email</label>
                            <input type="email" name="contact_email" id="contact_email" class="form-control" 
                                   value="<?php echo isset($settings['contact_email']) ? $settings['contact_email'] : ''; ?>" required>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input type="checkbox" name="enable_registration" id="enable_registration" class="form-check-input" 
                                   value="1" <?php echo (isset($settings['enable_registration']) && $settings['enable_registration'] == 1) ? 'checked' : ''; ?>>
                            <label for="enable_registration" class="form-check-label">Enable User Registration</label>
                            <div class="form-text">If disabled, only administrators can create new accounts.</div>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input type="checkbox" name="enable_public_courses" id="enable_public_courses" class="form-check-input" 
                                   value="1" <?php echo (isset($settings['enable_public_courses']) && $settings['enable_public_courses'] == 1) ? 'checked' : ''; ?>>
                            <label for="enable_public_courses" class="form-check-label">Enable Public Course Listings</label>
                            <div class="form-text">If disabled, only registered users can browse courses.</div>
                        </div>
                        
                        <div class="form-check mb-4">
                            <input type="checkbox" name="maintenance_mode" id="maintenance_mode" class="form-check-input" 
                                   value="1" <?php echo (isset($settings['maintenance_mode']) && $settings['maintenance_mode'] == 1) ? 'checked' : ''; ?>>
                            <label for="maintenance_mode" class="form-check-label">Enable Maintenance Mode</label>
                            <div class="form-text">When enabled, only administrators can access the site.</div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
