<div class="dt-no-header-builder-content dt-no-header-savon">
    <div class="no-header">
        <div class="no-header-logo">
            <a href="<?php echo esc_url( home_url('/') );?>" title="<?php bloginfo('title'); ?>"><?php echo savon_get_header_logo();?></a>
        </div>
        <?php
            $menu = false;
            if( has_nav_menu('main-menu') ) { ?>
                <div class="no-header-menu dt-header-menu" data-menu="dummy-menu">
                    <?php
                        $menu = wp_nav_menu( array(
                            'theme_location'  => 'main-menu',
                            'container_class' => 'menu-container',
                            'items_wrap'      => '<ul id="%1$s" class="%2$s" data-menu="dummy-menu"> <li class="close-nav"></li> %3$s </ul> <div class="sub-menu-overlay"></div>',
                            'menu_class'      => 'dt-primary-nav',
                            'link_before'     => '<span>',
                            'link_after'      => '</span>',
                            'walker'          => new Savon_Default_Hedaer_Walker_Nav_Menu,
                            'echo'            => false
                        ) );

                        echo apply_filters( 'savon_default_menu', $menu );

                        if( $menu ) { ?>
                            <div class="mobile-nav-container" data-menu="dummy-menu">
                                <div class="menu-trigger menu-trigger-icon" data-menu="dummy-menu">
                                    <i></i>
                                    <span><?php esc_html_e('Menu', 'savon'); ?></span>
                                </div>
                            	<div class="mobile-menu mobile-nav-offcanvas-right" data-menu="dummy-menu"></div>
                            </div><?php
                        } ?>
                </div><?php
            }?>
    </div>
</div>