<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="sidebar">
    <div class="sidebar-header">
        <h5>Student Dashboard</h5>
        <!-- User Profile Image -->
        <div class="user-profile text-center my-3">
            <?php if(isset($_SESSION['user_id'])): ?>
                <?php 
                    // Get user details from database
                    $CI =& get_instance();
                    $CI->load->model('User_model');
                    $user = $CI->User_model->get_user_by_id($_SESSION['user_id']);
                    $profile_image = isset($user['profile_image']) && !empty($user['profile_image']) 
                        ? base_url($user['profile_image']) 
                        : base_url('assets/images/profiles/default.png');
                ?>
                <img src="<?= $profile_image ?>" alt="Profile" class="rounded-circle profile-image">
                <p class="user-name mt-2"><?= $_SESSION['name'] ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(2) == '' || $this->uri->segment(2) == 'student' ? 'active' : '' ?>" href="<?= base_url('dashboard/student') ?>">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(2) == 'courses' ? 'active' : '' ?>" href="<?= base_url('dashboard/courses') ?>">
                    <i class="fas fa-book me-2"></i> My Courses
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(1) == 'discussion' ? 'active' : '' ?>" href="<?= base_url('discussions') ?>">
                    <i class="fas fa-comments me-2"></i> Discussions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(1) == 'announcement' ? 'active' : '' ?>" href="<?= base_url('announcements') ?>">
                    <i class="fas fa-bullhorn me-2"></i> Announcements
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(1) == 'progress' ? 'active' : '' ?>" href="<?= base_url('progress') ?>">
                    <i class="fas fa-chart-line me-2"></i> My Progress
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(2) == 'certificates' ? 'active' : '' ?>" href="<?= base_url('dashboard/certificates') ?>">
                    <i class="fas fa-certificate me-2"></i> My Certificates
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(2) == 'notifications' ? 'active' : '' ?>" href="<?= base_url('dashboard/notifications') ?>">
                    <i class="fas fa-bell me-2"></i> Notifications
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(2) == 'profile' ? 'active' : '' ?>" href="<?= base_url('dashboard/profile') ?>">
                    <i class="fas fa-user me-2"></i> Profile
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $this->uri->segment(2) == 'security' ? 'active' : '' ?>" href="<?= base_url('dashboard/security') ?>">
                    <i class="fas fa-shield-alt me-2"></i> Account Security
                </a>
            </li>
        </ul>
    </div>
</div>
