<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('progress'); ?>">My Progress</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $course['title']; ?></li>
                </ol>
            </nav>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><?php echo $course['title']; ?> - Progress</h1>
                <div>
                    <a href="<?php echo base_url('course/view/' . $course['id']); ?>" class="btn btn-primary">
                        <i class="fa fa-play-circle"></i> Continue Learning
                    </a>
                </div>
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
            
            <!-- Overall Course Progress -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Overall Course Progress</h5>
                </div>
                <div class="card-body">
                    <div class="progress mb-3" style="height: 25px;">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $course_progress['percentage']; ?>%;" 
                             aria-valuenow="<?php echo $course_progress['percentage']; ?>" aria-valuemin="0" aria-valuemax="100">
                            <?php echo $course_progress['percentage']; ?>%
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0"><strong>Completed Items:</strong> <?php echo $course_progress['completed_items']; ?> / <?php echo $course_progress['total_items']; ?></p>
                        <?php if ($course_progress['completed_items'] > 0): ?>
                            <form action="<?php echo base_url('progress/reset'); ?>" method="post" onsubmit="return confirm('Are you sure you want to reset all progress for this course? This action cannot be undone.');">
                                <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa fa-refresh"></i> Reset Progress
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Module Progress -->
            <div class="accordion" id="modulesAccordion">
                <?php foreach ($modules_progress as $index => $module_data): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?php echo $index; ?>">
                            <button class="accordion-button <?php echo ($index > 0) ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#collapse<?php echo $index; ?>" aria-expanded="<?php echo ($index === 0) ? 'true' : 'false'; ?>" 
                                    aria-controls="collapse<?php echo $index; ?>">
                                <?php echo $module_data['module']['title']; ?> - 
                                <span class="ms-2 badge bg-<?php echo ($module_data['progress']['percentage'] == 100) ? 'success' : 'primary'; ?>">
                                    <?php echo $module_data['progress']['percentage']; ?>% Complete
                                </span>
                            </button>
                        </h2>
                        <div id="collapse<?php echo $index; ?>" class="accordion-collapse collapse <?php echo ($index === 0) ? 'show' : ''; ?>" 
                             aria-labelledby="heading<?php echo $index; ?>" data-bs-parent="#modulesAccordion">
                            <div class="accordion-body">
                                <div class="progress mb-3">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $module_data['progress']['percentage']; ?>%;" 
                                         aria-valuenow="<?php echo $module_data['progress']['percentage']; ?>" aria-valuemin="0" aria-valuemax="100">
                                        <?php echo $module_data['progress']['percentage']; ?>%
                                    </div>
                                </div>
                                
                                <!-- Lessons -->
                                <?php if (!empty($module_data['lessons'])): ?>
                                    <h6 class="mt-4">Lessons</h6>
                                    <div class="list-group mb-3">
                                        <?php foreach ($module_data['lessons'] as $lesson): ?>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fa fa-book me-2"></i> 
                                                    <?php echo $lesson['lesson']['title']; ?>
                                                </div>
                                                <div>
                                                    <?php if ($lesson['completed']): ?>
                                                        <span class="badge bg-success">Completed</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Not Completed</span>
                                                    <?php endif; ?>
                                                    <a href="<?php echo base_url('lesson/view/' . $lesson['lesson']['id']); ?>" class="btn btn-sm btn-outline-primary ms-2">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Quizzes -->
                                <?php if (!empty($module_data['quizzes'])): ?>
                                    <h6 class="mt-4">Quizzes</h6>
                                    <div class="list-group">
                                        <?php foreach ($module_data['quizzes'] as $quiz): ?>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fa fa-question-circle me-2"></i> 
                                                    <?php echo $quiz['quiz']['title']; ?>
                                                </div>
                                                <div>
                                                    <?php if ($quiz['completed']): ?>
                                                        <span class="badge bg-success">
                                                            Completed <?php echo ($quiz['score'] !== NULL) ? '- Score: ' . $quiz['score'] . '%' : ''; ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Not Attempted</span>
                                                    <?php endif; ?>
                                                    <a href="<?php echo base_url('quiz/take/' . $quiz['quiz']['id']); ?>" class="btn btn-sm btn-outline-primary ms-2">
                                                        <?php echo ($quiz['completed']) ? '<i class="fa fa-refresh"></i> Retake' : '<i class="fa fa-play"></i> Start'; ?>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript for handling AJAX progress updates
    $(document).ready(function() {
        // Update progress on page load
        updateModuleStatusIndicators();
        
        // Function to update module status indicators
        function updateModuleStatusIndicators() {
            $('.accordion-item').each(function() {
                var completedItems = $(this).find('.badge.bg-success').length;
                var totalItems = $(this).find('.list-group-item').length;
                
                if (totalItems > 0 && completedItems === totalItems) {
                    $(this).find('.accordion-button .badge')
                        .removeClass('bg-primary')
                        .addClass('bg-success');
                }
            });
        }
    });
</script>
