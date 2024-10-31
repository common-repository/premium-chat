<?php

/**
 * Define the internationalization functionality.
 * 
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       premium.chat
 * @since      1.0.0
 *
 * @package    premium-chat
 * @subpackage premium-chat/includes
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PRMCT_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'premium-chat',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
