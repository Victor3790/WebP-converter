<?php
/**
 * Plugin Name: VCN WebP Converter
 * Description: This plugin transforms images to webp format when needed.
 * Author: Victor Crespo
 * Author URI: https://victorcrespo.net
 * Version: 1.0.0
 * License: GPL2
 *
 * @package    VCN_WebP_Converter
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

// Define the plugin file path.
if ( ! defined( 'VCN_WEBP_CONVERTER_PLUGIN_FILE' ) ) {
	define( 'VCN_WEBP_CONVERTER_PLUGIN_FILE', __FILE__ );
}

require_once 'includes/class-main.php';

$show_repeater = VcnWebpConverter\Main::get_instance();
