<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage NakedCompass
 * @since NakedCompass 1.0
 */
?>
<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ --> 
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> 
<html <?php language_attributes(); ?>> 
<!--<![endif]-->

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	
	<!-- Title is filtered a bit in functions.php -->
	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<meta name="description" content="" />

	<!-- Mobile viewport optimized: j.mp/bplateviewport -->
 	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link id="main_stylesheet" rel="stylesheet" type="text/css" media="all" href="<?= STYLES_DIR ?>/style.css" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!-- scripts concatenated and minified via ant build script-->
	<!-- This section will be stripped and replaced with the minified / concatenated js. -->
	<!-- Utilities::add_js must be called in the head -->
	<?php Utilities::add_js('/js/mylibs/jquery.cookie.js', 'jquery', $in_footer=true) ?>
	<?php Utilities::add_js('/js/mylibs/jquery.layoutSwitcher.js', 'jquery, jquerycookie', $in_footer=true) ?>
	<?php Utilities::add_js('/js/script.js', 'jquery, jquerycookie, jquerylayoutswitcher', $in_footer=true) ?>
	<!-- end scripts-->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	
	<div id="wrapper">
		<header id="header">
			<h1 class="logo">
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			</h1>

			<div id="access" role="navigation">
			<!--  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff -->
				<a href="#content" title="<?php esc_attr_e( 'Skip to content', THEME_NAME ); ?>"><?php _e( 'Skip to content', THEME_NAME ); ?></a>
				<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
				<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
			</div><!-- #access -->

			<ul id="layout">
				<li><a href="<?= STYLES_DIR ?>/style.css">Variable</a></li>
				<li><a href="<?= STYLES_DIR ?>/style_960.css">Standard</a></li>
				<li><a href="<?= STYLES_DIR ?>/style_1280.css">Wide</a></li>
			</ul>

		</header>
		<div id="main" role="main content area">