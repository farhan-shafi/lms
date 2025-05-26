<?php
// Quiz taking view
// File: /Applications/XAMPP/xamppfiles/htdocs/lms/application/views/course/take_quiz.php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="quiz-container py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><?= $quiz['title'] ?></h4>
                            
                            <?php if($quiz['time_limit']): ?>
                                <div class="quiz-timer bg-light text-dark px-3 py-2 rounded">
                                    <i class="fas fa-clock me-2"></i>
                                    <span id="quizTimer" data-time-limit="<?= $quiz['time_limit'] * 60 ?>">
                                        <?= $quiz['time_limit'] ?>:00
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="card-body p-4">
                        <form id="quizForm" action="<?= base_url('course/submit-quiz/' . $course_id . '/' . $lesson_id) ?>" method="post">
                            <div class="quiz-progress mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Question <span id="currentQuestionNumber">1</span> of <?= count($quiz['questions']) ?></span>
                                    <span id="progressPercentage">0%</span>
                                </div>
                                <div class="progress">
                                    <div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: 0%" 
                                         aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            
                            <div class="quiz-questions">
                                <?php foreach($quiz['questions'] as $index => $question): ?>
                                    <div class="quiz-question <?= $index > 0 ? 'd-none' : '' ?>" data-question-index="<?= $index ?>" id="question<?= $index ?>">
                                        <h5 class="question-title mb-4">
                                            <?= ($index + 1) ?>. <?= $question['question'] ?>
                                            <?php if($question['points'] > 1): ?>
                                                <span class="badge bg-info ms-2"><?= $question['points'] ?> points</span>
                                            <?php endif; ?>
                                        </h5>
                                        
                                        <?php if(!empty($question['image'])): ?>
                                            <div class="question-image mb-4">
                                                <img src="<?= base_url('assets/images/quizzes/' . $question['image']) ?>" 
                                                     class="img-fluid rounded" alt="Question Image">
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if($question['type'] == 'multiple_choice'): ?>
                                            <div class="question-options">
                                                <?php foreach($question['options'] as $option_index => $option): ?>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" 
                                                               name="answers[<?= $question['id'] ?>]" 
                                                               id="option<?= $question['id'] ?>_<?= $option_index ?>" 
                                                               value="<?= $option_index ?>">
                                                        <label class="form-check-label" for="option<?= $question['id'] ?>_<?= $option_index ?>">
                                                            <?= $option ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            
                                        <?php elseif($question['type'] == 'multiple_answer'): ?>
                                            <div class="question-options">
                                                <?php foreach($question['options'] as $option_index => $option): ?>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" 
                                                               name="answers[<?= $question['id'] ?>][]" 
                                                               id="option<?= $question['id'] ?>_<?= $option_index ?>" 
                                                               value="<?= $option_index ?>">
                                                        <label class="form-check-label" for="option<?= $question['id'] ?>_<?= $option_index ?>">
                                                            <?= $option ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            
                                        <?php elseif($question['type'] == 'true_false'): ?>
                                            <div class="question-options">
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="radio" 
                                                           name="answers[<?= $question['id'] ?>]" 
                                                           id="option<?= $question['id'] ?>_true" 
                                                           value="true">
                                                    <label class="form-check-label" for="option<?= $question['id'] ?>_true">
                                                        True
                                                    </label>
                                                </div>
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="radio" 
                                                           name="answers[<?= $question['id'] ?>]" 
                                                           id="option<?= $question['id'] ?>_false" 
                                                           value="false">
                                                    <label class="form-check-label" for="option<?= $question['id'] ?>_false">
                                                        False
                                                    </label>
                                                </div>
                                            </div>
                                            
                                        <?php elseif($question['type'] == 'short_answer'): ?>
                                            <div class="question-options">
                                                <div class="mb-3">
                                                    <input type="text" class="form-control" 
                                                           name="answers[<?= $question['id'] ?>]" 
                                                           placeholder="Your answer...">
                                                </div>
                                            </div>
                                            
                                        <?php elseif($question['type'] == 'essay'): ?>
                                            <div class="question-options">
                                                <div class="mb-3">
                                                    <textarea class="form-control" 
                                                              name="answers[<?= $question['id'] ?>]" 
                                                              rows="5" 
                                                              placeholder="Your answer..."></textarea>
                                                </div>
                                            </div>
                                            
                                        <?php elseif($question['type'] == 'matching'): ?>
                                            <div class="question-options matching-question">
                                                <?php foreach($question['left_options'] as $left_index => $left_option): ?>
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="col-5 pe-3">
                                                            <div class="bg-light p-2 rounded"><?= $left_option ?></div>
                                                        </div>
                                                        <div class="col-2 text-center">
                                                            <i class="fas fa-arrows-alt-h"></i>
                                                        </div>
                                                        <div class="col-5 ps-3">
                                                            <select class="form-select" name="answers[<?= $question['id'] ?>][<?= $left_index ?>]">
                                                                <option value="">Select a match...</option>
                                                                <?php foreach($question['right_options'] as $right_index => $right_option): ?>
                                                                    <option value="<?= $right_index ?>"><?= $right_option ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            
                                        <?php endif; ?>
                                        
                                        <?php if(!empty($question['explanation'])): ?>
                                            <div class="question-explanation mt-4 d-none">
                                                <div class="alert alert-info">
                                                    <h6 class="alert-heading mb-2">Explanation:</h6>
                                                    <?= $question['explanation'] ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="quiz-navigation mt-4 d-flex justify-content-between">
                                <button type="button" id="prevQuestionBtn" class="btn btn-secondary" disabled>
                                    <i class="fas fa-arrow-left me-1"></i> Previous
                                </button>
                                
                                <div class="d-flex">
                                    <button type="button" id="markForReviewBtn" class="btn btn-outline-warning me-2">
                                        <i class="fas fa-flag me-1"></i> Mark for Review
                                    </button>
                                    
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="questionNavigationDropdown" 
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            Question Navigation
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="questionNavigationDropdown" id="questionNavigationList">
                                            <?php foreach($quiz['questions'] as $index => $question): ?>
                                                <li>
                                                    <button type="button" class="dropdown-item question-nav-item" data-question-index="<?= $index ?>">
                                                        Question <?= $index + 1 ?>
                                                        <span class="question-status ms-2"></span>
                                                    </button>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                                
                                <button type="button" id="nextQuestionBtn" class="btn btn-primary">
                                    Next <i class="fas fa-arrow-right ms-1"></i>
                                </button>
                            </div>
                            
                            <div id="submitQuizBtnContainer" class="text-center mt-4 d-none">
                                <p class="mb-3">You've reached the end of the quiz. Review your answers or submit your quiz.</p>
                                <button type="button" id="submitQuizBtn" class="btn btn-success btn-lg">
                                    <i class="fas fa-check-circle me-1"></i> Submit Quiz
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Quiz sidebar for larger screens -->
                <div class="quiz-sidebar d-none d-lg-block mt-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="mb-3">Question Overview</h5>
                            <div class="question-overview d-flex flex-wrap gap-2 mb-3">
                                <?php foreach($quiz['questions'] as $index => $question): ?>
                                    <button type="button" class="btn btn-outline-secondary question-overview-item" 
                                            data-question-index="<?= $index ?>">
                                        <?= $index + 1 ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="question-legend d-flex flex-wrap mt-3">
                                <div class="me-3 mb-2 d-flex align-items-center">
                                    <div class="legend-indicator bg-success rounded-circle me-1" style="width: 12px; height: 12px;"></div>
                                    <small>Answered</small>
                                </div>
                                <div class="me-3 mb-2 d-flex align-items-center">
                                    <div class="legend-indicator bg-warning rounded-circle me-1" style="width: 12px; height: 12px;"></div>
                                    <small>Marked for Review</small>
                                </div>
                                <div class="me-3 mb-2 d-flex align-items-center">
                                    <div class="legend-indicator bg-light border rounded-circle me-1" style="width: 12px; height: 12px;"></div>
                                    <small>Unanswered</small>
                                </div>
                            </div>
                            
                            <div class="quiz-stats mt-4">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <div class="bg-light rounded p-2">
                                            <h6 class="mb-1" id="answeredCount">0</h6>
                                            <small class="text-muted">Answered</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="bg-light rounded p-2">
                                            <h6 class="mb-1" id="reviewCount">0</h6>
                                            <small class="text-muted">For Review</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="bg-light rounded p-2">
                                            <h6 class="mb-1" id="unansweredCount"><?= count($quiz['questions']) ?></h6>
                                            <small class="text-muted">Unanswered</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" id="sidebarSubmitQuizBtn" class="btn btn-success btn-lg w-100 mt-4">
                                <i class="fas fa-check-circle me-1"></i> Submit Quiz
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="submitConfirmModal" tabindex="-1" aria-labelledby="submitConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submitConfirmModalLabel">Submit Quiz?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to submit your quiz?</p>
                <div id="submitWarnings">
                    <!-- Warning messages will be added here via JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmSubmitBtn">Yes, Submit Quiz</button>
            </div>
        </div>
    </div>
