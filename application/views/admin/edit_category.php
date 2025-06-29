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
                        <li class="active"><a href="<?= base_url('admin/categories') ?>"><i class="fas fa-tags"></i> Categories</a></li>
                        <li><a href="<?= base_url('admin/users') ?>"><i class="fas fa-users"></i> Users</a></li>
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
                            <h1 class="admin-title"><?= $is_edit ? 'Edit Category' : 'Create Category' ?></h1>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?= base_url('admin/categories') ?>" class="btn btn-secondary">Back to Categories</a>
                        </div>
                    </div>
                </div>
                
                <!-- Category Form -->
                <div class="admin-section">
                    <div class="section-body">
                        <form action="<?= base_url('admin/edit_category' . ($is_edit ? '/'.$category['id'] : '')) ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Category Name *</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name', $is_edit ? $category['name'] : '') ?>" required>
                                        <?= form_error('name', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status *</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="">Select Status</option>
                                            <option value="active" <?= set_select('status', 'active', $is_edit ? $category['status'] == 'active' : TRUE) ?>>Active</option>
                                            <option value="inactive" <?= set_select('status', 'inactive', $is_edit ? $category['status'] == 'inactive' : FALSE) ?>>Inactive</option>
                                        </select>
                                        <?= form_error('status', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter category description..."><?= set_value('description', $is_edit ? $category['description'] : '') ?></textarea>
                                        <?= form_error('description', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="icon">Category Icon</label>
                                        <?php if ($is_edit && $category['icon']): ?>
                                            <div class="mb-2">
                                                <img src="<?= base_url('assets/images/categories/'.$category['icon']) ?>" alt="Current Icon" class="img-thumbnail" style="max-width: 100px;">
                                                <small class="d-block text-muted">Current icon</small>
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" class="form-control-file" id="icon" name="icon" accept="image/*">
                                        <small class="form-text text-muted">Upload a category icon (optional). Max size: 2MB. Supported formats: JPG, PNG, GIF, SVG</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><?= $is_edit ? 'Update Category' : 'Create Category' ?></button>
                                <a href="<?= base_url('admin/categories') ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
