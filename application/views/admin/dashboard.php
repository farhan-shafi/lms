<!-- Admin Dashboard View -->
<div class="admin-dashboard">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="page-title">Admin Dashboard</h1>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="row stats-cards">
            <div class="col-md-3">
                <div class="stats-card bg-primary">
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-info">
                        <h4 class="stats-number"><?= $total_users ?></h4>
                        <p class="stats-text">Total Users</p>
                    </div>
                    <div class="stats-link">
                        <a href="<?= site_url('admin/users') ?>">View Details <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card bg-success">
                    <div class="stats-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stats-info">
                        <h4 class="stats-number"><?= $total_courses ?></h4>
                        <p class="stats-text">Total Courses</p>
                    </div>
                    <div class="stats-link">
                        <a href="<?= site_url('admin/courses') ?>">View Details <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card bg-info">
                    <div class="stats-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stats-info">
                        <h4 class="stats-number"><?= $total_instructors ?></h4>
                        <p class="stats-text">Total Instructors</p>
                    </div>
                    <div class="stats-link">
                        <a href="<?= site_url('admin/instructors') ?>">View Details <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card bg-warning">
                    <div class="stats-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stats-info">
                        <h4 class="stats-number"><?= $currency_symbol . number_format($total_revenue, 2) ?></h4>
                        <p class="stats-text">Total Revenue</p>
                    </div>
                    <div class="stats-link">
                        <a href="<?= site_url('admin/payments') ?>">View Details <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Charts Row -->
        <div class="row charts-row">
            <div class="col-lg-8">
                <div class="card chart-card">
                    <div class="card-header">
                        <h4 class="card-title">Revenue Overview</h4>
                        <div class="chart-period">
                            <select id="revenuePeriod" class="form-control">
                                <option value="weekly">Last 7 Days</option>
                                <option value="monthly" selected>Last 30 Days</option>
                                <option value="yearly">Last 12 Months</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card chart-card">
                    <div class="card-header">
                        <h4 class="card-title">Course Categories</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="categoriesChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activities & Pending Reviews -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card recent-activities">
                    <div class="card-header">
                        <h4 class="card-title">Recent Activities</h4>
                    </div>
                    <div class="card-body">
                        <ul class="activities-list">
                            <?php if(empty($activities)): ?>
                                <li class="no-activities">No recent activities found.</li>
                            <?php else: ?>
                                <?php foreach($activities as $activity): ?>
                                <li class="activity-item">
                                    <div class="activity-icon">
                                        <?php if($activity['type'] == 'user_registered'): ?>
                                            <i class="fas fa-user-plus text-success"></i>
                                        <?php elseif($activity['type'] == 'course_created'): ?>
                                            <i class="fas fa-plus-circle text-primary"></i>
                                        <?php elseif($activity['type'] == 'course_published'): ?>
                                            <i class="fas fa-check-circle text-success"></i>
                                        <?php elseif($activity['type'] == 'enrollment'): ?>
                                            <i class="fas fa-user-graduate text-info"></i>
                                        <?php elseif($activity['type'] == 'payment'): ?>
                                            <i class="fas fa-credit-card text-warning"></i>
                                        <?php else: ?>
                                            <i class="fas fa-bell text-secondary"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="activity-details">
                                        <div class="activity-text"><?= $activity['description'] ?></div>
                                        <div class="activity-time"><?= $activity['time_ago'] ?></div>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                        <?php if(count($activities) >= 10): ?>
                        <div class="view-all">
                            <a href="<?= site_url('admin/activities') ?>" class="btn btn-sm btn-outline-primary">View All Activities</a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card pending-items">
                    <div class="card-header">
                        <h4 class="card-title">Pending Actions</h4>
                        <ul class="nav nav-tabs card-header-tabs" id="pendingTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="courses-tab" data-toggle="tab" href="#pendingCourses" role="tab" aria-controls="pendingCourses" aria-selected="true">Courses <span class="badge badge-danger"><?= count($pending_courses) ?></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="payouts-tab" data-toggle="tab" href="#pendingPayouts" role="tab" aria-controls="pendingPayouts" aria-selected="false">Payouts <span class="badge badge-danger"><?= count($pending_payouts) ?></span></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="pendingTabsContent">
                            <div class="tab-pane fade show active" id="pendingCourses" role="tabpanel" aria-labelledby="courses-tab">
                                <?php if(empty($pending_courses)): ?>
                                    <p class="no-pending">No pending courses to approve.</p>
                                <?php else: ?>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Course Title</th>
                                                <th>Instructor</th>
                                                <th>Submitted</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($pending_courses as $course): ?>
                                            <tr>
                                                <td><?= $course['title'] ?></td>
                                                <td><?= $course['instructor_name'] ?></td>
                                                <td><?= $course['submitted_date'] ?></td>
                                                <td>
                                                    <a href="<?= site_url('admin/courses/review/'.$course['id']) ?>" class="btn btn-sm btn-primary">Review</a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php if(count($pending_courses) >= 5): ?>
                                    <div class="view-all">
                                        <a href="<?= site_url('admin/courses/pending') ?>" class="btn btn-sm btn-outline-primary">View All Pending Courses</a>
                                    </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="tab-pane fade" id="pendingPayouts" role="tabpanel" aria-labelledby="payouts-tab">
                                <?php if(empty($pending_payouts)): ?>
                                    <p class="no-pending">No pending payout requests.</p>
                                <?php else: ?>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Instructor</th>
                                                <th>Amount</th>
                                                <th>Requested</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($pending_payouts as $payout): ?>
                                            <tr>
                                                <td><?= $payout['instructor_name'] ?></td>
                                                <td><?= $currency_symbol . number_format($payout['amount'], 2) ?></td>
                                                <td><?= $payout['requested_date'] ?></td>
                                                <td>
                                                    <a href="<?= site_url('admin/payouts/review/'.$payout['id']) ?>" class="btn btn-sm btn-primary">Process</a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php if(count($pending_payouts) >= 5): ?>
                                    <div class="view-all">
                                        <a href="<?= site_url('admin/payouts/pending') ?>" class="btn btn-sm btn-outline-primary">View All Pending Payouts</a>
                                    </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions and Latest Enrollments -->
        <div class="row">
            <div class="col-lg-4">
                <div class="card quick-actions">
                    <div class="card-header">
                        <h4 class="card-title">Quick Actions</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <a href="<?= site_url('admin/courses/create') ?>" class="quick-action-item">
                                    <div class="quick-action-icon bg-primary">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                    <div class="quick-action-text">Add New Course</div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="<?= site_url('admin/users/create') ?>" class="quick-action-item">
                                    <div class="quick-action-icon bg-success">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div class="quick-action-text">Add New User</div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="<?= site_url('admin/categories') ?>" class="quick-action-item">
                                    <div class="quick-action-icon bg-info">
                                        <i class="fas fa-folder-plus"></i>
                                    </div>
                                    <div class="quick-action-text">Manage Categories</div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="<?= site_url('admin/settings') ?>" class="quick-action-item">
                                    <div class="quick-action-icon bg-warning">
                                        <i class="fas fa-cog"></i>
                                    </div>
                                    <div class="quick-action-text">System Settings</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card latest-enrollments">
                    <div class="card-header">
                        <h4 class="card-title">Latest Enrollments</h4>
                    </div>
                    <div class="card-body">
                        <?php if(empty($latest_enrollments)): ?>
                            <p class="no-enrollments">No recent enrollments found.</p>
                        <?php else: ?>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Course</th>
                                        <th>Date</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($latest_enrollments as $enrollment): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if(!empty($enrollment['student_avatar'])): ?>
                                                    <img src="<?= base_url('uploads/avatars/'.$enrollment['student_avatar']) ?>" alt="<?= $enrollment['student_name'] ?>" class="avatar-sm mr-2">
                                                <?php else: ?>
                                                    <img src="<?= base_url('assets/images/default-avatar.jpg') ?>" alt="<?= $enrollment['student_name'] ?>" class="avatar-sm mr-2">
                                                <?php endif; ?>
                                                <?= $enrollment['student_name'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="<?= site_url('course/view/'.$enrollment['course_slug']) ?>"><?= $enrollment['course_title'] ?></a>
                                        </td>
                                        <td><?= $enrollment['enrollment_date'] ?></td>
                                        <td>
                                            <?php if($enrollment['price'] == 0): ?>
                                                <span class="badge badge-success">Free</span>
                                            <?php else: ?>
                                                <?= $currency_symbol . number_format($enrollment['price'], 2) ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($enrollment['payment_status'] == 'completed'): ?>
                                                <span class="badge badge-success">Completed</span>
                                            <?php elseif($enrollment['payment_status'] == 'pending'): ?>
                                                <span class="badge badge-warning">Pending</span>
                                            <?php elseif($enrollment['payment_status'] == 'free'): ?>
                                                <span class="badge badge-info">Free</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Failed</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="view-all">
                                <a href="<?= site_url('admin/enrollments') ?>" class="btn btn-sm btn-outline-primary">View All Enrollments</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Revenue chart
    var ctx1 = document.getElementById('revenueChart').getContext('2d');
    var revenueData = <?= json_encode($revenue_data) ?>;
    var revenueChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: revenueData.labels,
            datasets: [{
                label: 'Revenue',
                data: revenueData.values,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.4,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '<?= $currency_symbol ?>' + value;
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Revenue: <?= $currency_symbol ?>' + context.raw.toFixed(2);
                        }
                    }
                }
            }
        }
    });
    
    // Categories chart
    var ctx2 = document.getElementById('categoriesChart').getContext('2d');
    var categoryData = <?= json_encode($category_data) ?>;
    var categoriesChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: categoryData.labels,
            datasets: [{
                data: categoryData.values,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)',
                    'rgba(199, 199, 199, 0.8)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    
    // Handle period change for revenue chart
    $('#revenuePeriod').change(function() {
        var period = $(this).val();
        
        $.ajax({
            url: '<?= site_url('admin/get_revenue_data') ?>',
            type: 'GET',
            data: {period: period},
            dataType: 'json',
            success: function(response) {
                revenueChart.data.labels = response.labels;
                revenueChart.data.datasets[0].data = response.values;
                revenueChart.update();
            }
        });
    });
});
</script>
