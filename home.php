<?php /* The homepage file. */ ?>

<?php get_header(); ?>

	<div class="content left">

		<?php
		/* Run the loop to output the posts.
		 * If you want to overload this in a child theme then include a file
		 * called loop-index.php and that will be used instead.
		 */
		 get_template_part( 'loop', 'index' );
		?>

	</div><!-- end .content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>