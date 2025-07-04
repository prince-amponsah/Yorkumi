<?php
    if( isset( $enable_404message ) && $enable_404message == 1  ) {
        $class = $notfound_style;
        $class .= ( isset( $notfound_darkbg ) && ( $notfound_darkbg == 1 ) ) ? " dt-sc-dark-bg" :"";
    ?>
    <div class="wrapper <?php echo esc_attr( $class );?>">
        <div class="container">
            <div class="center-content-wrapper">
                <div class="center-content">
                <?php if( class_exists( '\Elementor\Plugin' ) ) {
                        $elementor_instance = Elementor\Plugin::instance();

                        if( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
                            $css_file = new \Elementor\Core\Files\CSS\Post( $pageid );
                            $css_file->enqueue();
                        }

                        if( !empty( $elementor_instance ) ) {
                            echo "{$elementor_instance->frontend->get_builder_content_for_display( $pageid )}";
                        }    
                    } else {
                        $content = get_the_content( '', false, $page_id );
                        echo do_shortcode( $content );
                    } ?>
                </div>
            </div>
        </div>
    </div><?php
    }
?>