<?php

/** =========================================================================== **/
/* > Constants
/** =========================================================================== **/

global $wpdb;

// Theme Name
define( 'SITE_NAME', 'NakedCompass' );
define( 'THEME_NAME', 'NakedCompass' );

// Paths
define( 'TEMPLATE_URL', get_bloginfo('template_url') );
define( 'STYLES_DIR', TEMPLATE_URL . '/css' );
define( 'HELPERS_DIR', 'app/helpers/' );

// Database Constants
// $wpdb->base_prefix retrieves the wp_ part
// $wpdb->prefix retrieves the wp_# part
define( 'DB_POSTS_FEATURED', $wpdb->prefix . THEME_NAME . '_posts_featured');

// Facebook Constants
define( 'FB_APP_ID', '163414424111');
define( 'FB_ADMINS', '684940468,100216');

// Other Constants
define( 'POST_EXCERPT_LENGTH', 60);

?>