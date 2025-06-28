<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('course/' . $course['slug']) ?>"><?= $course['title'] ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('announcement/index/' . $course['id']) ?>">Announcements</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Announcement</li>
                </ol>
            </nav>
            
            <h1 class="h2 mb-4">Create New Announcement</h1>
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="<?= base_url('announcement/create/' . $course['id']) ?>" method="post">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Announcement Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter announcement title" value="<?= set_value('title') ?>" required>
                            <?= form_error('title', '<small class="text-danger">', '</small>') ?>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea name="message" id="message" rows="10" class="form-control" placeholder="Enter announcement message..." required><?= set_value('message') ?></textarea>
                            <?= form_error('message', '<small class="text-danger">', '</small>') ?>
                        </div>
                        
                        <div class="alert alert-info">
                            <h5><i class="fas fa-info-circle me-2"></i> Announcement Tips</h5>
                            <ul class="mb-0">
                                <li>Be clear and concise in your title</li>
                                <li>Include all relevant details in your message</li>
                                <li>Use paragraphs to organize longer announcements</li>
                                <li>If you're sharing resources, include links or instructions</li>
                            </ul>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('announcement/index/' . $course['id']) ?>" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-bullhorn"></i> Publish Announcement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
