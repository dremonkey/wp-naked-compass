<?php
/**
 * The template for displaying the footer.
 * Contains the closing of #container, #main, and the empty div#sticky_push
 * used to make sure the footer always sticks to the bottom of the page 
 */
?>
		</div><!-- #end main -->
		<div id="sticky_push"></div>
	</div><!-- end #container -->
<footer id="footer">

	<a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
	<a href="http://wordpress.org/" title="Semantic Personal Publishing Platform" rel="generator">Proudly powered by WordPress </a>

</footer>

<?php wp_footer(); ?>

	<!-- mathiasbynens.be/notes/async-analytics-snippet Change UA-XXXXX-X to be your site's ID -->
	<script>
		var _gaq=[["_setAccount","UA-XXXXX-X"],["_trackPageview"],["_trackPageLoadTime"]];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
		g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
		s.parentNode.insertBefore(g,s)}(document,"script"));
	</script>

</body>
</html>