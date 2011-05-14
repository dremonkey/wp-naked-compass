<?php
/**
 * The main template file.
 * 
 * @package WordPress
 * @subpackage StarkHTML5
 * @since StarkHTML5 1.0
 */

get_header(); ?>

			<?php
			/* Run the loop to output the posts.
			 * If you want to overload this in a child theme then include a file
			 * called loop-index.php and that will be used instead.
			 */
			 get_template_part( 'loop', 'index' );
			?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>