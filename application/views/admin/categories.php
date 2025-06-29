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
                            <h1 class="admin-title">Manage Categories</h1>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?= base_url('admin/edit_category') ?>" class="btn btn-primary">Create Category</a>
                        </div>
                    </div>
                </div>
                
                <!-- Categories Table -->
                <div class="admin-section">
                    <div class="section-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categories as $key =>$category): ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td><?= $category['name'] ?></td>
                                            <td><?= $category['slug'] ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/categories/edit/'.$category['id']) ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                <a href="<?= base_url('admin/categories/delete/'.$category['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
