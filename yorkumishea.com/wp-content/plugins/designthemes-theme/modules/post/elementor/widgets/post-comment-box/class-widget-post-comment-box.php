<?php
use DTElementor\Widgets\DTElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Post_Comment_Box extends DTElementorWidgetBase {

    public function get_name() {
        return 'dt-post-comment-box';
    }

    public function get_title() {
        return __('Post - Comment Box', 'designthemes-theme');
    }

    public function get_icon() {
		return 'fa fa-commenting';
	}

    protected function register_controls() {

        $this->start_controls_section( 'dt_section_general', array(
            'label' => __( 'General', 'designthemes-theme'),
        ) );

            $this->add_control( 'comment_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => __('Style', 'designthemes-theme'),
                'default' => '',
                'options' => array(
                    ''  => __('Default', 'designthemes-theme'),
                    'rounded'	=> __('Rounded', 'designthemes-theme'),
                    'square'  	=> __('Square', 'designthemes-theme'),
                ),
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
        $template_args = array_merge( $template_args, savon_single_post_params() );
        $template_args['post_commentlist_style'] = $comment_style;

        $out .= savon_get_template_part( 'post', 'templates/post-extra/comment_box', '', $template_args );

		echo $out;
	}

    protected function content_template() {
    }
}