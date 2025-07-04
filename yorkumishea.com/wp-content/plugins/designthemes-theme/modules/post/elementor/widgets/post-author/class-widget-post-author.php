<?php
use DTElementor\Widgets\DTElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Post_Author extends DTElementorWidgetBase {

    public function get_name() {
        return 'dt-post-author';
    }

    public function get_title() {
        return __('Post - Author', 'designthemes-theme');
    }

    public function get_icon() {
		return 'fa fa-user';
	}

    protected function register_controls() {

        $this->start_controls_section( 'dt_section_general', array(
            'label' => __( 'General', 'designthemes-theme'),
        ) );

            $this->add_control( 'style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => __('Style', 'designthemes-theme'),
                'default' => '',
                'options' => array(
                    ''  => __('Default', 'designthemes-theme'),
                    'meta-elements-space'		 => __('Space', 'designthemes-theme'),
                    'meta-elements-boxed'  		 => __('Boxed', 'designthemes-theme'),
                    'meta-elements-boxed-curvy'  => __('Curvy', 'designthemes-theme'),
                    'meta-elements-boxed-round'  => __('Round', 'designthemes-theme'),
					'meta-elements-filled'  	 => __('Filled', 'designthemes-theme'),
					'meta-elements-filled-curvy' => __('Filled Curvy', 'designthemes-theme'),
					'meta-elements-filled-round' => __('Filled Round', 'designthemes-theme'),
                ),
            ) );

            $this->add_control( 'el_class', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => __('Extra class name', 'designthemes-theme'),
                'description' => __('Style particular element differently - add a class name and refer to it in custom CSS', 'designthemes-theme')
            ) );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

		$out = '';

		global $post;
		$post_id =  $post->ID;

        $Post_Style = savon_get_single_post_style( $post_id );

		$template_args['post_ID'] = $post_id;
		$template_args['post_Style'] = $Post_Style;

		$out .= '<div class="entry-author-wrapper '.$style.' '.$el_class.'">';
            $out .= savon_get_template_part( 'post', 'templates/'.$Post_Style.'/parts/author', '', $template_args );
		$out .= '</div>';

		echo $out;
	}

    protected function content_template() {
    }
}