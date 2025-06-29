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
                            <h1 class="admin-title">Manage Courses</h1>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?= base_url('admin/edit_course') ?>" class="btn btn-primary">Create Course</a>
                        </div>
                    </div>
                </div>
                
                <!-- Courses Table -->
                <div class="admin-section">
                    <div class="section-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Instructor</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($courses as $course): ?>
                                        <tr>
                                            <td><?= $course['id'] ?></td>
                                            <td><?= $course['title'] ?></td>
                                            <td><?= $course['instructor_name'] ?></td>
                                            <td><?= $course['category_name'] ?></td>
                                            <td>$<?= number_format($course['price'], 2) ?></td>
                                            <td>
                                                <?php if ($course['status'] == 'published'): ?>
                                                    <span class="badge badge-success">Published</span>
                                                <?php elseif ($course['status'] == 'pending'): ?>
                                                    <span class="badge badge-warning">Pending</span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">Draft</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('admin/courses/edit/'.$course['id']) ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                <a href="<?= base_url('admin/courses/delete/'.$course['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this course?')"><i class="fas fa-trash"></i></a>
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
