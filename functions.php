<?php

/**
 * @package WordPress
 * @subpackage NakedCompass
 * @since NakedCompass 1.0
 */

/** =========================================================================== **/
/* > Constants
/** =========================================================================== **/

	/**
	 * THEME_NAME is used throughout the site for things like translations and
	 * concatenated to the front of filter, action, and function names.
	 */
	define( 'THEME_NAME', 'NakedCompass');
	define( 'POST_EXCERPT_LENGTH', 60);
	define( 'TEMPLATE_URL', get_bloginfo('template_url') );
	define( 'STYLES_DIR', TEMPLATE_URL.'/css' );

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

		// Load the JS
		add_action('init', array($this, 'remove_wp_js') );
		add_action('init', array($this, 'add_js') );
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

	function add_js()
	{

		// Load the google api jquery
		// http://encosia.com/2008/12/10/3-reasons-why-you-should-let-google-host-jquery-for-you/
		wp_enqueue_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js', '', NULL, true);
		
		// Do not load these scripts if on the admin page	
		if (!is_admin()){

			// Enables threaded comments if the option is selected
		    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
		    	wp_enqueue_script( 'comment-reply', '', '', '', true );
		}
	}	
}


/** =========================================================================== **/
/* > Utilities
/** =========================================================================== **/

Class Utilities 
{

	/**
	 * add_js
	 *
	 * The build script automatically combines and minifies javascript files found
	 * in the footer so in order to preserve the use of the wp_enqueue_script 
	 * we can pass the js file generated by the build script to this function and which will 
	 * call wp_enqueue_script
	 *
	 * @param path 
	 * @param req (mixed) str or array list of dependencies
	 * @param in_footer (bool) true to load the js in the head  
	 */
	public function add_js($path, $req, $in_footer)
	{
		$pos = strrpos($path, '/') + 1;
		$name = Utilities::slice_string($path, $pos );
		$name= preg_replace("/((-[0-9.]+)?(.min)?(.js)$)/", '', $name);
		$name = Utilities::clean_string($name, 50, '');

		$path = TEMPLATE_URL.$path;
		wp_enqueue_script( $name, $path, $req, NULL, $in_footer );
	}

	/**
	 * clean_string()
	 *
	 * Creates URL friendly strings (wordpress style)
	 */
	public function clean_string($phrase, $maxLength=50, $sub='-') 
	{
	    $result = strtolower($phrase);
	    $result = preg_replace("/[^a-z0-9\s-]/", $sub, $result);
	    $result = trim(preg_replace("/[\s-]+/", " ", $result));
	    $result = trim(substr($result, 0, $maxLength));
	    $result = preg_replace("/\s/", $sub, $result);
	    return $result;
	}

	/**
	 * slice_string
	 *
	 * The start of the range is inclusive and the end is exclusive
	 *
	 * @param input (str) the string to be sliced up
	 * @param slice (mixed) can be a single character index, or a range separated by a colon.
	 */

	public function slice_string($input, $slice) {



		if (is_int($slice)) {
			$start = $slice;
		} else { 
			$arg = explode(':', $slice);
			$start = intval($arg[0]);
		}

	    if ($start < 0) {
	        $start += strlen($input);
	    }
	    if (count($arg) === 1) {
	        return substr($input, $start, 1);
	    }
	    if (trim($arg[1]) === '') {
	        return substr($input, $start);
	    }
	    $end = intval($arg[1]);
	    if ($end < 0) {
	        $end += strlen($input);
	    }
	    return substr($input, $start, $end - $start);
	}

	/**
	 * twitterStyleDate()
	 * 
	 * Twitter style post dates // 트위터 스타일의 날짜 표시법
	 * i.e. instead of 'Posted 13 Jan 2011 at 7:03' it displays 'Posted 3 hours ago'
	 */
	 
	public function twitterStyleDate($rtime) 
	{
		$tmptime = time() - $rtime;
		if($tmptime < 0)
			$rtimeStr = "Posted 1 second ago";
		else if ($tmptime < 60)
			$rtimeStr = "Posted ". (int)$tmptime . " seconds ago";
		else if ($tmptime < 120)
			$rtimeStr = "Posted ". (int)($tmptime/60) . " minute ago";
		else if ($tmptime < 3600)
			$rtimeStr = "Posted ". (int)($tmptime/60) . " minutes ago";
		else if ($tmptime < 7200)
			$rtimeStr = "Posted ". (int)($tmptime/3600) . " hour ago";
		else if ($tmptime < 86400)
			$rtimeStr = "Posted ". (int)($tmptime/3600) . " hours ago";
		else if ($tmptime < 172800)
			$rtimeStr = "Posted ". (int)($tmptime/86400) . " day ago";
		else if ($tmptime < 604800)
			$rtimeStr = "Posted ". (int)($tmptime/86400) . " days ago";
		else
			$rtimeStr = date('d F Y \a\t H:i:s' , $rtime);

		return $rtimeStr;
	}

	public function debug($obj){
		echo '<pre>';
		var_dump($obj);
		echo '</pre>';
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

?>