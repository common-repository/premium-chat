<?php

/**
 * Fired during plugin deactivation
 *
 * @link       premium.chat
 * @since      1.0.0
 *
 * @package    premium-chat
 * @subpackage premium-chat/includes
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PRMCT_Deactivator { 

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// Delete the option
		delete_option( 'Activated_Premium_chat' );
	}

}
