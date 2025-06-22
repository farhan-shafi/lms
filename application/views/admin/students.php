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
                        <li><a href="<?= base_url('admin/users') ?>"><i class="fas fa-users"></i> Users</a></li>
                        <li><a href="<?= base_url('admin/instructors') ?>"><i class="fas fa-chalkboard-teacher"></i> Instructors</a></li>
                        <li class="active"><a href="<?= base_url('admin/students') ?>"><i class="fas fa-user-graduate"></i> Students</a></li>
                        <li><a href="<?= base_url('admin/enrollments') ?>"><i class="fas fa-user-check"></i> Enrollments</a></li>
                        <li><a href="<?= base_url('admin/payments') ?>"><i class="fas fa-credit-card"></i> Payments</a></li>
                        <li><a href="<?= base_url('admin/reviews') ?>"><i class="fas fa-star"></i> Reviews</a></li>
                        <li><a href="<?= base_url('admin/reports') ?>"><i class="fas fa-chart-bar"></i> Reports</a></li>
                        <li><a href="<?= base_url('admin/settings') ?>"><i class="fas fa-cog"></i> Settings</a></li>
                        <li><a href="<?= base_url('dashboard/profile') ?>"><i class="fas fa-user"></i> My Profile</a></li>
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
                            <h1 class="admin-title">Manage Students</h1>
                        </div>
                    </div>
                </div>
                
                <!-- Students Table -->
                <div class="admin-section">
                    <div class="section-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>
                                        <tr>
                                            <td><?= $student['id'] ?></td>
                                            <td><?= $student['name'] ?></td>
                                            <td><?= $student['email'] ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/students/edit/'.$student['id']) ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                <a href="<?= base_url('admin/students/delete/'.$student['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?')"><i class="fas fa-trash"></i></a>
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
