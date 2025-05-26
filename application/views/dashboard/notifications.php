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
                        <p class="user-role"><?= ucfirst($user['role']) ?></p>
                    </div>
                    <ul class="dashboard-menu">
                        <?php if ($user['role'] == 'student'): ?>
                            <li><a href="<?= base_url('dashboard/student') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li><a href="<?= base_url('dashboard/courses') ?>"><i class="fas fa-book-open"></i> My Courses</a></li>
                            <li><a href="<?= base_url('dashboard/certificates') ?>"><i class="fas fa-certificate"></i> Certificates</a></li>
                        <?php elseif ($user['role'] == 'instructor'): ?>
                            <li><a href="<?= base_url('dashboard/instructor') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li><a href="<?= base_url('dashboard/courses') ?>"><i class="fas fa-book-open"></i> My Courses</a></li>
                            <li><a href="<?= base_url('instructor/create_course') ?>"><i class="fas fa-plus-circle"></i> Create Course</a></li>
                            <li><a href="<?= base_url('instructor/earnings') ?>"><i class="fas fa-dollar-sign"></i> Earnings</a></li>
                        <?php else: ?>
                            <li><a href="<?= base_url('dashboard/admin') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li><a href="<?= base_url('admin/courses') ?>"><i class="fas fa-book-open"></i> Courses</a></li>
                            <li><a href="<?= base_url('admin/users') ?>"><i class="fas fa-users"></i> Users</a></li>
                            <li><a href="<?= base_url('admin/settings') ?>"><i class="fas fa-cog"></i> Settings</a></li>
                        <?php endif; ?>
                        <li class="active"><a href="<?= base_url('dashboard/notifications') ?>"><i class="fas fa-bell"></i> Notifications</a></li>
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
                    <h1 class="dashboard-title">My Notifications</h1>
                    <p class="dashboard-subtitle">Stay updated with course announcements, messages, and system updates</p>
                </div>
                
                <!-- Notifications Section -->
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2 class="section-title">All Notifications</h2>
                        <div class="notification-actions">
                            <button type="button" class="btn btn-sm btn-outline-primary mark-all-read-btn">Mark All as Read</button>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filter
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="filterDropdown">
                                    <a class="dropdown-item active" href="#" data-filter="all">All Notifications</a>
                                    <a class="dropdown-item" href="#" data-filter="unread">Unread Only</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-filter="course">Course Updates</a>
                                    <a class="dropdown-item" href="#" data-filter="message">Messages</a>
                                    <a class="dropdown-item" href="#" data-filter="system">System Notifications</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section-body">
                        <?php if (empty($notifications)): ?>
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="far fa-bell"></i>
                                </div>
                                <h4>No Notifications Yet</h4>
                                <p>You don't have any notifications at the moment. We'll notify you when there are updates or messages.</p>
                            </div>
                        <?php else: ?>
                            <div class="notification-list">
                                <?php foreach ($notifications as $notification): ?>
                                    <div class="notification-item <?= $notification['is_read'] ? '' : 'unread' ?>" data-type="<?= $notification['type'] ?>">
                                        <div class="notification-icon">
                                            <?php if ($notification['type'] == 'course'): ?>
                                                <i class="fas fa-book-open"></i>
                                            <?php elseif ($notification['type'] == 'message'): ?>
                                                <i class="fas fa-envelope"></i>
                                            <?php elseif ($notification['type'] == 'enrollment'): ?>
                                                <i class="fas fa-user-graduate"></i>
                                            <?php elseif ($notification['type'] == 'review'): ?>
                                                <i class="fas fa-star"></i>
                                            <?php elseif ($notification['type'] == 'payment'): ?>
                                                <i class="fas fa-credit-card"></i>
                                            <?php elseif ($notification['type'] == 'certificate'): ?>
                                                <i class="fas fa-certificate"></i>
                                            <?php else: ?>
                                                <i class="fas fa-bell"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="notification-content">
                                            <div class="notification-header">
                                                <h5 class="notification-title"><?= $notification['title'] ?></h5>
                                                <span class="notification-time"><?= time_elapsed_string($notification['created_at']) ?></span>
                                            </div>
                                            <p class="notification-text"><?= $notification['message'] ?></p>
                                            <?php if ($notification['action_url']): ?>
                                                <a href="<?= base_url($notification['action_url']) ?>" class="notification-action">
                                                    <?= $notification['action_text'] ? $notification['action_text'] : 'View Details' ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (!$notification['is_read']): ?>
                                            <div class="notification-status">
                                                <button type="button" class="btn btn-sm btn-light mark-read-btn" data-id="<?= $notification['id'] ?>">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- Pagination -->
                            <?php if (count($notifications) > 10): ?>
                                <div class="pagination-container mt-4">
                                    <nav aria-label="Notification pagination">
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                            </li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">Next</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Notification Preferences -->
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2 class="section-title">Notification Preferences</h2>
                    </div>
                    <div class="section-body">
                        <form class="notification-preferences-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="mb-3">Email Notifications</h5>
                                    <div class="form-group custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="emailCourseUpdates" checked>
                                        <label class="custom-control-label" for="emailCourseUpdates">Course Updates</label>
                                    </div>
                                    <div class="form-group custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="emailMessages" checked>
                                        <label class="custom-control-label" for="emailMessages">Messages</label>
                                    </div>
                                    <div class="form-group custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="emailAnnouncements" checked>
                                        <label class="custom-control-label" for="emailAnnouncements">Announcements</label>
                                    </div>
                                    <div class="form-group custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="emailPromotions">
                                        <label class="custom-control-label" for="emailPromotions">Promotions and Offers</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="mb-3">Push Notifications</h5>
                                    <div class="form-group custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="pushCourseUpdates" checked>
                                        <label class="custom-control-label" for="pushCourseUpdates">Course Updates</label>
                                    </div>
                                    <div class="form-group custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="pushMessages" checked>
                                        <label class="custom-control-label" for="pushMessages">Messages</label>
                                    </div>
                                    <div class="form-group custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="pushAnnouncements" checked>
                                        <label class="custom-control-label" for="pushAnnouncements">Announcements</label>
                                    </div>
                                    <div class="form-group custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="pushPromotions">
                                        <label class="custom-control-label" for="pushPromotions">Promotions and Offers</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Save Preferences</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark single notification as read
    document.querySelectorAll('.mark-read-btn').forEach(button => {
        button.addEventListener('click', function() {
            const notificationId = this.getAttribute('data-id');
            const notificationItem = this.closest('.notification-item');
            
            fetch('<?= base_url('dashboard/mark_notification_read') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'notification_id=' + notificationId + '&<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    notificationItem.classList.remove('unread');
                    this.parentElement.remove();
                }
            })
            .catch(error => console.error('Error marking notification as read:', error));
        });
    });
    
    // Mark all notifications as read
    document.querySelector('.mark-all-read-btn').addEventListener('click', function() {
        fetch('<?= base_url('dashboard/mark_all_notifications_read') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: '<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelectorAll('.notification-item.unread').forEach(item => {
                    item.classList.remove('unread');
                    item.querySelector('.notification-status')?.remove();
                });
                
                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show mb-4';
                alert.innerHTML = 'All notifications marked as read. <button type="button" class="close" data-dismiss="alert">&times;</button>';
                document.querySelector('.section-header').insertAdjacentElement('afterend', alert);
                
                // Auto-dismiss after 3 seconds
                setTimeout(() => {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150);
                }, 3000);
            }
        })
        .catch(error => console.error('Error marking all notifications as read:', error));
    });
    
    // Filter notifications
    document.querySelectorAll('.dropdown-item[data-filter]').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Update active filter in dropdown
            document.querySelectorAll('.dropdown-item[data-filter]').forEach(el => el.classList.remove('active'));
            this.classList.add('active');
            
            const filterType = this.getAttribute('data-filter');
            const notificationItems = document.querySelectorAll('.notification-item');
            
            notificationItems.forEach(item => {
                if (filterType === 'all') {
                    item.style.display = '';
                } else if (filterType === 'unread') {
                    item.style.display = item.classList.contains('unread') ? '' : 'none';
                } else {
                    item.style.display = item.getAttribute('data-type') === filterType ? '' : 'none';
                }
            });
            
            // Update dropdown button text
            document.getElementById('filterDropdown').textContent = this.textContent;
        });
    });
    
    // Save notification preferences
    document.querySelector('.notification-preferences-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const preferences = {
            email_course_updates: document.getElementById('emailCourseUpdates').checked,
            email_messages: document.getElementById('emailMessages').checked,
            email_announcements: document.getElementById('emailAnnouncements').checked,
            email_promotions: document.getElementById('emailPromotions').checked,
            push_course_updates: document.getElementById('pushCourseUpdates').checked,
            push_messages: document.getElementById('pushMessages').checked,
            push_announcements: document.getElementById('pushAnnouncements').checked,
            push_promotions: document.getElementById('pushPromotions').checked
        };
        
        fetch('<?= base_url('dashboard/update_notification_preferences') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({
                ...preferences,
                '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
            }).toString()
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show mt-3';
                alert.innerHTML = 'Notification preferences updated successfully. <button type="button" class="close" data-dismiss="alert">&times;</button>';
                this.prepend(alert);
                
                // Auto-dismiss after 3 seconds
                setTimeout(() => {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150);
                }, 3000);
            }
        })
        .catch(error => console.error('Error updating notification preferences:', error));
    });
});
</script>
