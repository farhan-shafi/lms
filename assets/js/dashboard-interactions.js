/**
 * EduLearn LMS - Dashboard Interactions
 *
 * This file contains JS functionality specific to the dashboards
 */

document.addEventListener("DOMContentLoaded", function () {
	// Charts initialization
	initDashboardCharts();

	// Sidebar toggle functionality for responsive views
	const sidebarToggle = document.querySelector(".sidebar-toggle");
	if (sidebarToggle) {
		sidebarToggle.addEventListener("click", function () {
			document.querySelector(".sidebar").classList.toggle("show");
		});
	}

	// Initialize tooltips
	if (typeof bootstrap !== "undefined") {
		var tooltipTriggerList = [].slice.call(
			document.querySelectorAll('[data-bs-toggle="tooltip"]')
		);
		tooltipTriggerList.map(function (tooltipTriggerEl) {
			return new bootstrap.Tooltip(tooltipTriggerEl);
		});
	}
});

/**
 * Initialize dashboard charts
 */
function initDashboardCharts() {
	// Only initialize charts if Chart.js is loaded and we have canvas elements
	if (typeof Chart === "undefined") return;

	// Admin dashboard charts
	initAdminCharts();

	// Instructor dashboard charts
	initInstructorCharts();

	// Student dashboard charts
	initStudentCharts();
}

/**
 * Initialize admin dashboard charts
 */
function initAdminCharts() {
	const userStatsChart = document.getElementById("userStatsChart");
	if (userStatsChart) {
		new Chart(userStatsChart, {
			type: "line",
			data: {
				labels: [
					"Jan",
					"Feb",
					"Mar",
					"Apr",
					"May",
					"Jun",
					"Jul",
					"Aug",
					"Sep",
					"Oct",
					"Nov",
					"Dec",
				],
				datasets: [
					{
						label: "New Users",
						data: [50, 60, 70, 65, 80, 90, 85, 95, 100, 110, 115, 130],
						borderColor: "#4e73df",
						backgroundColor: "rgba(78, 115, 223, 0.05)",
						tension: 0.3,
						fill: true,
					},
				],
			},
			options: {
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: false,
					},
				},
				scales: {
					y: {
						beginAtZero: true,
						grid: {
							color: "rgba(0, 0, 0, 0.05)",
						},
					},
					x: {
						grid: {
							display: false,
						},
					},
				},
			},
		});
	}

	const revenueChart = document.getElementById("revenueChart");
	if (revenueChart) {
		new Chart(revenueChart, {
			type: "bar",
			data: {
				labels: [
					"Jan",
					"Feb",
					"Mar",
					"Apr",
					"May",
					"Jun",
					"Jul",
					"Aug",
					"Sep",
					"Oct",
					"Nov",
					"Dec",
				],
				datasets: [
					{
						label: "Revenue",
						data: [
							5000, 6000, 7500, 8000, 9000, 9500, 10000, 11000, 10500, 12000,
							12500, 13000,
						],
						backgroundColor: "#1cc88a",
					},
				],
			},
			options: {
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: false,
					},
				},
				scales: {
					y: {
						beginAtZero: true,
						grid: {
							color: "rgba(0, 0, 0, 0.05)",
						},
					},
					x: {
						grid: {
							display: false,
						},
					},
				},
			},
		});
	}
}

/**
 * Initialize instructor dashboard charts
 */
function initInstructorCharts() {
	const courseEnrollmentsChart = document.getElementById(
		"courseEnrollmentsChart"
	);
	if (courseEnrollmentsChart) {
		new Chart(courseEnrollmentsChart, {
			type: "line",
			data: {
				labels: [
					"Jan",
					"Feb",
					"Mar",
					"Apr",
					"May",
					"Jun",
					"Jul",
					"Aug",
					"Sep",
					"Oct",
					"Nov",
					"Dec",
				],
				datasets: [
					{
						label: "Course Enrollments",
						data: [20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75],
						borderColor: "#4e73df",
						backgroundColor: "rgba(78, 115, 223, 0.05)",
						tension: 0.3,
						fill: true,
					},
				],
			},
			options: {
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: false,
					},
				},
				scales: {
					y: {
						beginAtZero: true,
						grid: {
							color: "rgba(0, 0, 0, 0.05)",
						},
					},
					x: {
						grid: {
							display: false,
						},
					},
				},
			},
		});
	}

	const earningsChart = document.getElementById("earningsChart");
	if (earningsChart) {
		new Chart(earningsChart, {
			type: "bar",
			data: {
				labels: [
					"Jan",
					"Feb",
					"Mar",
					"Apr",
					"May",
					"Jun",
					"Jul",
					"Aug",
					"Sep",
					"Oct",
					"Nov",
					"Dec",
				],
				datasets: [
					{
						label: "Earnings",
						data: [
							500, 650, 700, 800, 950, 1000, 1100, 1150, 1200, 1250, 1300, 1400,
						],
						backgroundColor: "#1cc88a",
					},
				],
			},
			options: {
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: false,
					},
				},
				scales: {
					y: {
						beginAtZero: true,
						grid: {
							color: "rgba(0, 0, 0, 0.05)",
						},
					},
					x: {
						grid: {
							display: false,
						},
					},
				},
			},
		});
	}
}

/**
 * Initialize student dashboard charts
 */
function initStudentCharts() {
	const courseProgressChart = document.getElementById("courseProgressChart");
	if (courseProgressChart) {
		new Chart(courseProgressChart, {
			type: "doughnut",
			data: {
				labels: ["Completed", "In Progress", "Not Started"],
				datasets: [
					{
						data: [65, 25, 10],
						backgroundColor: ["#1cc88a", "#f6c23e", "#e74a3b"],
						hoverBackgroundColor: ["#17a673", "#dda20a", "#be2617"],
						hoverBorderColor: "rgba(234, 236, 244, 1)",
					},
				],
			},
			options: {
				maintainAspectRatio: false,
				cutout: "75%",
				plugins: {
					legend: {
						position: "bottom",
					},
				},
			},
		});
	}

	const studyTimeChart = document.getElementById("studyTimeChart");
	if (studyTimeChart) {
		new Chart(studyTimeChart, {
			type: "bar",
			data: {
				labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
				datasets: [
					{
						label: "Hours Studied",
						data: [2.5, 3, 2, 4, 1.5, 5, 3.5],
						backgroundColor: "#4e73df",
					},
				],
			},
			options: {
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: false,
					},
				},
				scales: {
					y: {
						beginAtZero: true,
						grid: {
							color: "rgba(0, 0, 0, 0.05)",
						},
					},
					x: {
						grid: {
							display: false,
						},
					},
				},
			},
		});
	}
}
