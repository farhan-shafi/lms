<?php
// Course learning interface view
// File: /Applications/XAMPP/xamppfiles/htdocs/lms/application/views/course/learn.php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="learning-interface">
    <div class="learning-header bg-dark text-white py-3">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">
                        <a href="<?= base_url('course/' . $course['slug']) ?>" class="text-white opacity-75 me-2">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <?= $course['title'] ?>
                    </h5>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end align-items-center">
                        <div class="progress flex-grow-1 me-3" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $enrollment['progress'] ?>%;" 
                                 aria-valuenow="<?= $enrollment['progress'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="text-white-50"><?= $enrollment['progress'] ?>% complete</span>
                        
                        <div class="dropdown ms-3">
                            <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" id="learningActions" 
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="learningActions">
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('course/notes/' . $course['id']) ?>">
                                        <i class="fas fa-sticky-note me-2"></i> My Notes
                                    </a>
                                </li>
                                <?php if($enrollment['progress'] == 100): ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url('course/certificate/' . $course['id']) ?>">
                                            <i class="fas fa-certificate me-2"></i> Get Certificate
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('course/download-resources/' . $course['id']) ?>">
                                        <i class="fas fa-download me-2"></i> Resources
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#reportIssueModal">
                                        <i class="fas fa-flag me-2"></i> Report Issue
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="learning-content">
        <div class="row g-0">
            <!-- Course sidebar navigation -->
            <div class="col-lg-3 learning-sidebar">
                <div class="sidebar-wrapper bg-light h-100 border-end overflow-auto">
                    <div class="p-3 border-bottom d-flex d-lg-none justify-content-between align-items-center">
                        <h6 class="mb-0">Course Content</h6>
                        <button class="btn btn-sm btn-outline-secondary" id="closeSidebar">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <div>
                            <span class="me-2"><?= count($modules) ?> sections</span>
                            <span class="me-2">•</span>
                            <span><?= $total_lessons ?> lessons</span>
                        </div>
                        <button class="btn btn-sm btn-outline-primary" id="expandAllSections">
                            <i class="fas fa-expand-alt"></i>
                        </button>
                    </div>
                    
                    <!-- Module accordion -->
                    <div class="accordion" id="learningModules">
                        <?php foreach($modules as $index => $module): ?>
                            <div class="accordion-item border-0 border-bottom">
                                <h2 class="accordion-header" id="moduleHeading<?= $module['id'] ?>">
                                    <button class="accordion-button <?= $current_module_id == $module['id'] ? '' : 'collapsed' ?> py-3" type="button" 
                                            data-bs-toggle="collapse" data-bs-target="#moduleCollapse<?= $module['id'] ?>" 
                                            aria-expanded="<?= $current_module_id == $module['id'] ? 'true' : 'false' ?>" 
                                            aria-controls="moduleCollapse<?= $module['id'] ?>">
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="module-title">
                                                    Section <?= $index + 1 ?>: <?= $module['title'] ?>
                                                </span>
                                                <span class="badge bg-secondary ms-2"><?= count($module['lessons']) ?></span>
                                            </div>
                                            
                                            <?php if(isset($module_progress[$module['id']])): ?>
                                                <div class="progress mt-2" style="height: 5px;">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                         style="width: <?= $module_progress[$module['id']] ?>%;" 
                                                         aria-valuenow="<?= $module_progress[$module['id']] ?>" 
                                                         aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mt-1">
                                                    <small class="text-muted"><?= $module_progress[$module['id']] ?>% complete</small>
                                                    <small class="text-muted"><?= $module['duration'] ?></small>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </button>
                                </h2>
                                
                                <div id="moduleCollapse<?= $module['id'] ?>" class="accordion-collapse collapse <?= $current_module_id == $module['id'] ? 'show' : '' ?>" 
                                     aria-labelledby="moduleHeading<?= $module['id'] ?>">
                                    <div class="accordion-body p-0">
                                        <ul class="list-group list-group-flush lesson-list">
                                            <?php foreach($module['lessons'] as $lesson): ?>
                                                <li class="list-group-item border-0 px-3 py-2 <?= $current_lesson_id == $lesson['id'] ? 'active bg-primary text-white' : '' ?>">
                                                    <a href="<?= base_url('course/learn/' . $course['id'] . '/' . $lesson['id']) ?>" 
                                                       class="lesson-link d-flex align-items-center <?= $current_lesson_id == $lesson['id'] ? 'text-white' : 'text-dark' ?> text-decoration-none">
                                                        <!-- Lesson type icon -->
                                                        <?php if($lesson['type'] == 'video'): ?>
                                                            <i class="fas fa-play-circle me-2 <?= $current_lesson_id == $lesson['id'] ? 'text-white' : 'text-primary' ?>"></i>
                                                        <?php elseif($lesson['type'] == 'document'): ?>
                                                            <i class="fas fa-file-alt me-2 <?= $current_lesson_id == $lesson['id'] ? 'text-white' : 'text-primary' ?>"></i>
                                                        <?php elseif($lesson['type'] == 'quiz'): ?>
                                                            <i class="fas fa-question-circle me-2 <?= $current_lesson_id == $lesson['id'] ? 'text-white' : 'text-primary' ?>"></i>
                                                        <?php else: ?>
                                                            <i class="fas fa-file me-2 <?= $current_lesson_id == $lesson['id'] ? 'text-white' : 'text-primary' ?>"></i>
                                                        <?php endif; ?>
                                                        
                                                        <div class="flex-grow-1">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="lesson-title"><?= $lesson['title'] ?></span>
                                                                
                                                                <!-- Completion status -->
                                                                <?php if(isset($completed_lessons) && in_array($lesson['id'], $completed_lessons)): ?>
                                                                    <i class="fas fa-check-circle <?= $current_lesson_id == $lesson['id'] ? 'text-white' : 'text-success' ?> ms-2"></i>
                                                                <?php endif; ?>
                                                            </div>
                                                            
                                                            <div class="d-flex justify-content-between align-items-center mt-1">
                                                                <small class="<?= $current_lesson_id == $lesson['id'] ? 'text-white-50' : 'text-muted' ?>">
                                                                    <?= $lesson['duration'] ?>
                                                                </small>
                                                                
                                                                <?php if($lesson['type'] == 'quiz'): ?>
                                                                    <small class="badge <?= $current_lesson_id == $lesson['id'] ? 'bg-white text-primary' : 'bg-secondary text-white' ?> rounded-pill">
                                                                        Quiz
                                                                    </small>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </a>
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
            
            <!-- Main content area -->
            <div class="col-lg-9 learning-main-content">
                <div class="d-lg-none bg-light p-2 border-bottom">
                    <button class="btn btn-primary btn-sm" id="openSidebar">
                        <i class="fas fa-bars me-1"></i> Course Content
                    </button>
                </div>
                
                <div class="content-wrapper h-100 d-flex flex-column">
                    <!-- Content navigation -->
                    <div class="content-nav bg-light border-bottom p-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="mb-0"><?= $current_lesson['title'] ?></h5>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-end">
                                    <?php if($prev_lesson): ?>
                                        <a href="<?= base_url('course/learn/' . $course['id'] . '/' . $prev_lesson['id']) ?>" class="btn btn-outline-secondary me-2">
                                            <i class="fas fa-chevron-left me-1"></i> Previous
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if(!in_array($current_lesson['id'], $completed_lessons)): ?>
                                        <a href="<?= base_url('course/complete-lesson/' . $course['id'] . '/' . $current_lesson['id']) ?>" class="btn btn-success me-2">
                                            <i class="fas fa-check me-1"></i> Mark as Complete
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if($next_lesson): ?>
                                        <a href="<?= base_url('course/learn/' . $course['id'] . '/' . $next_lesson['id']) ?>" class="btn btn-primary">
                                            Next <i class="fas fa-chevron-right ms-1"></i>
                                        </a>
                                    <?php elseif($enrollment['progress'] < 100): ?>
                                        <a href="<?= base_url('course/complete/' . $course['id']) ?>" class="btn btn-primary">
                                            Complete Course <i class="fas fa-flag-checkered ms-1"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('course/certificate/' . $course['id']) ?>" class="btn btn-primary">
                                            Get Certificate <i class="fas fa-certificate ms-1"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Lesson content -->
                    <div class="lesson-content flex-grow-1 overflow-auto p-3">
                        <?php if($current_lesson['type'] == 'video'): ?>
                            <div class="video-container mb-4">
                                <div class="ratio ratio-16x9">
                                    <?php if(strpos($current_lesson['content'], 'youtube.com') !== false || strpos($current_lesson['content'], 'vimeo.com') !== false): ?>
                                        <iframe src="<?= $current_lesson['content'] ?>" allowfullscreen></iframe>
                                    <?php else: ?>
                                        <video controls>
                                            <source src="<?= base_url('assets/videos/' . $current_lesson['content']) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <?php if(isset($current_lesson['transcript']) && !empty($current_lesson['transcript'])): ?>
                                <div class="transcript-container mb-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">Transcript</h5>
                                                <button class="btn btn-sm btn-outline-primary" id="toggleTranscript">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body transcript-content" style="display: none;">
                                            <?= $current_lesson['transcript'] ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                        <?php elseif($current_lesson['type'] == 'document'): ?>
                            <div class="document-container mb-4">
                                <?= $current_lesson['content'] ?>
                            </div>
                            
                        <?php elseif($current_lesson['type'] == 'quiz'): ?>
                            <div class="quiz-container mb-4">
                                <?php if(isset($quiz_completed) && $quiz_completed): ?>
                                    <div class="card border-success mb-4">
                                        <div class="card-body">
                                            <div class="text-center mb-4">
                                                <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
                                                <h4>Quiz Completed!</h4>
                                                <p class="lead">You've already completed this quiz with a score of <?= $quiz_result['score'] ?>%</p>
                                            </div>
                                            
                                            <div class="d-flex justify-content-center">
                                                <a href="<?= base_url('course/quiz-results/' . $course['id'] . '/' . $current_lesson['id']) ?>" class="btn btn-outline-primary me-2">
                                                    <i class="fas fa-eye me-1"></i> View Results
                                                </a>
                                                <a href="<?= base_url('course/retake-quiz/' . $course['id'] . '/' . $current_lesson['id']) ?>" class="btn btn-primary">
                                                    <i class="fas fa-redo me-1"></i> Retake Quiz
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <!-- Quiz instructions -->
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h4 class="card-title mb-3"><?= $quiz['title'] ?></h4>
                                            <p class="card-text"><?= $quiz['description'] ?></p>
                                            
                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <i class="fas fa-question-circle text-primary me-2 fa-lg"></i>
                                                        <div>
                                                            <h6 class="mb-0">Questions</h6>
                                                            <small class="text-muted"><?= count($quiz['questions']) ?> questions</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <i class="fas fa-clock text-primary me-2 fa-lg"></i>
                                                        <div>
                                                            <h6 class="mb-0">Time Limit</h6>
                                                            <small class="text-muted"><?= $quiz['time_limit'] ? $quiz['time_limit'] . ' minutes' : 'No time limit' ?></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <i class="fas fa-check-double text-primary me-2 fa-lg"></i>
                                                        <div>
                                                            <h6 class="mb-0">Passing Score</h6>
                                                            <small class="text-muted"><?= $quiz['passing_score'] ?>%</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <i class="fas fa-redo-alt text-primary me-2 fa-lg"></i>
                                                        <div>
                                                            <h6 class="mb-0">Attempts</h6>
                                                            <small class="text-muted"><?= $quiz['max_attempts'] ? $quiz['max_attempts'] . ' attempts allowed' : 'Unlimited attempts' ?></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="text-center mt-4">
                                                <a href="<?= base_url('course/take-quiz/' . $course['id'] . '/' . $current_lesson['id']) ?>" class="btn btn-primary btn-lg">
                                                    <i class="fas fa-play-circle me-1"></i> Start Quiz
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Additional resources -->
                        <?php if(isset($current_lesson['resources']) && !empty($current_lesson['resources'])): ?>
                            <div class="resources-container mb-4">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Resources</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <?php foreach($current_lesson['resources'] as $resource): ?>
                                                <li class="list-group-item px-0">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <i class="fas fa-file-<?= get_file_icon($resource['file_type']) ?> text-primary me-2"></i>
                                                            <?= $resource['title'] ?>
                                                        </div>
                                                        <a href="<?= base_url('course/download-resource/' . $resource['id']) ?>" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-download me-1"></i> Download
                                                        </a>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Notes section -->
                        <div class="notes-container mb-4">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">My Notes</h5>
                                        <button class="btn btn-sm btn-outline-primary" id="toggleNotes">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body notes-content" style="display: none;">
                                    <form action="<?= base_url('course/save-notes/' . $course['id'] . '/' . $current_lesson['id']) ?>" method="post">
                                        <div class="mb-3">
                                            <textarea class="form-control" name="notes" id="lesson-notes" rows="5" placeholder="Write your notes here..."><?= $notes ?? '' ?></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Save Notes
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Discussion section -->
                        <?php if(isset($discussions) && is_array($discussions)): ?>
                            <div class="discussion-container mb-4">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Discussion (<?= count($discussions) ?>)</h5>
                                            <button class="btn btn-sm btn-outline-primary" id="toggleDiscussion">
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body discussion-content" style="display: none;">
                                        <!-- Add new comment form -->
                                        <form action="<?= base_url('course/add-comment/' . $course['id'] . '/' . $current_lesson['id']) ?>" method="post" class="mb-4">
                                            <div class="mb-3">
                                                <textarea class="form-control" name="comment" rows="3" placeholder="Ask a question or share your thoughts..."></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-paper-plane me-1"></i> Post Comment
                                            </button>
                                        </form>
                                        
                                        <!-- Comments list -->
                                        <div class="comments-list">
                                            <?php if(empty($discussions)): ?>
                                                <div class="text-center py-4">
                                                    <i class="fas fa-comments text-muted fa-3x mb-3"></i>
                                                    <p class="mb-0">No discussions yet. Be the first to start a conversation!</p>
                                                </div>
                                            <?php else: ?>
                                                <?php foreach($discussions as $discussion): ?>
                                                    <div class="comment-item mb-4">
                                                        <div class="d-flex">
                                                            <img src="<?= base_url('assets/images/profiles/' . ($discussion['user_image'] ? $discussion['user_image'] : 'default.jpg')) ?>" 
                                                                 class="rounded-circle me-3" width="40" height="40" alt="<?= $discussion['user_name'] ?>">
                                                            <div class="flex-grow-1">
                                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                                    <h6 class="mb-0">
                                                                        <?= $discussion['user_name'] ?>
                                                                        <?php if($discussion['is_instructor']): ?>
                                                                            <span class="badge bg-primary ms-1">Instructor</span>
                                                                        <?php endif; ?>
                                                                    </h6>
                                                                    <small class="text-muted"><?= time_elapsed_string($discussion['created_at']) ?></small>
                                                                </div>
                                                                <p class="mb-2"><?= $discussion['comment'] ?></p>
                                                                <div class="comment-actions">
                                                                    <button class="btn btn-sm btn-link text-decoration-none p-0 me-3 reply-toggle" 
                                                                            data-comment-id="<?= $discussion['id'] ?>">
                                                                        <i class="fas fa-reply me-1"></i> Reply
                                                                    </button>
                                                                    <?php if($this->session->userdata('user_id') == $discussion['user_id']): ?>
                                                                        <a href="<?= base_url('course/delete-comment/' . $discussion['id']) ?>" 
                                                                           class="btn btn-sm btn-link text-decoration-none text-danger p-0 delete-comment">
                                                                            <i class="fas fa-trash-alt me-1"></i> Delete
                                                                        </a>
                                                                    <?php endif; ?>
                                                                </div>
                                                                
                                                                <!-- Reply form (hidden by default) -->
                                                                <div class="reply-form mt-3" id="replyForm<?= $discussion['id'] ?>" style="display: none;">
                                                                    <form action="<?= base_url('course/add-reply/' . $discussion['id']) ?>" method="post">
                                                                        <div class="mb-2">
                                                                            <textarea class="form-control form-control-sm" name="reply" rows="2" placeholder="Write your reply..."></textarea>
                                                                        </div>
                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="button" class="btn btn-sm btn-light me-2 cancel-reply" 
                                                                                    data-comment-id="<?= $discussion['id'] ?>">Cancel</button>
                                                                            <button type="submit" class="btn btn-sm btn-primary">Submit Reply</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                
                                                                <!-- Replies -->
                                                                <?php if(isset($discussion['replies']) && !empty($discussion['replies'])): ?>
                                                                    <div class="replies-list mt-3">
                                                                        <?php foreach($discussion['replies'] as $reply): ?>
                                                                            <div class="reply-item mt-3 border-start border-2 ps-3">
                                                                                <div class="d-flex">
                                                                                    <img src="<?= base_url('assets/images/profiles/' . ($reply['user_image'] ? $reply['user_image'] : 'default.jpg')) ?>" 
                                                                                         class="rounded-circle me-2" width="30" height="30" alt="<?= $reply['user_name'] ?>">
                                                                                    <div>
                                                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                                                            <h6 class="mb-0 small">
                                                                                                <?= $reply['user_name'] ?>
                                                                                                <?php if($reply['is_instructor']): ?>
                                                                                                    <span class="badge bg-primary ms-1">Instructor</span>
                                                                                                <?php endif; ?>
                                                                                            </h6>
                                                                                            <small class="text-muted"><?= time_elapsed_string($reply['created_at']) ?></small>
                                                                                        </div>
                                                                                        <p class="mb-1 small"><?= $reply['comment'] ?></p>
                                                                                        
                                                                                        <?php if($this->session->userdata('user_id') == $reply['user_id']): ?>
                                                                                            <div class="reply-actions">
                                                                                                <a href="<?= base_url('course/delete-reply/' . $reply['id']) ?>" 
                                                                                                   class="btn btn-sm btn-link text-decoration-none text-danger p-0 small delete-reply">
                                                                                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                                                                                </a>
                                                                                            </div>
                                                                                        <?php endif; ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Issue Modal -->
