/*
 * EduLearn LMS - Theme Customizer
 * Version 1.0
 * Created: May 25, 2025
 */

document.addEventListener("DOMContentLoaded", function () {
	// Initialize Theme Customizer
	initThemeCustomizer();
});

// Theme Customizer Functions
function initThemeCustomizer() {
	// Create theme customizer toggle button if it doesn't exist
	if (!document.querySelector(".theme-customizer-toggle")) {
		createThemeToggleButton();
	}

	// Create theme customizer panel if it doesn't exist
	if (!document.querySelector(".theme-customizer-panel")) {
		createThemeCustomizerPanel();
	}

	// Initialize stored theme settings
	loadSavedThemeSettings();

	// Add event listeners for theme customizer
	addThemeCustomizerEvents();
}

// Create theme toggle button
function createThemeToggleButton() {
	const toggleButton = document.createElement("button");
	toggleButton.className = "theme-customizer-toggle";
	toggleButton.innerHTML = '<i class="fas fa-palette"></i>';
	toggleButton.setAttribute("title", "Customize Theme");
	toggleButton.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: var(--primary-color);
        color: white;
        border: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    `;

	document.body.appendChild(toggleButton);

	// Add hover effect
	toggleButton.addEventListener("mouseenter", function () {
		this.style.transform = "scale(1.1)";
	});

	toggleButton.addEventListener("mouseleave", function () {
		this.style.transform = "scale(1)";
	});
}

// Create theme customizer panel
function createThemeCustomizerPanel() {
	const customizerPanel = document.createElement("div");
	customizerPanel.className = "theme-customizer-panel";
	customizerPanel.style.cssText = `
        position: fixed;
        top: 0;
        right: -300px;
        width: 300px;
        height: 100vh;
        background-color: #fff;
        box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
        z-index: 10000;
        transition: right 0.3s ease;
        padding: 20px;
        overflow-y: auto;
    `;

	// Panel header
	const panelHeader = document.createElement("div");
	panelHeader.style.cssText = `
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    `;

	const panelTitle = document.createElement("h4");
	panelTitle.textContent = "Theme Customizer";
	panelTitle.style.margin = "0";

	const closeButton = document.createElement("button");
	closeButton.className = "theme-customizer-close";
	closeButton.innerHTML = '<i class="fas fa-times"></i>';
	closeButton.style.cssText = `
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        color: #777;
        padding: 5px;
    `;

	panelHeader.appendChild(panelTitle);
	panelHeader.appendChild(closeButton);
	customizerPanel.appendChild(panelHeader);

	// Panel content
	const panelContent = document.createElement("div");

	// Color themes
	const themesSection = document.createElement("div");
	themesSection.className = "customizer-section";
	themesSection.style.marginBottom = "25px";

	const themesTitle = document.createElement("h5");
	themesTitle.textContent = "Color Theme";
	themesTitle.style.marginBottom = "15px";

	const themesGrid = document.createElement("div");
	themesGrid.style.cssText = `
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    `;

	// Add theme options
	const themes = [
		{ name: "default", label: "Blue", color: "#3498db" },
		{ name: "theme-purple", label: "Purple", color: "#9b59b6" },
		{ name: "theme-green", label: "Green", color: "#2ecc71" },
		{ name: "theme-orange", label: "Orange", color: "#e67e22" },
		{ name: "theme-red", label: "Red", color: "#e74c3c" },
		{ name: "theme-teal", label: "Teal", color: "#1abc9c" },
	];

	themes.forEach((theme) => {
		const themeOption = document.createElement("div");
		themeOption.className = "theme-option";
		themeOption.setAttribute("data-theme", theme.name);
		themeOption.style.cssText = `
            cursor: pointer;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        `;

		const themeColor = document.createElement("div");
		themeColor.style.cssText = `
            height: 30px;
            background-color: ${theme.color};
        `;

		const themeLabel = document.createElement("div");
		themeLabel.textContent = theme.label;
		themeLabel.style.cssText = `
            padding: 5px;
            text-align: center;
            font-size: 0.8rem;
        `;

		themeOption.appendChild(themeColor);
		themeOption.appendChild(themeLabel);
		themesGrid.appendChild(themeOption);

		// Add hover effect
		themeOption.addEventListener("mouseenter", function () {
			this.style.transform = "translateY(-3px)";
			this.style.boxShadow = "0 5px 15px rgba(0, 0, 0, 0.1)";
		});

		themeOption.addEventListener("mouseleave", function () {
			this.style.transform = "translateY(0)";
			this.style.boxShadow = "0 2px 5px rgba(0, 0, 0, 0.1)";
		});
	});

	themesSection.appendChild(themesTitle);
	themesSection.appendChild(themesGrid);
	panelContent.appendChild(themesSection);

	// Font options
	const fontSection = document.createElement("div");
	fontSection.className = "customizer-section";
	fontSection.style.marginBottom = "25px";

	const fontTitle = document.createElement("h5");
	fontTitle.textContent = "Font Family";
	fontTitle.style.marginBottom = "15px";

	const fontSelect = document.createElement("select");
	fontSelect.className = "form-control font-select";
	fontSelect.style.width = "100%";

	const fonts = [
		{ value: "", label: "Default (Poppins)" },
		{ value: "font-roboto", label: "Roboto" },
		{ value: "font-montserrat", label: "Montserrat" },
		{ value: "font-lato", label: "Lato" },
		{ value: "font-open-sans", label: "Open Sans" },
	];

	fonts.forEach((font) => {
		const option = document.createElement("option");
		option.value = font.value;
		option.textContent = font.label;
		fontSelect.appendChild(option);
	});

	fontSection.appendChild(fontTitle);
	fontSection.appendChild(fontSelect);
	panelContent.appendChild(fontSection);

	// Layout options
	const layoutSection = document.createElement("div");
	layoutSection.className = "customizer-section";
	layoutSection.style.marginBottom = "25px";

	const layoutTitle = document.createElement("h5");
	layoutTitle.textContent = "Layout Options";
	layoutTitle.style.marginBottom = "15px";

	// Container width
	const containerWidthLabel = document.createElement("label");
	containerWidthLabel.textContent = "Container Width";
	containerWidthLabel.style.display = "block";
	containerWidthLabel.style.marginBottom = "5px";

	const containerWidthRange = document.createElement("input");
	containerWidthRange.type = "range";
	containerWidthRange.className = "form-control-range container-width-range";
	containerWidthRange.min = "900";
	containerWidthRange.max = "1400";
	containerWidthRange.step = "50";
	containerWidthRange.value = "1200";
	containerWidthRange.style.width = "100%";
	containerWidthRange.style.marginBottom = "20px";

	// Border radius
	const borderRadiusLabel = document.createElement("label");
	borderRadiusLabel.textContent = "Border Radius";
	borderRadiusLabel.style.display = "block";
	borderRadiusLabel.style.marginBottom = "5px";

	const borderRadiusSelect = document.createElement("select");
	borderRadiusSelect.className = "form-control border-radius-select";
	borderRadiusSelect.style.width = "100%";
	borderRadiusSelect.style.marginBottom = "20px";

	const borderRadiusOptions = [
		{ value: "", label: "Default (0.5rem)" },
		{ value: "border-rounded-sm", label: "Small (0.25rem)" },
		{ value: "border-rounded-md", label: "Medium (0.5rem)" },
		{ value: "border-rounded-lg", label: "Large (0.75rem)" },
		{ value: "border-rounded-xl", label: "Extra Large (1rem)" },
	];

	borderRadiusOptions.forEach((option) => {
		const optionEl = document.createElement("option");
		optionEl.value = option.value;
		optionEl.textContent = option.label;
		borderRadiusSelect.appendChild(optionEl);
	});

	layoutSection.appendChild(layoutTitle);
	layoutSection.appendChild(containerWidthLabel);
	layoutSection.appendChild(containerWidthRange);
	layoutSection.appendChild(borderRadiusLabel);
	layoutSection.appendChild(borderRadiusSelect);
	panelContent.appendChild(layoutSection);

	// Toggle options
	const toggleSection = document.createElement("div");
	toggleSection.className = "customizer-section";
	toggleSection.style.marginBottom = "25px";

	const toggleTitle = document.createElement("h5");
	toggleTitle.textContent = "Toggle Options";
	toggleTitle.style.marginBottom = "15px";

	// Dark Mode Toggle
	const darkModeToggleWrapper = document.createElement("div");
	darkModeToggleWrapper.style.cssText = `
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    `;

	const darkModeLabel = document.createElement("label");
	darkModeLabel.textContent = "Dark Mode";
	darkModeLabel.style.margin = "0";

	const darkModeToggle = document.createElement("label");
	darkModeToggle.className = "toggle-switch";
	darkModeToggle.style.cssText = `
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    `;

	const darkModeCheckbox = document.createElement("input");
	darkModeCheckbox.type = "checkbox";
	darkModeCheckbox.className = "dark-mode-toggle";

	const darkModeSlider = document.createElement("span");
	darkModeSlider.className = "toggle-slider";
	darkModeSlider.style.cssText = `
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 24px;
    `;

	darkModeSlider.innerHTML = `
        <span style="
            position: absolute;
            content: '';
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        "></span>
    `;

	darkModeToggle.appendChild(darkModeCheckbox);
	darkModeToggle.appendChild(darkModeSlider);

	darkModeToggleWrapper.appendChild(darkModeLabel);
	darkModeToggleWrapper.appendChild(darkModeToggle);

	// RTL Toggle
	const rtlToggleWrapper = document.createElement("div");
	rtlToggleWrapper.style.cssText = `
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    `;

	const rtlLabel = document.createElement("label");
	rtlLabel.textContent = "RTL Mode";
	rtlLabel.style.margin = "0";

	const rtlToggle = document.createElement("label");
	rtlToggle.className = "toggle-switch";
	rtlToggle.style.cssText = `
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    `;

	const rtlCheckbox = document.createElement("input");
	rtlCheckbox.type = "checkbox";
	rtlCheckbox.className = "rtl-toggle";

	const rtlSlider = document.createElement("span");
	rtlSlider.className = "toggle-slider";
	rtlSlider.style.cssText = `
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 24px;
    `;

	rtlSlider.innerHTML = `
        <span style="
            position: absolute;
            content: '';
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        "></span>
    `;

	rtlToggle.appendChild(rtlCheckbox);
	rtlToggle.appendChild(rtlSlider);

	rtlToggleWrapper.appendChild(rtlLabel);
	rtlToggleWrapper.appendChild(rtlToggle);

	toggleSection.appendChild(toggleTitle);
	toggleSection.appendChild(darkModeToggleWrapper);
	toggleSection.appendChild(rtlToggleWrapper);
	panelContent.appendChild(toggleSection);

	// Reset button
	const resetButton = document.createElement("button");
	resetButton.className = "btn btn-danger btn-block reset-theme-btn";
	resetButton.textContent = "Reset to Default";
	resetButton.style.marginTop = "20px";

	panelContent.appendChild(resetButton);
	customizerPanel.appendChild(panelContent);

	// Add panel to body
	document.body.appendChild(customizerPanel);

	// Add dark mode styles to customizer panel
	const darkModeStyle = document.createElement("style");
	darkModeStyle.textContent = `
        .dark-mode .theme-customizer-panel {
            background-color: #2a2e32;
            color: #f8f9fa;
        }
        
        .dark-mode .theme-customizer-panel h4,
        .dark-mode .theme-customizer-panel h5 {
            color: #f8f9fa;
        }
        
        .dark-mode .theme-customizer-close {
            color: #f8f9fa;
        }
        
        .dark-mode .customizer-section {
            border-color: #444;
        }
        
        .dark-mode .theme-option {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }
        
        .dark-mode .theme-option div:last-child {
            background-color: #343a40;
            color: #f8f9fa;
        }
        
        .dark-mode .form-control {
            background-color: #343a40;
            border-color: #444;
            color: #f8f9fa;
        }
    `;

	document.head.appendChild(darkModeStyle);
}

// Load saved theme settings
function loadSavedThemeSettings() {
	// Load theme
	const savedTheme = localStorage.getItem("theme_color");
	if (savedTheme) {
		document.body.classList.remove(
			"theme-purple",
			"theme-green",
			"theme-orange",
			"theme-red",
			"theme-teal"
		);
		if (savedTheme !== "default") {
			document.body.classList.add(savedTheme);
		}
	}

	// Load dark mode
	const darkMode = localStorage.getItem("dark_mode") === "true";
	if (darkMode) {
		document.body.classList.add("dark-mode");
		const darkModeToggle = document.querySelector(".dark-mode-toggle");
		if (darkModeToggle) {
			darkModeToggle.checked = true;
		}
	}

	// Load RTL mode
	const rtlMode = localStorage.getItem("rtl_mode") === "true";
	if (rtlMode) {
		document.documentElement.setAttribute("dir", "rtl");
		const rtlToggle = document.querySelector(".rtl-toggle");
		if (rtlToggle) {
			rtlToggle.checked = true;
		}
	}

	// Load font
	const savedFont = localStorage.getItem("font_family");
	if (savedFont) {
		document.body.classList.remove(
			"font-roboto",
			"font-montserrat",
			"font-lato",
			"font-open-sans"
		);
		if (savedFont !== "") {
			document.body.classList.add(savedFont);
		}

		const fontSelect = document.querySelector(".font-select");
		if (fontSelect) {
			fontSelect.value = savedFont;
		}
	}

	// Load border radius
	const savedBorderRadius = localStorage.getItem("border_radius");
	if (savedBorderRadius) {
		document.body.classList.remove(
			"border-rounded-sm",
			"border-rounded-md",
			"border-rounded-lg",
			"border-rounded-xl"
		);
		if (savedBorderRadius !== "") {
			document.body.classList.add(savedBorderRadius);
		}

		const borderRadiusSelect = document.querySelector(".border-radius-select");
		if (borderRadiusSelect) {
			borderRadiusSelect.value = savedBorderRadius;
		}
	}

	// Load container width
	const savedContainerWidth = localStorage.getItem("container_width");
	if (savedContainerWidth) {
		document.documentElement.style.setProperty(
			"--container-width",
			`${savedContainerWidth}px`
		);

		const containerWidthRange = document.querySelector(
			".container-width-range"
		);
		if (containerWidthRange) {
			containerWidthRange.value = savedContainerWidth;
		}
	}
}

// Add event listeners for theme customizer
function addThemeCustomizerEvents() {
	// Toggle customizer panel
	const toggleButton = document.querySelector(".theme-customizer-toggle");
	const customizerPanel = document.querySelector(".theme-customizer-panel");
	const closeButton = document.querySelector(".theme-customizer-close");

	if (toggleButton && customizerPanel) {
		toggleButton.addEventListener("click", function () {
			customizerPanel.style.right = "0";
		});
	}

	if (closeButton && customizerPanel) {
		closeButton.addEventListener("click", function () {
			customizerPanel.style.right = "-300px";
		});
	}

	// Close panel when clicking outside
	document.addEventListener("click", function (e) {
		if (
			customizerPanel &&
			!customizerPanel.contains(e.target) &&
			e.target !== toggleButton &&
			!toggleButton.contains(e.target)
		) {
			customizerPanel.style.right = "-300px";
		}
	});

	// Theme options
	const themeOptions = document.querySelectorAll(".theme-option");

	themeOptions.forEach((option) => {
		option.addEventListener("click", function () {
			const theme = this.getAttribute("data-theme");

			// Remove all theme classes
			document.body.classList.remove(
				"theme-purple",
				"theme-green",
				"theme-orange",
				"theme-red",
				"theme-teal"
			);

			// Add selected theme class if not default
			if (theme !== "default") {
				document.body.classList.add(theme);
			}

			// Save to localStorage
			localStorage.setItem("theme_color", theme);

			// Add active class to selected theme
			themeOptions.forEach((opt) => opt.classList.remove("active"));
			this.classList.add("active");
		});
	});

	// Dark mode toggle
	const darkModeToggle = document.querySelector(".dark-mode-toggle");

	if (darkModeToggle) {
		darkModeToggle.addEventListener("change", function () {
			if (this.checked) {
				document.body.classList.add("dark-mode");
				localStorage.setItem("dark_mode", "true");
			} else {
				document.body.classList.remove("dark-mode");
				localStorage.setItem("dark_mode", "false");
			}
		});
	}

	// RTL toggle
	const rtlToggle = document.querySelector(".rtl-toggle");

	if (rtlToggle) {
		rtlToggle.addEventListener("change", function () {
			if (this.checked) {
				document.documentElement.setAttribute("dir", "rtl");
				localStorage.setItem("rtl_mode", "true");
			} else {
				document.documentElement.setAttribute("dir", "ltr");
				localStorage.setItem("rtl_mode", "false");
			}
		});
	}

	// Font select
	const fontSelect = document.querySelector(".font-select");

	if (fontSelect) {
		fontSelect.addEventListener("change", function () {
			// Remove all font classes
			document.body.classList.remove(
				"font-roboto",
				"font-montserrat",
				"font-lato",
				"font-open-sans"
			);

			// Add selected font class if not default
			if (this.value !== "") {
				document.body.classList.add(this.value);
			}

			// Save to localStorage
			localStorage.setItem("font_family", this.value);
		});
	}

	// Border radius select
	const borderRadiusSelect = document.querySelector(".border-radius-select");

	if (borderRadiusSelect) {
		borderRadiusSelect.addEventListener("change", function () {
			// Remove all border radius classes
			document.body.classList.remove(
				"border-rounded-sm",
				"border-rounded-md",
				"border-rounded-lg",
				"border-rounded-xl"
			);

			// Add selected border radius class if not default
			if (this.value !== "") {
				document.body.classList.add(this.value);
			}

			// Save to localStorage
			localStorage.setItem("border_radius", this.value);
		});
	}

	// Container width range
	const containerWidthRange = document.querySelector(".container-width-range");

	if (containerWidthRange) {
		containerWidthRange.addEventListener("input", function () {
			document.documentElement.style.setProperty(
				"--container-width",
				`${this.value}px`
			);

			// Save to localStorage
			localStorage.setItem("container_width", this.value);
		});
	}

	// Reset button
	const resetButton = document.querySelector(".reset-theme-btn");

	if (resetButton) {
		resetButton.addEventListener("click", function () {
			// Reset all theme settings
			document.body.classList.remove(
				"theme-purple",
				"theme-green",
				"theme-orange",
				"theme-red",
				"theme-teal"
			);
			document.body.classList.remove("dark-mode");
			document.body.classList.remove(
				"font-roboto",
				"font-montserrat",
				"font-lato",
				"font-open-sans"
			);
			document.body.classList.remove(
				"border-rounded-sm",
				"border-rounded-md",
				"border-rounded-lg",
				"border-rounded-xl"
			);
			document.documentElement.setAttribute("dir", "ltr");
			document.documentElement.style.removeProperty("--container-width");

			// Reset form controls
			if (darkModeToggle) darkModeToggle.checked = false;
			if (rtlToggle) rtlToggle.checked = false;
			if (fontSelect) fontSelect.value = "";
			if (borderRadiusSelect) borderRadiusSelect.value = "";
			if (containerWidthRange) containerWidthRange.value = "1200";

			// Reset theme options active state
			themeOptions.forEach((opt) => opt.classList.remove("active"));
			themeOptions[0].classList.add("active");

			// Clear localStorage
			localStorage.removeItem("theme_color");
			localStorage.removeItem("dark_mode");
			localStorage.removeItem("rtl_mode");
			localStorage.removeItem("font_family");
			localStorage.removeItem("border_radius");
			localStorage.removeItem("container_width");

			// Show success message
			alert("Theme settings have been reset to default");
		});
	}
}
