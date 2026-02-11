<?php
/**
 * The main template file
 *
 * @package Hannari
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php
	if ( have_posts() ) :

		if ( is_home() && ! is_front_page() ) :
			?>
			<header class="page-header">
				<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
			</header>
			<?php
		endif;

		while ( have_posts() ) :
			the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php
					if ( is_singular() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
					else :
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					endif;

					if ( 'post' === get_post_type() ) :
						?>
						<div class="entry-meta">
							<?php
							hannari_posted_on();
							hannari_posted_by();
							?>
						</div>
						<?php
					endif;
					?>
				</header>

				<?php hannari_post_thumbnail(); ?>

				<div class="entry-content">
					<?php
					if ( is_singular() ) :
						the_content();

						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'hannari' ),
								'after'  => '</div>',
							)
						);
					else :
						the_excerpt();
						?>
						<a href="<?php the_permalink(); ?>" class="read-more">
							<?php esc_html_e( 'Continue reading', 'hannari' ); ?>
						</a>
						<?php
					endif;
					?>
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
				<?php if ( is_search() ) : ?>
					<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'hannari' ); ?></p>
					<?php get_search_form(); ?>
				<?php else : ?>
					<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'hannari' ); ?></p>
				<?php endif; ?>
			</div>
		</section>

		<?php
	endif;
	?>

</main>

<?php
get_sidebar();
get_footer();
