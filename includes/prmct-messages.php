<?php

/**
 * 
 * WP Admin messages
 * 
 * @link       premium.chat
 * @since      1.0.0
 *
 * @package    premium-chat
 * @subpackage premium-chat/includes
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'PRMCT_Message' ) ){

    class PRMCT_Message {

        private $_message;
        private $_type;
        private $_isdismissible;

        public function __construct( $message, $type, $isdismissible ) {

            $this->_message         = $message;
            $this->_type            = $type;
            $this->_isdismissible   = $isdismissible;
            add_action( 'admin_notices', array( $this, 'show_prmct_message' ) );

        }

        public function show_stlp_message(){
            if(!empty($this->_message) && !empty($this->_type)){
                $dismissible = ($this->_isdismissible == true) ? 'is-dismissible' : '';
                ?>
                <div class="prmct-messages notice notice-<?php echo $this->_type; ?> <?php echo $dismissible; ?>" data-notice="prmct_message">
                <p><?php echo $this->_message; ?></p>
                </div>
            <?php
            }
        }

    }

}