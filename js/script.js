/* mathiasbynens.be/notes/async-analytics-snippet Change UA-XXXXX-X to be your site's ID */
/* this should come first. So make sure to insert the snippet before all other scripts */
var _gaq=[["_setAccount","UA-XXXXX-X"],["_trackPageview"],["_trackPageLoadTime"]];
(function(d,t){
	var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
	g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
	s.parentNode.insertBefore(g,s)
}(document,"script"));


// jQuery Document Ready
jQuery(function() {
	jQuery("#layout li a").layoutSwitcher();
});