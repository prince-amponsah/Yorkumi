<?php
use DTElementor\Widgets\DTElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Post_Related_Article extends DTElementorWidgetBase {

    public function get_name() {
        return 'dt-post-related-article';
    }

    public function get_title() {
        return __('Post - Related Article', 'designthemes-theme');
    }

    public function get_icon() {
		return 'fa fa-clone';
	}

    protected function register_controls() {

        $this->start_controls_section( 'dt_section_general', array(
            'label' => __( 'General', 'designthemes-theme'),
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

        $template_args['post_ID'] = $post_id;

        $out .= savon_get_template_part( 'post', 'templates/post-extra/related_article', '', $template_args );

		echo $out;
	}

    protected function content_template() {
    }
}