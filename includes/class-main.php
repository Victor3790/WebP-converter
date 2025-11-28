<?php
/**
 * File class-main.php
 *
 * This file belongs to the WebP Converter plugin.
 *
 * Responsibilities:
 * - Initialize the plugin.
 * - Register WordPress hooks (actions and filters) for admin and public areas.
 *
 * @package    VCN_WebP_Converter
 * @since      1.0.0
 * @author     Victor Crespo
 * @license    GPL-2.0-or-later
 */

namespace VcnWebpConverter;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Main class for the VCN WebP Converter plugin.
 */
class Main {
	/**
	 * The plugin instance.
	 *
	 * @var Main
	 */
	private static $instance = null;

	/**
	 * The constructor.
	 */
	private function __construct() {
		$this->define_constants();

		require_once PATH . 'includes/class-converter.php';

		// Add Hooks here.
		register_activation_hook( VCN_WEBP_CONVERTER_PLUGIN_FILE, array( $this, 'activate' ) );
		add_action( 'admin_notices', array( $this, 'display_messages' ) );
	}

	/**
	 * Get an instance.
	 *
	 * @return Main
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Define the constants for the plugin.
	 */
	private function define_constants() {
		if ( ! defined( __NAMESPACE__ . '\VERSION' ) ) {
			define( __NAMESPACE__ . '\VERSION', '1.0.0' );
		}

		if ( ! defined( __NAMESPACE__ . '\URL' ) ) {
			define( __NAMESPACE__ . '\URL', plugin_dir_url( VCN_WEBP_CONVERTER_PLUGIN_FILE ) );
		}

		if ( ! defined( __NAMESPACE__ . '\PATH' ) ) {
			define( __NAMESPACE__ . '\PATH', plugin_dir_path( VCN_WEBP_CONVERTER_PLUGIN_FILE ) );
		}
	}

	/**
	 * Actions to perform on plugin activation.
	 */
	public function activate() {
		// Check if imagick is available and webp is a supported format.
		$converter = new Converter();
		if ( ! $converter->is_conversion_supported() ) {
			set_transient( 'vcn_webp_conversion_supported', true, 5 );
		}
	}

	/**
	 * Handle plugin admin messages.
	 */
	public function display_messages() {
		if ( get_transient( 'vcn_webp_conversion_supported' ) ) {
			?>
			<div class="notice notice-error is-dismissible">
				<p>
					<strong><?php echo esc_html( get_plugin_data( __FILE__ )['Name'] ); ?>:</strong> 
					The Imagick extension is not available on your server or the webp format is not supported. Conversion will not work properly.
					Please contact your hosting provider to enable the Imagick PHP extension.
				</p>
			</div>
			<?php
		} else {
			delete_transient( 'vcn_webp_conversion_supported' );
			?>
			<div class="notice notice-info is-dismissible">
				<p>
					<strong><?php echo esc_html( get_plugin_data( VCN_WEBP_CONVERTER_PLUGIN_FILE )['Name'] ); ?>:</strong> 
					Ready to convert images to WebP format!
				</p>
			</div>
			<?php
		}
	}
}
