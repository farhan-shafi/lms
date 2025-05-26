<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="dashboard-container">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="dashboard-sidebar">
                    <div class="user-profile text-center">
                        <div class="profile-image">
                            <?php if ($user['profile_image'] && file_exists('./assets/images/profiles/'.$user['profile_image'])): ?>
                                <img src="<?= base_url('assets/images/profiles/'.$user['profile_image']) ?>" alt="<?= $user['name'] ?>" class="img-fluid rounded-circle">
                            <?php else: ?>
                                <img src="<?= base_url('assets/images/profiles/default.jpg') ?>" alt="<?= $user['name'] ?>" class="img-fluid rounded-circle">
                            <?php endif; ?>
                        </div>
                        <h4 class="user-name"><?= $user['name'] ?></h4>
                        <p class="user-role"><?= ucfirst($user['role']) ?></p>
                    </div>
                    <ul class="dashboard-menu">
                        <?php if ($user['role'] == 'student'): ?>
                            <li><a href="<?= base_url('dashboard/student') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li><a href="<?= base_url('dashboard/courses') ?>"><i class="fas fa-book-open"></i> My Courses</a></li>
                            <li><a href="<?= base_url('dashboard/certificates') ?>"><i class="fas fa-certificate"></i> Certificates</a></li>
                        <?php elseif ($user['role'] == 'instructor'): ?>
                            <li><a href="<?= base_url('dashboard/instructor') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li><a href="<?= base_url('dashboard/courses') ?>"><i class="fas fa-book-open"></i> My Courses</a></li>
                            <li><a href="<?= base_url('instructor/create_course') ?>"><i class="fas fa-plus-circle"></i> Create Course</a></li>
                            <li><a href="<?= base_url('instructor/earnings') ?>"><i class="fas fa-dollar-sign"></i> Earnings</a></li>
                        <?php else: ?>
                            <li><a href="<?= base_url('dashboard/admin') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li><a href="<?= base_url('admin/courses') ?>"><i class="fas fa-book-open"></i> Courses</a></li>
                            <li><a href="<?= base_url('admin/users') ?>"><i class="fas fa-users"></i> Users</a></li>
                            <li><a href="<?= base_url('admin/settings') ?>"><i class="fas fa-cog"></i> Settings</a></li>
                        <?php endif; ?>
                        <li><a href="<?= base_url('dashboard/notifications') ?>"><i class="fas fa-bell"></i> Notifications</a></li>
                        <li><a href="<?= base_url('dashboard/profile') ?>"><i class="fas fa-user"></i> My Profile</a></li>
                        <li class="active"><a href="<?= base_url('dashboard/change_password') ?>"><i class="fas fa-lock"></i> Change Password</a></li>
                        <li><a href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Dashboard Header -->
                <div class="dashboard-header">
                    <h1 class="dashboard-title">Change Password</h1>
                    <p class="dashboard-subtitle">Update your password to keep your account secure</p>
                </div>
                
                <!-- Change Password Form Section -->
                <div class="dashboard-section">
                    <div class="section-body">
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= $this->session->flashdata('success') ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= $this->session->flashdata('error') ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (validation_errors()): ?>
                            <div class="alert alert-danger">
                                <?= validation_errors() ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="password-form-container">
                                    <?= form_open('dashboard/change_password', ['class' => 'password-form']); ?>
                                        <div class="form-group">
                                            <label for="current_password">Current Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="new_password">New Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">Password must be at least 6 characters long and include a mix of letters, numbers, and special characters.</small>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="confirm_password">Confirm New Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirm_password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="password-strength">
                                            <div class="strength-meter">
                                                <div class="strength-meter-fill" data-strength="0"></div>
                                            </div>
                                            <div class="strength-text">Password strength: <span>Very Weak</span></div>
                                        </div>
                                        
                                        <div class="form-group mt-4">
                                            <button type="submit" class="btn btn-primary btn-block">Update Password</button>
                                        </div>
                                        
                                        <div class="password-tips">
                                            <h5>Password Tips:</h5>
                                            <ul>
                                                <li>Use at least 8 characters</li>
                                                <li>Include uppercase and lowercase letters</li>
                                                <li>Use numbers and special characters</li>
                                                <li>Avoid using personal information</li>
                                                <li>Don't reuse passwords from other sites</li>
                                            </ul>
                                        </div>
                                    <?= form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            
            if (input.type === 'password') {
                input.type = 'text';
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                input.type = 'password';
                this.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });
    });
    
    // Password strength meter
    const passwordInput = document.getElementById('new_password');
    const strengthMeter = document.querySelector('.strength-meter-fill');
    const strengthText = document.querySelector('.strength-text span');
    
    passwordInput.addEventListener('input', function() {
        const val = passwordInput.value;
        let strength = 0;
        
        // Length check
        if (val.length >= 6) strength += 1;
        if (val.length >= 8) strength += 1;
        
        // Character type checks
        if (val.match(/[a-z]+/)) strength += 1;
        if (val.match(/[A-Z]+/)) strength += 1;
        if (val.match(/[0-9]+/)) strength += 1;
        if (val.match(/[^a-zA-Z0-9]+/)) strength += 1;
        
        // Update strength meter
        const strengthPercentage = (strength / 6) * 100;
        strengthMeter.style.width = strengthPercentage + '%';
        strengthMeter.setAttribute('data-strength', strength);
        
        // Update strength text
        if (strength === 0) strengthText.textContent = 'Very Weak';
        else if (strength <= 2) strengthText.textContent = 'Weak';
        else if (strength <= 4) strengthText.textContent = 'Medium';
        else if (strength <= 5) strengthText.textContent = 'Strong';
        else strengthText.textContent = 'Very Strong';
    });
    
    // Password match validation
    const confirmInput = document.getElementById('confirm_password');
    
    confirmInput.addEventListener('input', function() {
        if (passwordInput.value === confirmInput.value) {
            confirmInput.setCustomValidity('');
        } else {
            confirmInput.setCustomValidity('Passwords do not match');
        }
    });
});
</script>
