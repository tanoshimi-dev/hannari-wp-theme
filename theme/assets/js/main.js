/**
 * Hannari Theme - Main JavaScript
 *
 * @package Hannari
 * @since 1.0.0
 */

(function() {
	'use strict';

	/**
	 * Initialize the theme scripts
	 */
	function init() {
		setupNavigation();
		setupSmoothScroll();
		setupExternalLinks();
	}

	/**
	 * Mobile navigation toggle
	 */
	function setupNavigation() {
		var nav = document.querySelector('.main-navigation');
		if (!nav) {
			return;
		}

		// Add mobile toggle button
		var menuToggle = document.createElement('button');
		menuToggle.className = 'menu-toggle';
		menuToggle.setAttribute('aria-expanded', 'false');
		menuToggle.setAttribute('aria-controls', 'primary-menu');
		menuToggle.innerHTML = '<span class="screen-reader-text">Menu</span><span class="menu-icon"></span>';

		// Insert toggle before the menu
		var menu = nav.querySelector('ul');
		if (menu) {
			nav.insertBefore(menuToggle, menu);

			// Toggle menu on click
			menuToggle.addEventListener('click', function() {
				var expanded = this.getAttribute('aria-expanded') === 'true';
				this.setAttribute('aria-expanded', !expanded);
				nav.classList.toggle('toggled');
			});

			// Close menu on escape key
			document.addEventListener('keydown', function(e) {
				if (e.key === 'Escape' && nav.classList.contains('toggled')) {
					menuToggle.setAttribute('aria-expanded', 'false');
					nav.classList.remove('toggled');
					menuToggle.focus();
				}
			});
		}
	}

	/**
	 * Smooth scroll for anchor links
	 */
	function setupSmoothScroll() {
		document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
			anchor.addEventListener('click', function(e) {
				var targetId = this.getAttribute('href');

				// Skip if just "#"
				if (targetId === '#') {
					return;
				}

				var target = document.querySelector(targetId);
				if (target) {
					e.preventDefault();
					target.scrollIntoView({
						behavior: 'smooth',
						block: 'start'
					});

					// Update focus for accessibility
					target.setAttribute('tabindex', '-1');
					target.focus();
				}
			});
		});
	}

	/**
	 * Open external links in new tab
	 */
	function setupExternalLinks() {
		var currentHost = window.location.hostname;

		document.querySelectorAll('a[href^="http"]').forEach(function(link) {
			var linkHost = new URL(link.href).hostname;

			if (linkHost !== currentHost) {
				link.setAttribute('target', '_blank');
				link.setAttribute('rel', 'noopener noreferrer');

				// Add screen reader text for accessibility
				if (!link.querySelector('.screen-reader-text')) {
					var srText = document.createElement('span');
					srText.className = 'screen-reader-text';
					srText.textContent = ' (opens in a new tab)';
					link.appendChild(srText);
				}
			}
		});
	}

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
