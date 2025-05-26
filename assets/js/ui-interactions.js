/*
 * EduLearn LMS - UI Interactions
 * Version: 1.0
 * Created: May 25, 2025
 */

document.addEventListener("DOMContentLoaded", function () {
	// Toast Notifications
	initToastNotifications();

	// Dark Mode Toggle
	initDarkModeToggle();

	// Course View Toggle (Grid/List)
	initCourseViewToggle();

	// Mobile Menu Toggle
	initMobileMenu();

	// Learning Sidebar Toggle
	initLearningSidebar();

	// Custom File Upload
	initCustomFileUpload();

	// Course Filter Mobile Toggle
	initCourseFilterToggle();

	// Initialize Tooltips
	initTooltips();

	// Initialize Skeleton Loaders
	initSkeletonLoaders();

	// Initialize Animated Elements
	initAnimatedElements();
});

// Toast Notifications
function initToastNotifications() {
	// Create toast container if it doesn't exist
	if (!document.querySelector(".toast-container")) {
		const toastContainer = document.createElement("div");
		toastContainer.className = "toast-container";
		document.body.appendChild(toastContainer);
	}

	// Function to show toast
	window.showToast = function (type, title, message, duration = 5000) {
		const toastContainer = document.querySelector(".toast-container");

		// Create toast element
		const toast = document.createElement("div");
		toast.className = `toast-notification toast-${type}`;

		// Set toast HTML
		toast.innerHTML = `
            <div class="toast-icon-container">
                <i class="fas ${getToastIcon(type)}"></i>
            </div>
            <div class="toast-content">
                <div class="toast-title">${title}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close">
                <i class="fas fa-times"></i>
            </button>
        `;

		// Add toast to container
		toastContainer.appendChild(toast);

		// Add close event
		toast.querySelector(".toast-close").addEventListener("click", () => {
			closeToast(toast);
		});

		// Auto close after duration
		setTimeout(() => {
			closeToast(toast);
		}, duration);
	};

	function closeToast(toast) {
		toast.classList.add("toast-closing");
		setTimeout(() => {
			toast.remove();
		}, 300);
	}

	function getToastIcon(type) {
		switch (type) {
			case "success":
				return "fa-check-circle";
			case "error":
				return "fa-exclamation-circle";
			case "warning":
				return "fa-exclamation-triangle";
			case "info":
				return "fa-info-circle";
			default:
				return "fa-info-circle";
		}
	}
}

// Dark Mode Toggle
function initDarkModeToggle() {
	const darkModeToggle = document.querySelector(".dark-mode-toggle");

	if (darkModeToggle) {
		// Check for saved theme preference or respect OS preference
		const savedTheme = localStorage.getItem("theme");
		const prefersDark = window.matchMedia(
			"(prefers-color-scheme: dark)"
		).matches;

		if (savedTheme === "dark" || (!savedTheme && prefersDark)) {
			document.body.classList.add("dark-mode");
			darkModeToggle.checked = true;
		}

		// Toggle dark mode on change
		darkModeToggle.addEventListener("change", function () {
			if (this.checked) {
				document.body.classList.add("dark-mode");
				localStorage.setItem("theme", "dark");
			} else {
				document.body.classList.remove("dark-mode");
				localStorage.setItem("theme", "light");
			}
		});
	}
}

// Course View Toggle (Grid/List)
function initCourseViewToggle() {
	const gridViewBtn = document.querySelector(".grid-view-btn");
	const listViewBtn = document.querySelector(".list-view-btn");
	const courseGrid = document.querySelector(".course-grid");

	if (gridViewBtn && listViewBtn && courseGrid) {
		// Check for saved view preference
		const savedView = localStorage.getItem("courseView");

		if (savedView === "list") {
			courseGrid.classList.add("list-view");
			listViewBtn.classList.add("active");
			gridViewBtn.classList.remove("active");
		} else {
			courseGrid.classList.remove("list-view");
			gridViewBtn.classList.add("active");
			listViewBtn.classList.remove("active");
		}

		// Toggle grid view
		gridViewBtn.addEventListener("click", function () {
			courseGrid.classList.remove("list-view");
			gridViewBtn.classList.add("active");
			listViewBtn.classList.remove("active");
			localStorage.setItem("courseView", "grid");
		});

		// Toggle list view
		listViewBtn.addEventListener("click", function () {
			courseGrid.classList.add("list-view");
			listViewBtn.classList.add("active");
			gridViewBtn.classList.remove("active");
			localStorage.setItem("courseView", "list");
		});
	}
}

// Mobile Menu Toggle
function initMobileMenu() {
	const navbarToggler = document.querySelector(".navbar-toggler");
	const navbarCollapse = document.querySelector(".navbar-collapse");

	if (navbarToggler && navbarCollapse) {
		navbarToggler.addEventListener("click", function () {
			navbarCollapse.classList.toggle("show");
			this.classList.toggle("active");

			// Add backdrop for mobile menu
			if (navbarCollapse.classList.contains("show")) {
				const backdrop = document.createElement("div");
				backdrop.className = "navbar-backdrop";
				backdrop.style.cssText =
					"position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.5); z-index: 1020;";
				document.body.appendChild(backdrop);

				backdrop.addEventListener("click", function () {
					navbarCollapse.classList.remove("show");
					navbarToggler.classList.remove("active");
					this.remove();
				});
			} else {
				const backdrop = document.querySelector(".navbar-backdrop");
				if (backdrop) backdrop.remove();
			}
		});
	}
}

