<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('course/' . $course['slug']) ?>"><?= $course['title'] ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Discussions</li>
                </ol>
            </nav>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2">Course Discussions</h1>
                <a href="<?= base_url('discussion/create/' . $course['id']) ?>" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> New Discussion
                </a>
            </div>
            
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <input type="text" class="form-control" id="searchDiscussion" placeholder="Search discussions...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="statusFilter">
                                <option value="all">All Statuses</option>
                                <option value="active">Active</option>
                                <option value="closed">Closed</option>
                                <option value="resolved">Resolved</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="sortOrder">
                                <option value="latest">Latest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="most_replies">Most Replies</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if (empty($discussions)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No discussions found. Be the first to start a discussion!
                </div>
            <?php else: ?>
                <div class="discussions-list">
                    <?php foreach ($discussions as $discussion): ?>
                        <div class="card shadow-sm mb-3 discussion-card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-1 text-center">
                                        <img src="<?= base_url('assets/images/profiles/' . ($discussion['profile_image'] ? $discussion['profile_image'] : 'default.jpg')) ?>" alt="<?= $discussion['user_name'] ?>" class="rounded-circle" width="50" height="50">
                                    </div>
                                    <div class="col-md-8">
                                        <h3 class="h5 mb-1">
                                            <a href="<?= base_url('discussion/view/' . $discussion['id']) ?>" class="text-decoration-none text-dark">
                                                <?= $discussion['title'] ?>
                                            </a>
                                            <?php if ($discussion['status'] === 'closed'): ?>
                                                <span class="badge bg-secondary ms-2">Closed</span>
                                            <?php endif; ?>
                                            <?php if (isset($discussion['has_solution']) && $discussion['has_solution']): ?>
                                                <span class="badge bg-success ms-2">Solved</span>
                                            <?php endif; ?>
                                        </h3>
                                        <p class="mb-0 text-muted small">
                                            Started by <?= $discussion['user_name'] ?> 
                                            <span class="mx-1">•</span> 
                                            <?= time_elapsed_string($discussion['created_at']) ?>
                                        </p>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <div class="d-flex flex-column align-items-end">
                                            <span class="badge bg-primary mb-2"><?= $discussion['reply_count'] ?> <?= $discussion['reply_count'] == 1 ? 'reply' : 'replies' ?></span>
                                            <small class="text-muted">Last activity: <?= time_elapsed_string($discussion['updated_at'] ?? $discussion['created_at']) ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Simple client-side filtering for discussions
    $(document).ready(function() {
        // Search filter
        $("#searchDiscussion").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".discussion-card").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        
        // Status filter
        $("#statusFilter").on("change", function() {
            var value = $(this).val();
            if (value === "all") {
                $(".discussion-card").show();
            } else {
                $(".discussion-card").hide();
                $(".discussion-card").each(function() {
                    if ($(this).find(".badge:contains('" + (value === "resolved" ? "Solved" : (value === "active" ? "" : "Closed")) + "')").length > 0) {
                        $(this).show();
                    }
                });
            }
        });
        
        // TODO: Implement sort order functionality (would require AJAX in a real implementation)
    });
</script>