<div class="modal fade" id="reportIssueModal" tabindex="-1" aria-labelledby="reportIssueModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportIssueModalLabel">Report an Issue</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('course/report-issue/' . $course['id'] . '/' . $current_lesson['id']) ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="issueType" class="form-label">Issue Type</label>
                        <select class="form-select" id="issueType" name="issue_type" required>
                            <option value="">Select an issue type...</option>
                            <option value="technical">Technical Problem</option>
                            <option value="content">Content Error</option>
                            <option value="suggestion">Suggestion</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="issueDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="issueDescription" name="description" rows="4" placeholder="Please describe the issue in detail..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Report</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile sidebar toggle
    const openSidebarBtn = document.getElementById('openSidebar');
    const closeSidebarBtn = document.getElementById('closeSidebar');
    const sidebar = document.querySelector('.learning-sidebar');
    
    if (openSidebarBtn) {
        openSidebarBtn.addEventListener('click', function() {
            sidebar.classList.add('sidebar-open');
        });
    }
    
    if (closeSidebarBtn) {
        closeSidebarBtn.addEventListener('click', function() {
            sidebar.classList.remove('sidebar-open');
        });
    }
    
    // Expand all sections
    const expandAllBtn = document.getElementById('expandAllSections');
    if (expandAllBtn) {
        expandAllBtn.addEventListener('click', function() {
            const collapseElements = document.querySelectorAll('.accordion-collapse');
            const isExpanded = expandAllBtn.querySelector('i').classList.contains('fa-compress-alt');
            
            collapseElements.forEach(collapse => {
                if (isExpanded) {
                    collapse.classList.remove('show');
                } else {
                    collapse.classList.add('show');
                }
            });
            
            if (isExpanded) {
                expandAllBtn.querySelector('i').classList.replace('fa-compress-alt', 'fa-expand-alt');
            } else {
                expandAllBtn.querySelector('i').classList.replace('fa-expand-alt', 'fa-compress-alt');
            }
        });
    }
    
    // Toggle transcript
    const toggleTranscriptBtn = document.getElementById('toggleTranscript');
    if (toggleTranscriptBtn) {
        toggleTranscriptBtn.addEventListener('click', function() {
            const transcriptContent = document.querySelector('.transcript-content');
            const icon = toggleTranscriptBtn.querySelector('i');
            
            if (transcriptContent.style.display === 'none') {
                transcriptContent.style.display = 'block';
                icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
            } else {
                transcriptContent.style.display = 'none';
                icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
            }
        });
    }
    
    // Toggle notes
    const toggleNotesBtn = document.getElementById('toggleNotes');
    if (toggleNotesBtn) {
        toggleNotesBtn.addEventListener('click', function() {
            const notesContent = document.querySelector('.notes-content');
            const icon = toggleNotesBtn.querySelector('i');
            
            if (notesContent.style.display === 'none') {
                notesContent.style.display = 'block';
                icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
            } else {
                notesContent.style.display = 'none';
                icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
            }
        });
    }
    
    // Toggle discussion
    const toggleDiscussionBtn = document.getElementById('toggleDiscussion');
    if (toggleDiscussionBtn) {
        toggleDiscussionBtn.addEventListener('click', function() {
            const discussionContent = document.querySelector('.discussion-content');
            const icon = toggleDiscussionBtn.querySelector('i');
            
            if (discussionContent.style.display === 'none') {
                discussionContent.style.display = 'block';
                icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
            } else {
                discussionContent.style.display = 'none';
                icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
            }
        });
    }
    
    // Reply toggle functionality
    const replyToggleBtns = document.querySelectorAll('.reply-toggle');
    replyToggleBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const replyForm = document.getElementById('replyForm' + commentId);
            
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        });
    });
    
    // Cancel reply
    const cancelReplyBtns = document.querySelectorAll('.cancel-reply');
    cancelReplyBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const replyForm = document.getElementById('replyForm' + commentId);
            
            replyForm.style.display = 'none';
        });
    });
    
    // Delete comment confirmation
    const deleteCommentBtns = document.querySelectorAll('.delete-comment, .delete-reply');
    deleteCommentBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this comment?')) {
                e.preventDefault();
            }
        });
    });
});
</script>
