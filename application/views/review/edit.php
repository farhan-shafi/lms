<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('course/view/' . $course['id']); ?>"><?php echo $course['title']; ?></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('review/index/' . $course['id']); ?>">Reviews</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Review</li>
                </ol>
            </nav>
            
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Edit Your Review for <?php echo $course['title']; ?></h4>
                </div>
                <div class="card-body">
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php echo form_open('review/edit/' . $review['id']); ?>
                        <div class="form-group mb-4">
                            <label for="rating">Rating</label>
                            <div class="star-rating">
                                <div class="rating-container">
                                    <input type="radio" name="rating" value="5" id="star5" <?php echo ($review['rating'] == 5) ? 'checked' : ''; ?>><label for="star5"></label>
                                    <input type="radio" name="rating" value="4" id="star4" <?php echo ($review['rating'] == 4) ? 'checked' : ''; ?>><label for="star4"></label>
                                    <input type="radio" name="rating" value="3" id="star3" <?php echo ($review['rating'] == 3) ? 'checked' : ''; ?>><label for="star3"></label>
                                    <input type="radio" name="rating" value="2" id="star2" <?php echo ($review['rating'] == 2) ? 'checked' : ''; ?>><label for="star2"></label>
                                    <input type="radio" name="rating" value="1" id="star1" <?php echo ($review['rating'] == 1) ? 'checked' : ''; ?>><label for="star1"></label>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span id="rating-text">
                                    <?php 
                                    switch($review['rating']) {
                                        case 5: echo 'Excellent! Highly recommend'; break;
                                        case 4: echo 'Very Good'; break;
                                        case 3: echo 'Good'; break;
                                        case 2: echo 'Fair'; break;
                                        case 1: echo 'Poor'; break;
                                        default: echo 'Select a rating';
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="review">Your Review</label>
                            <textarea name="review" id="review" class="form-control" rows="6" placeholder="Share your experience with this course..."><?php echo $review['review']; ?></textarea>
                            <div class="form-text text-muted">
                                Your review will help other students make informed decisions.
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo base_url('review/index/' . $course['id']); ?>" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Review</button>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Star Rating CSS */
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    font-size: 1.5em;
    justify-content: space-around;
    padding: 0 0.2em;
    text-align: center;
    width: 5em;
}

.star-rating input {
    display: none;
}

.star-rating label {
    color: #ccc;
    cursor: pointer;
}

.star-rating :checked ~ label {
    color: #f90;
}

.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #fc0;
}

.rating-container {
    display: flex;
    flex-direction: row-reverse;
}
</style>

<script>
    $(document).ready(function() {
        // Star rating functionality
        $('.star-rating input').on('change', function() {
            var ratingValue = $(this).val();
            var ratingText = '';
            
            switch(ratingValue) {
                case '5':
                    ratingText = 'Excellent! Highly recommend';
                    break;
                case '4':
                    ratingText = 'Very Good';
                    break;
                case '3':
                    ratingText = 'Good';
                    break;
                case '2':
                    ratingText = 'Fair';
                    break;
                case '1':
                    ratingText = 'Poor';
                    break;
                default:
                    ratingText = 'Select a rating';
            }
            
            $('#rating-text').text(ratingText);
        });
        
        // Form validation
        $('form').on('submit', function(e) {
            if (!$('input[name="rating"]:checked').val()) {
                e.preventDefault();
                alert('Please select a rating');
                return false;
            }
            
            if ($('#review').val().trim() === '') {
                e.preventDefault();
                alert('Please write a review');
                return false;
            }
        });
    });
</script>
