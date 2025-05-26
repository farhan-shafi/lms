/**
 * LMS Course Learning Interface JavaScript
 * This file contains all the client-side functionality for the course learning interface
 */

class CourseLearningInterface {
	constructor() {
		// Elements
		this.sidebarToggle = document.getElementById("sidebar-toggle");
		this.lessonSidebar = document.getElementById("lesson-sidebar");
		this.lessonContent = document.getElementById("lesson-content");
		this.lessonModules = document.querySelectorAll(".module-header");
		this.progressBar = document.getElementById("course-progress-bar");
		this.nextButton = document.getElementById("next-lesson-btn");
		this.prevButton = document.getElementById("prev-lesson-btn");
		this.completeButton = document.getElementById("complete-lesson-btn");
		this.videoPlayer = document.getElementById("video-player");
		this.notesToggle = document.getElementById("notes-toggle");
		this.notesPanel = document.getElementById("notes-panel");
		this.saveNotesBtn = document.getElementById("save-notes-btn");
		this.notesTextarea = document.getElementById("notes-textarea");
		this.discussionForm = document.getElementById("discussion-form");
		this.quizForm = document.getElementById("quiz-form");
		this.quizTimer = document.getElementById("quiz-timer");

		this.courseId =
			document.querySelector("[data-course-id]")?.dataset.courseId;
		this.lessonId =
			document.querySelector("[data-lesson-id]")?.dataset.lessonId;
		this.isQuiz =
			document.querySelector("[data-is-quiz]")?.dataset.isQuiz === "true";
		this.timeLimit =
			document.querySelector("[data-time-limit]")?.dataset.timeLimit;

		this.timerInterval = null;
		this.endTime = null;
		this.lastActivityTime = Date.now();
		this.progressTracking = true;

		this.init();
	}

	init() {
		this.initEventListeners();
		this.initModulesToggles();
		this.initVideoTracking();
		this.handleNotesSaving();

		if (this.isQuiz && this.timeLimit > 0) {
			this.startQuizTimer();
		}

		// Start progress tracking
		if (this.progressTracking) {
			this.trackProgress();
			// Set up activity tracking for progress updates
			window.addEventListener(
				"mousemove",
				() => (this.lastActivityTime = Date.now())
			);
			window.addEventListener(
				"keypress",
				() => (this.lastActivityTime = Date.now())
			);
			window.addEventListener(
				"click",
				() => (this.lastActivityTime = Date.now())
			);
		}
	}

	initEventListeners() {
		// Toggle sidebar
		if (this.sidebarToggle) {
			this.sidebarToggle.addEventListener("click", () => this.toggleSidebar());
		}

		// Navigation buttons
		if (this.nextButton) {
			this.nextButton.addEventListener("click", (e) =>
				this.navigateToLesson(e, "next")
			);
		}

		if (this.prevButton) {
			this.prevButton.addEventListener("click", (e) =>
				this.navigateToLesson(e, "prev")
			);
		}

		// Complete lesson button
		if (this.completeButton) {
			this.completeButton.addEventListener("click", (e) =>
				this.completeLesson(e)
			);
		}

		// Notes toggle
		if (this.notesToggle) {
			this.notesToggle.addEventListener("click", () => this.toggleNotes());
		}

		// Save notes
		if (this.saveNotesBtn) {
			this.saveNotesBtn.addEventListener("click", (e) => this.saveNotes(e));
		}

		// Discussion form
		if (this.discussionForm) {
			this.discussionForm.addEventListener("submit", (e) =>
				this.submitDiscussion(e)
			);
		}

		// Quiz form
		if (this.quizForm) {
			this.quizForm.addEventListener("submit", (e) => this.submitQuiz(e));
		}

		// Handle window resize
		window.addEventListener("resize", () => this.handleResize());

		// Prevent accidental navigation away from quiz
		if (this.isQuiz) {
			window.addEventListener("beforeunload", (e) =>
				this.handleQuizNavigation(e)
			);
		}
	}

	initModulesToggles() {
		if (this.lessonModules) {
			this.lessonModules.forEach((moduleHeader) => {
				moduleHeader.addEventListener("click", () => {
					const moduleContent = moduleHeader.nextElementSibling;
					const isExpanded = moduleHeader.classList.contains("expanded");

					if (isExpanded) {
						moduleHeader.classList.remove("expanded");
						moduleContent.style.maxHeight = "0";
					} else {
						moduleHeader.classList.add("expanded");
						moduleContent.style.maxHeight = moduleContent.scrollHeight + "px";
					}
				});

				// Expand the module containing the current lesson
				const currentLesson =
					moduleHeader.nextElementSibling.querySelector(".active");
				if (currentLesson) {
					moduleHeader.classList.add("expanded");
					moduleHeader.nextElementSibling.style.maxHeight =
						moduleHeader.nextElementSibling.scrollHeight + "px";
				}
			});
		}
	}

