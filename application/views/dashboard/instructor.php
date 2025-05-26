<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="dashboard-container">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="dashboard-sidebar">
                    <div class="user-profile text-center">
                        <div class="profile-image">
                            <?php if ($user['profile_image'] && file_exists('./assets/images/profiles/'.$user['profile_image'])): ?>
                                <img src="<?= base_url('assets/images/profiles/'.$user['profile_image']) ?>" alt="<?= $user['name'] ?>" class="img-fluid rounded-circle">
                            <?php else: ?>
                                <img src="<?= base_url('assets/images/profiles/default.jpg') ?>" alt="<?= $user['name'] ?>" class="img-fluid rounded-circle">
                            <?php endif; ?>
                        </div>
                        <h4 class="user-name"><?= $user['name'] ?></h4>
                        <p class="user-role">Instructor</p>
                    </div>
                    <ul class="dashboard-menu">
                        <li class="active"><a href="<?= base_url('dashboard/instructor') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                        <li><a href="<?= base_url('dashboard/courses') ?>"><i class="fas fa-book-open"></i> My Courses</a></li>
                        <li><a href="<?= base_url('instructor/create_course') ?>"><i class="fas fa-plus-circle"></i> Create Course</a></li>
                        <li><a href="<?= base_url('instructor/reviews') ?>"><i class="fas fa-star"></i> Reviews</a></li>
                        <li><a href="<?= base_url('instructor/earnings') ?>"><i class="fas fa-dollar-sign"></i> Earnings</a></li>
                        <li><a href="<?= base_url('instructor/students') ?>"><i class="fas fa-users"></i> Students</a></li>
                        <li><a href="<?= base_url('dashboard/notifications') ?>"><i class="fas fa-bell"></i> Notifications</a></li>
                        <li><a href="<?= base_url('dashboard/profile') ?>"><i class="fas fa-user"></i> My Profile</a></li>
                        <li><a href="<?= base_url('dashboard/change_password') ?>"><i class="fas fa-lock"></i> Change Password</a></li>
                        <li><a href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Dashboard Header -->
                <div class="dashboard-header">
                    <h1 class="dashboard-title">Instructor Dashboard</h1>
                    <p class="dashboard-subtitle">Welcome back, <?= $user['name'] ?>!</p>
                </div>
                
                <!-- Dashboard Stats -->
                <div class="row dashboard-stats">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-card-body">
                                <div class="stat-card-icon">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <div class="stat-card-info">
                                    <h5 class="stat-card-title">Courses</h5>
                                    <p class="stat-card-value"><?= count($courses) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-card-body">
                                <div class="stat-card-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-card-info">
                                    <h5 class="stat-card-title">Students</h5>
                                    <p class="stat-card-value"><?= $total_students ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-card-body">
                                <div class="stat-card-icon">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <div class="stat-card-info">
                                    <h5 class="stat-card-title">Revenue</h5>
                                    <p class="stat-card-value">$<?= number_format($total_revenue, 2) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-card-body">
                                <div class="stat-card-icon">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="stat-card-info">
                                    <h5 class="stat-card-title">Avg Rating</h5>
                                    <p class="stat-card-value"><?= number_format($average_rating, 1) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Create Course CTA -->
                <div class="dashboard-section">
                    <div class="create-course-cta">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3>Ready to share your knowledge?</h3>
                                <p>Create a new course and reach students worldwide.</p>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="<?= base_url('instructor/create_course') ?>" class="btn btn-primary">Create New Course</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Student Engagement Chart -->
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2 class="section-title">Student Engagement</h2>
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="chart-container">
                                    <canvas id="engagementChart"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="engagement-stats">
                                    <div class="engagement-stat-item">
                                        <h5>Course Completion Rate</h5>
                                        <p class="stat-value"><?= $engagement['completion_rate'] ?>%</p>
                                    </div>
                                    <div class="engagement-stat-item">
                                        <h5>Average Progress</h5>
                                        <p class="stat-value"><?= $engagement['average_progress'] ?>%</p>
                                    </div>
                                    <div class="engagement-stat-item">
                                        <h5>Quiz Participation</h5>
                                        <p class="stat-value"><?= $engagement['quiz_participation'] ?>%</p>
                                    </div>
                                    <div class="engagement-stat-item">
                                        <h5>Discussion Activity</h5>
                                        <p class="stat-value"><?= $engagement['discussion_activity'] ?> posts/week</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Reviews Section -->
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2 class="section-title">Recent Reviews</h2>
                        <a href="<?= base_url('instructor/reviews') ?>" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="section-body">
                        <?php if (empty($recent_reviews)): ?>
                            <div class="alert alert-info">
                                No reviews to display yet.
                            </div>
                        <?php else: ?>
                            <?php foreach ($recent_reviews as $review): ?>
                                <div class="review-card">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <?php if ($review['profile_image']): ?>
                                                <img src="<?= base_url('assets/images/profiles/'.$review['profile_image']) ?>" alt="<?= $review['student_name'] ?>" class="reviewer-image">
                                            <?php else: ?>
                                                <img src="<?= base_url('assets/images/profiles/default.jpg') ?>" alt="<?= $review['student_name'] ?>" class="reviewer-image">
                                            <?php endif; ?>
                                            <div class="reviewer-details">
                                                <h5><?= $review['student_name'] ?></h5>
                                                <p class="course-title"><?= $review['course_title'] ?></p>
                                            </div>
                                        </div>
                                        <div class="review-rating">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <?php if ($i <= $review['rating']): ?>
                                                    <i class="fas fa-star"></i>
                                                <?php else: ?>
                                                    <i class="far fa-star"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                            <span class="review-date"><?= date('M d, Y', strtotime($review['created_at'])) ?></span>
                                        </div>
                                    </div>
                                    <div class="review-body">
                                        <p><?= $review['review'] ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- My Courses Section -->
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2 class="section-title">My Courses</h2>
                        <a href="<?= base_url('dashboard/courses') ?>" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="section-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Category</th>
                                        <th>Students</th>
                                        <th>Rating</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($courses)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No courses created yet.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach (array_slice($courses, 0, 5) as $course): ?>
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
                                                <td><?= $course['category_name'] ?></td>
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
                                                    <div class="btn-group">
                                                        <a href="<?= base_url('instructor/edit_course/'.$course['id']) ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                                        <a href="<?= base_url('instructor/course_analytics/'.$course['id']) ?>" class="btn btn-sm btn-info" title="Analytics"><i class="fas fa-chart-line"></i></a>
                                                        <a href="<?= base_url('instructor/course_students/'.$course['id']) ?>" class="btn btn-sm btn-success" title="Students"><i class="fas fa-users"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Monthly Revenue Chart -->
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2 class="section-title">Monthly Earnings</h2>
                        <a href="<?= base_url('instructor/earnings') ?>" class="btn btn-sm btn-outline-primary">View Details</a>
                    </div>
                    <div class="section-body">
                        <div class="chart-container">
                            <canvas id="earningsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Student Engagement Chart
    var engagementCtx = document.getElementById('engagementChart').getContext('2d');
    var engagementChart = new Chart(engagementCtx, {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'],
            datasets: [{
                label: 'Course Views',
                data: [<?= implode(',', $engagement['weekly_views']) ?>],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.4
            }, {
                label: 'Lesson Completions',
                data: [<?= implode(',', $engagement['weekly_completions']) ?>],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                tension: 0.4
            }, {
                label: 'Quiz Attempts',
                data: [<?= implode(',', $engagement['weekly_quiz_attempts']) ?>],
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
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
    
    // Monthly Earnings Chart
    var earningsCtx = document.getElementById('earningsChart').getContext('2d');
    var earningsChart = new Chart(earningsCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Monthly Earnings ($)',
                data: [
                    <?php 
                    $monthlyData = array_fill(0, 12, 0);
                    foreach ($monthly_earnings as $earning) {
                        $month = intval(date('n', strtotime($earning['month']))) - 1;
                        $monthlyData[$month] = $earning['amount'];
                    }
                    echo implode(',', $monthlyData);
                    ?>
                ],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
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
});
</script>
