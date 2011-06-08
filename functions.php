<?php

/**
 * @package WordPress
 * @subpackage NakedCompass
 * @since NakedCompass 1.0
 */

/** =========================================================================== **/
/* > Constants / Includes
/** =========================================================================== **/

// Our Constants. This should always be first.
require_once('app/config/constants.php');

// Include our helper classes. These classes do not use constructors.
// thus do not need to be instantiated. These should come after the constants.
require_once(HELPERS_DIR . 'activation_hook.php');
require_once(HELPERS_DIR . 'registry.php');
require_once(HELPERS_DIR . 'utilities.php');
require_once(HELPERS_DIR . 'factory.php');

/** =========================================================================== **/
/* > Setup
/** =========================================================================== **/

new Theme_Setup();

Class Theme_Setup
{
	
	function __construct() 
	{
		add_action( 'after_setup_theme', array($this, 'set_defaults') );
		add_filter( 'wp_title', array($this, 'filter_wp_title'), 10, 2 );
		add_filter( 'excerpt_length', array($this, 'set_excerpt_length') );
		add_filter( 'excerpt_more', array($this, 'excerpt_more_style') );

		// Add the JS
		add_action('init', array($this, 'remove_wp_js') );
		add_action('init', array($this, 'register_js_libs') );

		// Load the JS
		add_filter('wp_print_scripts', array($this, 'lazy_load_js') );
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function set_defaults()
	{

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Make theme available for translation
		// Translations can be filed in the /languages/ directory
		load_theme_textdomain( THEME_NAME, TEMPLATEPATH . '/languages' );

		$locale = get_locale();
		$locale_file = TEMPLATEPATH . "/languages/$locale.php";
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => __( 'Primary Navigation', THEME_NAME ),
		) );

		// This theme allows users to set a custom background
		add_custom_background();

		// Enable thumbnails and set the sizes
		Theme_Setup::set_thumbnails();
	}

	function set_thumbnails()
	{
		// This theme uses post thumbnails
		add_theme_support( 'post-thumbnails' );

		// Default Post Thumbnail dimensions
		set_post_thumbnail_size( $width = 150, $height = 150, $crop = true ); 

		/* Thumbnail for our featured content slider... 1.6 ratio (i.e. the golden ration) */
    	add_image_size( $name = 'img_golden', $width = 480, $height = 300, $crop = true );

	}

	/**
	 * Make some changes to the format / content of the page titles
	 * @return string
	 */
	function filter_wp_title( $title, $separator ) 
	{
		// Don't affect wp_title() calls in feeds.
		if ( is_feed() )
			return $title;

		// The $paged global variable contains the page number of a listing of posts.
		// The $page global variable contains the page number of a single post that is paged.
		// We'll display whichever one applies, if we're not looking at the first page.
		global $paged, $page;

		if ( is_search() ) {
			// If we're a search, let's start over:
			$title = sprintf( __( 'Search results for %s', THEME_NAME ), '"' . get_search_query() . '"' );
			// Add a page number if we're on page 2 or more:
			if ( $paged >= 2 )
				$title .= " $separator " . sprintf( __( 'Page %s', THEME_NAME ), $paged );
			// Add the site name to the end:
			$title .= " $separator " . get_bloginfo( 'name', 'display' );
			// We're done. Let's send the new title back to wp_title():
			return $title;
		}

		// Otherwise, let's start by adding the site name to the end:
		$title .= get_bloginfo( 'name', 'display' );

		// If we have a site description and we're on the home/front page, add the description:
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title .= " $separator " . $site_description;

		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			$title .= " $separator " . sprintf( __( 'Page %s', THEME_NAME ), max( $paged, $page ) );

		// Return the new title to wp_title():
		return $title;
	}

	/**
	 * Sets the post excerpt length
 	 * @return int
 	 */
	function set_excerpt_length( $length ) 
	{
		$length = POST_EXCERPT_LENGTH;
		return $length;
	}

	/**
 	 * Replaces "[...]" (appended to excerpts) with an ellipsis (...).
 	 */
	function excerpt_more_style( $more ) 
	{
		return '&hellip;';
	}

	function remove_wp_js(){
		// Deregister the jquery that comes with wordpress
		if (!is_admin()) { 
			wp_deregister_script('jquery');
		}
	}

	/**
	 * register_js_libs()
	 *
	 * Use this function to register the js libraries that will NOT be concatenated with the scripts
	 * file when you run the build script. If you are loading the library from an external source like
	 * Google CDN then use wp_register_script and pass in the full path. If the library is own your own 
	 * server (i.e. in your theme) then use Utilities::add_js and pass in the relative path.
	 */
	function register_js_libs()
	{

		// Do not load these scripts if on the admin page	
		if (!is_admin()){

			// Load the jquery and jquery-ui from the google cdn
			// http://encosia.com/2008/12/10/3-reasons-why-you-should-let-google-host-jquery-for-you/
			wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js', '', NULL, true);
			wp_register_script( 'jqueryui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js', 'jquery', NULL, true);


			/* Modernizr enables HTML5 elements & feature detects */ 
			/* Respond is a polyfill for min/max-width CSS3 Media Queries */
			Utilities::add_js('/js/libs/modernizr-1.7.min.js', NULL, $in_footer=false);
			Utilities::add_js('/js/libs/respond.min.js', NULL, $in_footer=false);

		}
	}
	
	/**
	 * lazy_load_js()
	 *
	 * This function should be used to enqueue all your javascript. All javascript should be registered 
	 * prior to being enqueued here. To register use Utilities::add_js or wp_register_script. We 
	 * separate the registering and enqueuing of scripts so that we can take advantage of the HTML5 
	 * build script but still maintain control over which js files get loaded so that we are not
	 * loading all js files on every page. We only load what is necessary. 
	 */
	function lazy_load_js() 
	{

		/* NOTE: The name passed to wp_enqueue must be the same name as the one used to register 
		 * the script. 
		 */

		if (!is_admin()){

			/* Load sitewide javascript */
			wp_enqueue_script( 'modernizr' );
			wp_enqueue_script( 'respond' );

			//[[---replace scripts---]]
			// This section will be automatically replaced by the build script with a reference to
			// the new concatenated script. 
			wp_enqueue_script( 'script' ); 
			//[[---end replace scripts---]]

			if ( is_home() ) {
				/* Home only javascript */	
			}
			
		    if ( is_singular() ) {

		    	/* Singular pages only javascript */
		    	// http://codex.wordpress.org/Function_Reference/is_singular
		    	
		    	if ( comments_open() AND (get_option('thread_comments') == 1)) {
		    		// Enables threaded comments if the option is selected
		    		wp_enqueue_script( 'comment-reply', '', '', '', true );	
		    	}
		    }
		}
	}	
}


