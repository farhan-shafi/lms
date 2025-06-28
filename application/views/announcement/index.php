<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('course/' . $course['slug']) ?>"><?= $course['title'] ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Announcements</li>
                </ol>
            </nav>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2">Course Announcements</h1>
                
                <?php if ($this->session->userdata('role') === 'admin' || $course['instructor_id'] == $this->session->userdata('user_id')): ?>
                    <a href="<?= base_url('announcement/create/' . $course['id']) ?>" class="btn btn-primary">
                        <i class="fas fa-bullhorn"></i> New Announcement
                    </a>
                <?php endif; ?>
            </div>
            
            <?php if (empty($announcements)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No announcements have been posted for this course yet.
                </div>
            <?php else: ?>
                <div class="announcements-list">
                    <?php foreach ($announcements as $announcement): ?>
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h3 class="h5 mb-0">
                                    <a href="<?= base_url('announcement/view/' . $announcement['id']) ?>" class="text-decoration-none text-dark">
                                        <i class="fas fa-bullhorn me-2 text-primary"></i> <?= $announcement['title'] ?>
                                    </a>
                                </h3>
                                <span class="badge bg-secondary"><?= time_elapsed_string($announcement['created_at']) ?></span>
                            </div>
                            <div class="card-body">
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="<?= base_url('assets/images/profiles/' . ($announcement['profile_image'] ? $announcement['profile_image'] : 'default.jpg')) ?>" alt="<?= $announcement['instructor_name'] ?>" class="rounded-circle" width="50" height="50">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h4 class="h6 mb-0"><?= $announcement['instructor_name'] ?></h4>
                                        <small class="text-muted"><?= date('F j, Y \a\t g:i a', strtotime($announcement['created_at'])) ?></small>
                                    </div>
                                </div>
                                
                                <div class="announcement-content">
                                    <?php 
                                    // Show the first 200 characters if the message is long
                                    $message = $announcement['message'];
                                    if (strlen($message) > 200) {
                                        echo nl2br(htmlspecialchars(substr($message, 0, 200))) . '...';
                                        echo '<div class="text-end mt-2">';
                                        echo '<a href="' . base_url('announcement/view/' . $announcement['id']) . '" class="btn btn-sm btn-outline-primary">Read More</a>';
                                        echo '</div>';
                                    } else {
                                        echo nl2br(htmlspecialchars($message));
                                    }
                                    ?>
                                </div>
                                
                                <?php if ($this->session->userdata('role') === 'admin' || $course['instructor_id'] == $this->session->userdata('user_id')): ?>
                                    <div class="mt-3 text-end">
                                        <a href="<?= base_url('announcement/edit/' . $announcement['id']) ?>" class="btn btn-sm btn-outline-secondary me-2">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="<?= base_url('announcement/delete/' . $announcement['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this announcement?');">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
