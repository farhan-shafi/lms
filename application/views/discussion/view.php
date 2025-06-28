<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('course/' . $course['slug']) ?>"><?= $course['title'] ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('discussion/index/' . $course['id']) ?>">Discussions</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $discussion['title'] ?></li>
                </ol>
            </nav>
            
            <div class="discussion-header mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h1 class="h2"><?= $discussion['title'] ?></h1>
                    
                    <div class="discussion-actions">
                        <?php if ($discussion['status'] === 'active'): ?>
                            <?php if ($discussion['user_id'] == $this->session->userdata('user_id') || 
                                    $course['instructor_id'] == $this->session->userdata('user_id') ||
                                    $this->session->userdata('role') === 'admin'): ?>
                                <a href="<?= base_url('discussion/close/' . $discussion['id']) ?>" class="btn btn-outline-secondary btn-sm" onclick="return confirm('Are you sure you want to close this discussion?');">
                                    <i class="fas fa-times-circle"></i> Close Discussion
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="badge bg-secondary">Closed</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <img src="<?= base_url('assets/images/profiles/' . ($discussion['profile_image'] ? $discussion['profile_image'] : 'default.jpg')) ?>" alt="<?= $discussion['user_name'] ?>" class="rounded-circle" width="60" height="60">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h3 class="h5 mb-0"><?= $discussion['user_name'] ?></h3>
                                        <small class="text-muted">Posted <?= time_elapsed_string($discussion['created_at']) ?></small>
                                    </div>
                                    <div>
                                        <span class="badge bg-info">#1</span>
                                    </div>
                                </div>
                                <div class="discussion-content mt-3">
                                    <?= nl2br(htmlspecialchars($discussion['message'])) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <h3 class="h4 mb-3"><?= count($replies) ?> Replies</h3>
            
            <?php if (!empty($replies)): ?>
                <?php foreach ($replies as $index => $reply): ?>
                    <div class="card shadow-sm mb-3 <?= $reply['is_solution'] ? 'border-success' : '' ?>">
                        <?php if ($reply['is_solution']): ?>
                            <div class="card-header bg-success text-white">
                                <i class="fas fa-check-circle"></i> Marked as Solution
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="<?= base_url('assets/images/profiles/' . ($reply['profile_image'] ? $reply['profile_image'] : 'default.jpg')) ?>" alt="<?= $reply['user_name'] ?>" class="rounded-circle" width="50" height="50">
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <h3 class="h5 mb-0">
                                                <?= $reply['user_name'] ?>
                                                <?php if ($reply['user_role'] === 'instructor'): ?>
                                                    <span class="badge bg-primary ms-2">Instructor</span>
                                                <?php elseif ($reply['user_role'] === 'admin'): ?>
                                                    <span class="badge bg-danger ms-2">Admin</span>
                                                <?php endif; ?>
                                            </h3>
                                            <small class="text-muted">Replied <?= time_elapsed_string($reply['created_at']) ?></small>
                                        </div>
                                        <div>
                                            <span class="badge bg-info">#<?= $index + 2 ?></span>
                                            
                                            <?php if (!$reply['is_solution'] && $discussion['status'] === 'active'): ?>
                                                <?php if ($discussion['user_id'] == $this->session->userdata('user_id') || 
                                                      $course['instructor_id'] == $this->session->userdata('user_id') ||
                                                      $this->session->userdata('role') === 'admin'): ?>
                                                    <a href="<?= base_url('discussion/mark_solution/' . $reply['id'] . '/' . $discussion['id']) ?>" class="btn btn-success btn-sm ms-2" title="Mark as Solution">
                                                        <i class="fas fa-check-circle"></i>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="reply-content mt-3">
                                        <?= nl2br(htmlspecialchars($reply['message'])) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No replies yet. Be the first to reply!
                </div>
            <?php endif; ?>
            
            <?php if ($discussion['status'] === 'active'): ?>
                <div class="reply-form mt-4">
                    <h3 class="h4 mb-3">Add Your Reply</h3>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="<?= base_url('discussion/reply/' . $discussion['id']) ?>" method="post">
                                <div class="form-group mb-3">
                                    <textarea name="message" id="message" rows="5" class="form-control" placeholder="Type your reply here..." required></textarea>
                                </div>
                                
                                <?php if ($course['instructor_id'] == $this->session->userdata('user_id')): ?>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="is_solution" id="is_solution">
                                        <label class="form-check-label" for="is_solution">
                                            Mark as solution
                                        </label>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i> Post Reply
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-warning mt-4">
                    <i class="fas fa-exclamation-circle me-2"></i> This discussion is closed and no longer accepting replies.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
