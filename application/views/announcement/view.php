<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('course/' . $course['slug']) ?>"><?= $course['title'] ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('announcement/index/' . $course['id']) ?>">Announcements</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $announcement['title'] ?></li>
                </ol>
            </nav>
            
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h1 class="h3 mb-0"><?= $announcement['title'] ?></h1>
                </div>
                <div class="card-body">
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0 me-3">
                            <img src="<?= base_url('assets/images/profiles/' . ($instructor['profile_image'] ? $instructor['profile_image'] : 'default.jpg')) ?>" alt="<?= $instructor['name'] ?>" class="rounded-circle" width="60" height="60">
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="h5 mb-0"><?= $instructor['name'] ?></h4>
                            <div class="text-muted d-flex align-items-center">
                                <small class="me-3">Posted on <?= date('F j, Y \a\t g:i a', strtotime($announcement['created_at'])) ?></small>
                                <?php if (isset($announcement['updated_at']) && $announcement['updated_at'] != $announcement['created_at']): ?>
                                    <small class="me-3">(Edited <?= time_elapsed_string($announcement['updated_at']) ?>)</small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="announcement-content mb-4">
                        <?= nl2br(htmlspecialchars($announcement['message'])) ?>
                    </div>
                    
                    <?php if ($this->session->userdata('role') === 'admin' || $course['instructor_id'] == $this->session->userdata('user_id')): ?>
                        <div class="text-end">
                            <a href="<?= base_url('announcement/edit/' . $announcement['id']) ?>" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="<?= base_url('announcement/delete/' . $announcement['id']) ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this announcement?');">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="<?= base_url('announcement/index/' . $course['id']) ?>" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Back to Announcements
                </a>
                <a href="<?= base_url('course/' . $course['slug']) ?>" class="btn btn-primary">
                    Go to Course <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
