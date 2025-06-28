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
                    <h5 class="mb-0">System Maintenance</h5>
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
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Database Backup</h6>
                                </div>
                                <div class="card-body">
                                    <p>Create a backup of your database. This will download a SQL file that you can use to restore your data.</p>
                                    <?php echo form_open('settings/maintenance'); ?>
                                        <input type="hidden" name="create_backup" value="1">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-download me-2"></i> Create Backup
                                        </button>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Clear Cache</h6>
                                </div>
                                <div class="card-body">
                                    <p>Clear the system cache to fix display issues or update cached content.</p>
                                    <?php echo form_open('settings/maintenance'); ?>
                                        <input type="hidden" name="clear_cache" value="1">
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fa fa-trash me-2"></i> Clear Cache
                                        </button>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">System Information</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>PHP Version</th>
                                    <td><?php echo phpversion(); ?></td>
                                </tr>
                                <tr>
                                    <th>CodeIgniter Version</th>
                                    <td><?php echo CI_VERSION; ?></td>
                                </tr>
                                <tr>
                                    <th>Database Driver</th>
                                    <td><?php echo $this->db->platform(); ?></td>
                                </tr>
                                <tr>
                                    <th>Database Version</th>
                                    <td><?php echo $this->db->version(); ?></td>
                                </tr>
                                <tr>
                                    <th>Server OS</th>
                                    <td><?php echo php_uname('s') . ' ' . php_uname('r'); ?></td>
                                </tr>
                                <tr>
                                    <th>Server Software</th>
                                    <td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
                                </tr>
                                <tr>
                                    <th>Upload Max Size</th>
                                    <td><?php echo ini_get('upload_max_filesize'); ?></td>
                                </tr>
                                <tr>
                                    <th>Memory Limit</th>
                                    <td><?php echo ini_get('memory_limit'); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">System Logs</h6>
                        </div>
                        <div class="card-body">
                            <p>Recent system logs. Use these to diagnose issues with your LMS.</p>
                            
                            <div class="log-container border p-3 bg-light" style="max-height: 300px; overflow-y: auto; font-family: monospace; font-size: 0.8rem;">
                                <?php 
                                $log_path = APPPATH . 'logs/log-' . date('Y-m-d') . '.php';
                                if (file_exists($log_path)) {
                                    $log_content = file_get_contents($log_path);
                                    // Remove PHP header
                                    $log_content = str_replace('<?php defined(\'BASEPATH\') OR exit(\'No direct script access allowed\'); ?>', '', $log_content);
                                    echo nl2br(htmlspecialchars($log_content));
                                } else {
                                    echo "No log file found for today.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
