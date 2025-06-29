<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
// Add this debugging section temporarily
if (isset($error_courses)) {
    echo '<div class="alert alert-danger">Error loading courses: ' . $error_courses . '</div>';
}

// Make sure enrolled_courses is always an array
if (!isset($enrolled_courses) || !is_array($enrolled_courses)) {
    $enrolled_courses = [];
}

// Make sure recommended_courses is always an array
if (!isset($recommended_courses) || !is_array($recommended_courses)) {
    $recommended_courses = [];
}

// Make sure course_progress is always an array
if (!isset($course_progress) || !is_array($course_progress)) {
    $course_progress = [];
}

// Make sure upcoming_quizzes is always an array
if (!isset($upcoming_quizzes) || !is_array($upcoming_quizzes)) {
    $upcoming_quizzes = [];
}

// Make sure recent_activities is always an array
if (!isset($recent_activities) || !is_array($recent_activities)) {
    $recent_activities = [];
}

// Make sure certificates is always an array
if (!isset($certificates) || !is_array($certificates)) {
    $certificates = [];
}
?>
<div class="dashboard-container">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2">
                <?php $this->load->view('templates/student_sidebar'); ?>
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
                            <h1 class="admin-title">Student Dashboard</h1>
                            <p class="admin-subtitle">Welcome back, <?= $user['name'] ?>!</p>
                        </div>
                      
                    </div>
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
                                    <p class="stat-card-value"><?= isset($enrolled_courses) && is_array($enrolled_courses) ? count($enrolled_courses) : 0 ?></p>
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
                                        if (isset($course_progress) && is_array($course_progress)) {
                                            foreach ($course_progress as $progress) {
                                                if (isset($progress['progress']) && $progress['progress'] == 100) {
                                                    $completed_count++;
                                                }
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
                                    <p class="stat-card-value"><?= isset($certificates) && is_array($certificates) ? count($certificates) : 0 ?></p>
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
                                            <h5 class="progress-title"><a href="<?= base_url('course/view/'.@$course['id']) ?>"><?= @$course['title'] ?></a></h5>
                                            <div class="progress">
                                                <?php 
                                                $progress_value = 0;
                                                if (isset($course_progress) && is_array($course_progress)) {
                                                    foreach ($course_progress as $progress) {
                                                        if (isset($progress['course_id']) && isset($course['id']) && $progress['course_id'] == $course['id']) {
                                                            $progress_value = $progress['progress'];
                                                            break;
                                                        }
                                                    }
                                                }
                                                ?>
                                                <div class="progress-bar" role="progressbar" style="width: <?= $progress_value ?>%;" aria-valuenow="<?= $progress_value ?>" aria-valuemin="0" aria-valuemax="100"><?= $progress_value ?>%</div>
                                            </div>
                                            <div class="progress-meta">
                                                <span class="instructor"><i class="fas fa-user"></i> <?= isset($course['instructor_name']) ? $course['instructor_name'] : 'Unknown Instructor' ?></span>
                                                <span class="category"><i class="fas fa-tag"></i> <?= isset($course['category_name']) ? $course['category_name'] : 'Uncategorized' ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-center text-md-right">
                                            <a href="<?= base_url('course/learn/'.@$course['id']) ?>" class="btn btn-primary">Continue Learning</a>
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
                                                    <img src="<?= base_url('assets/images/courses/'.@$course['image']) ?>" class="card-img-top" alt="<?= @$course['title'] ?>">
                                                    <div class="course-price">
                                                        <?php if (isset($course['price']) && $course['price'] == 0): ?>
                                                            <span class="badge badge-success">Free</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-primary">$<?= isset($course['price']) ? number_format($course['price'], 2) : '0.00' ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="course-category">
                                                        <span class="badge badge-light"><?= isset($course['category_name']) ? $course['category_name'] : 'Uncategorized' ?></span>
                                                    </div>
                                                    <h5 class="card-title"><a href="<?= base_url('course/view/'.@$course['id']) ?>"><?= @$course['title'] ?></a></h5>
                                                    <div class="course-meta">
                                                        <span><i class="fas fa-user"></i> <?= isset($course['instructor_name']) ? $course['instructor_name'] : 'Unknown Instructor' ?></span>
                                                    </div>
                                                    <div class="course-rating">
                                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                                            <?php if (isset($course['rating']) && $i <= $course['rating']): ?>
                                                                <i class="fas fa-star"></i>
                                                            <?php elseif (isset($course['rating']) && $i - 0.5 <= $course['rating']): ?>
                                                                <i class="fas fa-star-half-alt"></i>
                                                            <?php else: ?>
                                                                <i class="far fa-star"></i>
                                                            <?php endif; ?>
                                                        <?php endfor; ?>
                                                        <span>(<?= isset($course['review_count']) ? $course['review_count'] : '0' ?>)</span>
                                                    </div>
                                                    <a href="<?= base_url('course/view/'.@$course['id']) ?>" class="btn btn-outline-primary btn-sm mt-2">View Course</a>
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