/** =========================================================================== **/
/* > Template Tags
/** =========================================================================== **/

$tt = new Template_Tags();

Class Template_Tags
{
	/**
	 * Returns a "Continue Reading" link for excerpts
	 * @return string (link)
	 */
	function read_more_link() 
	{
		return ' <a href="'. get_permalink() . '">' . __( 'Read More', THEME_NAME ) . '</a>';
	}

	/**
	 * Template for comments and pingbacks.
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 */
	function format_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 40 ); ?>
				<?php printf( __( '%s <span class="says">says:</span>', THEME_NAME ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
			</div><!-- .comment-author .vcard -->
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php _e( 'Your comment is awaiting moderation.', THEME_NAME ); ?></em>
				<br />
			<?php endif; ?>

			<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php
					/* translators: 1: date, 2: time */
					printf( __( '%1$s at %2$s', THEME_NAME ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', THEME_NAME ), ' ' );
				?>
			</div><!-- .comment-meta .commentmetadata -->

			<div class="comment-body"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</div><!-- #comment-##  -->

		<?php
				break;
			case 'pingback'  :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php _e( 'Pingback:', THEME_NAME ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', THEME_NAME), ' ' ); ?></p>
		<?php
				break;
		endswitch;
	}

}


/** =========================================================================== **/
/* > Register our theme activation and deactivation hooks
/** =========================================================================== **/

/* This should be at the bottom of your functions.php files
 * Anything that you want to tie into these two hooks must be initiated before this fires 
 */
register_theme_activation_hook( THEME_NAME , 'do_theme_activate');
register_theme_deactivation_hook( THEME_NAME , 'do_theme_deactivate');

/* Theme Activation Hooks. */

/* For those things that only need to happen once (on activation)... hook into this */
function do_theme_activate()
{
	do_action( THEME_NAME . '_do_theme_activate' );
}

/* For cleanup on theme deactivation... hook into this */
function do_theme_deactivate()
{
	do_action( THEME_NAME . '_do_theme_deactivate' );
}

?>