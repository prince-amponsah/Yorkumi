<?php
use DTElementor\Widgets\DTElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Header_Menu extends DTElementorWidgetBase {

    public function get_name() {
        return 'dt-header-menu';
    }

    public function get_title() {
        return esc_html__('Header Menu', 'designthemes-theme');
    }

    public function get_icon() {
		return 'fa fa-bars';
	}

    protected function register_controls() {

		$nav_menus = array( 0 => esc_html__('Select Menu', 'designthemes-theme')  );
		$menus     = wp_get_nav_menus();

		foreach ($menus as $menu ) {
			$nav_menus[$menu->term_id] = $menu->name;
		}

        $this->start_controls_section( 'dt_section_general', array(
            'label' => esc_html__( 'General', 'designthemes-theme'),
        ) );
            $this->add_control( 'nav_id', array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Choose Menu', 'designthemes-theme'),
				'default' => '0',
				'options' => $nav_menus
            ) );

            $this->add_responsive_control( 'align', array(
                'label'        => esc_html__( 'Alignment', 'designthemes-theme' ),
                'type'         => Controls_Manager::CHOOSE,
                'prefix_class' => 'elementor%s-align-',
                'options'      => array(
                    'left'   => array( 'title' => esc_html__('Left','designthemes-theme'), 'icon' => 'eicon-h-align-left' ),
                    'center' => array( 'title' => esc_html__('Center','designthemes-theme'), 'icon' => 'eicon-h-align-center' ),
                    'right'  => array( 'title' => esc_html__('Right','designthemes-theme'), 'icon' => 'eicon-h-align-right' ),
                )
            ) );
        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

        $navigation = wp_nav_menu( array(
        	'menu'            => $nav_id,
			'container_class' => 'menu-container',
			'items_wrap'      => '<ul id="%1$s" class="%2$s" data-menu="'.$nav_id.'"> <li class="close-nav"></li> %3$s </ul> <div class="sub-menu-overlay"></div>',
			'menu_class'      => 'dt-primary-nav',
			'link_before'     => '<span>',
			'link_after'      => '</span>',
            'walker'          => new Savon_Walker_Nav_Menu,
            'echo'            => false
        ) );

        $out = '<div class="dt-header-menu" data-menu="'.esc_attr( $nav_id ).'">';

        	$out .= $navigation;

            $out .= '<div class="mobile-nav-container mobile-nav-offcanvas-right" data-menu="'.esc_attr( $nav_id ).'">';
                $out .= '<div class="menu-trigger menu-trigger-icon" data-menu="'.esc_attr( $nav_id ).'">';
                    $out .= '<i></i>';
                    $out .= '<span>'.esc_html__('Menu', 'designthemes-theme').'</span>';
                $out .= '</div>';
                $out .= '<div class="mobile-menu" data-menu="'.esc_attr( $nav_id ).'"></div>';
                $out .= '<div class="overlay"></div>';
            $out .= '</div>';

        $out .= '</div>';

        echo $out;
    }

    protected function content_template() {
    }
}