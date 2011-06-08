<?php
/**
 * Provides activation/deactivation hook for wordpress theme.
 *
 * @author Krishna Kant Sharma (http://www.krishnakantsharma.com)
 *
 * Usage:
 * ----------------------------------------------
 * Include this file in your theme code.
 * ----------------------------------------------
 * function my_theme_activate() {
 *    // code to execute on theme activation
 * }
 * register_theme_activation_hook('mytheme', 'my_theme_activate');
 *
 * function my_theme_deactivate() {
 *    // code to execute on theme deactivation
 * }
 * register_theme_deactivation_hook('mytheme', 'my_theme_deactivate');
 * ----------------------------------------------
 * 
 * 
 */

/**
 *
 * @desc registers a theme activation hook
 * @param $code (str) : Code of the theme. This can be the base folder of your theme. Eg if your theme is in folder 'mytheme' then code will be 'mytheme'
 * @param $function (callback) : Function to call when theme gets activated.
 */
function register_theme_activation_hook($code, $function) {
    $option_key = "theme_is_activated_" . $code;
    if(!get_option($option_key)) {
        call_user_func($function);
        update_option($option_key , 1);
    }
}

/**
 * @desc registers deactivation hook
 * @param $code (str) : Code of the theme. This must match the value you provided in wp_register_theme_activation_hook function as $code
 * @param $function (callback) : Function to call when theme gets deactivated.
 */
function register_theme_deactivation_hook($code, $function) {
    // store function in code specific global
    $GLOBALS["register_theme_deactivation_hook_function" . $code]=$function;

    // create a runtime function which will delete the option set while activation of this theme and will call deactivation function provided in $function
    $fn=create_function('$theme', ' call_user_func($GLOBALS["register_theme_deactivation_hook_function' . $code . '"]); delete_option("theme_is_activated_' . $code. '");');

    // Your theme can perceive the switch theme hook as a deactivation hook.
    add_action("switch_theme", $fn);
}