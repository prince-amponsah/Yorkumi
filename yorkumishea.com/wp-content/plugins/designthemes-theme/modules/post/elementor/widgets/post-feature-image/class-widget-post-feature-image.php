<?php
use DTElementor\Widgets\DTElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Post_Feature_Image extends DTElementorWidgetBase {

    public function get_name() {
        return 'dt-post-feature-image';
    }

    public function get_title() {
        return __('Post - Feature Image', 'designthemes-theme');
    }

    public function get_icon() {
		return 'fa fa-picture-o';
	}

    protected function register_controls() {

        $this->start_controls_section( 'dt_section_general', array(
            'label' => __( 'General', 'designthemes-theme'),
        ) );

            $this->add_control( 'enable_lightbox', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __('Enable Lightbox?', 'designthemes-theme'),
                'label_on'     => __( 'Yes', 'designthemes-theme' ),
                'label_off'    => __( 'No', 'designthemes-theme' ),
                'return_value' => 'yes',
                'default'      => '',
				'description' => __('YES! to enable lightbox preview feature.', 'designthemes-theme')
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
        $template_args['enable_image_lightbox'] = $enable_lightbox;

		$out .= '<div class="'.$el_class.'">';
            $out .= savon_get_template_part( 'post', 'templates/'.$Post_Style.'/parts/image', '', $template_args );
		$out .= '</div><!-- Featured Image -->';

		echo $out;
	}

    protected function content_template() {
    }
}