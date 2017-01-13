<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://hanover.digital
 * @since      1.0.0
 *
 * @package    Wp_Cms_Simplifier
 * @subpackage Wp_Cms_Simplifier/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Cms_Simplifier
 * @subpackage Wp_Cms_Simplifier/includes
 * @author     Shaun Dobson <shaun@hanover.digital>
 */
class Wp_Cms_Simplifier_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-cms-simplifier',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
