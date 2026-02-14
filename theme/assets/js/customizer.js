/**
 * Hannari Theme - Customizer Live Preview
 *
 * @package Hannari
 * @since 1.0.0
 */

(function(api) {
	'use strict';

	var colorMap = {
		'hannari_main_color':            '--color-main',
		'hannari_pastel_color':          '--color-pastel',
		'hannari_accent_color':          '--color-accent',
		'hannari_link_color':            '--color-link',
		'hannari_header_bg_color':       '--color-header-bg',
		'hannari_header_text_color':     '--color-header-text',
		'hannari_body_bg_color':         '--color-body-bg',
		'hannari_footer_bg_color':       '--color-footer-bg',
		'hannari_footer_text_color':     '--color-footer-text',
		'hannari_widget_title_color':    '--color-widget-title',
		'hannari_widget_title_bg_color': '--color-widget-title-bg',
		'hannari_totop_color':           '--color-totop'
	};

	Object.keys(colorMap).forEach(function(setting) {
		var prop = colorMap[setting];
		api(setting, function(value) {
			value.bind(function(newVal) {
				document.documentElement.style.setProperty(prop, newVal);
			});
		});
	});
})(wp.customize);
