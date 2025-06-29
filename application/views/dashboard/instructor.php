<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="dashboard-container">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2">
                <?php $this->load->view('templates/instructor_sidebar'); ?>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-10">
                <!-- Dashboard Header -->
                <div class="admin-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <button class="btn sidebar-toggle d-lg-none me-2">
                                <i class="fas fa-bars"></i>
                            </button>
                            <h1 class="admin-title">Instructor Dashboard</h1>
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