	toggleSidebar() {
		if (this.lessonSidebar && this.lessonContent) {
			document.body.classList.toggle("sidebar-collapsed");

			if (document.body.classList.contains("sidebar-collapsed")) {
				localStorage.setItem("lms_sidebar_collapsed", "true");
			} else {
				localStorage.setItem("lms_sidebar_collapsed", "false");
			}
		}
	}

	handleResize() {
		// Auto-collapse sidebar on small screens
		if (
			window.innerWidth < 768 &&
			!document.body.classList.contains("sidebar-collapsed")
		) {
			document.body.classList.add("sidebar-collapsed");
		}
	}

	navigateToLesson(e, direction) {
		if (e) e.preventDefault();

		if (
			!this.isQuiz ||
			confirm(
				"Are you sure you want to leave the quiz? Your progress will not be saved."
			)
		) {
			const url =
				direction === "next"
					? this.nextButton.getAttribute("href")
					: this.prevButton.getAttribute("href");

			if (url) {
				window.location.href = url;
			}
		}
	}

	completeLesson(e) {
		e.preventDefault();

		const button = this.completeButton;
		const originalText = button.innerHTML;
		button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
		button.disabled = true;

		// Make AJAX request to mark lesson as complete
		fetch(button.getAttribute("href"), {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
				"X-Requested-With": "XMLHttpRequest",
			},
			credentials: "same-origin",
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success) {
					button.classList.remove("btn-primary");
					button.classList.add("btn-success");
					button.innerHTML = '<i class="fas fa-check"></i> Completed';

					// Update progress bar
					if (this.progressBar) {
						this.progressBar.style.width = data.progress + "%";
						this.progressBar.setAttribute("aria-valuenow", data.progress);
						document.getElementById("progress-percentage").textContent =
							data.progress + "%";
					}

					// Update lesson status in sidebar
					const sidebarItem = document.querySelector(
						`.lesson-item[data-lesson-id="${this.lessonId}"]`
					);
					if (sidebarItem) {
						sidebarItem.classList.add("completed");
					}

					// Show next lesson button if it was hidden
					if (this.nextButton && data.next_lesson_url) {
						this.nextButton.classList.remove("d-none");
						this.nextButton.setAttribute("href", data.next_lesson_url);
					}

					// Show completion message if course is completed
					if (data.course_completed) {
						this.showCourseCompletionMessage(data);
					}
				} else {
					button.innerHTML = originalText;
					button.disabled = false;
					alert(data.message || "Failed to complete lesson. Please try again.");
				}
			})
			.catch((error) => {
				console.error("Error:", error);
				button.innerHTML = originalText;
				button.disabled = false;
				alert("An error occurred. Please try again.");
			});
	}

	showCourseCompletionMessage(data) {
		// Create modal for course completion
		const modal = document.createElement("div");
		modal.className = "modal fade";
		modal.id = "courseCompletionModal";
		modal.setAttribute("tabindex", "-1");
		modal.setAttribute("role", "dialog");
		modal.setAttribute("aria-labelledby", "courseCompletionModalLabel");
		modal.setAttribute("aria-hidden", "true");

		modal.innerHTML = `
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="courseCompletionModalLabel">Congratulations!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="completion-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h4>You have successfully completed this course!</h4>
                        <p>We hope you enjoyed the learning experience and gained valuable knowledge.</p>
                        ${
													data.certificate_url
														? `
                            <p>Your certificate is ready for download.</p>
                            <a href="${data.certificate_url}" class="btn btn-success" target="_blank">
                                <i class="fas fa-certificate"></i> Get Your Certificate
                            </a>
                        `
														: ""
												}
                    </div>
                    <div class="modal-footer">
                        <a href="${
													data.dashboard_url
												}" class="btn btn-secondary">Go to Dashboard</a>
                        <a href="${
													data.course_url
												}" class="btn btn-primary">Course Homepage</a>
                    </div>
                </div>
            </div>
        `;

		document.body.appendChild(modal);
		$("#courseCompletionModal").modal("show");
	}

	initVideoTracking() {
		if (this.videoPlayer) {
			// Using HTML5 video API
			this.videoPlayer.addEventListener("timeupdate", () =>
				this.trackVideoProgress()
			);
			this.videoPlayer.addEventListener("ended", () => this.handleVideoEnded());

			// Load saved position if available
			const savedTime = localStorage.getItem(`video_position_${this.lessonId}`);
			if (savedTime) {
				this.videoPlayer.currentTime = parseFloat(savedTime);
			}
		}
	}

	trackVideoProgress() {
		if (this.videoPlayer && this.lessonId) {
			const currentTime = this.videoPlayer.currentTime;
			const duration = this.videoPlayer.duration;

			// Save current position every 5 seconds
			if (currentTime % 5 < 0.5) {
				localStorage.setItem(
					`video_position_${this.lessonId}`,
					currentTime.toString()
				);
			}

			// If video is 80% watched, consider it as completed
			if (
				currentTime / duration >= 0.8 &&
				this.completeButton &&
				!this.completeButton.disabled
			) {
				// Auto-complete the lesson
				this.completeLesson(new Event("auto"));
			}
		}
	}

	handleVideoEnded() {
		// Video has ended, mark as completed
		if (this.completeButton && !this.completeButton.disabled) {
			this.completeLesson(new Event("auto"));
		}

		// Remove saved position
		localStorage.removeItem(`video_position_${this.lessonId}`);
	}

	toggleNotes() {
		if (this.notesPanel) {
			this.notesPanel.classList.toggle("show");

			if (this.notesPanel.classList.contains("show")) {
				this.notesToggle.innerHTML = '<i class="fas fa-times"></i> Hide Notes';
			} else {
				this.notesToggle.innerHTML =
					'<i class="fas fa-sticky-note"></i> Show Notes';
			}
		}
	}

	handleNotesSaving() {
		// Auto-save notes while typing (debounced)
		if (this.notesTextarea) {
			let timeout;
			this.notesTextarea.addEventListener("input", () => {
				clearTimeout(timeout);
				timeout = setTimeout(() => {
					this.saveNotes(null, true);
				}, 1000);
			});

			// Load saved notes
			const savedNotes = localStorage.getItem(`lesson_notes_${this.lessonId}`);
			if (savedNotes) {
				this.notesTextarea.value = savedNotes;
			}
		}
	}

	saveNotes(e, isAutoSave = false) {
		if (e) e.preventDefault();

		const notes = this.notesTextarea.value;

		// Save to localStorage
		localStorage.setItem(`lesson_notes_${this.lessonId}`, notes);

		// Save to server
		if (!isAutoSave || notes.length > 100) {
			const saveUrl = this.saveNotesBtn.getAttribute("data-url");

			fetch(saveUrl, {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
					"X-Requested-With": "XMLHttpRequest",
				},
				body: JSON.stringify({
					lesson_id: this.lessonId,
					notes: notes,
				}),
				credentials: "same-origin",
			})
				.then((response) => response.json())
				.then((data) => {
					if (!isAutoSave) {
						if (data.success) {
							this.showToast("Notes saved successfully!", "success");
						} else {
							this.showToast(
								"Failed to save notes. Please try again.",
								"error"
							);
						}
					}
				})
				.catch((error) => {
					console.error("Error saving notes:", error);
					if (!isAutoSave) {
						this.showToast("Error saving notes. Please try again.", "error");
					}
				});
		}
	}

	submitDiscussion(e) {
		e.preventDefault();

		const form = this.discussionForm;
		const submitBtn = form.querySelector('button[type="submit"]');
		const originalText = submitBtn.innerHTML;
		submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Posting...';
		submitBtn.disabled = true;

		const formData = new FormData(form);

		fetch(form.action, {
			method: "POST",
			body: formData,
			credentials: "same-origin",
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success) {
					// Add the new comment to the list
					const commentsList = document.getElementById("comments-list");
					if (commentsList) {
						const newComment = document.createElement("div");
						newComment.className = "comment-item";
						newComment.innerHTML = data.comment_html;
						commentsList.prepend(newComment);

						// Clear the form
						form.reset();
					}

					this.showToast("Comment posted successfully!", "success");
				} else {
					this.showToast(
						data.message || "Failed to post comment. Please try again.",
						"error"
					);
				}

				submitBtn.innerHTML = originalText;
				submitBtn.disabled = false;
			})
			.catch((error) => {
				console.error("Error posting comment:", error);
				submitBtn.innerHTML = originalText;
				submitBtn.disabled = false;
				this.showToast("An error occurred. Please try again.", "error");
			});
	}

	startQuizTimer() {
		if (this.quizTimer && this.timeLimit > 0) {
			// Check if there's a saved end time
			const savedEndTime = sessionStorage.getItem(
				`quiz_end_time_${this.lessonId}`
			);

			if (savedEndTime) {
				this.endTime = new Date(parseInt(savedEndTime));
			} else {
				// Set end time
				this.endTime = new Date(Date.now() + this.timeLimit * 60 * 1000);
				sessionStorage.setItem(
					`quiz_end_time_${this.lessonId}`,
					this.endTime.getTime()
				);
			}

			// Update timer every second
			this.timerInterval = setInterval(() => {
				const now = new Date();
				const diff = this.endTime - now;

				if (diff <= 0) {
					// Time's up
					clearInterval(this.timerInterval);
					this.quizTimer.textContent = "Time's up!";
					this.quizTimer.classList.add("text-danger");

					// Submit the quiz automatically
					if (this.quizForm) {
						this.submitQuiz(new Event("auto"));
					}
				} else {
					// Update the timer display
					const minutes = Math.floor(diff / 1000 / 60);
					const seconds = Math.floor((diff / 1000) % 60);
					this.quizTimer.textContent = `${minutes}:${
						seconds < 10 ? "0" : ""
					}${seconds}`;

					// Add warning class when less than 5 minutes left
					if (diff < 5 * 60 * 1000) {
						this.quizTimer.classList.add("text-danger");
					}
				}
			}, 1000);
		}
	}

	submitQuiz(e) {
		if (e && e.type !== "auto") e.preventDefault();

		const form = this.quizForm;
		const submitBtn = form.querySelector('button[type="submit"]');

		if (submitBtn) {
			const originalText = submitBtn.innerHTML;
			submitBtn.innerHTML =
				'<i class="fas fa-spinner fa-spin"></i> Submitting...';
			submitBtn.disabled = true;
		}

		// Clear timer
		if (this.timerInterval) {
			clearInterval(this.timerInterval);
			sessionStorage.removeItem(`quiz_end_time_${this.lessonId}`);
		}

		const formData = new FormData(form);

		// Add remaining time if there was a time limit
		if (this.endTime) {
			const now = new Date();
			const remainingSeconds = Math.max(
				0,
				Math.floor((this.endTime - now) / 1000)
			);
			formData.append("remaining_time", remainingSeconds);
		}

		fetch(form.action, {
			method: "POST",
			body: formData,
			credentials: "same-origin",
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success) {
					// Redirect to results page
					window.location.href = data.results_url;
				} else {
					if (submitBtn) {
						submitBtn.innerHTML = originalText;
						submitBtn.disabled = false;
					}
					this.showToast(
						data.message || "Failed to submit quiz. Please try again.",
						"error"
					);
				}
			})
			.catch((error) => {
				console.error("Error submitting quiz:", error);
				if (submitBtn) {
					submitBtn.innerHTML = originalText;
					submitBtn.disabled = false;
				}
				this.showToast("An error occurred. Please try again.", "error");
			});
	}

	handleQuizNavigation(e) {
		// Show warning when navigating away from an unfinished quiz
		const formData = new FormData(this.quizForm);
		const hasAnswers = Array.from(formData.entries()).some((entry) =>
			entry[0].startsWith("answer")
		);

		if (hasAnswers) {
			e.preventDefault();
			e.returnValue =
				"You have unsaved quiz answers. Are you sure you want to leave?";
			return e.returnValue;
		}
	}

	trackProgress() {
		// Send progress update to server every minute if user is active
		setInterval(() => {
			if (Date.now() - this.lastActivityTime < 5 * 60 * 1000) {
				// Only if active in the last 5 minutes
				fetch("/course/track_progress", {
					method: "POST",
					headers: {
						"Content-Type": "application/json",
						"X-Requested-With": "XMLHttpRequest",
					},
					body: JSON.stringify({
						course_id: this.courseId,
						lesson_id: this.lessonId,
						time_spent: 60, // Seconds
					}),
					credentials: "same-origin",
				})
					.then((response) => response.json())
					.then((data) => {
						// Update progress silently
						if (data.success && this.progressBar && data.progress) {
							this.progressBar.style.width = data.progress + "%";
							this.progressBar.setAttribute("aria-valuenow", data.progress);
							document.getElementById("progress-percentage").textContent =
								data.progress + "%";
						}
					})
					.catch((error) => {
						console.error("Error tracking progress:", error);
					});
			}
		}, 60 * 1000); // Every minute
	}

	showToast(message, type = "info") {
		const toastContainer = document.getElementById("toast-container");

		if (!toastContainer) {
			const container = document.createElement("div");
			container.id = "toast-container";
			container.className = "toast-container position-fixed bottom-0 end-0 p-3";
			document.body.appendChild(container);
		}

		const toast = document.createElement("div");
		toast.className = `toast toast-${type}`;
		toast.setAttribute("role", "alert");
		toast.setAttribute("aria-live", "assertive");
		toast.setAttribute("aria-atomic", "true");

		toast.innerHTML = `
            <div class="toast-header">
                <strong class="me-auto">${
									type.charAt(0).toUpperCase() + type.slice(1)
								}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        `;

		document.getElementById("toast-container").appendChild(toast);

		const bsToast = new bootstrap.Toast(toast, {
			delay: 5000,
		});
		bsToast.show();

		// Remove toast after it's hidden
		toast.addEventListener("hidden.bs.toast", () => {
			toast.remove();
		});
	}
}

// Initialize when DOM is ready
document.addEventListener("DOMContentLoaded", () => {
	new CourseLearningInterface();
});
