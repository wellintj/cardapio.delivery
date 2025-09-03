<style>
	/* Toggle Button Styles */
	.theme-toggle {
		position: fixed;
		top: 50%;
		right: 20px;
		transform: translateY(-50%);
	}

	.user.theme-toggle {
		position: fixed;
		top: auto;
		bottom: 191px;
		right: 34px;
	}

	.theme-toggle-btn {
		background: none;
		border: none;
		cursor: pointer;
		padding: 10px;
		border-radius: 50%;
		width: 45px;
		height: 45px;
		display: flex;
		align-items: center;
		justify-content: center;
		transition: all 0.3s ease;
		position: relative;
	}

	.theme-toggle-btn:hover {
		background-color: rgba(0, 0, 0, 0.1);
	}

	body.theme-dark .theme-toggle-btn:hover {
		background-color: rgba(255, 255, 255, 0.1);
	}

	.sun-icon,
	.moon-icon {
		position: absolute;
		transition: all 0.3s ease;
	}

	.sun-icon svg,
	.moon-icon svg {
		width: 24px;
		height: 24px;
		fill: var(--dcolor);
		stroke: var(--dcolor);
	}

	/* Light theme icon states */
	.sun-icon {
		opacity: 1;
		transform: scale(1);
	}

	.moon-icon {
		opacity: 0;
		transform: scale(0.5);
	}

	/* Dark theme icon states */
	body.theme-dark .sun-icon {
		opacity: 0;
		transform: scale(0.5);
	}

	body.theme-dark .moon-icon {
		opacity: 1;
		transform: scale(1);
	}

	/* Additional dark theme styles */
	body.theme-dark .theme-toggle-btn {
		color: var(--dark-text);
	}

	.theme-toggle-btn {
		color: var(--light-text);
	}

	@media screen and (max-width: 767px) {
		.user.theme-toggle {
			right: 17px;
		}
	}
</style>

<div class="theme-toggle <?= isset($role) ? $role : ''; ?>">
	<button id="theme-toggle-btn" class="theme-toggle-btn">
		<span class="sun-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
				<circle cx="12" cy="12" r="5" />
				<line x1="12" y1="1" x2="12" y2="3" />
				<line x1="12" y1="21" x2="12" y2="23" />
				<line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
				<line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
				<line x1="1" y1="12" x2="3" y2="12" />
				<line x1="21" y1="12" x2="23" y2="12" />
				<line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
				<line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
			</svg>
		</span>
		<span class="moon-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
				<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
			</svg>
		</span>
	</button>
</div>


<script>
	$(document).ready(function() {
		var isDevelopment = false;
		var Dtime = '10';
		// Cookie management functions
		function setCookie(name, value, minutes) {
			const date = new Date();
			date.setTime(date.getTime() + (minutes * 60 * 1000));
			const expires = "expires=" + date.toUTCString();
			document.cookie = name + "=" + value + ";" + expires + ";path=/";
			console.log(`Cookie ${name} set to expire in ${minutes} minute(s) at: ${date.toUTCString()}`);
		}

		function getCookie(name) {
			const cookieName = name + "=";
			const cookies = document.cookie.split(';');
			for (let i = 0; i < cookies.length; i++) {
				let cookie = cookies[i].trim();
				if (cookie.indexOf(cookieName) === 0) {
					return cookie.substring(cookieName.length, cookie.length);
				}
			}
			if (isDevelopment == true) {
				console.log(`Cookie ${name} not found`);
			}

			return null;
		}

		// Get default theme from body class
		function getDefaultTheme() {
			if ($('body').hasClass('theme-dark')) {
				return 'theme-dark';
			} else if ($('body').hasClass('theme-light')) {
				return 'theme-light';
			}
			return 'theme-light'; // Fallback default
		}

		// Apply theme function
		function applyTheme() {
			const savedTheme = getCookie('userTheme');
			const defaultTheme = getDefaultTheme();

			if (!savedTheme) {
				if (isDevelopment == true) {
					console.log('No theme cookie found, using default theme:', defaultTheme);
				}
				return; // Keep the default theme that's already in body class
			}
			if (isDevelopment == true) {
				console.log('Applying saved theme:', savedTheme);
			}
			if (savedTheme === 'theme-dark') {
				$('body').removeClass('theme-light').addClass('theme-dark');
			} else {
				$('body').removeClass('theme-dark').addClass('theme-light');
			}
		}

		// Apply theme on page load
		applyTheme();

		// Theme toggle click handler
		$('#theme-toggle-btn').click(function() {
			if ($('body').hasClass('theme-dark')) {
				// Switch to light theme
				$('body').removeClass('theme-dark').addClass('theme-light');
				setCookie('userTheme', 'theme-light', Dtime); // 1 minute expiration
			} else {
				// Switch to dark theme
				$('body').removeClass('theme-light').addClass('theme-dark');
				setCookie('userTheme', 'theme-dark', Dtime); // 1 minute expiration
			}
		});

		// System theme preference check - only if no cookie AND no default theme
		if (!getCookie('userTheme') && !getDefaultTheme()) {
			if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
				$('body').removeClass('theme-light').addClass('theme-dark');
				setCookie('userTheme', 'theme-dark', Dtime); // 1 minute expiration
			} else {
				$('body').removeClass('theme-dark').addClass('theme-light');
				setCookie('userTheme', 'theme-light', Dtime); // 1 minute expiration
			}
		}
	});
</script>