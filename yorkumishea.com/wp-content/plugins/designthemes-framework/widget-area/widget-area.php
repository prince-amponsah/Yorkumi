<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'DesignThemesFrameworkWidgetArea' ) ) {
    class DesignThemesFrameworkWidgetArea {

		protected $widget_areas     = array();
		protected $orig             = array();
		private   static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
    
            return self::$_instance;
        }

        function __construct() {
            /**
             * Before Hook
             */
            do_action( 'dt_before_fw_widget_area_load' );

                add_action( 'admin_print_scripts-widgets.php', array( $this, 'add_widget_box' ) );
                add_action( 'load-widgets.php', array( $this, 'enqueue_scripts' ), 100 );
                add_action( 'load-widgets.php', array( $this, 'create_widget_area' ), 100 );

                add_action( 'widgets_init', array( $this, 'register_main_widget_areas' ), 10 );			
                add_action( 'widgets_init', array( $this, 'register_custom_widget_areas' ), 20 );

                add_action( 'wp_ajax_dt_delete_widget_area', array( $this, 'delete_widget_area' ) );

            /**
             * Adter Hook
             */
            do_action( 'dt_after_fw_metabox_load' );
        }

		public function add_widget_box() { ?>
			<script type="text/html" id="dttheme-add-widget-template">
				<div id="dttheme-add-widget" class="widgets-holder-wrap">
					<div>
						<div class="sidebar-name">
							<h3><?php esc_html_e( 'Create Widget Area', 'designthemes-framework' ); ?>
								<span class="spinner"></span>
							</h3>
			  			</div>
			  			<div class="sidebar-description">
			  				<form method="post">
			  					<div class="widget-content">
			  						<input id="dttheme-add-widget-input" name="dttheme-add-widget-input" type="text" class="regular-text" title="<?php esc_attr_e( 'Name', 'designthemes-framework' ); ?>" placeholder="<?php esc_attr_e( 'Name', 'designthemes-framework' ); ?>" />
			  					</div>
			  					<div class="widget-control-actions">
			  						<div class="aligncenter">
			  							<input class="button-primary" type="submit" value="<?php esc_attr_e( 'Create Widget Area', 'designthemes-framework' ); ?>" />
			  						</div>
									<br class="clear">
								</div>
							</form>
						</div>
					</div>
				</div>
			</script><?php
        }
        
        public function enqueue_scripts() {
            wp_enqueue_script( 'designthemes-widget-areas', DT_FW_DIR_URL.'widget-area/assets/js/widget-areas.js', array('jquery'), DT_FW_VERSION, true );
            wp_enqueue_style( 'designthemes-widget-areas', DT_FW_DIR_URL.'widget-area/assets/css/widget-areas.css', null, DT_FW_VERSION );
            wp_localize_script( 'designthemes-widget-areas', 'dtObject', array(
				'delete'      => esc_html__( 'Delete', 'designthemes-framework' ),
				'confirm'     => esc_html__( 'Confirm', 'designthemes-framework' ),
				'cancel'      => esc_html__( 'Cancel', 'designthemes-framework' ),
				'deleteNonce' => wp_create_nonce('widgetarea_delete_nonce')
			) );
        }

		public function create_widget_area() {
			if( !empty( $_POST['dttheme-add-widget-input'] ) ) {
				$this->widget_areas = $this->get_widget_areas();
				array_push( $this->widget_areas, $this->check_widget_area_name( $_POST['dttheme-add-widget-input'] ) );
				$this->save_widget_areas();
				wp_redirect( esc_url( admin_url( 'widgets.php' ) ) );
				die();
			}
        }
        
		public function check_widget_area_name( $name ) {
			if ( empty( $GLOBALS['wp_registered_widget_areas'] ) ) {
				return $name;
			}

			$taken = array();
			foreach ( $GLOBALS['wp_registered_widget_areas'] as $widget_area ) {
				$taken[] = $widget_area['name'];
			}

			$taken = array_merge( $taken, $this->widget_areas );

			if ( in_array( $name, $taken ) ) {
				$counter  = substr( $name, -1 );  
				$new_name = "";
				  
				if ( ! is_numeric( $counter ) ) {
					$new_name = $name . " 1";
				} else {
					$new_name = substr( $name, 0, -1 ) . ((int) $counter + 1);
				}

				$name = $this->check_widget_area_name( $new_name );
			}
			echo esc_html( $name );
			exit();
        }
        
		public function get_widget_areas() {
			// If the single instance hasn't been set, set it now.
			if ( ! empty( $this->widget_areas ) ) {
				return $this->widget_areas;
			}

			// Get widget areas saved in theme mod
            $widget_areas = get_option( 'designthemes-widget-areas' );
            if( $widget_areas ) {
                $widget_areas = $widget_areas['widget-areas'];
            }

			// If theme mod isn't empty set to class widget area var
			if ( ! empty( $widget_areas ) && is_array( $widget_areas ) ) {
				$this->widget_areas = array_unique( array_merge( $this->widget_areas, $widget_areas ) );
			}

			// Return widget areas
			return $this->widget_areas;
        }
        
		public function save_widget_areas() {
			$options = get_option( 'designthemes-widget-areas', array() );

			if( isset( $options['widget-areas'] ) ) {

				$options['widget-areas'] = array();
			}

			$options['widget-areas'] = array_unique( $this->widget_areas );

			update_option( 'designthemes-widget-areas', $options );
        }
        
        public function register_main_widget_areas() {
            $sidebars = apply_filters( 'dt_register_sidebars_array', array() );
            if ( $sidebars ) {
				$before_title = apply_filters( 'dt_widget_before_title_tag', '<h3 class="widgettitle">' );
                $after_title  = apply_filters( 'dt_widget_after_title_tag', '</h3>' );

                foreach ( $sidebars as $id => $name ) {
					register_sidebar( array(
						'name'          => $name,
						'id'            => $id,
						'before_widget' => '<aside id="%1$s" class="widget %2$s">',
						'after_widget'  => '</aside>',
						'before_title'  => $before_title,
						'after_title'   => $after_title,
					) );
                }
            }
        }

        public function register_custom_widget_areas() {
			// Get widget areas
			if ( empty( $this->widget_areas ) ) {
				$this->widget_areas = $this->get_widget_areas();
			}

			// Original widget areas is empty
			$this->orig = array();

			// Save widget areas
			if ( ! empty( $this->orig ) && $this->orig != $this->widget_areas ) {
				$this->widget_areas = array_unique( array_merge( $this->widget_areas, $this->orig ) );
				$this->save_widget_areas();
            }

            if ( is_array( $this->widget_areas ) ) {
				$before_title = apply_filters( 'dt_widget_before_title_tag', '<h3 class="widgettitle">' );
                $after_title  = apply_filters( 'dt_widget_after_title_tag', '</h3>' );
            }

            foreach ( array_unique( $this->widget_areas ) as $widget_area ) {
                register_sidebar( array(
                    'id'            => sanitize_key( $widget_area ),
                    'name'          => $widget_area,
                    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => $before_title,
                    'after_title'   => $after_title,
                ) );
            }
        }

        public function delete_widget_area() {
			$widgetarea_delete_nonce = $_POST['widgetarea_delete_nonce'];
			if(isset($widgetarea_delete_nonce) && wp_verify_nonce($widgetarea_delete_nonce, 'widgetarea_delete_nonce')) {

				if( !empty( $_REQUEST['widget'] ) ) {

					$name = strip_tags( ( stripslashes( $_REQUEST['widget'] ) ) );
					$this->widget_areas = $this->get_widget_areas();
					$key = array_search($name, $this->widget_areas );
					if ( $key >= 0 ) {
						unset( $this->widget_areas[$key] );
						$this->save_widget_areas();
					}

					echo json_encode( array(
						'status' => 'widget_area-deleted'
					) );
					wp_die();
				}
			}
        }
    }
}

DesignThemesFrameworkWidgetArea::instance();