<?php

/**
 * The actual WP functions and hooks.
 * 
 * @link       premium.chat
 * @since      1.0.5
 *
 * @package    premium-chat
 * @subpackage premium-chat/includes
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PRMCT_Hooks {

	const PAGE_IDENTIFIER = 'prmct_configurator';
    
    /**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.5
	 *
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct() {
        // Nothing to construct
	}

	/**
	 * This allow us to add the premium.chat in any page, porst by using shortcode [premium-chat id="xxxx"]
	 */

	public function PRMCT_shortcode($atts, $content = ''){

		$widget = '';

		// The widget id is needed in order to add it
		if(isset($atts['id']) && !empty($atts['id'])){
			$widget .= '<!-- BEGIN PREMIUM.CHAT CODE {literal} -->';
			$widget .= '<div class="pchat-widget-placeholder"></div>';
			$widget .= '<script type="text/javascript">';
			$widget .= sprintf("(function(d,w,i){w.premiumchat = w.premiumchat || [];var p = w.premiumchat; if(!p.length){function l(){
				w.premiumchat_domain = 'https://premium.chat/';var s = d.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = w.premiumchat_domain+'embed/js/widget.js'; var ss = d.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}
				if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}}
				p.push({'num': p.length, 'wid': i});})(document, window,%s);", esc_attr($atts['id']));
			$widget .= '</script>';
			$widget .= '<!-- {/literal} END PREMIUM.CHAT CODE -->';
			$widget .= '<style>.pchat-widget-block{ max-width: 475px !important; }</style>';
		}
		return $widget;

	}

	/**
	 * This will register a widget
	 */
	public function PRMCT_register_widget(){
		register_widget( 'PRMCT_widget' );
	}

	/**
	 * This will add an extra gutenberg category
	 */
	public function PRMCT_add_block_category($categories){

		// Skip block registration if Gutenberg is not enabled/merged.
		if (!function_exists('register_block_type')) {
			return;
		}

		$categories[] = [
			'slug'  => 'premium-chat-blocks',
			'title' => sprintf(
				__( '%1$s Blocks', 'premium-chat' ),
				'Premium.Chat'
			),
		];

		return $categories;

	}

	/**
	 * Register our custom gutenberg block
	 */
	public function PRMCT_register_gutenberg_block(){

		// Skip block registration if Gutenberg is not enabled/merged.
		if (!function_exists('register_block_type')) {
			return;
		}

		wp_register_script(
			'premium-chat',
			PRMCT_ASSETS_FOLDER . 'build/premium-chat.js',
			array(
				'wp-blocks',
				'wp-editor',
				'wp-i18n'
			),
			true
		  );

		register_block_type('premium-chat/premium-chat', array(
			'editor_script' => 'premium-chat',
			'render_callback' => [$this, 'PRMCT_block_handler_render_callback'],
			'attributes' => [
				'id' => [
					'default' => 1
				]
			]
		));

	}

	/**
	 * Output our custom gutenberg block
	 */
	public function PRMCT_block_handler_render_callback($atts){
		$html = '';
		if(isset($atts['id']) && !empty($atts['id'])){
			$html .= '<p>';
				$html .= do_shortcode(sprintf('[premium-chat id="%s"]', esc_attr($atts['id'])));
			$html .= '</p>';
		}else{
			$html .= __('Please add a Widget ID to your block.','premium-chat');
		}
		return $html;
	}

	/**
	 * This will add the plugin wizard page
	 */
	public function PRMCT_add_wizard_page(){
		add_dashboard_page( 'Premium.Chat', 
							'Premium.Chat', 
							'manage_options', 
							self::PAGE_IDENTIFIER, 
							array($this, 'PRMCT_render_wizard_page')
						);
	}

	/**
	 * This will add the plugin wizard page assets
	 */
	public function PRMCT_enqueue_assets(){
		$minify_enabled = (PRMCT_MINIFY == true) ? 'min.' : '';
		$minify_version = (PRMCT_MINIFY == true) ? PRMCT_CSS_JS_VERSION : time();
		wp_register_style( 'premium-chat-main-css', PRMCT_ASSETS_FOLDER . sprintf('css/premium-chat-admin.%scss', $minify_enabled), '', $minify_version, 'all' );
		wp_register_style( 'premium-chat-bootstrap-css', PRMCT_ASSETS_FOLDER . 'css/bootstrap.min.css', '', '', 'all' );
	}

	/**
	 * This render the wizard page
	 */
	public function PRMCT_render_wizard_page(){
			$this->PRMCT_enqueue_assets();
			$dashboard_url = admin_url( sprintf('/index.php') );
			$wizard_title  = sprintf(
				__( '%s &rsaquo; Welcome', 'premium-chat' ),
				'Premium.Chat'
			);
		?>
		<!DOCTYPE html>
		<!--[if IE 9]>
		<html class="ie9" <?php language_attributes(); ?> >
		<![endif]-->
		<!--[if !(IE 9) ]><!-->
		<html <?php language_attributes(); ?>>
		<!--<![endif]-->
		<head>
			<meta name="viewport" content="width=device-width, initial-scale=1"/>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
			<title><?php echo esc_html( $wizard_title ); ?></title>
			<?php
				wp_print_head_scripts();
				wp_print_styles( 'premium-chat-main-css' );
				wp_print_styles( 'premium-chat-bootstrap-css' );
			?>
		</head>
		<body class="wp-admin wp-core-ui premium_chat_wizard">
			<div class="premium_chat_wizard">
				<div class="container top">
					<div class="row">
						<nav class="navbar navbar-expand-md  w-100">
							<a class="navbar-brand" href="https://premium.chat" target="_blank">
								<img src="<?php echo PRMCT_ASSETS_FOLDER . 'images/logo-dark-new.svg'; ?>" alt="logo">
							</a>
							<a class="button premium-chat-wizard-return-link" href="<?php echo esc_url( $dashboard_url ); ?>">
								<span aria-hidden="true" class="dashicons dashicons-no"></span>
								<?php
									echo __( 'Close the introduction', 'premium-chat' );
								?>
							</a>
						</nav>
					</div>
				</div>
				<div class="container entry-section">
					<div class="row">
						<div class="col-md-6 pt-4 pb-5 mobile-white mobile-white-border mt-0 mt-md-4">
							<div class="row text-left text-md-left">
								<div class="col-md-12 pl-md-3 ml-md-3 ml-lg-0">
									<h1 class="color434F5E ins-txt-shadow font-20-mobile"><?php echo __('Get Paid to Chat By Adding a Profitable New
										Revenue Stream to your Website and Social Media','premium-chat'); ?></h1>
								</div>
							</div>
							<!-- row END -->
							<div class="row text-left text-md-left mt-3">
								<div class="col-md-12 pl-md-3 ml-md-3 ml-lg-0 color697B90-08 ">
									<p class="pr-5 ins-txt-shadow"><?php echo __('Premium.Chat is a powerful online live chat billing software
										platform for Advisors, Coaches, Consultants, Experts, Counselors,
										Influencers, Psychics, Entertainers, Tech Support Specialists,
										Creators, and any individual or business wanting to earn money
										by the minute for chatting. Charge a pay per minute fee, or a
										flat rate price to your fans, followers, and customers for your
										advice, expertise, or service through one-on-one paid text chat.','premium-chat'); ?></p>
								</div>
							</div>
							<!-- row END -->
							<div class="row text-left text-md-left mt-2">
								<div class="col-md-12 pl-md-3 ml-md-3 ml-lg-0 color697B90-08">
									<p class="ins-txt-shadow"><?php echo __('Get Your Paid Chat Widget Setup in 3 Minutes, and Start
										Making Money today - with no setup costs, or monthly fees!','premium-chat'); ?></p>
								</div>
							</div>
							<!-- row END -->
							<div class="row text-left text-md-left mt-3 d-md-flex">
								<div class="col-md-12 pl-md-3 ml-md-3 ml-lg-0 text-center text-lg-left">
									<a href="https://premium.chat/user/signup-seller" target="_blank" title="<?php echo __('Signup','premium-chat'); ?>" class="btn btn-success btn-gradient px-4 py-2 mr-3 mb-4"><?php echo __('Get Started for','premium-chat'); ?>
										<?php echo __('Free','premium-chat'); ?>
									</a>
									<a href="https://www.youtube.com/watch?v=fZtfTUBTFFo" target="_blank" title="<?php echo __('View how it works','premium-chat'); ?>" class="btn btn-transparent px-4 py-2 mb-4">
										<div class="d-flex align-content-center color697B90">
											<img class="mr-2" src="<?php echo PRMCT_ASSETS_FOLDER . 'images/icon-play.svg'; ?>">
											<span><?php echo __('See How It Works','premium-chat'); ?></span>
										</div>
									</a>
								</div>
							</div>
							<!-- row END -->
						</div>
						<div class="col-md-6 pt-4 mt-4">
							<img class="img-fluid pc-home-widget" src="<?php echo PRMCT_ASSETS_FOLDER . 'images/home-widget.png'; ?>">
						</div>
					</div>
					<!-- row END -->
				</div>
				<div class="container entry-section">
					<div class="row">
						<div class="col-md-4 pt-4 mt-4">
							<h4><?php echo __('Gutenberg','premium-chat'); ?></h4>
							<p><?php echo __('Add the Premium.chat Gutenberg Block to your post, page or custom post type.','premium-chat'); ?></p>
							<img class="img-fluid pc-home-widget" src="<?php echo PRMCT_ASSETS_FOLDER . 'images/premium-chat-gutenberg.jpg'; ?>">
						</div>
						<div class="col-md-4 pt-4 mt-4">
							<h4><?php echo __('Toolbar widget','premium-chat'); ?></h4>
							<p><?php echo __('Add the Premium.chat toolbar widget to your sidebar, footer or other toolbars.','premium-chat'); ?></p>
							<img class="img-fluid pc-home-widget" src="<?php echo PRMCT_ASSETS_FOLDER . 'images/premium-chat-toolbars.jpg'; ?>">
						</div>
						<div class="col-md-4 pt-4 mt-4">
							<h4><?php echo __('Shortcode','premium-chat'); ?></h4>
							<p><?php echo __('Add a shortcode in your post, page or custom post type.','premium-chat'); ?></p>
							<img class="img-fluid pc-home-widget" src="<?php echo PRMCT_ASSETS_FOLDER . 'images/premium-chat-shortcode.jpg'; ?>">
						</div>
					</div>
					<!-- row END -->
				</div>
			</div>
			<?php
				wp_print_scripts( 'premium-chat-main-js' );
			?>
		</body>
		</html>
	<?php
		exit;
	}

	/**
	 * Redirect the user to the introduction page
	 * of the plugin.
	 */
	public function PRMCT_redirect_admin(){
		if ( get_option( 'Activated_Premium_chat' ) ) {
			delete_option( 'Activated_Premium_chat' );
			if ( ! headers_sent() ) {
				exit(wp_redirect(sprintf('index.php?page=%s', self::PAGE_IDENTIFIER)));
			}
		}
	}

}