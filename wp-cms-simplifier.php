<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://hanover.digital
 * @since             1.0.0
 * @package           Wp_Cms_Simplifier
 *
 * @wordpress-plugin
 * Plugin Name:       WP CMS simplifier
 * Plugin URI:        http://hanover.digital
 * Description:       A quick way to strip commonly unused elements from the WordPress CMS interface
 * Version:           1.0.0
 * Author:            Shaun Dobson
 * Author URI:        http://hanover.digital
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-cms-simplifier
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-cms-simplifier-activator.php
 */
function activate_wp_cms_simplifier() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-cms-simplifier-activator.php';
	Wp_Cms_Simplifier_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-cms-simplifier-deactivator.php
 */
function deactivate_wp_cms_simplifier() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-cms-simplifier-deactivator.php';
	Wp_Cms_Simplifier_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_cms_simplifier' );
register_deactivation_hook( __FILE__, 'deactivate_wp_cms_simplifier' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-cms-simplifier.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_cms_simplifier() {

	$plugin = new Wp_Cms_Simplifier();
	$plugin->run();

}
run_wp_cms_simplifier();
