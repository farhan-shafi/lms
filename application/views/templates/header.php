<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>EduLearn LMS</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico') ?>" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Main CSS (includes all custom styling) -->
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
    
    <?php if(isset($additional_css)): ?>
        <?= $additional_css ?>
    <?php endif; ?>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="EduLearn LMS" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $this->uri->segment(1) == '' || $this->uri->segment(1) == 'home' ? 'active' : '' ?>" href="<?= base_url() ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $this->uri->segment(1) == 'courses' ? 'active' : '' ?>" href="<?= base_url('courses') ?>">Courses</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                            <?php 
                            // Check if categories is set in the controller
                            if(isset($categories) && is_array($categories)): 
                                foreach($categories as $category): 
                            ?>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('courses?category=' . $category['slug']) ?>">
                                        <i class="fas fa-<?= $category['icon'] ?>"></i> <?= $category['name'] ?>
                                    </a>
                                </li>
                            <?php 
                                endforeach; 
                            else: 
                                // If categories isn't available, we'll show placeholder items
                            ?>
                                <li><a class="dropdown-item" href="<?= base_url('courses?category=web-development') ?>"><i class="fas fa-code"></i> Web Development</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('courses?category=mobile-development') ?>"><i class="fas fa-mobile-alt"></i> Mobile Development</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('courses?category=data-science') ?>"><i class="fas fa-database"></i> Data Science</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= base_url('courses') ?>"><i class="fas fa-th-list"></i> All Categories</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $this->uri->segment(1) == 'about' ? 'active' : '' ?>" href="<?= base_url('about') ?>">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $this->uri->segment(1) == 'contact' ? 'active' : '' ?>" href="<?= base_url('contact') ?>">Contact</a>
                    </li>
                </ul>
                
                <form class="d-flex mx-auto me-2 search-form" action="<?= base_url('courses/search') ?>" method="GET">
                    <div class="input-group">
                        <input class="form-control" type="search" name="q" placeholder="Search courses..." aria-label="Search" value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
                        <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
                
                <div class="navbar-nav ms-auto">
                    <?php if($this->session->userdata('user_id')): ?>
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="avatar-sm me-2">
                                    <?php
                                    $profile_image = $this->session->userdata('profile_image') ?? 'default.jpg';
                                    $username = $this->session->userdata('name') ?? 'User';
                                    ?>
                                    <img src="<?= base_url('assets/images/profiles/' . $profile_image) ?>" alt="<?= $username ?>" class="rounded-circle img-fluid">
                                </div>
                                <span><?= $username ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <?php if($this->session->userdata('role') == 'admin'): ?>
                                    <li><a class="dropdown-item" href="<?= base_url('dashboard/admin') ?>"><i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php elseif($this->session->userdata('role') == 'instructor'): ?>
                                    <li><a class="dropdown-item" href="<?= base_url('dashboard/instructor') ?>"><i class="fas fa-chalkboard-teacher me-2"></i>Instructor Dashboard</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="<?= base_url('dashboard') ?>"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('my-courses') ?>"><i class="fas fa-graduation-cap me-2"></i>My Courses</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="fas fa-user me-2"></i>My Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?= base_url('login') ?>" class="btn btn-outline-primary me-2">Login</a>
                        <a href="<?= base_url('register') ?>" class="btn btn-primary">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main content with top margin for navbar -->
    <main class="main-content">
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                <?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
                <?= $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if($this->session->flashdata('info')): ?>
            <div class="alert alert-info alert-dismissible fade show mx-3 mt-3" role="alert">
                <?= $this->session->flashdata('info') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
