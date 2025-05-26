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
                        <p class="user-role">Student</p>
                    </div>
                    <ul class="dashboard-menu">
                        <li class="active"><a href="<?= base_url('dashboard/student') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                        <li><a href="<?= base_url('dashboard/courses') ?>"><i class="fas fa-book-open"></i> My Courses</a></li>
                        <li><a href="<?= base_url('dashboard/certificates') ?>"><i class="fas fa-certificate"></i> Certificates</a></li>
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
                    <h1 class="dashboard-title">Student Dashboard</h1>
                    <p class="dashboard-subtitle">Welcome back, <?= $user['name'] ?>!</p>
                </div>
                
                <!-- Dashboard Stats -->
                <div class="row dashboard-stats">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-card-body">
                                <div class="stat-card-icon">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <div class="stat-card-info">
                                    <h5 class="stat-card-title">Enrolled Courses</h5>
                                    <p class="stat-card-value"><?= count($enrolled_courses) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-card-body">
                                <div class="stat-card-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div class="stat-card-info">
                                    <h5 class="stat-card-title">Completed Courses</h5>
                                    <p class="stat-card-value">
                                        <?php 
                                        $completed_count = 0;
                                        foreach ($course_progress as $progress) {
                                            if ($progress['progress'] == 100) {
                                                $completed_count++;
                                            }
                                        }
                                        echo $completed_count;
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-card-body">
                                <div class="stat-card-icon">
                                    <i class="fas fa-certificate"></i>
                                </div>
                                <div class="stat-card-info">
                                    <h5 class="stat-card-title">Certificates</h5>
                                    <p class="stat-card-value"><?= count($certificates) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Course Progress Section -->
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2 class="section-title">Course Progress</h2>
                        <a href="<?= base_url('dashboard/courses') ?>" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="section-body">
                        <?php if (empty($enrolled_courses)): ?>
                            <div class="alert alert-info">
                                You haven't enrolled in any courses yet. <a href="<?= base_url('courses') ?>">Browse Courses</a>
                            </div>
                        <?php else: ?>
                            <?php foreach (array_slice($enrolled_courses, 0, 3) as $course): ?>
                                <div class="progress-card">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h5 class="progress-title"><a href="<?= base_url('course/view/'.$course['id']) ?>"><?= $course['title'] ?></a></h5>
                                            <div class="progress">
                                                <?php 
                                                $progress_value = 0;
                                                foreach ($course_progress as $progress) {
                                                    if ($progress['course_id'] == $course['id']) {
                                                        $progress_value = $progress['progress'];
                                                        break;
                                                    }
                                                }
                                                ?>
                                                <div class="progress-bar" role="progressbar" style="width: <?= $progress_value ?>%;" aria-valuenow="<?= $progress_value ?>" aria-valuemin="0" aria-valuemax="100"><?= $progress_value ?>%</div>
                                            </div>
                                            <div class="progress-meta">
                                                <span class="instructor"><i class="fas fa-user"></i> <?= $course['instructor_name'] ?></span>
                                                <span class="category"><i class="fas fa-tag"></i> <?= $course['category_name'] ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-center text-md-right">
                                            <a href="<?= base_url('course/learn/'.$course['id']) ?>" class="btn btn-primary">Continue Learning</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Upcoming Quizzes Section -->
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2 class="section-title">Upcoming Quizzes</h2>
                    </div>
                    <div class="section-body">
                        <?php if (empty($upcoming_quizzes)): ?>
                            <div class="alert alert-info">
                                You don't have any upcoming quizzes at the moment.
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Quiz</th>
                                            <th>Course</th>
                                            <th>Due Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($upcoming_quizzes as $quiz): ?>
                                            <tr>
                                                <td><?= $quiz['title'] ?></td>
                                                <td><?= $quiz['course_title'] ?></td>
                                                <td><?= date('M d, Y', strtotime($quiz['due_date'])) ?></td>
                                                <td>
                                                    <a href="<?= base_url('course/quiz/'.$quiz['id']) ?>" class="btn btn-sm btn-primary">Take Quiz</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Recent Activities Section -->
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2 class="section-title">Recent Activities</h2>
                    </div>
                    <div class="section-body">
                        <?php if (empty($recent_activities)): ?>
                            <div class="alert alert-info">
                                No recent activities to display.
                            </div>
                        <?php else: ?>
                            <div class="activity-list">
                                <?php foreach ($recent_activities as $activity): ?>
                                    <div class="activity-item">
                                        <div class="activity-icon">
                                            <?php if ($activity['type'] == 'course_enrolled'): ?>
                                                <i class="fas fa-user-graduate"></i>
                                            <?php elseif ($activity['type'] == 'lesson_completed'): ?>
                                                <i class="fas fa-check-circle"></i>
                                            <?php elseif ($activity['type'] == 'quiz_completed'): ?>
                                                <i class="fas fa-clipboard-check"></i>
                                            <?php elseif ($activity['type'] == 'course_completed'): ?>
                                                <i class="fas fa-trophy"></i>
                                            <?php elseif ($activity['type'] == 'certificate_earned'): ?>
                                                <i class="fas fa-certificate"></i>
                                            <?php else: ?>
                                                <i class="fas fa-history"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="activity-content">
                                            <p class="activity-text"><?= $activity['description'] ?></p>
                                            <p class="activity-time"><i class="far fa-clock"></i> <?= time_elapsed_string($activity['created_at']) ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Recommended Courses Section -->
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2 class="section-title">Recommended Courses</h2>
                        <a href="<?= base_url('courses') ?>" class="btn btn-sm btn-outline-primary">Browse All</a>
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <?php if (empty($recommended_courses)): ?>
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        No recommended courses at the moment. Keep exploring!
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php foreach ($recommended_courses as $course): ?>
                                    <div class="col-md-6">
                                        <div class="course-card">
                                            <div class="card">
                                                <div class="course-image">
                                                    <img src="<?= base_url('assets/images/courses/'.$course['image']) ?>" class="card-img-top" alt="<?= $course['title'] ?>">
                                                    <div class="course-price">
                                                        <?php if ($course['price'] == 0): ?>
                                                            <span class="badge badge-success">Free</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-primary">$<?= number_format($course['price'], 2) ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="course-category">
                                                        <span class="badge badge-light"><?= $course['category_name'] ?></span>
                                                    </div>
                                                    <h5 class="card-title"><a href="<?= base_url('course/view/'.$course['id']) ?>"><?= $course['title'] ?></a></h5>
                                                    <div class="course-meta">
                                                        <span><i class="fas fa-user"></i> <?= $course['instructor_name'] ?></span>
                                                    </div>
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
                                                    <a href="<?= base_url('course/view/'.$course['id']) ?>" class="btn btn-outline-primary btn-sm mt-2">View Course</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
