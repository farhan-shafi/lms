<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">My Learning Progress</h1>
            
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>
            
            <?php if (empty($progress_data)): ?>
                <div class="alert alert-info">
                    <p>You are not enrolled in any courses yet.</p>
                    <a href="<?php echo base_url('courses'); ?>" class="btn btn-primary">Browse Courses</a>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($progress_data as $course_id => $data): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><?php echo $data['course_title']; ?></h5>
                                    <span class="badge bg-primary"><?php echo $data['progress']['percentage']; ?>% Complete</span>
                                </div>
                                <div class="card-body">
                                    <div class="progress mb-3">
                                        <div class="progress-bar" role="progressbar" style="width: <?php echo $data['progress']['percentage']; ?>%" 
                                             aria-valuenow="<?php echo $data['progress']['percentage']; ?>" aria-valuemin="0" aria-valuemax="100">
                                            <?php echo $data['progress']['percentage']; ?>%
                                        </div>
                                    </div>
                                    <p>
                                        <strong>Completed Items:</strong> 
                                        <?php echo $data['progress']['completed_items']; ?> / <?php echo $data['progress']['total_items']; ?>
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <a href="<?php echo base_url('progress/course/' . $course_id); ?>" class="btn btn-outline-primary">
                                            View Detailed Progress
                                        </a>
                                        <a href="<?php echo base_url('course/view/' . $course_id); ?>" class="btn btn-outline-success">
                                            Continue Learning
                                        </a>
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
    // Add any JavaScript functionality needed
    $(document).ready(function() {
        // Add filter functionality if needed
        $('#course-filter').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('.course-card').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>
