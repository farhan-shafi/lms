<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('course/view/' . $course['id']); ?>"><?php echo $course['title']; ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reviews</li>
                </ol>
            </nav>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><?php echo $course['title']; ?> - Reviews</h1>
                <?php if ($user_enrolled && !$user_has_reviewed): ?>
                    <a href="<?php echo base_url('review/create/' . $course['id']); ?>" class="btn btn-primary">
                        <i class="fa fa-star"></i> Write a Review
                    </a>
                <?php endif; ?>
            </div>
            
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
            
            <!-- Rating Summary -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Rating Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <h2 class="display-3"><?php echo number_format($average_rating, 1); ?></h2>
                            <div class="rating-stars mb-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= round($average_rating)): ?>
                                        <i class="fa fa-star text-warning"></i>
                                    <?php elseif ($i - 0.5 <= $average_rating): ?>
                                        <i class="fa fa-star-half-o text-warning"></i>
                                    <?php else: ?>
                                        <i class="fa fa-star-o text-warning"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <p class="text-muted"><?php echo count($reviews); ?> reviews</p>
                        </div>
                        <div class="col-md-8">
                            <div class="rating-bars">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="col-2">
                                            <span><?php echo $i; ?> <i class="fa fa-star text-warning"></i></span>
                                        </div>
                                        <div class="col-8">
                                            <div class="progress" style="height: 10px;">
                                                <?php 
                                                $percentage = (count($reviews) > 0) 
                                                    ? (isset($rating_counts[$i]) ? ($rating_counts[$i] / count($reviews) * 100) : 0) 
                                                    : 0; 
                                                ?>
                                                <div class="progress-bar bg-warning" role="progressbar" 
                                                     style="width: <?php echo $percentage; ?>%" 
                                                     aria-valuenow="<?php echo $percentage; ?>" 
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-2 text-end">
                                            <?php echo isset($rating_counts[$i]) ? $rating_counts[$i] : 0; ?>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Review Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" id="review-search" class="form-control" placeholder="Search reviews...">
                        </div>
                        <div class="col-md-3">
                            <select id="rating-filter" class="form-control">
                                <option value="all">All Ratings</option>
                                <option value="5">5 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="2">2 Stars</option>
                                <option value="1">1 Star</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="sort-filter" class="form-control">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="highest">Highest Rated</option>
                                <option value="lowest">Lowest Rated</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- User's Own Review (if exists) -->
            <?php if ($user_has_reviewed): ?>
                <div class="card border-primary mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Your Review</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="rating-stars me-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= $user_review['rating']): ?>
                                        <i class="fa fa-star text-warning"></i>
                                    <?php else: ?>
                                        <i class="fa fa-star-o text-warning"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <span class="text-muted"><?php echo date('M d, Y', strtotime($user_review['created_at'])); ?></span>
                        </div>
                        <p><?php echo $user_review['review']; ?></p>
                        <div class="d-flex justify-content-end">
                            <a href="<?php echo base_url('review/edit/' . $user_review['id']); ?>" class="btn btn-sm btn-outline-primary me-2">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a href="<?php echo base_url('review/delete/' . $user_review['id']); ?>" class="btn btn-sm btn-outline-danger" 
                               onclick="return confirm('Are you sure you want to delete your review?');">
                                <i class="fa fa-trash"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- All Reviews -->
            <div id="reviews-container">
                <?php if (empty($reviews)): ?>
                    <div class="alert alert-info">
                        No reviews have been submitted yet.
                    </div>
                <?php else: ?>
                    <?php foreach ($reviews as $review): ?>
                        <?php if ($user_has_reviewed && $review['user_id'] == $this->session->userdata('user_id')) continue; // Skip user's own review as it's displayed above ?>
                        <div class="card mb-3 review-item" data-rating="<?php echo $review['rating']; ?>" data-date="<?php echo strtotime($review['created_at']); ?>">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <div>
                                        <h5 class="mb-0"><?php echo $review['user_name']; ?></h5>
                                        <div class="rating-stars">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <?php if ($i <= $review['rating']): ?>
                                                    <i class="fa fa-star text-warning"></i>
                                                <?php else: ?>
                                                    <i class="fa fa-star-o text-warning"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                            <span class="text-muted ms-2"><?php echo date('M d, Y', strtotime($review['created_at'])); ?></span>
                                        </div>
                                    </div>
                                    <div>
                                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                                            <a href="<?php echo base_url('review/delete/' . $review['id']); ?>" class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Are you sure you want to delete this review?');">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="<?php echo base_url('review/report/' . $review['id']); ?>" class="btn btn-sm btn-outline-secondary">
                                                <i class="fa fa-flag"></i> Report
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <p><?php echo $review['review']; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Filter reviews by search term
        $('#review-search').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('.review-item').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        
        // Filter reviews by rating
        $('#rating-filter').on('change', function() {
            var rating = $(this).val();
            if (rating === 'all') {
                $('.review-item').show();
            } else {
                $('.review-item').hide();
                $('.review-item[data-rating="' + rating + '"]').show();
            }
        });
        
        // Sort reviews
        $('#sort-filter').on('change', function() {
            var sortBy = $(this).val();
            var $reviews = $('#reviews-container .review-item');
            
            $reviews.sort(function(a, b) {
                if (sortBy === 'newest') {
                    return $(b).data('date') - $(a).data('date');
                } else if (sortBy === 'oldest') {
                    return $(a).data('date') - $(b).data('date');
                } else if (sortBy === 'highest') {
                    return $(b).data('rating') - $(a).data('rating');
                } else if (sortBy === 'lowest') {
                    return $(a).data('rating') - $(b).data('rating');
                }
            });
            
            $('#reviews-container').append($reviews);
        });
    });
</script>
