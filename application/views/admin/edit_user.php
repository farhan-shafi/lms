<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="dashboard-container">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2">
                <?php $this->load->view('templates/admin_sidebar'); ?>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-10">
                <!-- Dashboard Header -->
                <div class="admin-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="admin-title">Edit User</h1>
                            <p class="admin-subtitle">Update user information</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">Back to Users</a>
                        </div>
                    </div>
                </div>
                
                <!-- Edit User Form -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                        <?php endif; ?>
                        
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                        <?php endif; ?>
                        
                        <?php if (validation_errors()): ?>
                            <div class="alert alert-danger"><?= validation_errors() ?></div>
                        <?php endif; ?>
                        
                        <form action="<?= base_url('admin/edit_user/' . $user['id']) ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name', $user['name']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email', $user['email']) ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                        <small class="text-muted">Leave blank to keep current password</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <select class="form-control" id="role" name="role" required>
                                            <option value="student" <?= set_select('role', 'student', ($user['role'] == 'student')) ?>>Student</option>
                                            <option value="instructor" <?= set_select('role', 'instructor', ($user['role'] == 'instructor')) ?>>Instructor</option>
                                            <option value="admin" <?= set_select('role', 'admin', ($user['role'] == 'admin')) ?>>Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="active" <?= set_select('status', 'active', (isset($user['status']) && $user['status'] == 'active')) ?>>Active</option>
                                            <option value="inactive" <?= set_select('status', 'inactive', (isset($user['status']) && $user['status'] == 'inactive')) ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="profile_image" class="form-label">Profile Image</label>
                                        <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                                        <?php if (isset($user['profile_image']) && !empty($user['profile_image'])): ?>
                                            <div class="mt-2">
                                                <img src="<?= base_url($user['profile_image']) ?>" alt="Current Profile Image" class="img-thumbnail" style="max-width: 100px;">
                                                <small class="text-muted d-block">Current profile image</small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
