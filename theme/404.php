<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Hannari
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">

	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( '404', 'hannari' ); ?></h1>
		</header>

		<div class="page-content">
			<p><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'hannari' ); ?></p>
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'hannari' ); ?></p>

			<?php get_search_form(); ?>

			<div class="widget widget_recent_entries">
				<h2 class="widget-title"><?php esc_html_e( 'Recent Posts', 'hannari' ); ?></h2>
				<ul>
					<?php
					$recent_posts = wp_get_recent_posts(
						array(
							'numberposts' => 5,
							'post_status' => 'publish',
						)
					);
					foreach ( $recent_posts as $post ) :
						?>
						<li>
							<a href="<?php echo esc_url( get_permalink( $post['ID'] ) ); ?>">
								<?php echo esc_html( $post['post_title'] ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
