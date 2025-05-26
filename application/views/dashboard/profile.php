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
                        <li class="active"><a href="<?= base_url('dashboard/profile') ?>"><i class="fas fa-user"></i> My Profile</a></li>
                        <li><a href="<?= base_url('dashboard/change_password') ?>"><i class="fas fa-lock"></i> Change Password</a></li>
                        <li><a href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Dashboard Header -->
                <div class="dashboard-header">
                    <h1 class="dashboard-title">My Profile</h1>
                    <p class="dashboard-subtitle">Manage your personal information and profile settings</p>
                </div>
                
                <!-- Profile Form Section -->
                <div class="dashboard-section">
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
                    
                    <?php if (isset($upload_error)): ?>
                        <div class="alert alert-danger">
                            <?= $upload_error ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?= validation_errors() ?>
                        </div>
                    <?php endif; ?>
                    
                    <?= form_open_multipart('dashboard/profile', ['class' => 'profile-form']); ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="profile-image-upload">
                                    <div class="current-image">
                                        <?php if ($user['profile_image'] && file_exists('./assets/images/profiles/'.$user['profile_image'])): ?>
                                            <img src="<?= base_url('assets/images/profiles/'.$user['profile_image']) ?>" alt="<?= $user['name'] ?>" class="img-fluid rounded">
                                        <?php else: ?>
                                            <img src="<?= base_url('assets/images/profiles/default.jpg') ?>" alt="<?= $user['name'] ?>" class="img-fluid rounded">
                                        <?php endif; ?>
                                    </div>
                                    <div class="image-upload-controls">
                                        <label for="profile_image" class="btn btn-outline-primary btn-block">
                                            <i class="fas fa-upload"></i> Upload New Image
                                        </label>
                                        <input type="file" id="profile_image" name="profile_image" class="d-none">
                                        <p class="text-muted small">Allowed formats: JPG, JPEG, PNG. Max size: 2MB</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name', $user['name']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email', $user['email']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="bio">Bio</label>
                                    <textarea class="form-control" id="bio" name="bio" rows="4"><?= set_value('bio', $user['bio']) ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12">
                                <h4 class="section-subtitle">Social Media Profiles</h4>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                        </div>
                                        <input type="url" class="form-control" id="website" name="website" value="<?= set_value('website', $user['website']) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="twitter">Twitter</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                        </div>
                                        <input type="url" class="form-control" id="twitter" name="twitter" value="<?= set_value('twitter', $user['twitter']) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="facebook">Facebook</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                        </div>
                                        <input type="url" class="form-control" id="facebook" name="facebook" value="<?= set_value('facebook', $user['facebook']) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="linkedin">LinkedIn</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                        </div>
                                        <input type="url" class="form-control" id="linkedin" name="linkedin" value="<?= set_value('linkedin', $user['linkedin']) ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php if ($user['role'] == 'instructor'): ?>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h4 class="section-subtitle">Instructor Details</h4>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expertise">Areas of Expertise</label>
                                        <input type="text" class="form-control" id="expertise" name="expertise" value="<?= set_value('expertise', $user['expertise']) ?>">
                                        <small class="form-text text-muted">Separate with commas (e.g., Web Development, JavaScript, UI/UX)</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="experience">Years of Experience</label>
                                        <input type="number" class="form-control" id="experience" name="experience" value="<?= set_value('experience', $user['experience']) ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                            <a href="<?= $user['role'] == 'admin' ? base_url('dashboard/admin') : base_url('dashboard/'.$user['role']) ?>" class="btn btn-outline-secondary ml-2">Cancel</a>
                        </div>
                    <?= form_close(); ?>
                </div>
                
                <!-- Account Settings Section -->
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2 class="section-title">Account Settings</h2>
                    </div>
                    <div class="section-body">
                        <div class="account-settings">
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h5>Email Notifications</h5>
                                    <p>Receive email notifications for course updates, announcements, and new messages.</p>
                                </div>
                                <div class="setting-action">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="emailNotifications" <?= $user['email_notifications'] ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="emailNotifications"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h5>Two-Factor Authentication</h5>
                                    <p>Add an extra layer of security to your account by enabling two-factor authentication.</p>
                                </div>
                                <div class="setting-action">
                                    <a href="<?= base_url('dashboard/security') ?>" class="btn btn-sm btn-outline-primary">Setup</a>
                                </div>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h5>Change Password</h5>
                                    <p>Update your password to keep your account secure.</p>
                                </div>
                                <div class="setting-action">
                                    <a href="<?= base_url('dashboard/change_password') ?>" class="btn btn-sm btn-outline-primary">Change</a>
                                </div>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h5>Delete Account</h5>
                                    <p>Permanently delete your account and all associated data.</p>
                                </div>
                                <div class="setting-action">
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#deleteAccountModal">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountModalLabel">Delete Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete your account? This action cannot be undone and will result in the permanent loss of your account, courses, progress, and all associated data.</p>
                <div class="form-group">
                    <label for="deleteConfirmation">Type "DELETE" to confirm:</label>
                    <input type="text" class="form-control" id="deleteConfirmation" placeholder="DELETE">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteAccount" disabled>Delete Account</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview profile image before upload
    document.getElementById('profile_image').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('.current-image img').src = e.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
    
    // Email notifications toggle
    document.getElementById('emailNotifications').addEventListener('change', function(e) {
        fetch('<?= base_url('dashboard/update_notification_preferences') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'email_notifications=' + (e.target.checked ? 1 : 0) + '&<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show mt-3';
                alert.innerHTML = 'Notification preferences updated successfully. <button type="button" class="close" data-dismiss="alert">&times;</button>';
                document.querySelector('.account-settings').prepend(alert);
                
                // Auto-dismiss after 3 seconds
                setTimeout(() => {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150);
                }, 3000);
            }
        })
        .catch(error => console.error('Error updating notification preferences:', error));
    });
    
    // Delete account confirmation
    const deleteConfirmInput = document.getElementById('deleteConfirmation');
    const confirmDeleteBtn = document.getElementById('confirmDeleteAccount');
    
    deleteConfirmInput.addEventListener('input', function() {
        confirmDeleteBtn.disabled = this.value !== 'DELETE';
    });
    
    confirmDeleteBtn.addEventListener('click', function() {
        if (deleteConfirmInput.value === 'DELETE') {
            window.location.href = '<?= base_url('dashboard/delete_account') ?>';
        }
    });
});
</script>
