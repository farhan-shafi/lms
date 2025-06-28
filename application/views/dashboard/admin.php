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
                            <h1 class="admin-title">Admin Dashboard</h1>
                            <p class="admin-subtitle">Welcome back, <?= $user['name'] ?>!</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="admin-user-dropdown">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php if ($user['profile_image'] && file_exists('./assets/images/profiles/'.$user['profile_image'])): ?>
                                            <img src="<?= base_url('assets/images/profiles/'.$user['profile_image']) ?>" alt="<?= $user['name'] ?>" class="user-image">
                                        <?php else: ?>
                                            <img src="<?= base_url('assets/images/profiles/default.jpg') ?>" alt="<?= $user['name'] ?>" class="user-image">
                                        <?php endif; ?>
                                        <span class="user-name"><?= $user['name'] ?></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                        <a class="dropdown-item" href="<?= base_url('dashboard/profile') ?>"><i class="fas fa-user"></i> Profile</a>
                                        <a class="dropdown-item" href="<?= base_url('dashboard/change_password') ?>"><i class="fas fa-lock"></i> Change Password</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Dashboard Stats -->
                <div class="row admin-stats">
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-card-body">
                                <div class="stat-card-icon primary">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-card-info">
                                    <h5 class="stat-card-title">Total Students</h5>
                                    <p class="stat-card-value"><?= $stats['students'] ?></p>
                                    <p class="stat-card-change"><i class="fas fa-arrow-up"></i> 12.5% this month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-card-body">
                                <div class="stat-card-icon success">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div class="stat-card-info">
                                    <h5 class="stat-card-title">Total Instructors</h5>
                                    <p class="stat-card-value"><?= $stats['instructors'] ?></p>
                                    <p class="stat-card-change"><i class="fas fa-arrow-up"></i> 5.3% this month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-card-body">
                                <div class="stat-card-icon info">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <div class="stat-card-info">
                                    <h5 class="stat-card-title">Total Courses</h5>
                                    <p class="stat-card-value"><?= $stats['courses'] ?></p>
                                    <p class="stat-card-change"><i class="fas fa-arrow-up"></i> 8.2% this month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-card-body">
                                <div class="stat-card-icon warning">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <div class="stat-card-info">
                                    <h5 class="stat-card-title">Total Revenue</h5>
                                    <p class="stat-card-value">$<?= number_format($stats['revenue'], 2) ?></p>
                                    <p class="stat-card-change"><i class="fas fa-arrow-up"></i> 15.7% this month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Revenue Chart -->
                <div class="admin-section">
                    <div class="section-header">
                        <h2 class="section-title">Revenue Overview</h2>
                        <div class="section-actions">
                            <select class="form-control form-control-sm" id="revenueTimeRange">
                                <option value="weekly">This Week</option>
                                <option value="monthly" selected>This Month</option>
                                <option value="yearly">This Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="chart-container">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <!-- Recent Users Section -->
                    <div class="col-lg-6">
                        <div class="admin-section">
                            <div class="section-header">
                                <h2 class="section-title">Recent Users</h2>
                                <a href="<?= base_url('admin/users') ?>" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                            <div class="section-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Role</th>
                                                <th>Date Joined</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_users as $user): ?>
                                                <tr>
                                                    <td>
                                                        <div class="user-list-item">
                                                            <?php if ($user['profile_image']): ?>
                                                                <img src="<?= base_url('assets/images/profiles/'.$user['profile_image']) ?>" alt="<?= $user['name'] ?>" class="user-list-image">
                                                            <?php else: ?>
                                                                <img src="<?= base_url('assets/images/profiles/default.jpg') ?>" alt="<?= $user['name'] ?>" class="user-list-image">
                                                            <?php endif; ?>
                                                            <div class="user-list-info">
                                                                <h5><?= $user['name'] ?></h5>
                                                                <p><?= $user['email'] ?></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php if ($user['role'] == 'admin'): ?>
                                                            <span class="badge badge-danger">Admin</span>
                                                        <?php elseif ($user['role'] == 'instructor'): ?>
                                                            <span class="badge badge-info">Instructor</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-primary">Student</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                                                    <td>
                                                        <?php if ($user['status'] == 'active'): ?>
                                                            <span class="badge badge-success">Active</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-secondary">Inactive</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Courses Section -->
                    <div class="col-lg-6">
                        <div class="admin-section">
                            <div class="section-header">
                                <h2 class="section-title">Recent Courses</h2>
                                <a href="<?= base_url('admin/courses') ?>" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                            <div class="section-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th>Instructor</th>
                                                <th>Category</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_courses as $course): ?>
                                                <tr>
                                                    <td>
                                                        <div class="course-list-item">
                                                            <img src="<?= base_url('assets/images/courses/'.$course['image']) ?>" alt="<?= $course['title'] ?>" class="course-list-image">
                                                            <div class="course-list-info">
                                                                <h5><a href="<?= base_url('course/view/'.$course['id']) ?>"><?= $course['title'] ?></a></h5>
                                                                <p class="course-price">
                                                                    <?php if ($course['price'] == 0): ?>
                                                                        <span class="badge badge-success">Free</span>
                                                                    <?php else: ?>
                                                                        <span class="badge badge-primary">$<?= number_format($course['price'], 2) ?></span>
                                                                    <?php endif; ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?= $course['instructor_name'] ?></td>
                                                    <td><?= $course['category_name'] ?></td>
                                                    <td>
                                                        <?php if ($course['status'] == 'published'): ?>
                                                            <span class="badge badge-success">Published</span>
                                                        <?php elseif ($course['status'] == 'pending'): ?>
                                                            <span class="badge badge-warning">Pending</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-secondary">Draft</span>
                                                        <?php endif; ?>
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
                
                <div class="row">
                    <!-- Popular Courses Section -->
                    <div class="col-lg-8">
                        <div class="admin-section">
                            <div class="section-header">
                                <h2 class="section-title">Popular Courses</h2>
                                <a href="<?= base_url('admin/courses?sort=popular') ?>" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                            <div class="section-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th>Instructor</th>
                                                <th>Students</th>
                                                <th>Rating</th>
                                                <th>Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($popular_courses as $course): ?>
                                                <tr>
                                                    <td>
                                                        <div class="course-list-item">
                                                            <img src="<?= base_url('assets/images/courses/'.$course['image']) ?>" alt="<?= $course['title'] ?>" class="course-list-image">
                                                            <div class="course-list-info">
                                                                <h5><a href="<?= base_url('course/view/'.$course['id']) ?>"><?= $course['title'] ?></a></h5>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?= $course['instructor_name'] ?></td>
                                                    <td><?= $course['student_count'] ?></td>
                                                    <td>
                                                        <div class="course-rating">
                                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                <?php if ($i <= $course['rating']): ?>
                                                                    <i class="fas fa-star"></i>
                                                                <?php elseif ($i - 0.5 <= $course['rating']): ?>
                                                                    <i class="fas fa-star-half-alt"></i>
                                                                <?php else: ?>
                                                                    <i class="far fa-star"></i>
                                                                <?php endif; ?>
                                                            <?php endfor; ?>
                                                            <span>(<?= $course['review_count'] ?>)</span>
                                                        </div>
                                                    </td>
                                                    <td>$<?= number_format($course['revenue'], 2) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Category Stats Section -->
                    <div class="col-lg-4">
                        <div class="admin-section">
                            <div class="section-header">
                                <h2 class="section-title">Categories</h2>
                                <a href="<?= base_url('admin/categories') ?>" class="btn btn-sm btn-outline-primary">Manage</a>
                            </div>
                            <div class="section-body">
                                <div class="chart-container">
                                    <canvas id="categoryChart"></canvas>
                                </div>
                                <div class="category-stats-list">
                                    <?php 
                                    $categoryLabels = [];
                                    $categoryCounts = [];
                                    $categoryColors = ['#36a2eb', '#ff6384', '#4bc0c0', '#ffcd56', '#9966ff', '#ff9f40'];
                                    foreach ($categories as $index => $category): 
                                        $categoryLabels[] = $category['name'];
                                        $categoryCounts[] = $category['course_count'];
                                    ?>
                                        <div class="category-stat-item">
                                            <div class="category-name">
                                                <span class="category-color" style="background-color: <?= $categoryColors[$index % count($categoryColors)] ?>;"></span>
                                                <span><?= $category['name'] ?></span>
                                            </div>
                                            <div class="category-count"><?= $category['course_count'] ?> Courses</div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions Section -->
                <div class="admin-section">
                    <div class="section-header">
                        <h2 class="section-title">Quick Actions</h2>
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="<?= base_url('admin/users/create') ?>" class="quick-action-card">
                                    <div class="icon">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <h5>Add User</h5>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="<?= base_url('admin/categories/create') ?>" class="quick-action-card">
                                    <div class="icon">
                                        <i class="fas fa-folder-plus"></i>
                                    </div>
                                    <h5>Add Category</h5>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="<?= base_url('admin/courses/create') ?>" class="quick-action-card">
                                    <div class="icon">
                                        <i class="fas fa-plus-circle"></i>
                                    </div>
                                    <h5>Add Course</h5>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="<?= base_url('admin/reports') ?>" class="quick-action-card">
                                    <div class="icon">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <h5>View Reports</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    var revenueCtx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Revenue ($)',
                data: [
                    <?php 
                    $monthlyData = array_fill(0, 12, 0);
                    foreach ($monthly_revenue as $revenue) {
                        $month = intval(date('n', strtotime($revenue['month']))) - 1;
                        $monthlyData[$month] = $revenue['amount'];
                    }
                    echo implode(',', $monthlyData);
                    ?>
                ],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    
    // Category Chart
    var categoryCtx = document.getElementById('categoryChart').getContext('2d');
    var categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($categoryLabels) ?>,
            datasets: [{
                data: <?= json_encode($categoryCounts) ?>,
                backgroundColor: <?= json_encode($categoryColors) ?>,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
