<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 *
 * @package WordPress
 * @subpackage NakedCompass
 */
?>

<ul>

<?php
/* When we call the dynamic_sidebar() function, it'll spit out
 * the widgets for that widget area. If it instead returns false,
 * then the sidebar simply doesn't exist, so we'll hard-code in
 * some default sidebar stuff just in case.
 */
if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : ?>

	<li>
		<?php get_search_form(); ?>
	</li>

	<li>
		<h3><?php _e( 'Archives', THEME_NAME ); ?></h3>
		<ul>
			<?php wp_get_archives( 'type=monthly' ); ?>
		</ul>
	</li>

	<li>
		<h3><?php _e( 'Meta', THEME_NAME ); ?></h3>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<?php wp_meta(); ?>
		</ul>
	</li>

<?php endif; // end primary widget area ?>
</ul>