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
                            <h1 class="admin-title"><?= $is_edit ? 'Edit Category' : 'Create Category' ?></h1>
                            <p class="admin-subtitle"><?= $is_edit ? 'Update category information' : 'Add a new course category' ?></p>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?= base_url('admin/categories') ?>" class="btn btn-secondary">Back to Categories</a>
                        </div>
                    </div>
                </div>
                
                <!-- Edit Category Form -->
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
                        
                        <form action="<?= $is_edit ? base_url('admin/edit_category/' . $category['id']) : base_url('admin/edit_category') ?>" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name', $is_edit ? $category['name'] : '') ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"><?= set_value('description', $is_edit ? $category['description'] : '') ?></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="active" <?= set_select('status', 'active', ($is_edit && isset($category['status']) && $category['status'] == 'active')) ?>>Active</option>
                                            <option value="inactive" <?= set_select('status', 'inactive', ($is_edit && isset($category['status']) && $category['status'] == 'inactive')) ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="icon" class="form-label">Category Icon</label>
                                        <input type="file" class="form-control" id="icon" name="icon" accept="image/*">
                                        <?php if ($is_edit && isset($category['icon']) && !empty($category['icon'])): ?>
                                            <div class="mt-2">
                                                <img src="<?= base_url($category['icon']) ?>" alt="Current Icon" class="img-thumbnail" style="max-width: 100px;">
                                                <small class="text-muted d-block">Current icon</small>
                                            </div>
                                        <?php endif; ?>
                                        <small class="text-muted">Recommended size: 64x64px</small>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if ($is_edit): ?>
                                <div class="mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control" value="<?= $category['slug'] ?>" readonly disabled>
                                    <small class="text-muted">Slug cannot be changed after creation</small>
                                </div>
                            <?php endif; ?>
                            
                            <button type="submit" class="btn btn-primary"><?= $is_edit ? 'Update Category' : 'Create Category' ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
