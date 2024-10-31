<?php

/**
 * 
 * Init dependecies
 * 
 * @link       premium.chat
 * @since      1.0.0
 *
 * @package    premium-chat
 * @subpackage premium-chat/includes
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PRMCT_init {

    /**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'premium-chat';
		$this->version     = '1.0.0';
		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->set_locale();

	}

	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/prmct-loader.php';

		/**
		 * The class responsible for hooks
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/prmct-hooks.php';

		/**
		 * The class responsible for registering WordPress widgets
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/prmct-widgets.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/prmct-i18n.php';

		$this->loader 	= new PRMCT_Loader();

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function define_admin_hooks() {

		$wphooks		= new PRMCT_Hooks();

		// Register shortcode
		add_shortcode( 'premium-chat', array($wphooks, 'PRMCT_shortcode') );
		
		// Register widget 
		$this->loader->add_action( 'widgets_init', $wphooks, 'PRMCT_register_widget' );

		// Register gutenber custom category
		$this->loader->add_filter( 'block_categories', $wphooks, 'PRMCT_add_block_category' );

		// Register gutenberg block
		$this->loader->add_action( 'init', $wphooks, 'PRMCT_register_gutenberg_block');

		// Redirect admin to welcome page ater activating the plugin
		$this->loader->add_action( 'admin_init', $wphooks, 'PRMCT_redirect_admin');
		
		// Register the page for the wizard.
		$this->loader->add_action( 'admin_menu', $wphooks, 'PRMCT_add_wizard_page' );
		$this->loader->add_action( 'admin_enqueue_scripts', $wphooks, 'PRMCT_enqueue_assets' );

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Bucket_Auth_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new PRMCT_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}


}