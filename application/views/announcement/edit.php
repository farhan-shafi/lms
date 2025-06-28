<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('course/' . $course['slug']) ?>"><?= $course['title'] ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('announcement/index/' . $course['id']) ?>">Announcements</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Announcement</li>
                </ol>
            </nav>
            
            <h1 class="h2 mb-4">Edit Announcement</h1>
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="<?= base_url('announcement/edit/' . $announcement['id']) ?>" method="post">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Announcement Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter announcement title" value="<?= set_value('title', $announcement['title']) ?>" required>
                            <?= form_error('title', '<small class="text-danger">', '</small>') ?>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea name="message" id="message" rows="10" class="form-control" placeholder="Enter announcement message..." required><?= set_value('message', $announcement['message']) ?></textarea>
                            <?= form_error('message', '<small class="text-danger">', '</small>') ?>
                        </div>
                        
                        <div class="alert alert-warning">
                            <h5><i class="fas fa-exclamation-triangle me-2"></i> Edit Notice</h5>
                            <p class="mb-0">Students will see that this announcement has been edited. Please ensure your changes maintain the original intent of the announcement to avoid confusion.</p>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('announcement/view/' . $announcement['id']) ?>" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Announcement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
