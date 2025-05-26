<!-- LMS UI Component Demo Page -->
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="page-title">UI Components Demo</h1>
            <p class="lead">This page showcases the various UI components and styles available in the EduLearn LMS system.</p>
        </div>
    </div>

    <!-- Theme Customization Demo -->
    <section class="card shadow-sm mb-5">
        <div class="card-header">
            <h2 class="h4 mb-0">Theme Customization</h2>
        </div>
        <div class="card-body">
            <p>Click the theme customizer button in the bottom right corner to customize the theme.</p>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card theme-preview theme-blue">
                        <div class="card-body text-center py-4">
                            <h5>Blue Theme</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card theme-preview theme-green">
                        <div class="card-body text-center py-4">
                            <h5>Green Theme</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card theme-preview theme-purple">
                        <div class="card-body text-center py-4">
                            <h5>Purple Theme</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Buttons Demo -->
    <section class="card shadow-sm mb-5">
        <div class="card-header">
            <h2 class="h4 mb-0">Buttons</h2>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <h5>Standard Buttons</h5>
                <div class="btn-group-demo">
                    <button class="btn btn-primary">Primary</button>
                    <button class="btn btn-secondary">Secondary</button>
                    <button class="btn btn-success">Success</button>
                    <button class="btn btn-danger">Danger</button>
                    <button class="btn btn-warning">Warning</button>
                    <button class="btn btn-info">Info</button>
                    <button class="btn btn-light">Light</button>
                    <button class="btn btn-dark">Dark</button>
                </div>
            </div>
            <div class="mb-4">
                <h5>Outlined Buttons</h5>
                <div class="btn-group-demo">
                    <button class="btn btn-outline-primary">Primary</button>
                    <button class="btn btn-outline-secondary">Secondary</button>
                    <button class="btn btn-outline-success">Success</button>
                    <button class="btn btn-outline-danger">Danger</button>
                    <button class="btn btn-outline-warning">Warning</button>
                    <button class="btn btn-outline-info">Info</button>
                    <button class="btn btn-outline-dark">Dark</button>
                </div>
            </div>
            <div class="mb-4">
                <h5>Button Sizes</h5>
                <div class="btn-group-demo">
                    <button class="btn btn-primary btn-sm">Small</button>
                    <button class="btn btn-primary">Default</button>
                    <button class="btn btn-primary btn-lg">Large</button>
                </div>
            </div>
            <div>
                <h5>Button with Icons</h5>
                <div class="btn-group-demo">
                    <button class="btn btn-primary"><i class="fas fa-download me-2"></i>Download</button>
                    <button class="btn btn-success"><i class="fas fa-check me-2"></i>Confirm</button>
                    <button class="btn btn-danger"><i class="fas fa-trash me-2"></i>Delete</button>
                    <button class="btn btn-info"><i class="fas fa-info-circle me-2"></i>Info</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Cards Demo -->
    <section class="card shadow-sm mb-5">
        <div class="card-header">
            <h2 class="h4 mb-0">Course Cards</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Course Card 1 -->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="course-card">
                        <div class="course-card-img">
                            <img src="https://via.placeholder.com/300x200?text=Web+Development" alt="Course Image">
                            <div class="course-card-badge">Bestseller</div>
                        </div>
                        <div class="course-card-body">
                            <div class="course-card-category">Web Development</div>
                            <h3 class="course-card-title">Complete Web Development Bootcamp</h3>
                            <div class="course-card-instructor">By John Smith</div>
                            <div class="course-card-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>4.5 (230 reviews)</span>
                            </div>
                            <div class="course-card-progress">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span>75% complete</span>
                            </div>
                        </div>
                        <div class="course-card-footer">
                            <div class="course-card-price">$49.99</div>
                            <button class="btn btn-primary btn-sm">Enroll Now</button>
                        </div>
                    </div>
                </div>
                
                <!-- Course Card 2 -->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="course-card">
                        <div class="course-card-img">
                            <img src="https://via.placeholder.com/300x200?text=Data+Science" alt="Course Image">
                            <div class="course-card-badge course-card-badge-new">New</div>
                        </div>
                        <div class="course-card-body">
                            <div class="course-card-category">Data Science</div>
                            <h3 class="course-card-title">Data Science and Machine Learning</h3>
                            <div class="course-card-instructor">By Sarah Johnson</div>
                            <div class="course-card-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>4.0 (180 reviews)</span>
                            </div>
                            <div class="course-card-progress">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span>30% complete</span>
                            </div>
                        </div>
                        <div class="course-card-footer">
                            <div class="course-card-price">$59.99</div>
                            <button class="btn btn-primary btn-sm">Enroll Now</button>
                        </div>
                    </div>
                </div>
                
                <!-- Course Card 3 -->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="course-card">
                        <div class="course-card-img">
                            <img src="https://via.placeholder.com/300x200?text=Mobile+Development" alt="Course Image">
                        </div>
                        <div class="course-card-body">
                            <div class="course-card-category">Mobile Development</div>
                            <h3 class="course-card-title">iOS App Development with Swift</h3>
                            <div class="course-card-instructor">By Michael Brown</div>
                            <div class="course-card-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>5.0 (120 reviews)</span>
                            </div>
                            <div class="course-card-progress">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span>Completed</span>
                            </div>
                        </div>
                        <div class="course-card-footer">
                            <div class="course-card-price">$69.99</div>
                            <button class="btn btn-success btn-sm">Completed</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- UI Components Demo -->
    <section class="card shadow-sm mb-5">
        <div class="card-header">
            <h2 class="h4 mb-0">UI Components</h2>
        </div>
        <div class="card-body">
            <!-- Toasts -->
            <div class="mb-4">
                <h5>Toast Notifications</h5>
                <div class="btn-group-demo">
                    <button class="btn btn-primary show-toast" data-toast-type="primary">Primary Toast</button>
                    <button class="btn btn-success show-toast" data-toast-type="success">Success Toast</button>
                    <button class="btn btn-danger show-toast" data-toast-type="error">Error Toast</button>
                    <button class="btn btn-warning show-toast" data-toast-type="warning">Warning Toast</button>
                    <button class="btn btn-info show-toast" data-toast-type="info">Info Toast</button>
                </div>
            </div>
            
            <!-- Custom Form Elements -->
            <div class="mb-4">
                <h5>Custom Form Elements</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Custom Checkbox</label>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck1" checked>
                            <label class="custom-control-label" for="customCheck1">Option 1</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                            <label class="custom-control-label" for="customCheck2">Option 2</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Custom Radio</label>
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio" class="custom-control-input" name="customRadio" id="customRadio1" checked>
                            <label class="custom-control-label" for="customRadio1">Option 1</label>
                        </div>
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio" class="custom-control-input" name="customRadio" id="customRadio2">
                            <label class="custom-control-label" for="customRadio2">Option 2</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Custom File Upload</label>
                        <div class="custom-file-upload">
                            <input type="file" id="customFile" class="custom-file-input">
                            <label for="customFile" class="custom-file-label">
                                <i class="fas fa-cloud-upload-alt me-2"></i>Choose file
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Custom Range Slider</label>
                        <input type="range" class="custom-range" min="0" max="100" step="1" value="50" id="customRange">
                        <div class="range-value"><span id="rangeValue">50</span>%</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Animations Demo -->
    <section class="card shadow-sm mb-5">
        <div class="card-header">
            <h2 class="h4 mb-0">Animations</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card animation-demo fade-in">
                        <div class="card-body text-center">
                            <i class="fas fa-star mb-3 fa-2x"></i>
                            <h5>Fade In</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card animation-demo slide-up">
                        <div class="card-body text-center">
                            <i class="fas fa-arrow-up mb-3 fa-2x"></i>
                            <h5>Slide Up</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card animation-demo slide-right">
                        <div class="card-body text-center">
                            <i class="fas fa-arrow-right mb-3 fa-2x"></i>
                            <h5>Slide Right</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card animation-demo scale-up">
                        <div class="card-body text-center">
                            <i class="fas fa-expand-alt mb-3 fa-2x"></i>
                            <h5>Scale Up</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6 mb-3">
                    <h5>Hover Effects</h5>
                    <div class="card hover-demo">
                        <div class="card-body text-center py-5">
                            <h4>Hover Me</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <h5>Progress Animation</h5>
                    <div class="progress-animation-demo">
                        <div class="progress mb-2">
                            <div class="progress-bar progress-animate" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <button class="btn btn-primary animate-progress">Start Animation</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Toast Container -->
    <div class="toast-container"></div>
