<?php
/**
 * The loop that displays posts.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 */
?>

<!--If there are no posts to display, do this -->
<?php if ( ! have_posts() ) : ?>
	<h1><?php _e( 'Not Found', THEME_NAME ); ?></h1>
	<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', THEME_NAME ); ?></p>
	<?php get_search_form(); ?>
<?php endif; ?>

<!--
============================================================ 
Start the Loop
============================================================ 
-->
<?php while ( have_posts() ) : the_post(); ?>

<!-- 
============================================================ 
How to display posts in the Gallery category. 
The gallery category is the old way 
============================================================ 
-->

<?php if ( ( function_exists( 'get_post_format' ) && 'gallery' == get_post_format( $post->ID ) ) || in_category( _x( 'gallery', 'gallery category slug', THEME_NAME ) ) ) : ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', THEME_NAME ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

		<div> <!-- start entry content -->
		<?php
			$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
		?>
		<?php if ( $images ) : ?>
			<?php 
				$total_images = count( $images );
				$image = array_shift( $images );
				$image_img_tag = wp_get_attachment_image( $image->ID, 'thumbnail' );
			?>

			<div class="gallery-thumb">
				<a class="size-thumbnail" href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
			</div><!-- .gallery-thumb -->

		<?php endif; ?>

		<?php the_excerpt(); ?>
		</div> <!-- end entry content -->

		<div> <!-- start utility-->
		<?php if ( function_exists( 'get_post_format' ) && 'gallery' == get_post_format( $post->ID ) ) : ?>

			<a href="<?php echo get_post_format_link( 'gallery' ); ?>" title="<?php esc_attr_e( 'View Galleries', THEME_NAME ); ?>"><?php _e( 'More Galleries', THEME_NAME ); ?></a>
			<span class="meta-sep">|</span>

		<?php elseif ( in_category( _x( 'gallery', 'gallery category slug', THEME_NAME ) ) ) : ?>

			<a href="<?php echo get_term_link( _x( 'gallery', 'gallery category slug', THEME_NAME ), 'category' ); ?>" title="<?php esc_attr_e( 'View posts in the Gallery category', THEME_NAME ); ?>"><?php _e( 'More Galleries', THEME_NAME ); ?></a>
			<span class="meta-sep">|</span>

		<?php endif; ?>

			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', THEME_NAME ), __( '1 Comment', THEME_NAME ), __( '% Comments', THEME_NAME ) ); ?></span>
			<?php edit_post_link( __( 'Edit', THEME_NAME ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
		</div><!-- end utility-->
	
	</div><!-- #post-## -->

<?php else : ?>

<!-- 
============================================================ 
How to display all other posts 
============================================================ 
-->

	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', THEME_NAME ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

		<?php the_excerpt(); ?>

		<div> <!-- start utility-->
			
		<?php if ( count( get_the_category() ) ) : ?>
			<span class="cat-links">
				<?php __( 'Posted in', THEME_NAME ); ?>
				<?php get_the_category_list( ', ' ); ?>
			</span>
			<span class="meta-sep">|</span>
			
		<?php endif; ?>
			
		<?php $tags_list = get_the_tag_list( '', ', ' ); ?>

			<?php if ( $tags_list ): ?>
				<span class="tag-links">
					<?php printf( __( '<span class="%1$s">Tagged</span> %2$s', THEME_NAME ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?>
				</span>
				<span class="meta-sep">|</span>
			<?php endif; ?>

			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', THEME_NAME ), __( '1 Comment', THEME_NAME ), __( '% Comments', THEME_NAME ) ); ?></span>
			<?php edit_post_link( __( 'Edit', THEME_NAME ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>

		</div><!-- end utility -->
	</div><!-- #post-## -->

	<?php comments_template( '', true ); ?>

<?php endif; ?>

<?php endwhile; ?>

<!-- Display navigation to next/previous pages when applicable -->
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<?php next_posts_link( __( '&larr; Older posts', THEME_NAME ) ); ?>
				<?php previous_posts_link( __( 'Newer posts &rarr;', THEME_NAME ) ); ?>
<?php endif; ?>