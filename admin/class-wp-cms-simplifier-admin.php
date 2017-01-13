<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://hanover.digital
 * @since      1.0.0
 *
 * @package    Wp_Cms_Simplifier
 * @subpackage Wp_Cms_Simplifier/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Cms_Simplifier
 * @subpackage Wp_Cms_Simplifier/admin
 * @author     Shaun Dobson <shaun@hanover.digital>
 */
class Wp_Cms_Simplifier_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Cms_Simplifier_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Cms_Simplifier_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-cms-simplifier-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Cms_Simplifier_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Cms_Simplifier_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-cms-simplifier-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	public static function cms_customisations() {
		
		// Enable SVGs in media uploader
			if ( ! function_exists( 'cc_mime_types' ) ) {
				function cc_mime_types( $mimes ) {
					$mimes['svg'] = 'image/svg+xml';
					return $mimes;
				}
				add_filter( 'upload_mimes', 'cc_mime_types' );			
			}

		// Make SVGs visible in media library
		// From SVG support plugin http://wordpress.org/plugins/svg-support/
		// The plugin (not on Github so I couldn't fork it) adds code to the front-end which I don't want, but this function below 
		// in addition to the above mime types addition (not from the plugin) does everything I need
			if ( ! function_exists( 'hd_svgs_display_thumbs' ) ) {
	
				function hd_svgs_display_thumbs() {
				
					ob_start();
				
					add_action( 'shutdown', 'hd_svgs_thumbs_filter', 0 );
					function hd_svgs_thumbs_filter() {
				
					    $final = '';
					    $ob_levels = count( ob_get_level() );
				
					    for ( $i = 0; $i < $ob_levels; $i++ ) {
				
					        $final .= ob_get_clean();
				
					    }
				
					    echo apply_filters( 'final_output', $final );
				
					}
				
					add_filter( 'final_output', 'hd_svgs_final_output' );
					function hd_svgs_final_output( $content ) {
				
						$content = str_replace(
							'<# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',
							'<# } else if ( \'svg+xml\' === data.subtype ) { #>
								<img class="details-image" src="{{ data.url }}" draggable="false" />
								<# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',
				
							$content
						);
				
						$content = str_replace(
							'<# } else if ( \'image\' === data.type && data.sizes ) { #>',
							'<# } else if ( \'svg+xml\' === data.subtype ) { #>
								<div class="centered">
									<img src="{{ data.url }}" class="thumbnail" draggable="false" />
								</div>
							<# } else if ( \'image\' === data.type && data.sizes ) { #>',
				
							$content
						);
				
						return $content;
				
					}
				}
				add_action('admin_init', 'hd_svgs_display_thumbs');
			}

		// Give editors access to 'Appearance' menu
			// get the the role object
			$role_object = get_role( 'editor' );
			// add $cap capability to this role object
			$role_object->add_cap( 'edit_theme_options' );

		// Disable theme and plugin editors
			define( 'DISALLOW_FILE_EDIT', true);
			
		// Disable the theme editor (this should be superfluous thanks to above addition)
			if ( ! function_exists( 'hd_remove_editor_menu' ) ) {
				function hd_remove_editor_menu() {
				    remove_action('admin_menu', '_add_themes_utility_last', 101);
				}
				add_action('_admin_menu', 'hd_remove_editor_menu', 1);
			}			
			
		// Remove 'Comments' and other commonly unused options from CMS menu
			if ( ! function_exists( 'hd_remove_admin_menu_items' ) ) {
				function hd_remove_admin_menu_items() {
					$remove_menu_items = array(
						__('Comments'),
						__('Links'),
						__('Profile'),
						__('Posts')
					);
					global $menu;
					end ($menu);
					while (prev($menu)){
						$item = explode(' ',$menu[key($menu)][0]);
						if(in_array($item[0] != NULL?$item[0]:"" , $remove_menu_items)){
						unset($menu[key($menu)]);}
					}
				}
				add_action('admin_menu', 'hd_remove_admin_menu_items');
			}	

		// Remove options from the admin toolbar
			if ( ! function_exists( 'hd_edit_toolbar' ) ) {
				function hd_edit_toolbar($wp_toolbar) {
				    $wp_toolbar->remove_node('wp-logo');				// Remove the WordPress logo
				    $wp_toolbar->remove_node('comments'); 				// Remove the comments box
				    $wp_toolbar->remove_node('new-content'); 			// Remove the '+ New' option
					$wp_toolbar->remove_node('wpseo-menu'); 			// Remove the 'SEO' option    
				}		 
				add_action('admin_bar_menu', 'hd_edit_toolbar', 999);
			}

		// Customise the admin footer
			
			// Remove footer WP version
				if ( ! function_exists( 'remove_footer_wp_version' ) ) {
					function remove_footer_wp_version() {
						remove_filter( 'update_footer', 'core_update_footer' ); 
					}
					add_action( 'admin_menu', 'remove_footer_wp_version' );
				}
			// Customise admin footer text
				if ( ! function_exists( 'customise_admin_footer_text' ) ) {
					function customise_admin_footer_text () {
						echo 'Custom designed CMS for [site name] by <a href="http://hanover.digital" target="_blank">hanover digital</a> | Powered by WordPress (version ' . get_bloginfo( 'version' ) . ')</p>';
					}
					add_filter('admin_footer_text', 'customise_admin_footer_text');
				}		
		
	}

}
