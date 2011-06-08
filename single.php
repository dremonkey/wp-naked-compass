<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage NakedCompass
 */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

					<?php previous_post_link( '%link', '' . _x( '&larr;', 'Previous post link', THEME_NAME ) . ' %title' ); ?>
					<?php next_post_link( '%link', '%title ' . _x( '&rarr;', 'Next post link', THEME_NAME ) . '' ); ?>

					<h1><?php the_title(); ?></h1>

						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', THEME_NAME ), 'after' => '' ) ); ?>

<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyten_author_bio_avatar_size', 60 ) ); ?>
							<h2><?php printf( esc_attr__( 'About %s', THEME_NAME ), get_the_author() ); ?></h2>
							<?php the_author_meta( 'description' ); ?>
							<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
								<?php printf( __( 'View all posts by %s &rarr;', THEME_NAME ), get_the_author() ); ?>
							</a>
<?php endif; ?>

						<?php edit_post_link( __( 'Edit', THEME_NAME ), '', '' ); ?>

				<?php previous_post_link( '%link', '' . _x( '&larr;', 'Previous post link', THEME_NAME ) . ' %title' ); ?>
				<?php next_post_link( '%link', '%title ' . _x( '&rarr;', 'Next post link', THEME_NAME ) . '' ); ?>

				<?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>