<div class="side-navigation">
    <div class="side-nav-container">
        <ul class="side-nav"><?php 
            $args   = array('child_of' => $id,'title_li' => '','sort_order'=> 'ASC','sort_column' => 'menu_order');
            $parent = wp_get_post_parent_id( $id );
            
            if( $parent ) {
                $args = array('child_of' => $parent,'title_li' => '','sort_order'=> 'ASC','sort_column' => 'menu_order');
            }

            $pages = get_pages( $args );
            $ids   = array();

            foreach($pages as $page) {
                $ids[] = $page->ID;
            }

            foreach( $ids as $pid ) {
                $title     = get_the_title($pid);
                $permalink = get_permalink( $pid );
                $current   = ( $id ===  $pid) ? "current_page_item" : "";

                echo '<li class="'.esc_attr( $current ).'">';
                    echo '<a href="'.esc_url( $permalink ).'">'.esc_html( $title ).'</a>';
                echo '</li>';
            }
            ?>
        </ul>
    </div><?php
    if( !empty( $show_content ) && !empty( $content_id ) ){
        if( class_exists( '\Elementor\Plugin' ) ) {
            $elementor_instance = Elementor\Plugin::instance();
            
            if( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
                $css_file = new \Elementor\Core\Files\CSS\Post( $content_id );
                $css_file->enqueue();
            }

            if( !empty( $elementor_instance ) ) {
                echo "{$elementor_instance->frontend->get_builder_content_for_display( $content_id )}";
            }            

        } else {
            $content = get_the_content( '', false, $content_id );
            echo do_shortcode( $content );
        }
    }?>
</div>