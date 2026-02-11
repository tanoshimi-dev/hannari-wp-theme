<?php
/**
 * The template for displaying search results
 *
 * @package Hannari
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<h1 class="page-title">
				<?php
				printf(
					/* translators: %s: Search query */
					esc_html__( 'Search Results for: %s', 'hannari' ),
					'<span>' . get_search_query() . '</span>'
				);
				?>
			</h1>
		</header>

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

					<?php if ( 'post' === get_post_type() ) : ?>
						<div class="entry-meta">
							<?php
							hannari_posted_on();
							hannari_posted_by();
							?>
						</div>
					<?php endif; ?>
				</header>

				<?php hannari_post_thumbnail(); ?>

				<div class="entry-summary">
					<?php the_excerpt(); ?>
					<a href="<?php the_permalink(); ?>" class="read-more">
						<?php esc_html_e( 'Continue reading', 'hannari' ); ?>
					</a>
				</div>

				<footer class="entry-footer">
					<?php hannari_entry_footer(); ?>
				</footer>
			</article>

			<?php
		endwhile;

		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => esc_html__( '&laquo; Previous', 'hannari' ),
				'next_text' => esc_html__( 'Next &raquo;', 'hannari' ),
			)
		);

	else :
		?>

		<section class="no-results not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'hannari' ); ?></h1>
			</header>

			<div class="page-content">
				<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'hannari' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		</section>

		<?php
	endif;
	?>

</main>

<?php
get_sidebar();
get_footer();
