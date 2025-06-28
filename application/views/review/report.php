<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('course/view/' . $review['course_id']); ?>"><?php echo $course['title']; ?></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('review/index/' . $review['course_id']); ?>">Reviews</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Report Review</li>
                </ol>
            </nav>
            
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Report Review</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <h6 class="mb-1">Review being reported:</h6>
                        <div class="ps-3 pt-2">
                            <div class="d-flex mb-2">
                                <div class="rating-stars me-2">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $review['rating']): ?>
                                            <i class="fa fa-star text-warning"></i>
                                        <?php else: ?>
                                            <i class="fa fa-star-o text-warning"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <span>by <?php echo $user['username']; ?></span>
                            </div>
                            <p class="mb-0"><?php echo $review['review']; ?></p>
                        </div>
                    </div>
                    
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php echo form_open('review/report/' . $review['id']); ?>
                        <div class="form-group mb-4">
                            <label for="reason">Reason for Report</label>
                            <select name="reason" id="reason" class="form-control">
                                <option value="">-- Select a reason --</option>
                                <option value="Offensive content">Offensive content</option>
                                <option value="Spam or misleading">Spam or misleading</option>
                                <option value="Not related to course">Not related to course</option>
                                <option value="Other">Other (please specify below)</option>
                            </select>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="additional_comments">Additional Comments</label>
                            <textarea name="additional_comments" id="additional_comments" class="form-control" rows="4" placeholder="Please provide more details about your report..."></textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo base_url('review/index/' . $review['course_id']); ?>" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger">Submit Report</button>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Form validation
        $('form').on('submit', function(e) {
            if ($('#reason').val() === '') {
                e.preventDefault();
                alert('Please select a reason for your report');
                return false;
            }
            
            if ($('#reason').val() === 'Other' && $('#additional_comments').val().trim() === '') {
                e.preventDefault();
                alert('Please provide details for your report');
                return false;
            }
        });
        
        // Show/hide additional comments field based on reason
        $('#reason').on('change', function() {
            if ($(this).val() === 'Other') {
                $('#additional_comments').closest('.form-group').show();
                $('#additional_comments').attr('required', true);
            } else {
                $('#additional_comments').closest('.form-group').show();
                $('#additional_comments').attr('required', false);
            }
        });
    });
</script>
