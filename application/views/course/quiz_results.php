<?php
// Quiz results view
// File: /Applications/XAMPP/xamppfiles/htdocs/lms/application/views/course/quiz_results.php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="quiz-results-container py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Results summary card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <?php if($quiz_result['passed']): ?>
                                <div class="results-icon success mb-3">
                                    <i class="fas fa-check-circle text-success fa-5x"></i>
                                </div>
                                <h2 class="text-success">Congratulations!</h2>
                                <p class="lead">You have passed the quiz</p>
                            <?php else: ?>
                                <div class="results-icon failed mb-3">
                                    <i class="fas fa-times-circle text-danger fa-5x"></i>
                                </div>
                                <h2 class="text-danger">Quiz Not Passed</h2>
                                <p class="lead">You did not reach the passing score</p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="row text-center">
                            <div class="col-md-3 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <h4 class="mb-0"><?= $quiz_result['score'] ?>%</h4>
                                    <p class="text-muted mb-0">Your Score</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <h4 class="mb-0"><?= $quiz['passing_score'] ?>%</h4>
                                    <p class="text-muted mb-0">Passing Score</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <h4 class="mb-0"><?= $quiz_result['correct_count'] ?>/<?= $quiz_result['total_questions'] ?></h4>
                                    <p class="text-muted mb-0">Correct Answers</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="p-3 bg-light rounded">
                                    <h4 class="mb-0"><?= $quiz_result['time_taken'] ?></h4>
                                    <p class="text-muted mb-0">Time Taken</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Score gauge chart -->
                        <div class="score-gauge my-4">
                            <div class="progress" style="height: 30px;">
                                <div class="progress-bar <?= $quiz_result['passed'] ? 'bg-success' : 'bg-danger' ?>" 
                                     role="progressbar" style="width: <?= $quiz_result['score'] ?>%;" 
                                     aria-valuenow="<?= $quiz_result['score'] ?>" aria-valuemin="0" aria-valuemax="100">
                                    <?= $quiz_result['score'] ?>%
                                </div>
                                <?php if(!$quiz_result['passed']): ?>
                                    <div class="passing-score-indicator" style="left: <?= $quiz['passing_score'] ?>%;">
                                        <div class="passing-line"></div>
                                        <div class="passing-label bg-primary text-white px-2 py-1 rounded small">
                                            Passing: <?= $quiz['passing_score'] ?>%
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <?php if(!$quiz_result['passed'] && ($quiz['max_attempts'] === null || $quiz_result['attempt_count'] < $quiz['max_attempts'])): ?>
                                <a href="<?= base_url('course/retake-quiz/' . $course_id . '/' . $lesson_id) ?>" class="btn btn-primary me-2">
                                    <i class="fas fa-redo me-1"></i> Retake Quiz
                                </a>
                            <?php endif; ?>
                            
                            <a href="<?= base_url('course/learn/' . $course_id . '/' . $lesson_id) ?>" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-arrow-left me-1"></i> Back to Lesson
                            </a>
                            
                            <a href="<?= base_url('course/learn/' . $course_id) ?>" class="btn btn-outline-primary">
                                <i class="fas fa-book me-1"></i> Continue Course
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Question review -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h4 class="mb-0">Question Review</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="accordion" id="questionReview">
                            <?php foreach($quiz_result['questions'] as $index => $question): ?>
                                <div class="accordion-item mb-3 border">
                                    <h2 class="accordion-header" id="heading<?= $index ?>">
                                        <button class="accordion-button <?= $index > 0 ? 'collapsed' : '' ?>" type="button" 
                                                data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" 
                                                aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" 
                                                aria-controls="collapse<?= $index ?>">
                                            <div class="d-flex align-items-center w-100">
                                                <div class="me-3">
                                                    <?php if($question['is_correct']): ?>
                                                        <span class="badge bg-success rounded-circle">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger rounded-circle">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <div class="flex-grow-1">
                                                    <div class="fw-bold">Question <?= $index + 1 ?></div>
                                                    <div class="text-truncate"><?= $question['question'] ?></div>
                                                </div>
                                                
                                                <div class="ms-3 text-end">
                                                    <?php if($question['is_correct']): ?>
                                                        <span class="text-success">Correct</span>
                                                    <?php else: ?>
                                                        <span class="text-danger">Incorrect</span>
                                                    <?php endif; ?>
                                                    
                                                    <?php if($question['points'] > 0): ?>
                                                        <div class="small text-muted">
                                                            <?= $question['earned_points'] ?>/<?= $question['points'] ?> points
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="collapse<?= $index ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" 
                                         aria-labelledby="heading<?= $index ?>">
                                        <div class="accordion-body">
                                            <div class="question-content mb-4">
                                                <h5 class="mb-3"><?= $question['question'] ?></h5>
                                                
                                                <?php if(!empty($question['image'])): ?>
                                                    <div class="question-image mb-3">
                                                        <img src="<?= base_url('assets/images/quizzes/' . $question['image']) ?>" 
                                                             class="img-fluid rounded" alt="Question Image">
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <?php if($question['type'] == 'multiple_choice' || $question['type'] == 'multiple_answer'): ?>
                                                    <div class="options-list">
                                                        <?php foreach($question['options'] as $option_index => $option): ?>
                                                            <?php
                                                            $is_selected = in_array($option_index, $question['user_answer']);
                                                            $is_correct = in_array($option_index, $question['correct_answer']);
                                                            
                                                            $option_class = '';
                                                            if($is_selected && $is_correct) {
                                                                $option_class = 'bg-success text-white';
                                                            } elseif($is_selected && !$is_correct) {
                                                                $option_class = 'bg-danger text-white';
                                                            } elseif(!$is_selected && $is_correct) {
                                                                $option_class = 'bg-light border-success';
                                                            }
                                                            ?>
                                                            
                                                            <div class="option-item p-3 rounded mb-2 <?= $option_class ?>">
                                                                <div class="d-flex align-items-center">
                                                                    <?php if($is_selected && $is_correct): ?>
                                                                        <i class="fas fa-check-circle text-white me-2"></i>
                                                                    <?php elseif($is_selected && !$is_correct): ?>
                                                                        <i class="fas fa-times-circle text-white me-2"></i>
                                                                    <?php elseif(!$is_selected && $is_correct): ?>
                                                                        <i class="fas fa-check-circle text-success me-2"></i>
                                                                    <?php else: ?>
                                                                        <i class="far fa-circle text-muted me-2"></i>
                                                                    <?php endif; ?>
                                                                    
                                                                    <?= $option ?>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    
                                                <?php elseif($question['type'] == 'true_false'): ?>
                                                    <div class="options-list">
                                                        <?php 
                                                        $user_answer = $question['user_answer'];
                                                        $correct_answer = $question['correct_answer'];
                                                        ?>
                                                        
                                                        <div class="option-item p-3 rounded mb-2 
                                                            <?= $user_answer === 'true' && $correct_answer === 'true' ? 'bg-success text-white' : 
                                                               ($user_answer === 'true' && $correct_answer !== 'true' ? 'bg-danger text-white' : 
                                                               ($user_answer !== 'true' && $correct_answer === 'true' ? 'bg-light border-success' : '')) ?>">
                                                            <div class="d-flex align-items-center">
                                                                <?php if($user_answer === 'true' && $correct_answer === 'true'): ?>
                                                                    <i class="fas fa-check-circle text-white me-2"></i>
                                                                <?php elseif($user_answer === 'true' && $correct_answer !== 'true'): ?>
                                                                    <i class="fas fa-times-circle text-white me-2"></i>
                                                                <?php elseif($user_answer !== 'true' && $correct_answer === 'true'): ?>
                                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                                <?php else: ?>
                                                                    <i class="far fa-circle text-muted me-2"></i>
                                                                <?php endif; ?>
                                                                
                                                                True
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="option-item p-3 rounded mb-2 
                                                            <?= $user_answer === 'false' && $correct_answer === 'false' ? 'bg-success text-white' : 
                                                               ($user_answer === 'false' && $correct_answer !== 'false' ? 'bg-danger text-white' : 
                                                               ($user_answer !== 'false' && $correct_answer === 'false' ? 'bg-light border-success' : '')) ?>">
                                                            <div class="d-flex align-items-center">
                                                                <?php if($user_answer === 'false' && $correct_answer === 'false'): ?>
                                                                    <i class="fas fa-check-circle text-white me-2"></i>
                                                                <?php elseif($user_answer === 'false' && $correct_answer !== 'false'): ?>
                                                                    <i class="fas fa-times-circle text-white me-2"></i>
                                                                <?php elseif($user_answer !== 'false' && $correct_answer === 'false'): ?>
                                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                                <?php else: ?>
                                                                    <i class="far fa-circle text-muted me-2"></i>
                                                                <?php endif; ?>
                                                                
                                                                False
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                <?php elseif($question['type'] == 'short_answer'): ?>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="answer-container mb-3">
                                                                <h6>Your Answer:</h6>
                                                                <div class="p-3 rounded <?= $question['is_correct'] ? 'bg-success text-white' : 'bg-danger text-white' ?>">
                                                                    <?= $question['user_answer'] ? $question['user_answer'] : '<em>No answer provided</em>' ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="answer-container mb-3">
                                                                <h6>Correct Answer:</h6>
                                                                <div class="p-3 rounded bg-light">
                                                                    <?= is_array($question['correct_answer']) ? implode(', ', $question['correct_answer']) : $question['correct_answer'] ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                <?php elseif($question['type'] == 'essay'): ?>
                                                    <div class="answer-container mb-3">
                                                        <h6>Your Answer:</h6>
                                                        <div class="p-3 rounded bg-light">
                                                            <?= $question['user_answer'] ? nl2br($question['user_answer']) : '<em>No answer provided</em>' ?>
                                                        </div>
                                                    </div>
                                                    
                                                    <?php if(isset($question['instructor_feedback']) && !empty($question['instructor_feedback'])): ?>
                                                        <div class="feedback-container mb-3">
                                                            <h6>Instructor Feedback:</h6>
                                                            <div class="p-3 rounded bg-light">
                                                                <?= nl2br($question['instructor_feedback']) ?>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                <?php elseif($question['type'] == 'matching'): ?>
                                                    <div class="matching-answers mb-3">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 40%;">Item</th>
                                                                    <th style="width: 30%;">Your Match</th>
                                                                    <th style="width: 30%;">Correct Match</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach($question['left_options'] as $left_index => $left_option): ?>
                                                                    <?php 
                                                                    $user_match_index = isset($question['user_answer'][$left_index]) ? $question['user_answer'][$left_index] : null;
                                                                    $correct_match_index = $question['correct_answer'][$left_index];
                                                                    $is_correct_match = $user_match_index === $correct_match_index;
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= $left_option ?></td>
                                                                        <td class="<?= $is_correct_match ? 'bg-success text-white' : 'bg-danger text-white' ?>">
                                                                            <?= $user_match_index !== null ? $question['right_options'][$user_match_index] : '<em>No match selected</em>' ?>
                                                                        </td>
                                                                        <td>
                                                                            <?= $question['right_options'][$correct_match_index] ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <?php if(!empty($question['explanation'])): ?>
                                                    <div class="explanation-container mt-4">
                                                        <div class="alert alert-info">
                                                            <h6 class="alert-heading mb-2">Explanation:</h6>
                                                            <?= $question['explanation'] ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation buttons -->
                <div class="text-center mb-4">
                    <?php if(!$quiz_result['passed'] && ($quiz['max_attempts'] === null || $quiz_result['attempt_count'] < $quiz['max_attempts'])): ?>
                        <a href="<?= base_url('course/retake-quiz/' . $course_id . '/' . $lesson_id) ?>" class="btn btn-primary me-2">
                            <i class="fas fa-redo me-1"></i> Retake Quiz
                        </a>
                    <?php endif; ?>
                    
                    <a href="<?= base_url('course/learn/' . $course_id . '/' . $lesson_id) ?>" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i> Back to Lesson
                    </a>
                    
                    <a href="<?= base_url('course/learn/' . $course_id) ?>" class="btn btn-outline-primary">
                        <i class="fas fa-book me-1"></i> Continue Course
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.passing-score-indicator {
    position: absolute;
    top: 0;
    bottom: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.passing-line {
    width: 2px;
    height: 100%;
    background-color: #007bff;
}

.passing-label {
    position: absolute;
    top: -25px;
    transform: translateX(-50%);
    white-space: nowrap;
}
</style>
