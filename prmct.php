<?php

/**
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              premium.chat
 * @since             1.0.1
 * @package           Premium Chat
 *
 * @wordpress-plugin
 * Plugin Name:       Premium Chat
 * Plugin URI:        premium.chat
 * Description:       Get Paid to Chat By Adding a Profitable New Revenue Stream to your Website and Social Media. This plugin can be used to add the Premium.chat widget to your website.
 * Version:           1.0.1
 * Author:            Premium Chat
 * Author URI:        https://premium.chat/
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       premium-chat
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Include plugin actication
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// The plugins folder path
define('PRMCT_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define('PRMCT_ASSETS_FOLDER', plugins_url('assets/', __FILE__));
define('PRMCT_MINIFY', true); // set to false if you want to change javascript/css
define('PRMCT_CSS_JS_VERSION', '1.1');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/prmct-init.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/prmct-activator.php
 */
function PRMCT_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/prmct-activator.php';
	PRMCT_Activator::activate();
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/prmct-deactivator.php
 */
function PRMCT_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/prmct-deactivator.php';
	PRMCT_Deactivator::deactivate();
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.1
 */
function PRMCT_run() {
	$plugin = new PRMCT_init();
	$plugin->run();
}

register_activation_hook( __FILE__, 'PRMCT_activate');
register_deactivation_hook( __FILE__, 'PRMCT_deactivate' );
PRMCT_run();