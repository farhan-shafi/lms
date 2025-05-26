/**
 * EduLearn LMS - Main JavaScript
 * Version 1.0
 */

(function () {
	"use strict";

	// DOM Elements
	const navbar = document.querySelector(".navbar");
	const toTopBtn = document.getElementById("to-top-btn");

	// Document Ready Function
	document.addEventListener("DOMContentLoaded", function () {
		// Initialize Bootstrap tooltips
		initializeTooltips();

		// Initialize toast notifications
		initializeToasts();

		// Initialize dropdowns
		initializeDropdowns();

		// Initialize course video player controls
		initializeVideoPlayers();

		// Add any other initialization functions here
	});

	// Add shadow to navbar on scroll
	window.addEventListener("scroll", function () {
		if (window.scrollY > 50) {
			navbar.classList.add("shadow");
		} else {
			navbar.classList.remove("shadow");
		}

		// Show/hide back to top button
		if (toTopBtn) {
			if (window.scrollY > 300) {
				toTopBtn.classList.add("show");
			} else {
				toTopBtn.classList.remove("show");
			}
		}
	});

	// Initialize tooltips
	const tooltipTriggerList = [].slice.call(
		document.querySelectorAll('[data-bs-toggle="tooltip"]')
	);
	tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl);
	});

	// Initialize popovers
	const popoverTriggerList = [].slice.call(
		document.querySelectorAll('[data-bs-toggle="popover"]')
	);
	popoverTriggerList.map(function (popoverTriggerEl) {
		return new bootstrap.Popover(popoverTriggerEl);
	});

	// Smooth scroll for anchor links
	document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
		anchor.addEventListener("click", function (e) {
			const target = document.querySelector(this.getAttribute("href"));
			if (target) {
				e.preventDefault();
				target.scrollIntoView({
					behavior: "smooth",
				});
			}
		});
	});

	// Auto-dismiss alerts
	const autoAlerts = document.querySelectorAll(
		".alert-dismissible.auto-dismiss"
	);
	autoAlerts.forEach((alert) => {
		setTimeout(() => {
			const bsAlert = new bootstrap.Alert(alert);
			bsAlert.close();
		}, 5000);
	});

	// Course search filter
	const searchInput = document.getElementById("course-search");
	const courseCards = document.querySelectorAll(".course-card");

	if (searchInput && courseCards.length > 0) {
		searchInput.addEventListener("keyup", function () {
			const searchTerm = this.value.toLowerCase();

			courseCards.forEach((card) => {
				const title = card
					.querySelector(".card-title")
					.textContent.toLowerCase();
				const instructor = card
					.querySelector(".instructor")
					.textContent.toLowerCase();
				const category = card
					.querySelector(".category-badge")
					.textContent.toLowerCase();

				if (
					title.includes(searchTerm) ||
					instructor.includes(searchTerm) ||
					category.includes(searchTerm)
				) {
					card.style.display = "block";
				} else {
					card.style.display = "none";
				}
			});
		});
	}

	// Video player functionality
	const videoPlayers = document.querySelectorAll(".video-player");

	videoPlayers.forEach((player) => {
		const video = player.querySelector("video");
		const playBtn = player.querySelector(".play-btn");

		if (video && playBtn) {
			playBtn.addEventListener("click", function () {
				if (video.paused) {
					video.play();
					playBtn.classList.add("playing");
				} else {
					video.pause();
					playBtn.classList.remove("playing");
				}
			});

			video.addEventListener("ended", function () {
				playBtn.classList.remove("playing");
			});
		}
	});

	// Course rating functionality
	const ratingStars = document.querySelectorAll(".rating-input .star");
	const ratingValue = document.querySelector(
		'.rating-input input[name="rating"]'
	);

	if (ratingStars.length > 0 && ratingValue) {
		ratingStars.forEach((star) => {
			star.addEventListener("click", function () {
				const value = this.dataset.value;
				ratingValue.value = value;

				// Reset all stars
				ratingStars.forEach((s) => s.classList.remove("active"));

				// Add active class to selected stars
				ratingStars.forEach((s) => {
					if (s.dataset.value <= value) {
						s.classList.add("active");
					}
				});
			});
		});
	}

	// Quiz timer functionality
	const quizTimer = document.getElementById("quiz-timer");

	if (quizTimer) {
		const duration = parseInt(quizTimer.dataset.duration) * 60; // Convert minutes to seconds
		let timeLeft = duration;

		const updateTimer = () => {
			const minutes = Math.floor(timeLeft / 60);
			const seconds = timeLeft % 60;

			quizTimer.textContent = `${minutes.toString().padStart(2, "0")}:${seconds
				.toString()
				.padStart(2, "0")}`;

			if (timeLeft <= 300) {
				// 5 minutes or less
				quizTimer.classList.add("text-danger");
			}

			if (timeLeft <= 0) {
				clearInterval(timerInterval);
				document.getElementById("quiz-form").submit();
			}

			timeLeft--;
		};

		updateTimer();
		const timerInterval = setInterval(updateTimer, 1000);
	}

	// File input preview
	const fileInputs = document.querySelectorAll(".custom-file-input");

	fileInputs.forEach((input) => {
		input.addEventListener("change", function () {
			const fileName = this.files[0].name;
			const label = this.nextElementSibling;
			label.textContent = fileName;

			// Image preview if available
			const preview = document.querySelector(this.dataset.preview);
			if (preview && this.files && this.files[0]) {
				const reader = new FileReader();

				reader.onload = function (e) {
					preview.src = e.target.result;
					preview.style.display = "block";
				};

				reader.readAsDataURL(this.files[0]);
			}
		});
	});

	// Password toggle
	const passwordToggles = document.querySelectorAll(".password-toggle");

	passwordToggles.forEach((toggle) => {
		toggle.addEventListener("click", function () {
			const input = this.previousElementSibling;
			const type =
				input.getAttribute("type") === "password" ? "text" : "password";
			input.setAttribute("type", type);

			this.querySelector("i").classList.toggle("fa-eye");
			this.querySelector("i").classList.toggle("fa-eye-slash");
		});
	});

	// Course enrollment confirmation
	const enrollButtons = document.querySelectorAll(".enroll-btn");

	enrollButtons.forEach((button) => {
		button.addEventListener("click", function (e) {
			if (!confirm("Are you sure you want to enroll in this course?")) {
				e.preventDefault();
			}
		});
	});

	// Dynamic form fields
	const addFieldBtn = document.getElementById("add-field");
	const fieldContainer = document.getElementById("dynamic-fields");

	if (addFieldBtn && fieldContainer) {
		addFieldBtn.addEventListener("click", function () {
			const fieldCount = fieldContainer.children.length;

			const fieldGroup = document.createElement("div");
			fieldGroup.className = "input-group mb-3";

			fieldGroup.innerHTML = `
                <input type="text" name="fields[${fieldCount}][key]" class="form-control" placeholder="Key">
                <input type="text" name="fields[${fieldCount}][value]" class="form-control" placeholder="Value">
                <button type="button" class="btn btn-outline-danger remove-field">
                    <i class="fas fa-times"></i>
                </button>
            `;

			fieldContainer.appendChild(fieldGroup);

			// Add event listener to remove button
			const removeBtn = fieldGroup.querySelector(".remove-field");
			removeBtn.addEventListener("click", function () {
				fieldContainer.removeChild(fieldGroup);
			});
		});
	}

	// Initialize existing remove buttons
	document.querySelectorAll(".remove-field").forEach((button) => {
		button.addEventListener("click", function () {
			const fieldGroup = this.parentElement;
			fieldContainer.removeChild(fieldGroup);
		});
	});
})();
