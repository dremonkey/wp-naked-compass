<?php
/**
 * The template for displaying Tag Archive pages.
 *
 * @package WordPress
 * @subpackage NakedCompass
 */

get_header(); ?>

				<h1><?php
					printf( __( 'Tag Archives: %s', THEME_NAME ), '' . single_tag_title( '', false ) . '' );
				?></h1>

<?php
/* Run the loop for the tag archive to output the posts
 * If you want to overload this in a child theme then include a file
 * called loop-tag.php and that will be used instead.
 */
 get_template_part( 'loop', 'tag' );
?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>