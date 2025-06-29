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
                            <h1 class="admin-title">Create a Default Category</h1>
                            <p class="admin-subtitle">Add a default category to start with</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?= base_url('admin/categories') ?>" class="btn btn-secondary">Back to Categories</a>
                        </div>
                    </div>
                </div>
                
                <!-- Create Default Category Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                        <?php endif; ?>
                        
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                        <?php endif; ?>
                        
                        <p>This will create a default "Programming" category so you can start creating courses.</p>
                        
                        <form action="<?= base_url('admin/create_default_category') ?>" method="post">
                            <button type="submit" class="btn btn-primary">Create Default Category</button>
                        </form>
                    </div>
                </div>
                
                <!-- Create Default Instructor Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5>Create a Default Instructor</h5>
                    </div>
                    <div class="card-body">
                        <p>This will create a default instructor account so you can create courses.</p>
                        
                        <form action="<?= base_url('admin/create_default_instructor') ?>" method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="John Instructor" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="instructor@example.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" class="form-control" id="password" name="password" value="password123" required>
                            </div>
                            
                            <button type="submit" class="btn btn-success">Create Default Instructor</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
