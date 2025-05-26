<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="hero-title">Learn Without Limits</h1>
                <p class="hero-text">Access quality education anytime, anywhere. Join thousands of students and instructors on our platform.</p>
                <div class="hero-buttons">
                    <a href="<?= base_url('courses') ?>" class="btn btn-primary btn-lg">Browse Courses</a>
                    <a href="<?= base_url('auth/register') ?>" class="btn btn-outline-primary btn-lg ml-3">Sign Up</a>
                </div>
            </div>
            <div class="col-md-6">
                <img src="<?= base_url('assets/images/hero-image.jpg') ?>" alt="Learning Management System" class="img-fluid hero-image">
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section">
    <div class="container">
        <h2 class="section-title text-center">Top Categories</h2>
        <div class="row">
            <?php foreach ($categories as $category): ?>
            <div class="col-md-3 col-sm-6">
                <a href="<?= base_url('courses/category/'.$category['id']) ?>" class="category-card">
                    <div class="card">
                        <img src="<?= base_url('assets/images/categories/'.$category['image']) ?>" class="card-img-top" alt="<?= $category['name'] ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $category['name'] ?></h5>
                            <p class="card-text"><?= $category['course_count'] ?> Courses</p>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Featured Courses Section -->
<section class="featured-courses-section">
    <div class="container">
        <h2 class="section-title text-center">Featured Courses</h2>
        <div class="row">
            <?php foreach ($featured_courses as $course): ?>
            <div class="col-lg-4 col-md-6">
                <div class="course-card">
                    <div class="card">
                        <div class="course-image">
                            <img src="<?= base_url('assets/images/courses/'.$course['image']) ?>" class="card-img-top" alt="<?= $course['title'] ?>">
                            <div class="course-price">
                                <?php if ($course['price'] == 0): ?>
                                <span class="badge badge-success">Free</span>
                                <?php else: ?>
                                <span class="badge badge-primary">$<?= number_format($course['price'], 2) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="course-category">
                                <span class="badge badge-light"><?= $course['category_name'] ?></span>
                            </div>
                            <h5 class="card-title"><a href="<?= base_url('course/view/'.$course['id']) ?>"><?= $course['title'] ?></a></h5>
                            <p class="card-text"><?= word_limiter($course['description'], 15) ?></p>
                            <div class="course-meta">
                                <span><i class="fas fa-user"></i> <?= $course['instructor_name'] ?></span>
                                <span><i class="fas fa-users"></i> <?= $course['student_count'] ?> students</span>
                            </div>
                            <div class="course-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= $course['rating']): ?>
                                        <i class="fas fa-star"></i>
                                    <?php elseif ($i - 0.5 <= $course['rating']): ?>
                                        <i class="fas fa-star-half-alt"></i>
                                    <?php else: ?>
                                        <i class="far fa-star"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <span>(<?= $course['review_count'] ?>)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?= base_url('courses') ?>" class="btn btn-outline-primary">View All Courses</a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-6">
                <div class="stat-item text-center">
                    <div class="stat-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="stat-number"><?= $stats['courses'] ?>+</h3>
                    <p class="stat-title">Courses</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item text-center">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="stat-number"><?= $stats['students'] ?>+</h3>
                    <p class="stat-title">Students</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item text-center">
                    <div class="stat-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3 class="stat-number"><?= $stats['instructors'] ?>+</h3>
                    <p class="stat-title">Instructors</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item text-center">
                    <div class="stat-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3 class="stat-number"><?= $stats['enrollments'] ?>+</h3>
                    <p class="stat-title">Enrollments</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Courses Section -->
<section class="latest-courses-section">
    <div class="container">
        <h2 class="section-title text-center">Latest Courses</h2>
        <div class="row">
            <?php foreach ($latest_courses as $course): ?>
            <div class="col-lg-3 col-md-6">
                <div class="course-card">
                    <div class="card">
                        <div class="course-image">
                            <img src="<?= base_url('assets/images/courses/'.$course['image']) ?>" class="card-img-top" alt="<?= $course['title'] ?>">
                            <div class="course-price">
                                <?php if ($course['price'] == 0): ?>
                                <span class="badge badge-success">Free</span>
                                <?php else: ?>
                                <span class="badge badge-primary">$<?= number_format($course['price'], 2) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="course-category">
                                <span class="badge badge-light"><?= $course['category_name'] ?></span>
                            </div>
                            <h5 class="card-title"><a href="<?= base_url('course/view/'.$course['id']) ?>"><?= $course['title'] ?></a></h5>
                            <div class="course-meta">
                                <span><i class="fas fa-user"></i> <?= $course['instructor_name'] ?></span>
                            </div>
                            <div class="course-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= $course['rating']): ?>
                                        <i class="fas fa-star"></i>
                                    <?php elseif ($i - 0.5 <= $course['rating']): ?>
                                        <i class="fas fa-star-half-alt"></i>
                                    <?php else: ?>
                                        <i class="far fa-star"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <span>(<?= $course['review_count'] ?>)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section">
    <div class="container">
        <h2 class="section-title text-center">What Our Students Say</h2>
        <div class="testimonial-carousel">
            <div class="row">
                <div class="col-md-4">
                    <div class="testimonial-item">
                        <div class="testimonial-content">
                            <p>"This platform has transformed my learning experience. The courses are well-structured and taught by experts in their fields."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="<?= base_url('assets/images/profiles/testimonial-1.jpg') ?>" alt="Testimonial">
                            <div class="author-info">
                                <h5>Sarah Johnson</h5>
                                <p>Web Developer</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-item">
                        <div class="testimonial-content">
                            <p>"The quality of instruction and course materials is exceptional. I've been able to advance my career significantly thanks to these courses."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="<?= base_url('assets/images/profiles/testimonial-2.jpg') ?>" alt="Testimonial">
                            <div class="author-info">
                                <h5>Michael Chen</h5>
                                <p>Data Scientist</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-item">
                        <div class="testimonial-content">
                            <p>"I love the flexibility of learning at my own pace. The platform is easy to navigate and the community support is incredible."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="<?= base_url('assets/images/profiles/testimonial-3.jpg') ?>" alt="Testimonial">
                            <div class="author-info">
                                <h5>Emily Rodriguez</h5>
                                <p>Marketing Specialist</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Become Instructor Section -->
<section class="become-instructor-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="<?= base_url('assets/images/instructor-cta.jpg') ?>" alt="Become an Instructor" class="img-fluid">
            </div>
            <div class="col-md-6">
                <div class="become-instructor-content">
                    <h2>Become an Instructor</h2>
                    <p>Share your knowledge with thousands of students around the world. Create engaging courses and help others learn while earning income.</p>
                    <ul class="instructor-benefits">
                        <li><i class="fas fa-check-circle"></i> Reach students globally</li>
                        <li><i class="fas fa-check-circle"></i> Earn revenue from course sales</li>
                        <li><i class="fas fa-check-circle"></i> Flexible schedule</li>
                        <li><i class="fas fa-check-circle"></i> Supportive community</li>
                    </ul>
                    <a href="<?= base_url('instructor/register') ?>" class="btn btn-primary btn-lg">Start Teaching Today</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-box">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3>Subscribe to Our Newsletter</h3>
                    <p>Get updates on new courses, special offers, and learning tips.</p>
                </div>
                <div class="col-md-6">
                    <form class="newsletter-form" action="<?= base_url('home/subscribe') ?>" method="post">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your Email Address" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Subscribe</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
