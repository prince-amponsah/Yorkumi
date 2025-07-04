<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesCustomJS' ) ) {
    class DesignThemesCustomJS {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            $this->load_modules();
            $this->frontend();
        }

        function load_modules() {
            include_once DT_THEME_DIR_PATH.'modules/add-js/customizer/index.php';
        }

        function frontend() {
            $js = dt_customizer_settings('additional_js');
            if( !empty( $js ) ) {
                add_action( 'wp_footer', array( $this, 'load_js' ), 9999 );
            }
        }

        function load_js(){
            $js = dt_customizer_settings('additional_js');
            echo '<!-- customizer additional_js -->';
                echo '<script type="text/javascript">'.stripslashes($js).'</script>';
            echo '<!-- customizer additional_js -->';        
        }        

    }
}

DesignThemesCustomJS::instance();