// Learning Sidebar Toggle
function initLearningSidebar() {
	const sidebarToggle = document.querySelector(".sidebar-toggle");
	const learningSidebar = document.querySelector(".learning-sidebar");

	if (sidebarToggle && learningSidebar) {
		sidebarToggle.addEventListener("click", function () {
			learningSidebar.classList.toggle("sidebar-open");

			// Add backdrop for mobile sidebar
			if (learningSidebar.classList.contains("sidebar-open")) {
				const backdrop = document.createElement("div");
				backdrop.className = "sidebar-backdrop";
				backdrop.style.cssText =
					"position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.5); z-index: 1040;";
				document.body.appendChild(backdrop);

				backdrop.addEventListener("click", function () {
					learningSidebar.classList.remove("sidebar-open");
					this.remove();
				});
			} else {
				const backdrop = document.querySelector(".sidebar-backdrop");
				if (backdrop) backdrop.remove();
			}
		});
	}
}

// Custom File Upload
function initCustomFileUpload() {
	const customFileInputs = document.querySelectorAll(
		'.custom-file-upload input[type="file"]'
	);

	customFileInputs.forEach((input) => {
		const fileNameDisplay = input.parentElement.querySelector(
			".custom-file-upload-name"
		);

		if (fileNameDisplay) {
			input.addEventListener("change", function () {
				if (this.files.length > 0) {
					fileNameDisplay.textContent = this.files[0].name;
				} else {
					fileNameDisplay.textContent = "No file chosen";
				}
			});
		}
	});
}

// Course Filter Mobile Toggle
function initCourseFilterToggle() {
	const filterToggle = document.querySelector(".filter-toggle");
	const courseFilters = document.querySelector(".course-filters");

	if (filterToggle && courseFilters) {
		filterToggle.addEventListener("click", function () {
			courseFilters.classList.toggle("filters-open");

			// Add backdrop for mobile filters
			if (courseFilters.classList.contains("filters-open")) {
				const backdrop = document.createElement("div");
				backdrop.className = "filters-backdrop";
				backdrop.style.cssText =
					"position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.5); z-index: 1030;";
				document.body.appendChild(backdrop);

				backdrop.addEventListener("click", function () {
					courseFilters.classList.remove("filters-open");
					this.remove();
				});
			} else {
				const backdrop = document.querySelector(".filters-backdrop");
				if (backdrop) backdrop.remove();
			}
		});
	}
}

// Initialize Tooltips
function initTooltips() {
	const tooltips = document.querySelectorAll(".tooltip-custom");

	tooltips.forEach((tooltip) => {
		// Set position relative if not already set
		if (getComputedStyle(tooltip).position === "static") {
			tooltip.style.position = "relative";
		}
	});
}

// Initialize Skeleton Loaders
function initSkeletonLoaders() {
	// Replace skeleton loaders with content when loaded
	const skeletonItems = document.querySelectorAll(".skeleton-loader");

	if (skeletonItems.length > 0) {
		window.addEventListener("load", function () {
			setTimeout(() => {
				skeletonItems.forEach((item) => {
					item.classList.remove("skeleton-loader");
				});
			}, 500);
		});
	}
}

// Initialize Animated Elements
function initAnimatedElements() {
	// Add stagger animation class after page load
	const staggerContainers = document.querySelectorAll(".stagger-container");

	if (staggerContainers.length > 0) {
		window.addEventListener("load", function () {
			setTimeout(() => {
				staggerContainers.forEach((container) => {
					container.classList.add("stagger-appear");
				});
			}, 300);
		});
	}

	// Initialize intersection observer for fade-in-up animations
	const fadeElements = document.querySelectorAll(".fade-in-up");

	if (fadeElements.length > 0 && "IntersectionObserver" in window) {
		const fadeObserver = new IntersectionObserver(
			(entries) => {
				entries.forEach((entry) => {
					if (entry.isIntersecting) {
						entry.target.style.opacity = "1";
						entry.target.style.transform = "translateY(0)";
						fadeObserver.unobserve(entry.target);
					}
				});
			},
			{ threshold: 0.1 }
		);

		fadeElements.forEach((element) => {
			element.style.opacity = "0";
			element.style.transform = "translateY(30px)";
			element.style.transition = "opacity 0.6s ease, transform 0.6s ease";
			fadeObserver.observe(element);
		});
	} else {
		// Fallback for browsers without Intersection Observer
		fadeElements.forEach((element) => {
			element.style.opacity = "1";
			element.style.transform = "translateY(0)";
		});
	}
}

// Function to create confetti effect on achievements
window.createConfetti = function (container) {
	const confettiContainer = document.createElement("div");
	confettiContainer.className = "confetti-container";
	document.body.appendChild(confettiContainer);

	const colors = ["#f39c12", "#3498db", "#2ecc71", "#e74c3c", "#9b59b6"];

	// Create confetti pieces
	for (let i = 0; i < 100; i++) {
		const confetti = document.createElement("div");
		confetti.className = "confetti";
		confetti.style.backgroundColor =
			colors[Math.floor(Math.random() * colors.length)];
		confetti.style.left = Math.random() * 100 + "vw";
		confetti.style.animationDuration = Math.random() * 3 + 2 + "s";
		confetti.style.animationDelay = Math.random() * 2 + "s";
		confetti.style.width = Math.random() * 10 + 5 + "px";
		confetti.style.height = Math.random() * 10 + 5 + "px";

		confettiContainer.appendChild(confetti);
	}

	// Remove confetti after animation
	setTimeout(() => {
		confettiContainer.remove();
	}, 6000);
};
