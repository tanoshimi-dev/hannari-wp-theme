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
		setupScrollToTop();
	}

	/**
	 * Mobile navigation toggle with overlay
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

		// Create overlay
		var overlay = document.createElement('div');
		overlay.className = 'nav-overlay';
		document.body.appendChild(overlay);

		var menu = nav.querySelector('ul');
		if (menu) {
			nav.insertBefore(menuToggle, menu);

			function openMenu() {
				menuToggle.setAttribute('aria-expanded', 'true');
				nav.classList.add('toggled');
				overlay.classList.add('is-active');
				document.body.style.overflow = 'hidden';
			}

			function closeMenu() {
				menuToggle.setAttribute('aria-expanded', 'false');
				nav.classList.remove('toggled');
				overlay.classList.remove('is-active');
				document.body.style.overflow = '';
			}

			menuToggle.addEventListener('click', function() {
				var expanded = this.getAttribute('aria-expanded') === 'true';
				if (expanded) {
					closeMenu();
				} else {
					openMenu();
				}
			});

			overlay.addEventListener('click', function() {
				closeMenu();
				menuToggle.focus();
			});

			document.addEventListener('keydown', function(e) {
				if (e.key === 'Escape' && nav.classList.contains('toggled')) {
					closeMenu();
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

				if (!link.querySelector('.screen-reader-text')) {
					var srText = document.createElement('span');
					srText.className = 'screen-reader-text';
					srText.textContent = ' (opens in a new tab)';
					link.appendChild(srText);
				}
			}
		});
	}

	/**
	 * Scroll-to-top button: show on scroll, smooth scroll back
	 */
	function setupScrollToTop() {
		var btn = document.querySelector('.scroll-to-top');
		if (!btn) {
			return;
		}

		window.addEventListener('scroll', function() {
			if (window.pageYOffset > 500) {
				btn.classList.add('is-visible');
			} else {
				btn.classList.remove('is-visible');
			}
		});

		btn.addEventListener('click', function() {
			window.scrollTo({
				top: 0,
				behavior: 'smooth'
			});
		});
	}

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
