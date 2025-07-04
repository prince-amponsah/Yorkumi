<?php

/**
 * WooCommerce - Taxonomy Core Class
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Dt_Shop_Others_Taxonomy' ) ) {

    class Dt_Shop_Others_Taxonomy {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Create page - Custom Fields
                add_action('product_cat_add_form_fields', array ( $this, 'dtshop_taxonomy_add_new_meta_field' ), 20, 1);

            // Edit page - Custom Fields
                add_action('product_cat_edit_form_fields', array ( $this, 'dtshop_taxonomy_edit_meta_field' ), 20, 1);

            // Save - Custom Fields
                add_action('edited_product_cat', array ( $this, 'dtshop_save_taxonomy_custom_meta' ), 20, 1);
                add_action('create_product_cat', array ( $this, 'dtshop_save_taxonomy_custom_meta' ), 20, 1);

            // Enqueue Admin Scripts
                add_action ( 'admin_enqueue_scripts', array ( $this, 'dtshop_admin_enqueue_scripts' ) );

            // Load Modules
				$this->load_modules();

        }


        /*
        Module Paths
        */

            function module_dir_path() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_DIR . '/woocommerce/others/taxonomy/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( savon_is_file_in_theme( __FILE__ ) ) {
                    return SAVON_MODULE_URI . '/woocommerce/others/taxonomy/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }


        /**
         * Create page - Custom Fields
         */
            function dtshop_taxonomy_add_new_meta_field( $terms ) {

                ?>
                <div class="form-field">
                    <label for="dtshop_cat_color"><?php esc_html_e('Color', 'designthemes-theme'); ?></label>
                    <input type="text" name="dtshop_cat_color" id="dtshop_cat_color" class="dtshop-color-picker-alpha">
                    <p class="description"><?php esc_html_e('If you wish choose specific color for your category.', 'designthemes-theme'); ?></p>
                </div>
                <?php
            }

        /**
         * Edit page - Custom Fields
         */
            function dtshop_taxonomy_edit_meta_field( $term ) {

                //getting term ID
                $term_id = $term->term_id;

                // retrieve the existing value(s) for this meta field.
                $dtshop_cat_color = get_term_meta($term_id, 'dtshop_cat_color', true);
                ?>
                <tr class="form-field">
                    <th scope="row" valign="top"><label for="dtshop_cat_color"><?php esc_html_e('Color', 'designthemes-theme'); ?></label></th>
                    <td>
                        <input type="text" name="dtshop_cat_color" id="dtshop_cat_color" class="dtshop-color-picker-alpha" value="<?php echo esc_attr($dtshop_cat_color) ? esc_attr($dtshop_cat_color) : ''; ?>">
                        <p class="description"><?php esc_html_e('If you wish choose specific color for your category.', 'designthemes-theme'); ?></p>
                    </td>
                </tr>
                <?php
            }

        /**
         * Save - Custom Fields
         */
            function dtshop_save_taxonomy_custom_meta( $term_id ) {

                $dtshop_cat_color = filter_input(INPUT_POST, 'dtshop_cat_color');
                update_term_meta($term_id, 'dtshop_cat_color', $dtshop_cat_color);

            }

        /**
         * Enqueue Admin Scripts
         */
            function dtshop_admin_enqueue_scripts() {

                $current_screen = get_current_screen();
                if($current_screen->id == 'edit-product_cat') {

                    wp_enqueue_script('dtshop-taxonomy', $this->module_dir_url() . 'assets/js/taxonomy.js', array ('jquery'), false, true);

                }

            }

        /**
         * Load Modules
         */
            function load_modules() {

                include_once $this->module_dir_path(). 'elementor/index.php';

            }

    }

}

if( !function_exists('dtshop_others_taxonomy') ) {
	function dtshop_others_taxonomy() {
        $reflection = new ReflectionClass('Dt_Shop_Others_Taxonomy');
        return $reflection->newInstanceWithoutConstructor();
	}
}

Dt_Shop_Others_Taxonomy::instance();