<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('course/' . $course['slug']) ?>"><?= $course['title'] ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('discussion/index/' . $course['id']) ?>">Discussions</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('discussion/view/' . $discussion['id']) ?>"><?= $discussion['title'] ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reply</li>
                </ol>
            </nav>
            
            <h1 class="h2 mb-4">Reply to Discussion</h1>
            
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h3 class="h5 mb-0">Original Discussion</h3>
                </div>
                <div class="card-body">
                    <h4 class="h4"><?= $discussion['title'] ?></h4>
                    <p class="mb-0 text-muted small">
                        Started by <?= $discussion['user_name'] ?> 
                        <span class="mx-1">•</span> 
                        <?= time_elapsed_string($discussion['created_at']) ?>
                    </p>
                    <hr>
                    <div class="discussion-content">
                        <?= nl2br(htmlspecialchars($discussion['message'])) ?>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="<?= base_url('discussion/reply/' . $discussion['id']) ?>" method="post">
                        <div class="form-group mb-3">
                            <label for="message" class="form-label">Your Reply</label>
                            <textarea name="message" id="message" rows="8" class="form-control" placeholder="Type your reply here..." required><?= set_value('message') ?></textarea>
                            <?= form_error('message', '<small class="text-danger">', '</small>') ?>
                        </div>
                        
                        <?php if ($course['instructor_id'] == $this->session->userdata('user_id')): ?>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="is_solution" id="is_solution" <?= set_checkbox('is_solution', '1') ?>>
                                <label class="form-check-label" for="is_solution">
                                    Mark as solution
                                </label>
                                <small class="text-muted d-block">Check this if your reply solves the original question.</small>
                            </div>
                        <?php endif; ?>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('discussion/view/' . $discussion['id']) ?>" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Post Reply
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