</div>

<!-- Warning Modal -->
<div class="modal fade" id="leaveWarningModal" tabindex="-1" aria-labelledby="leaveWarningModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="leaveWarningModalLabel">Warning!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>You are about to leave this page. Any unsaved progress in this quiz will be lost.</p>
                <p>Are you sure you want to continue?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Stay on Page</button>
                <a href="#" id="confirmLeaveBtn" class="btn btn-danger">Leave Page</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quizForm = document.getElementById('quizForm');
    const questions = document.querySelectorAll('.quiz-question');
    const prevQuestionBtn = document.getElementById('prevQuestionBtn');
    const nextQuestionBtn = document.getElementById('nextQuestionBtn');
    const submitQuizBtnContainer = document.getElementById('submitQuizBtnContainer');
    const submitQuizBtn = document.getElementById('submitQuizBtn');
    const sidebarSubmitQuizBtn = document.getElementById('sidebarSubmitQuizBtn');
    const markForReviewBtn = document.getElementById('markForReviewBtn');
    const confirmSubmitBtn = document.getElementById('confirmSubmitBtn');
    const currentQuestionNumber = document.getElementById('currentQuestionNumber');
    const progressBar = document.getElementById('progressBar');
    const progressPercentage = document.getElementById('progressPercentage');
    const questionOverviewItems = document.querySelectorAll('.question-overview-item');
    const questionNavItems = document.querySelectorAll('.question-nav-item');
    const answeredCount = document.getElementById('answeredCount');
    const reviewCount = document.getElementById('reviewCount');
    const unansweredCount = document.getElementById('unansweredCount');
    const confirmLeaveBtn = document.getElementById('confirmLeaveBtn');
    
    let currentQuestionIndex = 0;
    const totalQuestions = questions.length;
    let questionStatuses = Array(totalQuestions).fill('unanswered');
    
    // Timer functionality
    const quizTimer = document.getElementById('quizTimer');
    let timerInterval;
    
    if (quizTimer) {
        const timeLimit = parseInt(quizTimer.getAttribute('data-time-limit'));
        let remainingTime = timeLimit;
        
        timerInterval = setInterval(function() {
            remainingTime--;
            
            if (remainingTime <= 0) {
                clearInterval(timerInterval);
                alert('Time is up! Your quiz will be submitted automatically.');
                submitQuiz();
                return;
            }
            
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            
            quizTimer.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            // Warning when 1 minute remaining
            if (remainingTime === 60) {
                alert('You have 1 minute remaining!');
            }
        }, 1000);
    }
    
    // Show a specific question
    function showQuestion(index) {
        questions.forEach((question, i) => {
            if (i === index) {
                question.classList.remove('d-none');
            } else {
                question.classList.add('d-none');
            }
        });
        
        currentQuestionIndex = index;
        currentQuestionNumber.textContent = index + 1;
        
        // Update navigation buttons
        prevQuestionBtn.disabled = index === 0;
        
        if (index === totalQuestions - 1) {
            nextQuestionBtn.classList.add('d-none');
            submitQuizBtnContainer.classList.remove('d-none');
        } else {
            nextQuestionBtn.classList.remove('d-none');
            submitQuizBtnContainer.classList.add('d-none');
        }
        
        // Update progress
        const progress = Math.round(((index + 1) / totalQuestions) * 100);
        progressBar.style.width = `${progress}%`;
        progressBar.setAttribute('aria-valuenow', progress);
        progressPercentage.textContent = `${progress}%`;
        
        // Update review button
        updateMarkForReviewButton();
    }
    
    // Initialize
    showQuestion(0);
    updateQuestionStatuses();
    
    // Previous question button
    prevQuestionBtn.addEventListener('click', function() {
        if (currentQuestionIndex > 0) {
            showQuestion(currentQuestionIndex - 1);
        }
    });
    
    // Next question button
    nextQuestionBtn.addEventListener('click', function() {
        if (currentQuestionIndex < totalQuestions - 1) {
            showQuestion(currentQuestionIndex + 1);
        }
    });
    
    // Mark for review button
    markForReviewBtn.addEventListener('click', function() {
        const status = questionStatuses[currentQuestionIndex];
        
        if (status === 'review' || status === 'answered_review') {
            questionStatuses[currentQuestionIndex] = status === 'review' ? 'unanswered' : 'answered';
        } else {
            questionStatuses[currentQuestionIndex] = status === 'unanswered' ? 'review' : 'answered_review';
        }
        
        updateQuestionStatuses();
        updateMarkForReviewButton();
    });
    
    function updateMarkForReviewButton() {
        const status = questionStatuses[currentQuestionIndex];
        
        if (status === 'review' || status === 'answered_review') {
            markForReviewBtn.innerHTML = '<i class="fas fa-flag-checkered me-1"></i> Unmark Review';
            markForReviewBtn.classList.remove('btn-outline-warning');
            markForReviewBtn.classList.add('btn-warning');
        } else {
            markForReviewBtn.innerHTML = '<i class="fas fa-flag me-1"></i> Mark for Review';
            markForReviewBtn.classList.remove('btn-warning');
            markForReviewBtn.classList.add('btn-outline-warning');
        }
    }
    
    // Question navigation items
    questionOverviewItems.forEach((item, index) => {
        item.addEventListener('click', function() {
            showQuestion(index);
        });
    });
    
    questionNavItems.forEach((item, index) => {
        item.addEventListener('click', function() {
            showQuestion(index);
        });
    });
    
    // Track answer changes
    const answerInputs = document.querySelectorAll('input[type="radio"], input[type="checkbox"], input[type="text"], textarea, select');
    answerInputs.forEach(input => {
        input.addEventListener('change', function() {
            const questionIndex = parseInt(this.closest('.quiz-question').getAttribute('data-question-index'));
            const status = questionStatuses[questionIndex];
            
            questionStatuses[questionIndex] = status === 'review' ? 'answered_review' : 'answered';
            updateQuestionStatuses();
        });
    });
    
    // Update question statuses
    function updateQuestionStatuses() {
        // Count different statuses
        let answered = 0;
        let review = 0;
        
        questionStatuses.forEach((status, index) => {
            const overviewItem = questionOverviewItems[index];
            const navItem = questionNavItems[index];
            const navItemStatus = navItem.querySelector('.question-status');
            
            // Reset classes
            overviewItem.className = 'btn question-overview-item';
            
            if (status === 'answered' || status === 'answered_review') {
                answered++;
            }
            
            if (status === 'review' || status === 'answered_review') {
                review++;
                overviewItem.classList.add('btn-warning');
                navItemStatus.innerHTML = '<i class="fas fa-flag text-warning"></i>';
            } else if (status === 'answered') {
                overviewItem.classList.add('btn-success');
                navItemStatus.innerHTML = '<i class="fas fa-check text-success"></i>';
            } else {
                overviewItem.classList.add('btn-outline-secondary');
                navItemStatus.innerHTML = '';
            }
            
            // Highlight current question
            if (index === currentQuestionIndex) {
                overviewItem.classList.add('border-primary', 'border-2');
            }
        });
        
        // Update counters
        answeredCount.textContent = answered;
        reviewCount.textContent = review;
        unansweredCount.textContent = totalQuestions - answered;
    }
    
    // Submit quiz buttons
    submitQuizBtn.addEventListener('click', function() {
        confirmSubmit();
    });
    
    sidebarSubmitQuizBtn.addEventListener('click', function() {
        confirmSubmit();
    });
    
    // Show confirmation modal with warnings
    function confirmSubmit() {
        const submitWarnings = document.getElementById('submitWarnings');
        submitWarnings.innerHTML = '';
        
        const unansweredQuestions = questionStatuses.filter(status => status === 'unanswered' || status === 'review').length;
        const reviewQuestions = questionStatuses.filter(status => status === 'review' || status === 'answered_review').length;
        
        if (unansweredQuestions > 0) {
            const warning = document.createElement('div');
            warning.className = 'alert alert-warning';
            warning.innerHTML = `<i class="fas fa-exclamation-triangle me-2"></i> You have ${unansweredQuestions} unanswered question(s).`;
            submitWarnings.appendChild(warning);
        }
        
        if (reviewQuestions > 0) {
            const warning = document.createElement('div');
            warning.className = 'alert alert-warning';
            warning.innerHTML = `<i class="fas fa-flag me-2"></i> You have ${reviewQuestions} question(s) marked for review.`;
            submitWarnings.appendChild(warning);
        }
        
        const submitConfirmModal = new bootstrap.Modal(document.getElementById('submitConfirmModal'));
        submitConfirmModal.show();
    }
    
    // Confirm submission
    confirmSubmitBtn.addEventListener('click', function() {
        submitQuiz();
    });
    
    // Submit quiz function
    function submitQuiz() {
        // Stop timer if it exists
        if (timerInterval) {
            clearInterval(timerInterval);
        }
        
        // Submit the form
        quizForm.submit();
    }
    
    // Page leave warning
    const courseLinks = document.querySelectorAll('a:not([href^="#"]):not([href^="javascript"])');
    courseLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to leave the quiz? Your progress will be lost.')) {
                e.preventDefault();
            }
        });
    });
    
    // Handle browser back/forward buttons
    window.addEventListener('beforeunload', function(e) {
        const message = 'You have unsaved changes. Are you sure you want to leave?';
        e.returnValue = message;
        return message;
    });
});
</script>
