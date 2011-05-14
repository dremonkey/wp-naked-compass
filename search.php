<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage NakedCompass
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>
				<h1><?php printf( __( 'Search Results for: %s', THEME_NAME ), '' . get_search_query() . '' ); ?></h1>

				<!-- Run the search loop -->
				<?php get_template_part( 'loop', 'search' ); ?>
<?php else : ?>
					<h2><?php _e( 'Nothing Found', THEME_NAME ); ?></h2>
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', THEME_NAME ); ?></p>
					<?php get_search_form(); ?>
<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
