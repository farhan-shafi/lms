<!-- Course Creation View -->
<div class="course-creation">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header">
                    <h1 class="page-title">Create New Course</h1>
                    <p class="page-subtitle">Fill in the details below to create your new course</p>
                </div>
            </div>
        </div>
        
        <!-- Course Creation Form -->
        <div class="row">
            <div class="col-lg-8">
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>
                
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>
                
                <form action="<?= site_url('instructor/courses/save') ?>" method="post" enctype="multipart/form-data" id="courseForm">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title">Basic Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Course Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" required>
                                <div class="form-text text-muted">Choose a clear and concise title that accurately describes your course.</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="subtitle">Course Subtitle</label>
                                <input type="text" class="form-control" id="subtitle" name="subtitle">
                                <div class="form-text text-muted">A brief description that appears below your course title.</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="description">Course Description <span class="text-danger">*</span></label>
                                <textarea class="form-control rich-editor" id="description" name="description" rows="8" required></textarea>
                                <div class="form-text text-muted">Provide a detailed description of your course content, what students will learn, and the benefits they'll gain.</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="category_id">Category <span class="text-danger">*</span></label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="">Select a category</option>
                                    <?php foreach($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="language">Language <span class="text-danger">*</span></label>
                                <select class="form-control" id="language" name="language" required>
                                    <option value="">Select a language</option>
                                    <option value="English">English</option>
                                    <option value="Spanish">Spanish</option>
                                    <option value="French">French</option>
                                    <option value="German">German</option>
                                    <option value="Italian">Italian</option>
                                    <option value="Portuguese">Portuguese</option>
                                    <option value="Russian">Russian</option>
                                    <option value="Chinese">Chinese</option>
                                    <option value="Japanese">Japanese</option>
                                    <option value="Arabic">Arabic</option>
                                    <option value="Hindi">Hindi</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="level">Course Level <span class="text-danger">*</span></label>
                                <select class="form-control" id="level" name="level" required>
                                    <option value="">Select a level</option>
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                    <option value="all-levels">All Levels</option>
                                </select>
                                <div class="form-text text-muted">Select the appropriate level for your target audience.</div>
                            </div>
                            
                            <div class="form-group">
                                <label>Course Image <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image" accept="image/*" required>
                                    <label class="custom-file-label" for="image">Choose file...</label>
                                </div>
                                <div class="form-text text-muted">Upload a high-quality image (16:9 ratio recommended, minimum 1280x720 pixels).</div>
                                <div class="image-preview mt-3" id="imagePreview"></div>
                            </div>
                            
                            <div class="form-group">
                                <label>Promotional Video (Optional)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="promo_video" name="promo_video" accept="video/*">
                                    <label class="custom-file-label" for="promo_video">Choose file...</label>
                                </div>
                                <div class="form-text text-muted">Upload a short promotional video (max 2 minutes, MP4 format recommended).</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title">Course Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>What will students learn in your course? <span class="text-danger">*</span></label>
                                <div class="learning-objectives">
                                    <div class="objective-item input-group mb-2">
                                        <input type="text" class="form-control" name="objectives[]" placeholder="e.g., Build a complete web application from scratch" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-danger remove-objective"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="objective-item input-group mb-2">
                                        <input type="text" class="form-control" name="objectives[]" placeholder="e.g., Master advanced JavaScript concepts">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-danger remove-objective"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary add-objective"><i class="fas fa-plus"></i> Add Learning Objective</button>
                            </div>
                            
                            <div class="form-group">
                                <label>Requirements/Prerequisites <span class="text-danger">*</span></label>
                                <div class="requirements">
                                    <div class="requirement-item input-group mb-2">
                                        <input type="text" class="form-control" name="requirements[]" placeholder="e.g., Basic knowledge of HTML, CSS, and JavaScript" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-danger remove-requirement"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary add-requirement"><i class="fas fa-plus"></i> Add Requirement</button>
                            </div>
                            
                            <div class="form-group">
                                <label for="target_audience">Who is this course for? <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="target_audience" name="target_audience" rows="3" required placeholder="Describe your target audience"></textarea>
                                <div class="form-text text-muted">Specify who would benefit most from taking your course.</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title">Pricing</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="price_type">Price Type <span class="text-danger">*</span></label>
                                <select class="form-control" id="price_type" name="price_type" required>
                                    <option value="free">Free</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </div>
                            
                            <div class="paid-options" style="display: none;">
                                <div class="form-group">
                                    <label for="price">Regular Price (<?= $currency_symbol ?>) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="price" name="price" min="0" step="0.01">
                                    <div class="form-text text-muted">Set your course price. You will receive <?= $instructor_revenue_percentage ?>% of the revenue after platform fees.</div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="has_discount">Offer Discount</label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="has_discount" name="has_discount">
                                        <label class="custom-control-label" for="has_discount">Enable discount price</label>
                                    </div>
                                </div>
                                
                                <div class="discount-options" style="display: none;">
                                    <div class="form-group">
                                        <label for="discount_price">Discount Price (<?= $currency_symbol ?>)</label>
                                        <input type="number" class="form-control" id="discount_price" name="discount_price" min="0" step="0.01">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="discount_start_date">Discount Start Date</label>
                                        <input type="date" class="form-control" id="discount_start_date" name="discount_start_date">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="discount_end_date">Discount End Date</label>
                                        <input type="date" class="form-control" id="discount_end_date" name="discount_end_date">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-lg" name="save_type" value="draft">Save as Draft</button>
                        <button type="submit" class="btn btn-success btn-lg" name="save_type" value="submit">Submit for Review</button>
                        <a href="<?= site_url('instructor/courses') ?>" class="btn btn-outline-secondary btn-lg">Cancel</a>
                    </div>
                </form>
            </div>
            
            <div class="col-lg-4">
                <div class="card mb-4 guidelines-card">
                    <div class="card-header">
                        <h4 class="card-title">Course Guidelines</h4>
                    </div>
                    <div class="card-body">
                        <div class="guideline-item">
                            <h5><i class="fas fa-check-circle text-success"></i> Quality Standards</h5>
                            <p>Ensure your course meets our quality standards:</p>
                            <ul>
                                <li>Clear audio and video</li>
                                <li>Comprehensive content coverage</li>
                                <li>Practical exercises and examples</li>
                                <li>Regular updates and maintenance</li>
                            </ul>
                        </div>
                        <div class="guideline-item">
                            <h5><i class="fas fa-lightbulb text-warning"></i> Tips for Success</h5>
                            <ul>
                                <li>Focus on delivering practical value</li>
                                <li>Include engaging assignments and quizzes</li>
                                <li>Structure your content logically</li>
                                <li>Create a compelling course description</li>
                                <li>Respond promptly to student questions</li>
                            </ul>
                        </div>
                        <div class="guideline-item">
                            <h5><i class="fas fa-info-circle text-info"></i> Review Process</h5>
                            <p>After submission, your course will go through a review process to ensure it meets our standards. This typically takes 2-3 business days.</p>
                        </div>
                        <div class="guideline-item">
                            <h5><i class="fas fa-question-circle text-primary"></i> Need Help?</h5>
                            <p>Check out our <a href="<?= site_url('instructor/resources') ?>">Instructor Resources</a> or <a href="<?= site_url('contact') ?>">Contact Support</a> if you have questions.</p>
                        </div>
                    </div>
                </div>
                
                <div class="card revenue-calculator">
                    <div class="card-header">
                        <h4 class="card-title">Revenue Calculator</h4>
                    </div>
                    <div class="card-body">
                        <div class="calculator-input">
                            <label for="calc_price">Course Price (<?= $currency_symbol ?>)</label>
                            <input type="number" class="form-control" id="calc_price" min="0" step="0.01" value="0">
                        </div>
                        <div class="calculator-input">
                            <label for="calc_students">Estimated Students</label>
                            <input type="number" class="form-control" id="calc_students" min="0" step="1" value="100">
                        </div>
                        <div class="calculator-results">
                            <div class="result-item">
                                <div class="result-label">Platform Fee (<?= 100 - $instructor_revenue_percentage ?>%)</div>
                                <div class="result-value" id="platformFee"><?= $currency_symbol ?>0.00</div>
                            </div>
                            <div class="result-item">
                                <div class="result-label">Your Revenue (<?= $instructor_revenue_percentage ?>%)</div>
                                <div class="result-value" id="instructorRevenue"><?= $currency_symbol ?>0.00</div>
                            </div>
                            <div class="result-item total">
                                <div class="result-label">Potential Earnings</div>
                                <div class="result-value" id="potentialEarnings"><?= $currency_symbol ?>0.00</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize rich text editor
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '.rich-editor',
            height: 300,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 16px; }'
        });
    }
    
    // Custom file input
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
        
        // Preview image if selected
        if(this.id === 'image') {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').html('<img src="' + e.target.result + '" class="img-fluid">');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Toggle paid options
    $('#price_type').change(function() {
        if($(this).val() === 'paid') {
            $('.paid-options').slideDown();
            $('#price').attr('required', true);
        } else {
            $('.paid-options').slideUp();
            $('#price').attr('required', false);
        }
    });
    
    // Toggle discount options
    $('#has_discount').change(function() {
        if($(this).is(':checked')) {
            $('.discount-options').slideDown();
            $('#discount_price').attr('required', true);
        } else {
            $('.discount-options').slideUp();
            $('#discount_price').attr('required', false);
        }
    });
    
    // Add learning objective
    $('.add-objective').click(function() {
        var newObjective = '<div class="objective-item input-group mb-2">' +
                          '<input type="text" class="form-control" name="objectives[]" placeholder="e.g., Master a new skill">' +
                          '<div class="input-group-append">' +
                          '<button type="button" class="btn btn-outline-danger remove-objective"><i class="fas fa-times"></i></button>' +
                          '</div></div>';
        $('.learning-objectives').append(newObjective);
    });
    
    // Remove learning objective
    $(document).on('click', '.remove-objective', function() {
        if($('.objective-item').length > 1) {
            $(this).closest('.objective-item').remove();
        } else {
            alert('You need at least one learning objective.');
        }
    });
    
    // Add requirement
    $('.add-requirement').click(function() {
        var newRequirement = '<div class="requirement-item input-group mb-2">' +
                            '<input type="text" class="form-control" name="requirements[]" placeholder="e.g., Basic knowledge of a topic">' +
                            '<div class="input-group-append">' +
                            '<button type="button" class="btn btn-outline-danger remove-requirement"><i class="fas fa-times"></i></button>' +
                            '</div></div>';
        $('.requirements').append(newRequirement);
    });
    
    // Remove requirement
    $(document).on('click', '.remove-requirement', function() {
        if($('.requirement-item').length > 1) {
            $(this).closest('.requirement-item').remove();
        } else {
            alert('You need at least one requirement.');
        }
    });
    
    // Revenue calculator
    function updateCalculator() {
        var price = parseFloat($('#calc_price').val()) || 0;
        var students = parseInt($('#calc_students').val()) || 0;
        var totalRevenue = price * students;
        var platformFee = totalRevenue * (<?= 100 - $instructor_revenue_percentage ?> / 100);
        var instructorRevenue = totalRevenue * (<?= $instructor_revenue_percentage ?> / 100);
        
        $('#platformFee').text('<?= $currency_symbol ?>' + platformFee.toFixed(2));
        $('#instructorRevenue').text('<?= $currency_symbol ?>' + instructorRevenue.toFixed(2));
        $('#potentialEarnings').text('<?= $currency_symbol ?>' + instructorRevenue.toFixed(2));
    }
    
    $('#calc_price, #calc_students').on('input', updateCalculator);
    
    // Form validation
    $('#courseForm').submit(function(e) {
        var isValid = true;
        
        // Check if description is empty when using TinyMCE
        if (typeof tinymce !== 'undefined') {
            var description = tinymce.get('description').getContent();
            if (!description) {
                alert('Please provide a course description.');
                isValid = false;
            }
        }
        
        // Validate price if paid course
        if ($('#price_type').val() === 'paid') {
            var price = parseFloat($('#price').val());
            if (isNaN(price) || price <= 0) {
                alert('Please enter a valid price for your course.');
                isValid = false;
            }
            
            // Validate discount price if discount is enabled
            if ($('#has_discount').is(':checked')) {
                var discountPrice = parseFloat($('#discount_price').val());
                if (isNaN(discountPrice) || discountPrice <= 0 || discountPrice >= price) {
                    alert('Discount price must be lower than the regular price.');
                    isValid = false;
                }
            }
        }
        
        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>
