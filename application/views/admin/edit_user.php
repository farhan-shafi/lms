<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="dashboard-container">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2">
                <div class="admin-sidebar">
                    <div class="sidebar-header">
                        <div class="admin-logo">
                            <img src="<?= base_url('assets/images/logo.png') ?>" alt="LMS Logo" class="img-fluid">
                        </div>
                        <h4 class="admin-title">Admin Panel</h4>
                    </div>
                    <ul class="admin-menu">
                        <li><a href="<?= base_url('dashboard/admin') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                        <li><a href="<?= base_url('admin/courses') ?>"><i class="fas fa-book-open"></i> Courses</a></li>
                        <li><a href="<?= base_url('admin/categories') ?>"><i class="fas fa-tags"></i> Categories</a></li>
                        <li class="active"><a href="<?= base_url('admin/users') ?>"><i class="fas fa-users"></i> Users</a></li>
                        <li><a href="<?= base_url('admin/instructors') ?>"><i class="fas fa-chalkboard-teacher"></i> Instructors</a></li>
                        <li><a href="<?= base_url('admin/students') ?>"><i class="fas fa-user-graduate"></i> Students</a></li>
                        <li><a href="<?= base_url('admin/enrollments') ?>"><i class="fas fa-user-check"></i> Enrollments</a></li>
                        <li><a href="<?= base_url('admin/payments') ?>"><i class="fas fa-credit-card"></i> Payments</a></li>
                        <li><a href="<?= base_url('admin/settings') ?>"><i class="fas fa-cog"></i> Settings</a></li>
                        <li><a href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-10">
                <!-- Dashboard Header -->
                <div class="admin-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="admin-title">Edit User</h1>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">Back to Users</a>
                        </div>
                    </div>
                </div>
                
                <!-- Edit User Form -->
                <div class="admin-section">
                    <div class="section-body">
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                        <?php endif; ?>
                        
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                        <?php endif; ?>
                        
                        <?php if (validation_errors()): ?>
                            <div class="alert alert-danger"><?= validation_errors() ?></div>
                        <?php endif; ?>
                        
                        <form action="<?= base_url('admin/users/edit/'.$user['id']) ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Full Name *</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name', $user['name']) ?>" required>
                                        <?= form_error('name', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email Address *</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email', $user['email']) ?>" required>
                                        <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
                                        <?= form_error('password', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Leave blank to keep current password">
                                        <?= form_error('confirm_password', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Role *</label>
                                        <select class="form-control" id="role" name="role" required>
                                            <option value="">Select Role</option>
                                            <option value="student" <?= set_select('role', 'student', $user['role'] == 'student') ?>>Student</option>
                                            <option value="instructor" <?= set_select('role', 'instructor', $user['role'] == 'instructor') ?>>Instructor</option>
                                            <option value="admin" <?= set_select('role', 'admin', $user['role'] == 'admin') ?>>Admin</option>
                                        </select>
                                        <?= form_error('role', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status *</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="">Select Status</option>
                                            <option value="active" <?= set_select('status', 'active', $user['status'] == 'active') ?>>Active</option>
                                            <option value="inactive" <?= set_select('status', 'inactive', $user['status'] == 'inactive') ?>>Inactive</option>
                                        </select>
                                        <?= form_error('status', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="profile_image">Profile Image</label>
                                        <?php if ($user['profile_image'] && $user['profile_image'] != 'default.png'): ?>
                                            <div class="mb-2">
                                                <img src="<?= base_url('assets/images/profiles/'.$user['profile_image']) ?>" alt="Current Profile" class="img-thumbnail" style="max-width: 100px;">
                                                <small class="d-block text-muted">Current image</small>
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" class="form-control-file" id="profile_image" name="profile_image" accept="image/*">
                                        <small class="form-text text-muted">Upload a new profile picture (optional). Max size: 2MB</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update User</button>
                                <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
