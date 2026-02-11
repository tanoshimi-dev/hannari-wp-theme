<?php
/**
 * The footer template
 *
 * @package Hannari
 * @since 1.0.0
 */

?>

		</div><!-- .content-area -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
			<div class="footer-widgets">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div>
		<?php endif; ?>

		<div class="site-info">
			<?php
			printf(
				/* translators: %s: Current year and site name */
				esc_html__( '&copy; %s. All rights reserved.', 'hannari' ),
				esc_html( date_i18n( 'Y' ) . ' ' . get_bloginfo( 'name' ) )
			);
			?>
		</div>
	</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