</div>

<script>
    // Toast Demo Script
    document.addEventListener('DOMContentLoaded', function() {
        // Toast buttons
        const toastButtons = document.querySelectorAll('.show-toast');
        toastButtons.forEach(button => {
            button.addEventListener('click', function() {
                const toastType = this.getAttribute('data-toast-type');
                let toastTitle, toastMessage, toastIcon;
                
                switch(toastType) {
                    case 'success':
                        toastTitle = 'Success!';
                        toastMessage = 'Your action was completed successfully.';
                        toastIcon = 'fas fa-check-circle';
                        break;
                    case 'error':
                        toastTitle = 'Error!';
                        toastMessage = 'An error occurred. Please try again.';
                        toastIcon = 'fas fa-exclamation-circle';
                        break;
                    case 'warning':
                        toastTitle = 'Warning!';
                        toastMessage = 'Please proceed with caution.';
                        toastIcon = 'fas fa-exclamation-triangle';
                        break;
                    case 'info':
                        toastTitle = 'Information';
                        toastMessage = 'Here is some important information.';
                        toastIcon = 'fas fa-info-circle';
                        break;
                    default:
                        toastTitle = 'Notification';
                        toastMessage = 'This is a standard notification.';
                        toastIcon = 'fas fa-bell';
                }
                
                showToast(toastTitle, toastMessage, toastType, toastIcon);
            });
        });
        
        // Range slider
        const rangeSlider = document.getElementById('customRange');
        const rangeValue = document.getElementById('rangeValue');
        
        if (rangeSlider && rangeValue) {
            rangeSlider.addEventListener('input', function() {
                rangeValue.textContent = this.value;
            });
        }
        
        // Animate progress bar
        const animateProgressBtn = document.querySelector('.animate-progress');
        const progressBar = document.querySelector('.progress-animate');
        
        if (animateProgressBtn && progressBar) {
            animateProgressBtn.addEventListener('click', function() {
                progressBar.style.width = '0%';
                progressBar.setAttribute('aria-valuenow', '0');
                
                setTimeout(() => {
                    progressBar.style.transition = 'width 1.5s ease-in-out';
                    progressBar.style.width = '100%';
                    progressBar.setAttribute('aria-valuenow', '100');
                }, 100);
            });
        }
        
        // Custom file upload
        const fileInput = document.getElementById('customFile');
        const fileLabel = document.querySelector('.custom-file-label');
        
        if (fileInput && fileLabel) {
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    fileLabel.innerHTML = '<i class="fas fa-file me-2"></i>' + this.files[0].name;
                } else {
                    fileLabel.innerHTML = '<i class="fas fa-cloud-upload-alt me-2"></i>Choose file';
                }
            });
        }
    });
    
    // Function to show toast notification
    function showToast(title, message, type, icon) {
        const toastContainer = document.querySelector('.toast-container');
        
        if (!toastContainer) return;
        
        const toastId = 'toast-' + Date.now();
        const toastHTML = `
            <div id="${toastId}" class="toast toast-${type} fade-in">
                <div class="toast-header">
                    <i class="${icon} me-2"></i>
                    <strong class="me-auto">${title}</strong>
                    <small>Just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `;
        
        toastContainer.insertAdjacentHTML('beforeend', toastHTML);
        
        const toastElement = document.getElementById(toastId);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            toastElement.classList.remove('fade-in');
            toastElement.classList.add('fade-out');
            setTimeout(() => {
                toastElement.remove();
            }, 300);
        }, 5000);
        
        // Close button functionality
        const closeButton = toastElement.querySelector('.btn-close');
        closeButton.addEventListener('click', function() {
            toastElement.classList.remove('fade-in');
            toastElement.classList.add('fade-out');
            setTimeout(() => {
                toastElement.remove();
            }, 300);
        });
    }
</script>
