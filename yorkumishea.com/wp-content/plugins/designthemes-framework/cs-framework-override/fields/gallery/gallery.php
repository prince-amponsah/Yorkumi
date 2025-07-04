<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Gallery
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class CSFramework_Option_Gallery extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output(){

    echo apply_filters( 'cs_element_before', $this->element_before() );

    $value  = $this->element_value();
    $add    = ( ! empty( $this->field['add_title'] ) ) ? $this->field['add_title'] : esc_html__( 'Add Gallery', 'designthemes-framework' );
    $edit   = ( ! empty( $this->field['edit_title'] ) ) ? $this->field['edit_title'] : esc_html__( 'Edit Gallery', 'designthemes-framework' );
    $clear  = ( ! empty( $this->field['clear_title'] ) ) ? $this->field['clear_title'] : esc_html__( 'Clear', 'designthemes-framework' );
    $hidden = ( empty( $value ) ) ? ' hidden' : '';

    $show_id = isset($this->field['show_id']) ? $this->field['show_id'] : false;

    echo '<ul>';

    if( ! empty( $value ) ) {

      $values = explode( ',', $value );

      foreach ( $values as $id ) {
        $show_id_html = '';
        if($show_id) {
          $show_id_html = '<span>'.$id.'</span>';
        }
        $attachment = wp_get_attachment_image_src( $id, 'thumbnail' );
        echo '<li><img src="'. $attachment[0] .'" alt="'.esc_attr__( 'Image', 'designthemes-framework' ).'" />'.$show_id_html.'</li>';
      }

    }

    echo '</ul>';
    echo '<a href="#" class="button button-primary cs-add">'. $add .'</a>';
    echo '<a href="#" class="button cs-edit'. $hidden .'">'. $edit .'</a>';
    echo '<a href="#" class="button cs-warning-primary cs-remove'. $hidden .'">'. $clear .'</a>';
    echo '<input type="text" name="'. $this->element_name() .'" value="'. $value .'"'. $this->element_class() . $this->element_attributes() .'/>';

    echo apply_filters( 'cs_element_after', $this->element_after() );
  }

}
