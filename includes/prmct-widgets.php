<?php

/**
 * Register a custom widget for WordPress
 * 
 * @link       premium.chat
 * @since      1.0.4
 *
 * @package    premium-chat
 * @subpackage premium-chat/includes
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PRMCT_widget extends WP_Widget {

    /**
	 * Construct widget
	 *
	 * @since    1.0.0
	 */
    function __construct() {

        parent::__construct(

            // widget ID
            'premium_chat_widget',

            // widget name
            __('Premium.Chat widget', 'premium-chat'),

            // widget description
            array( 'description' => __( 'Add a Premium.Chat widget to your toolbar.', 'premium-chat' ), )

        );

    }

    /**
	 * The widget output
	 *
	 * @since    1.0.0
	 */
    public function widget( $args, $instance ) {

        $prmct_widget_id = $instance['prmct_widget_id'];
        if(isset($prmct_widget_id) && $prmct_widget_id != 0){
            echo $args['before_widget'];
                echo do_shortcode(sprintf("[premium-chat id='%s']", $prmct_widget_id));
            echo $args['after_widget'];
        }

    }

    /**
	 * The widget form
	 *
	 * @since    1.0.0
	 */
    public function form( $instance ) {
        if ( isset( $instance[ 'prmct_widget_id' ] ) ){
            $prmct_widget_id = $instance[ 'prmct_widget_id' ];
        }else{
            $prmct_widget_id = 0;
        }
    ?>
        <p>
            <?php echo sprintf(__('Go to <a href="%s" target="_blank">premium.chat</a> and register your widget.', 'premium-chat'), 'https://premium.chat' ); ?>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'prmct_widget_id' ); ?>"><?php _e( 'Widget ID:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'prmct_widget_id' ); ?>" name="<?php echo $this->get_field_name( 'prmct_widget_id' ); ?>" type="number" value="<?php echo esc_attr( $prmct_widget_id ); ?>" />
        </p>
    <?php

    }

    /**
	 * The widget update
	 *
	 * @since    1.0.0
	 */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['prmct_widget_id'] = ( ! empty( $new_instance['prmct_widget_id'] ) ) ? strip_tags( $new_instance['prmct_widget_id'] ) : '';
        return $instance;
    }

}