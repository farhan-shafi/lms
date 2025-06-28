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
                    <h5 class="mb-0">Appearance Settings</h5>
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
                    
                    <?php if (isset($upload_error)): ?>
                        <div class="alert alert-danger">
                            <?php echo $upload_error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($upload_error_favicon)): ?>
                        <div class="alert alert-danger">
                            <?php echo $upload_error_favicon; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php echo form_open_multipart('settings/appearance'); ?>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="mb-3">Site Logo</h6>
                                <div class="mb-3">
                                    <?php if (isset($settings['site_logo']) && !empty($settings['site_logo'])): ?>
                                        <div class="mb-2">
                                            <img src="<?php echo base_url($settings['site_logo']); ?>" alt="Site Logo" class="img-thumbnail" style="max-height: 100px;">
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <label for="site_logo">Upload New Logo</label>
                                        <input type="file" name="site_logo" id="site_logo" class="form-control">
                                        <div class="form-text">Recommended size: 200x50 pixels. Max file size: 2MB. Allowed formats: JPG, PNG, GIF.</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <h6 class="mb-3">Site Favicon</h6>
                                <div class="mb-3">
                                    <?php if (isset($settings['site_favicon']) && !empty($settings['site_favicon'])): ?>
                                        <div class="mb-2">
                                            <img src="<?php echo base_url($settings['site_favicon']); ?>" alt="Favicon" class="img-thumbnail" style="max-height: 32px;">
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <label for="site_favicon">Upload New Favicon</label>
                                        <input type="file" name="site_favicon" id="site_favicon" class="form-control">
                                        <div class="form-text">Recommended size: 32x32 pixels. Max file size: 1MB. Allowed formats: ICO, PNG.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <h6 class="mb-3">Color Scheme</h6>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="primary_color">Primary Color</label>
                                    <div class="input-group">
                                        <input type="color" id="primary_color_picker" class="form-control form-control-color" 
                                               value="<?php echo isset($settings['primary_color']) ? $settings['primary_color'] : '#007bff'; ?>" 
                                               onchange="document.getElementById('primary_color').value=this.value;">
                                        <input type="text" name="primary_color" id="primary_color" class="form-control" 
                                               value="<?php echo isset($settings['primary_color']) ? $settings['primary_color'] : '#007bff'; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="secondary_color">Secondary Color</label>
                                    <div class="input-group">
                                        <input type="color" id="secondary_color_picker" class="form-control form-control-color" 
                                               value="<?php echo isset($settings['secondary_color']) ? $settings['secondary_color'] : '#6c757d'; ?>" 
                                               onchange="document.getElementById('secondary_color').value=this.value;">
                                        <input type="text" name="secondary_color" id="secondary_color" class="form-control" 
                                               value="<?php echo isset($settings['secondary_color']) ? $settings['secondary_color'] : '#6c757d'; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="theme">Theme</label>
                            <select name="theme" id="theme" class="form-control">
                                <option value="default" <?php echo (isset($settings['theme']) && $settings['theme'] == 'default') ? 'selected' : ''; ?>>Default</option>
                                <option value="dark" <?php echo (isset($settings['theme']) && $settings['theme'] == 'dark') ? 'selected' : ''; ?>>Dark</option>
                                <option value="light" <?php echo (isset($settings['theme']) && $settings['theme'] == 'light') ? 'selected' : ''; ?>>Light</option>
                                <option value="custom" <?php echo (isset($settings['theme']) && $settings['theme'] == 'custom') ? 'selected' : ''; ?>>Custom</option>
                            </select>
                        </div>
                        
                        <h6 class="mb-3">Custom Code</h6>
                        <div class="form-group mb-3">
                            <label for="custom_css">Custom CSS</label>
                            <textarea name="custom_css" id="custom_css" class="form-control" rows="5"><?php echo isset($settings['custom_css']) ? $settings['custom_css'] : ''; ?></textarea>
                            <div class="form-text">Add custom CSS to customize the appearance of your site. This will be added to all pages.</div>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="custom_js">Custom JavaScript</label>
                            <textarea name="custom_js" id="custom_js" class="form-control" rows="5"><?php echo isset($settings['custom_js']) ? $settings['custom_js'] : ''; ?></textarea>
                            <div class="form-text">Add custom JavaScript to add functionality to your site. This will be added to all pages.</div>
                        </div>
                        
                        <div class="form-group mb-4">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Preview</h6>
                                </div>
                                <div class="card-body">
                                    <div id="preview-container">
                                        <p>Below is a preview of how your color scheme will appear:</p>
                                        <div class="row mt-3">
                                            <div class="col-md-4 mb-2">
                                                <button id="preview-primary" class="btn btn-primary w-100">Primary Button</button>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <button id="preview-secondary" class="btn btn-secondary w-100">Secondary Button</button>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div id="preview-text" class="card p-2 text-center">Text Color</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        // Update preview when color changes
        function updatePreview() {
            var primaryColor = $('#primary_color').val();
            var secondaryColor = $('#secondary_color').val();
            
            $('#preview-primary').css('background-color', primaryColor);
            $('#preview-primary').css('border-color', primaryColor);
            
            $('#preview-secondary').css('background-color', secondaryColor);
            $('#preview-secondary').css('border-color', secondaryColor);
        }
        
        // Update on color change
        $('#primary_color, #secondary_color').on('change', updatePreview);
        $('#primary_color_picker, #secondary_color_picker').on('input', updatePreview);
        
        // Initialize preview
        updatePreview();
        
        // Sync color inputs
        $('#primary_color').on('input', function() {
            $('#primary_color_picker').val($(this).val());
            updatePreview();
        });
        
        $('#secondary_color').on('input', function() {
            $('#secondary_color_picker').val($(this).val());
            updatePreview();
        });
    });
</script>
