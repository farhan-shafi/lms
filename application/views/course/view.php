<!-- filepath: /Applications/XAMPP/xamppfiles/htdocs/lms/application/views/course/view.php -->
<div class="course-detail-container">
    <div class="course-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="course-title"><?= $course['title'] ?></h1>
                    <div class="course-meta">
                        <span><i class="fas fa-user"></i> <?= $instructor['name'] ?></span>
                        <span><i class="fas fa-folder"></i> <?= $category['name'] ?></span>
                        <span><i class="fas fa-users"></i> <?= $course['enrollment_count'] ?> students</span>
                        <span><i class="fas fa-calendar"></i> Last updated: <?= date('M d, Y', strtotime($course['updated_at'])) ?></span>
                    </div>
                    <div class="course-rating">
                        <?php for($i=1; $i<=5; $i++): ?>
                            <?php if($i <= $course['rating']): ?>
                                <i class="fas fa-star"></i>
                            <?php elseif($i-0.5 <= $course['rating']): ?>
                                <i class="fas fa-star-half-alt"></i>
                            <?php else: ?>
                                <i class="far fa-star"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <span>(<?= $course['rating_count'] ?> ratings)</span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="course-sidebar">
                        <div class="course-image">
                            <?php if(!empty($course['image'])): ?>
                                <img src="<?= base_url('uploads/courses/'.$course['image']) ?>" alt="<?= $course['title'] ?>">
                            <?php else: ?>
                                <img src="<?= base_url('assets/images/course-placeholder.jpg') ?>" alt="<?= $course['title'] ?>">
                            <?php endif; ?>
                        </div>
                        <div class="course-price">
                            <?php if($course['price'] == 0): ?>
                                <span class="free-price">Free</span>
                            <?php else: ?>
                                <span class="regular-price"><?= $this->settings_model->get_currency_symbol() . number_format($course['price'], 2) ?></span>
                                <?php if($course['discount_price'] > 0): ?>
                                    <span class="discount-price"><?= $this->settings_model->get_currency_symbol() . number_format($course['discount_price'], 2) ?></span>
                                    <span class="discount-percentage"><?= round((($course['price'] - $course['discount_price']) / $course['price']) * 100) ?>% OFF</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="course-actions">
                            <?php if($is_enrolled): ?>
                                <a href="<?= site_url('course/learn/'.$course['slug']) ?>" class="btn btn-primary btn-block"><i class="fas fa-play-circle"></i> Continue Learning</a>
                            <?php else: ?>
                                <?php if($course['price'] == 0): ?>
                                    <a href="<?= site_url('course/enroll/'.$course['slug']) ?>" class="btn btn-success btn-block"><i class="fas fa-check-circle"></i> Enroll Now (Free)</a>
                                <?php else: ?>
                                    <a href="<?= site_url('payment/checkout/'.$course['slug']) ?>" class="btn btn-primary btn-block"><i class="fas fa-shopping-cart"></i> Buy Now</a>
                                    <a href="<?= site_url('cart/add/'.$course['slug']) ?>" class="btn btn-outline-primary btn-block"><i class="fas fa-cart-plus"></i> Add to Cart</a>
                                <?php endif; ?>
                                <?php if($course['has_preview']): ?>
                                    <a href="<?= site_url('course/preview/'.$course['slug']) ?>" class="btn btn-outline-secondary btn-block"><i class="fas fa-eye"></i> Preview Course</a>
                                <?php endif; ?>
                            <?php endif; ?>
                            <button class="btn btn-outline-danger btn-block wishlist-btn" data-course="<?= $course['id'] ?>">
                                <i class="<?= $in_wishlist ? 'fas' : 'far' ?> fa-heart"></i> 
                                <span><?= $in_wishlist ? 'Remove from Wishlist' : 'Add to Wishlist' ?></span>
                            </button>
                        </div>
                        <div class="course-includes">
                            <h5>This course includes:</h5>
                            <ul>
                                <li><i class="fas fa-play-circle"></i> <?= $course['total_duration'] ?> of video content</li>
                                <li><i class="fas fa-file"></i> <?= $course['resource_count'] ?> downloadable resources</li>
                                <li><i class="fas fa-puzzle-piece"></i> <?= $course['quiz_count'] ?> quizzes</li>
                                <li><i class="fas fa-certificate"></i> Certificate of completion</li>
                                <li><i class="fas fa-infinity"></i> Full lifetime access</li>
                                <li><i class="fas fa-mobile-alt"></i> Access on mobile and TV</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="course-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <ul class="nav nav-tabs" id="courseTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="curriculum-tab" data-toggle="tab" href="#curriculum" role="tab" aria-controls="curriculum" aria-selected="false">Curriculum</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="instructor-tab" data-toggle="tab" href="#instructor" role="tab" aria-controls="instructor" aria-selected="false">Instructor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="courseTabContent">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                            <div class="course-description">
                                <h3>About this course</h3>
                                <?= $course['description'] ?>
                            </div>
                            
                            <div class="course-objectives">
                                <h3>What you'll learn</h3>
                                <ul class="objectives-list">
                                    <?php foreach(json_decode($course['objectives'], true) as $objective): ?>
                                    <li><i class="fas fa-check"></i> <?= $objective ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            
                            <div class="course-requirements">
                                <h3>Requirements</h3>
                                <ul>
                                    <?php foreach(json_decode($course['requirements'], true) as $requirement): ?>
                                    <li><i class="fas fa-circle"></i> <?= $requirement ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            
                            <div class="target-audience">
                                <h3>Who this course is for</h3>
                                <p><?= $course['target_audience'] ?></p>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="curriculum" role="tabpanel" aria-labelledby="curriculum-tab">
                            <div class="course-curriculum">
                                <div class="curriculum-info">
                                    <span><?= count($modules) ?> modules</span>
                                    <span><?= $course['lesson_count'] ?> lessons</span>
                                    <span>Total: <?= $course['total_duration'] ?></span>
                                </div>
                                
                                <div class="accordion" id="accordionCurriculum">
                                    <?php foreach ($modules as $index => $module): ?>
                                    <div class="card">
                                        <div class="card-header" id="heading<?= $module['id'] ?>">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse<?= $module['id'] ?>" aria-expanded="<?= ($index == 0) ? 'true' : 'false' ?>" aria-controls="collapse<?= $module['id'] ?>">
                                                    <i class="fas fa-chevron-down"></i>
                                                    <?= $module['title'] ?>
                                                    <span class="module-lessons-count"><?= count($module['lessons']) ?> lessons</span>
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="collapse<?= $module['id'] ?>" class="collapse <?= ($index == 0) ? 'show' : '' ?>" aria-labelledby="heading<?= $module['id'] ?>" data-parent="#accordionCurriculum">
                                            <div class="card-body">
                                                <ul class="curriculum-list">
                                                    <?php foreach ($module['lessons'] as $lesson): ?>
                                                    <li class="curriculum-lesson">
                                                        <div class="lesson-info">
                                                            <span class="lesson-icon">
                                                                <?php if($lesson['type'] == 'video'): ?>
                                                                    <i class="fas fa-play-circle"></i>
                                                                <?php elseif($lesson['type'] == 'quiz'): ?>
                                                                    <i class="fas fa-question-circle"></i>
                                                                <?php else: ?>
                                                                    <i class="fas fa-file-alt"></i>
                                                                <?php endif; ?>
                                                            </span>
                                                            <span class="lesson-title"><?= $lesson['title'] ?></span>
                                                        </div>
                                                        <div class="lesson-meta">
                                                            <?php if($lesson['is_preview']): ?>
                                                                <span class="preview-badge">Preview</span>
                                                            <?php endif; ?>
                                                            <?php if($lesson['type'] == 'video'): ?>
                                                                <span class="lesson-duration"><?= $lesson['duration'] ?></span>
                                                            <?php elseif($lesson['type'] == 'quiz'): ?>
                                                                <span class="lesson-duration"><?= $lesson['question_count'] ?> questions</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="instructor" role="tabpanel" aria-labelledby="instructor-tab">
                            <div class="instructor-profile">
                                <div class="instructor-header">
                                    <div class="instructor-avatar">
                                        <?php if(!empty($instructor['avatar'])): ?>
                                            <img src="<?= base_url('uploads/avatars/'.$instructor['avatar']) ?>" alt="<?= $instructor['name'] ?>">
                                        <?php else: ?>
                                            <img src="<?= base_url('assets/images/default-avatar.jpg') ?>" alt="<?= $instructor['name'] ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div class="instructor-info">
                                        <h3 class="instructor-name"><?= $instructor['name'] ?></h3>
                                        <p class="instructor-title"><?= $instructor['title'] ?></p>
                                        <div class="instructor-stats">
                                            <span><i class="fas fa-star"></i> <?= $instructor['rating'] ?> Average Rating</span>
                                            <span><i class="fas fa-comment"></i> <?= $instructor['review_count'] ?> Reviews</span>
                                            <span><i class="fas fa-users"></i> <?= $instructor['student_count'] ?> Students</span>
                                            <span><i class="fas fa-play"></i> <?= $instructor['course_count'] ?> Courses</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="instructor-bio">
                                    <h4>About the instructor</h4>
                                    <?= $instructor['biography'] ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <div class="course-reviews">
                                <div class="reviews-summary">
                                    <div class="average-rating">
                                        <div class="rating-number"><?= number_format($course['rating'], 1) ?></div>
                                        <div class="rating-stars">
                                            <?php for($i=1; $i<=5; $i++): ?>
                                                <?php if($i <= $course['rating']): ?>
                                                    <i class="fas fa-star"></i>
                                                <?php elseif($i-0.5 <= $course['rating']): ?>
                                                    <i class="fas fa-star-half-alt"></i>
                                                <?php else: ?>
                                                    <i class="far fa-star"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </div>
                                        <div class="rating-count"><?= $course['rating_count'] ?> ratings</div>
                                    </div>
                                    <div class="rating-breakdown">
                                        <?php foreach(array_reverse($rating_breakdown) as $stars => $percentage): ?>
                                        <div class="rating-progress">
                                            <span class="rating-stars"><?= $stars ?> stars</span>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: <?= $percentage ?>%" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="rating-percent"><?= $percentage ?>%</span>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                
                                <div class="reviews-list">
                                    <?php if(empty($reviews)): ?>
                                        <div class="no-reviews">
                                            <p>This course doesn't have any reviews yet.</p>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach($reviews as $review): ?>
                                        <div class="review-item">
                                            <div class="review-header">
                                                <div class="reviewer-avatar">
                                                    <?php if(!empty($review['avatar'])): ?>
                                                        <img src="<?= base_url('uploads/avatars/'.$review['avatar']) ?>" alt="<?= $review['name'] ?>">
                                                    <?php else: ?>
                                                        <img src="<?= base_url('assets/images/default-avatar.jpg') ?>" alt="<?= $review['name'] ?>">
                                                    <?php endif; ?>
                                                </div>
                                                <div class="reviewer-info">
                                                    <h5 class="reviewer-name"><?= $review['name'] ?></h5>
                                                    <div class="review-date"><?= date('M d, Y', strtotime($review['created_at'])) ?></div>
                                                </div>
                                                <div class="review-rating">
                                                    <?php for($i=1; $i<=5; $i++): ?>
                                                        <?php if($i <= $review['rating']): ?>
                                                            <i class="fas fa-star"></i>
                                                        <?php else: ?>
                                                            <i class="far fa-star"></i>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>
                                            <div class="review-content">
                                                <?= $review['comment'] ?>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                        
                                        <?php if($total_reviews > count($reviews)): ?>
                                        <div class="load-more-reviews">
                                            <button class="btn btn-outline-primary" id="loadMoreReviews" data-course="<?= $course['id'] ?>" data-offset="<?= count($reviews) ?>">Load More Reviews</button>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if($is_enrolled && !$has_reviewed): ?>
                                <div class="add-review">
                                    <h4>Write a Review</h4>
                                    <form id="reviewForm" action="<?= site_url('course/add_review') ?>" method="post">
                                        <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                        <div class="form-group">
                                            <label>Your Rating</label>
                                            <div class="rating-selector">
                                                <input type="radio" id="star5" name="rating" value="5" /><label for="star5"><i class="far fa-star"></i></label>
                                                <input type="radio" id="star4" name="rating" value="4" /><label for="star4"><i class="far fa-star"></i></label>
                                                <input type="radio" id="star3" name="rating" value="3" /><label for="star3"><i class="far fa-star"></i></label>
                                                <input type="radio" id="star2" name="rating" value="2" /><label for="star2"><i class="far fa-star"></i></label>
                                                <input type="radio" id="star1" name="rating" value="1" /><label for="star1"><i class="far fa-star"></i></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="reviewComment">Your Review</label>
                                            <textarea class="form-control" id="reviewComment" name="comment" rows="4" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit Review</button>
                                    </form>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="related-courses">
                        <h3>Related Courses</h3>
                        <?php if(!empty($related_courses)): ?>
                            <?php foreach($related_courses as $related): ?>
                            <div class="related-course-item">
                                <a href="<?= site_url('course/view/'.$related['slug']) ?>">
                                    <div class="related-course-image">
                                        <?php if(!empty($related['image'])): ?>
                                            <img src="<?= base_url('uploads/courses/'.$related['image']) ?>" alt="<?= $related['title'] ?>">
                                        <?php else: ?>
                                            <img src="<?= base_url('assets/images/course-placeholder.jpg') ?>" alt="<?= $related['title'] ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div class="related-course-info">
                                        <h5 class="related-course-title"><?= $related['title'] ?></h5>
                                        <div class="related-course-instructor"><?= $related['instructor_name'] ?></div>
                                        <div class="related-course-meta">
                                            <span class="related-course-rating">
                                                <i class="fas fa-star"></i> <?= number_format($related['rating'], 1) ?>
                                            </span>
                                            <span class="related-course-price">
                                                <?php if($related['price'] == 0): ?>
                                                    <span class="free">Free</span>
                                                <?php else: ?>
                                                    <?= $this->settings_model->get_currency_symbol() . number_format($related['price'], 2) ?>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No related courses found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Toggle wishlist status
        $('.wishlist-btn').click(function() {
            var courseId = $(this).data('course');
            var $btn = $(this);
            
            $.ajax({
                url: '<?= site_url('course/toggle_wishlist') ?>',
                type: 'POST',
                data: {course_id: courseId},
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        if(response.added) {
                            $btn.find('i').removeClass('far').addClass('fas');
                            $btn.find('span').text('Remove from Wishlist');
                        } else {
                            $btn.find('i').removeClass('fas').addClass('far');
                            $btn.find('span').text('Add to Wishlist');
                        }
                    }
                }
            });
        });
        
        // Rating selector behavior
        $('.rating-selector label').hover(
            function() {
                $(this).prevAll().addBack().find('i').addClass('fas').removeClass('far');
                $(this).nextAll().find('i').addClass('far').removeClass('fas');
            },
            function() {
                var $checked = $('input[name="rating"]:checked');
                if ($checked.length) {
                    var checkedVal = parseInt($checked.val());
                    $('.rating-selector label').each(function(index) {
                        if (5-index <= checkedVal) {
                            $(this).find('i').addClass('fas').removeClass('far');
                        } else {
                            $(this).find('i').addClass('far').removeClass('fas');
                        }
                    });
                } else {
                    $('.rating-selector label i').addClass('far').removeClass('fas');
                }
            }
        );
        
        $('.rating-selector input').change(function() {
            var val = parseInt($(this).val());
            $('.rating-selector label').each(function(index) {
                if (5-index <= val) {
                    $(this).find('i').addClass('fas').removeClass('far');
                } else {
                    $(this).find('i').addClass('far').removeClass('fas');
                }
            });
        });
        
        // Load more reviews
        $('#loadMoreReviews').click(function() {
            var $btn = $(this);
            var courseId = $btn.data('course');
            var offset = $btn.data('offset');
            
            $.ajax({
                url: '<?= site_url('course/load_more_reviews') ?>',
                type: 'GET',
                data: {course_id: courseId, offset: offset},
                dataType: 'json',
                beforeSend: function() {
                    $btn.text('Loading...').prop('disabled', true);
                },
                success: function(response) {
                    if(response.reviews.length > 0) {
                        var reviewsHtml = '';
                        $.each(response.reviews, function(index, review) {
                            reviewsHtml += '<div class="review-item">';
                            reviewsHtml += '<div class="review-header">';
                            reviewsHtml += '<div class="reviewer-avatar">';
                            if(review.avatar) {
                                reviewsHtml += '<img src="<?= base_url('uploads/avatars/') ?>' + review.avatar + '" alt="' + review.name + '">';
                            } else {
                                reviewsHtml += '<img src="<?= base_url('assets/images/default-avatar.jpg') ?>" alt="' + review.name + '">';
                            }
                            reviewsHtml += '</div>';
                            reviewsHtml += '<div class="reviewer-info">';
                            reviewsHtml += '<h5 class="reviewer-name">' + review.name + '</h5>';
                            reviewsHtml += '<div class="review-date">' + review.date + '</div>';
                            reviewsHtml += '</div>';
                            reviewsHtml += '<div class="review-rating">';
                            for(var i=1; i<=5; i++) {
                                if(i <= review.rating) {
                                    reviewsHtml += '<i class="fas fa-star"></i>';
                                } else {
                                    reviewsHtml += '<i class="far fa-star"></i>';
                                }
                            }
                            reviewsHtml += '</div>';
                            reviewsHtml += '</div>';
                            reviewsHtml += '<div class="review-content">' + review.comment + '</div>';
                            reviewsHtml += '</div>';
                        });
                        
                        $('.reviews-list .review-item:last').after(reviewsHtml);
                        $btn.data('offset', offset + response.reviews.length);
                        
                        if(response.has_more) {
                            $btn.text('Load More Reviews').prop('disabled', false);
                        } else {
                            $btn.parent('.load-more-reviews').remove();
                        }
                    }
                },
                error: function() {
                    $btn.text('Load More Reviews').prop('disabled', false);
                }
            });
        });
    });
</script>
