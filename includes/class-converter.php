<?php
/**
 * File class-converter.php
 *
 * This file belongs to the WebP Converter plugin.
 *
 * Responsibilities:
 * - Handle image conversion to WebP format.
 * - Check compatibility and requirements for conversion.
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
 * The converter class.
 */
class Converter {
	/**
	 * Check if imagick is available.
	 */
	public function is_imagick_available() {
		return extension_loaded( 'imagick' ) && class_exists( 'Imagick' );
	}

	/**
	 * Check if webp format is supported.
	 */
	public function is_webp_supported() {
		try {
			$imagick = new \Imagick();
			$formats = $imagick->queryFormats( 'WEBP' );
			return in_array( 'WEBP', $formats, true );
		} catch ( \Exception $e ) {
			return false;
		}
	}

	/**
	 * Check if imagick is active in the server
	 * and if it supports webp format.
	 */
	public function is_conversion_supported() {
		if ( $this->is_imagick_available() ) {
			return $this->is_webp_supported();
		}
		return false;
	}
}
