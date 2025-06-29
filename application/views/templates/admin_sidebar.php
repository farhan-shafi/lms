<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="sidebar">
    <div class="sidebar-header">
        <h5>Admin Dashboard</h5>
        <!-- User Profile Image -->
        <div class="user-profile text-center my-3 ">
            <?php if(isset($_SESSION['user_id'])): ?>
                <?php 
                    // Get user details from database
                    $CI =& get_instance();
                    $CI->load->model('User_model');
                    $user = $CI->User_model->get_user_by_id($_SESSION['user_id']);
                    $profile_image = isset($user['profile_image']) && !empty($user['profile_image']) 
                        ? base_url('assets/images/profiles/' . $user['profile_image']) 
                        : base_url('assets/images/profiles/placeholder.png');
                ?>
                <img src="<?= $profile_image ?>" alt="Profile" class="rounded-circle img-fluid profile-image">
                <p class="user-name mt-2"><?= $_SESSION['name'] ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(2) == '' || $this->uri->segment(2) == 'index' ? 'active' : '' ?>" href="<?= base_url('admin') ?>">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(2) == 'users' ? 'active' : '' ?>" href="<?= base_url('admin/users') ?>">
                    <i class="fas fa-users me-2"></i> Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(2) == 'courses' ? 'active' : '' ?>" href="<?= base_url('admin/courses') ?>">
                    <i class="fas fa-book me-2"></i> Courses
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(2) == 'categories' ? 'active' : '' ?>" href="<?= base_url('admin/categories') ?>">
                    <i class="fas fa-folder me-2"></i> Categories
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(1) == 'announcement' ? 'active' : '' ?>" href="<?= base_url('announcements') ?>">
                    <i class="fas fa-bullhorn me-2"></i> Announcements
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(1) == 'discussion' ? 'active' : '' ?>" href="<?= base_url('discussions') ?>">
                    <i class="fas fa-comments me-2"></i> Discussions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(1) == 'review' ? 'active' : '' ?>" href="<?= base_url('reviews') ?>">
                    <i class="fas fa-star me-2"></i> Reviews
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(1) == 'certificate' ? 'active' : '' ?>" href="<?= base_url('certificates') ?>">
                    <i class="fas fa-certificate me-2"></i> Certificates
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(1) == 'progress' ? 'active' : '' ?>" href="<?= base_url('progress') ?>">
                    <i class="fas fa-chart-line me-2"></i> Progress Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(2) == 'payments' ? 'active' : '' ?>" href="<?= base_url('admin/payments') ?>">
                    <i class="fas fa-money-bill-alt me-2"></i> Payments
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(1) == 'settings' ? 'active' : '' ?>" href="<?= base_url('settings') ?>">
                    <i class="fas fa-cog me-2"></i> Settings
                </a>
            </li>
        </ul>
    </div>
</div>
