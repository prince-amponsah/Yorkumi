<?php
use DTElementor\Widgets\DTElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Post_Related_Posts extends DTElementorWidgetBase {

    public function get_name() {
        return 'dt-post-related-posts';
    }

    public function get_title() {
        return __('Post - Related Posts', 'designthemes-theme');
    }

    public function get_icon() {
		return 'fa fa-files-o';
	}

    protected function register_controls() {

        $this->start_controls_section( 'dt_section_general', array(
            'label' => __( 'General', 'designthemes-theme'),
        ) );

            $this->add_control( 'related_title', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => __('Title', 'designthemes-theme'),
                'default'     => __('Related Posts', 'designthemes-theme'),
				'description' => __('Put the related posts section title.', 'designthemes-theme'),
            ) );

            $this->add_control( 'related_column', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => __('Column', 'designthemes-theme'),
                'default' => 'one-third-column',
                'options' => array(
                    'one-column'  		=> __('I Column', 'designthemes-theme'),
                    'one-half-column'  	=> __('II Columns', 'designthemes-theme'),
                    'one-third-column'  => __('III Columns', 'designthemes-theme'),
                ),
            ) );

            $this->add_control( 'related_count', array(
                'type'        => Controls_Manager::NUMBER,
                'label'       => __('Count', 'designthemes-theme'),
                'default'     => '3',
                'placeholder' => __( 'Put no.of related posts to show.', 'designthemes-theme' ),
            ) );

            $this->add_control( 'related_excerpt', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __('Enable Excerpt?', 'designthemes-theme'),
                'label_on'     => __( 'Yes', 'designthemes-theme' ),
                'label_off'    => __( 'No', 'designthemes-theme' ),
                'return_value' => 'yes',
                'default'      => '',
            ) );

            $this->add_control( 'related_excerpt_length', array(
                'type'        => Controls_Manager::NUMBER,
                'label'       => __('Excerpt Length', 'designthemes-theme'),
                'default'     => '25',
                'condition' => array( 'related_excerpt' => 'yes' )
            ) );

            $this->add_control( 'related_carousel', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __('Enable Carousel?', 'designthemes-theme'),
                'label_on'     => __( 'Yes', 'designthemes-theme' ),
                'label_off'    => __( 'No', 'designthemes-theme' ),
                'return_value' => 'yes',
                'default'      => '',
            ) );

            $this->add_control( 'related_nav_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => __('Navigation Style', 'designthemes-theme'),
                'default' => '',
                'options' => array(
                    ''  		  => __('None', 'designthemes-theme'),
                    'navigation'  => __('Navigations', 'designthemes-theme'),
                    'pager'  	  => __('Pager', 'designthemes-theme'),
                ),
				'condition' => array( 'related_carousel' => 'yes' )
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
		$template_args['related_Title'] = $related_title;
		$template_args['related_Column'] = $related_column;
		$template_args['related_Count'] = $related_count;
		$template_args['related_Excerpt'] = $related_excerpt;
		$template_args['related_Excerpt_Length'] = $related_excerpt_length;
		$template_args['related_Carousel'] = $related_carousel;
		$template_args['related_Nav_Style'] = $related_nav_style;

		$out .= '<div class="entry-related-posts-wrapper '.$el_class.'">';
           $out .= savon_get_template_part( 'post', 'templates/post-extra/related_posts', '', $template_args );
		$out .= '</div>';

		echo $out;
	}

    protected function content_template() {
    }
}