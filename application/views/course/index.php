<?php
// courses index view
// File: /Applications/XAMPP/xamppfiles/htdocs/lms/application/views/course/index.php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container mt-5 pt-5">
    <div class="row">
        <!-- Sidebar filters -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Filter Courses</h5>
                    
                    <!-- Categories filter -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Categories</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item border-0 px-0">
                                <a href="<?= base_url('courses') ?>" class="text-decoration-none <?= !$this->input->get('category') ? 'fw-bold text-primary' : 'text-dark' ?>">
                                    <i class="fas fa-th-list me-2"></i> All Categories
                                </a>
                            </li>
                            <?php foreach($categories as $category): ?>
                                <li class="list-group-item border-0 px-0">
                                    <a href="<?= base_url('courses?category=' . $category['slug']) ?>" 
                                       class="text-decoration-none <?= ($this->input->get('category') == $category['slug']) ? 'fw-bold text-primary' : 'text-dark' ?>">
                                        <i class="fas fa-<?= $category['icon'] ?> me-2"></i> <?= $category['name'] ?>
                                        <span class="badge bg-light text-dark rounded-pill ms-1"><?= $category['course_count'] ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <!-- Sort filter -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Sort By</h6>
                        <select class="form-select" id="sort-courses">
                            <option value="latest" <?= ($this->input->get('sort') == 'latest' || !$this->input->get('sort')) ? 'selected' : '' ?>>Latest</option>
                            <option value="popular" <?= $this->input->get('sort') == 'popular' ? 'selected' : '' ?>>Most Popular</option>
                            <option value="rating" <?= $this->input->get('sort') == 'rating' ? 'selected' : '' ?>>Highest Rated</option>
                            <option value="price_low" <?= $this->input->get('sort') == 'price_low' ? 'selected' : '' ?>>Price: Low to High</option>
                            <option value="price_high" <?= $this->input->get('sort') == 'price_high' ? 'selected' : '' ?>>Price: High to Low</option>
                        </select>
                    </div>
                    
                    <!-- Price range filter (Optional) -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Price</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input price-filter" type="checkbox" value="free" id="price-free">
                            <label class="form-check-label" for="price-free">
                                Free
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input price-filter" type="checkbox" value="paid" id="price-paid">
                            <label class="form-check-label" for="price-paid">
                                Paid
                            </label>
                        </div>
                    </div>
                    
                    <!-- Apply filters button -->
                    <button id="apply-filters" class="btn btn-primary w-100">Apply Filters</button>
                </div>
            </div>
        </div>
        
        <!-- Course listings -->
        <div class="col-lg-9">
            <!-- Header section with title and search results info -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <?php if(isset($category)): ?>
                        <h2 class="h3 mb-1"><?= $category['name'] ?> Courses</h2>
                        <p class="text-muted"><?= $total_courses ?> courses found</p>
                    <?php elseif(isset($search)): ?>
                        <h2 class="h3 mb-1">Search Results for "<?= htmlspecialchars($search) ?>"</h2>
                        <p class="text-muted"><?= $total_courses ?> courses found</p>
                    <?php else: ?>
                        <h2 class="h3 mb-1">All Courses</h2>
                        <p class="text-muted"><?= $total_courses ?> courses available</p>
                    <?php endif; ?>
                </div>
                <div>
                    <div class="d-flex align-items-center">
                        <span class="me-2">View:</span>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-secondary active" id="grid-view">
                                <i class="fas fa-th-large"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="list-view">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Course grid -->
            <div class="row g-4 course-grid">
                <?php if(empty($courses)): ?>
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> No courses found. Please try different search criteria.
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach($courses as $course): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm course-card">
                                <div class="position-relative">
                                    <img src="<?= base_url('assets/images/courses/' . ($course['image'] ? $course['image'] : 'default-course.jpg')) ?>" 
                                         class="card-img-top" alt="<?= $course['title'] ?>">
                                    
                                    <?php if($course['discount_price'] && $course['discount_price'] < $course['price']): ?>
                                        <div class="position-absolute top-0 end-0 bg-danger text-white px-2 py-1 m-2 rounded-pill">
                                            <?= round((($course['price'] - $course['discount_price']) / $course['price']) * 100) ?>% OFF
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="course-overlay">
                                        <a href="<?= base_url('course/' . $course['slug']) ?>" class="btn btn-primary btn-sm">View Course</a>
                                    </div>
                                </div>
                                
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-<?= $course['category_icon'] ?>"></i> <?= $course['category_name'] ?>
                                        </span>
                                        <div class="course-rating">
                                            <i class="fas fa-star text-warning"></i>
                                            <span><?= number_format($course['average_rating'], 1) ?></span>
                                            <small class="text-muted">(<?= $course['rating_count'] ?>)</small>
                                        </div>
                                    </div>
                                    
                                    <h5 class="card-title">
                                        <a href="<?= base_url('course/' . $course['slug']) ?>" class="text-decoration-none text-dark">
                                            <?= $course['title'] ?>
                                        </a>
                                    </h5>
                                    
                                    <p class="card-text text-muted small mb-2">
                                        <?= character_limiter($course['description'], 100) ?>
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="course-meta small text-muted">
                                            <span><i class="fas fa-book-open me-1"></i> <?= $course['lesson_count'] ?> lessons</span>
                                            <span class="ms-2"><i class="fas fa-clock me-1"></i> <?= $course['duration'] ?></span>
                                        </div>
                                        
                                        <div class="course-price">
                                            <?php if($course['is_free']): ?>
                                                <span class="text-success fw-bold">Free</span>
                                            <?php elseif($course['discount_price'] && $course['discount_price'] < $course['price']): ?>
                                                <span class="text-danger fw-bold"><?= currency_format($course['discount_price']) ?></span>
                                                <small class="text-muted text-decoration-line-through"><?= currency_format($course['price']) ?></small>
                                            <?php else: ?>
                                                <span class="fw-bold"><?= currency_format($course['price']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                                    <div class="instructor d-flex align-items-center">
                                        <img src="<?= base_url('assets/images/profiles/' . ($course['instructor_image'] ? $course['instructor_image'] : 'default.jpg')) ?>" 
                                             class="rounded-circle me-1" width="24" height="24" alt="<?= $course['instructor_name'] ?>">
                                        <small class="text-muted"><?= $course['instructor_name'] ?></small>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-users me-1"></i> <?= $course['enrollment_count'] ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <!-- Pagination -->
            <div class="mt-5">
                <?= $pagination ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sort courses functionality
    const sortSelect = document.getElementById('sort-courses');
    sortSelect.addEventListener('change', function() {
        updateFilters();
    });
    
    // Grid/List view toggle
    const gridView = document.getElementById('grid-view');
    const listView = document.getElementById('list-view');
    const courseGrid = document.querySelector('.course-grid');
    
    gridView.addEventListener('click', function() {
        courseGrid.classList.remove('list-view');
        gridView.classList.add('active');
        listView.classList.remove('active');
        localStorage.setItem('course_view', 'grid');
    });
    
    listView.addEventListener('click', function() {
        courseGrid.classList.add('list-view');
        listView.classList.add('active');
        gridView.classList.remove('active');
        localStorage.setItem('course_view', 'list');
    });
    
    // Load saved view preference
    const savedView = localStorage.getItem('course_view');
    if(savedView === 'list') {
        courseGrid.classList.add('list-view');
        listView.classList.add('active');
        gridView.classList.remove('active');
    }
    
    // Apply filters button
    document.getElementById('apply-filters').addEventListener('click', function() {
        updateFilters();
    });
    
    // Price filter functionality
    const priceFilters = document.querySelectorAll('.price-filter');
    
    function updateFilters() {
        let url = new URL(window.location.href);
        let params = new URLSearchParams(url.search);
        
        // Update sort parameter
        params.set('sort', sortSelect.value);
        
        // Update price parameter
        let priceValues = [];
        priceFilters.forEach(filter => {
            if(filter.checked) {
                priceValues.push(filter.value);
            }
        });
        
        if(priceValues.length > 0) {
            params.set('price', priceValues.join(','));
        } else {
            params.delete('price');
        }
        
        // Redirect with updated parameters
        window.location.href = url.pathname + '?' + params.toString();
    }
    
    // Set initial state of price filters based on URL
    let url = new URL(window.location.href);
    let params = new URLSearchParams(url.search);
    let priceParam = params.get('price');
    
    if(priceParam) {
        let prices = priceParam.split(',');
        priceFilters.forEach(filter => {
            filter.checked = prices.includes(filter.value);
        });
    }
});
</script>
