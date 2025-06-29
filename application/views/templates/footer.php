    </main>
    
    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">EduLearn LMS</h5>
                    <p class="text-muted">A comprehensive learning management system designed to make education accessible, engaging, and effective for everyone.</p>
                    <div class="social-icons mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= base_url() ?>" class="text-muted">Home</a></li>
                        <li class="mb-2"><a href="<?= base_url('courses') ?>" class="text-muted">All Courses</a></li>
                        <li class="mb-2"><a href="<?= base_url('about') ?>" class="text-muted">About Us</a></li>
                        <li class="mb-2"><a href="<?= base_url('contact') ?>" class="text-muted">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="mb-3">Categories</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= base_url('courses?category=web-development') ?>" class="text-muted">Web Development</a></li>
                        <li class="mb-2"><a href="<?= base_url('courses?category=mobile-development') ?>" class="text-muted">Mobile Development</a></li>
                        <li class="mb-2"><a href="<?= base_url('courses?category=data-science') ?>" class="text-muted">Data Science</a></li>
                        <li class="mb-2"><a href="<?= base_url('courses?category=design') ?>" class="text-muted">Design</a></li>
                        <li class="mb-2"><a href="<?= base_url('courses') ?>" class="text-muted">All Categories</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="mb-3">Contact Us</h5>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Learning Street, Education City</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +1 (123) 456-7890</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@edulearn.com</li>
                    </ul>
                    <div class="mt-3">
                        <h6>Subscribe to Newsletter</h6>
                        <form action="<?= base_url('newsletter/subscribe') ?>" method="post" class="mt-2">
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Your email" required>
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-secondary">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-muted">© 2025 EduLearn LMS. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0 text-muted">
                        <a href="<?= base_url('terms') ?>" class="text-muted me-3">Terms of Service</a>
                        <a href="<?= base_url('privacy') ?>" class="text-muted">Privacy Policy</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    
    <!-- Custom JS -->
    <script src="<?= base_url('assets/js/main.js') ?>"></script>
    <script src="<?= base_url('assets/js/ui-interactions.js') ?>"></script>
    <script src="<?= base_url('assets/js/theme-customizer.js') ?>"></script>
    <script src="<?= base_url('assets/js/dashboard-interactions.js') ?>"></script>
    
    <script>
    $(document).ready(function() {
        // Toggle sidebar on mobile
        $('.sidebar-toggle').on('click', function() {
            $('.sidebar').toggleClass('show');
        });
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
    </script>
    
    <?php if(isset($additional_js)): ?>
        <?= $additional_js ?>
    <?php endif; ?>
</body>
</html>
