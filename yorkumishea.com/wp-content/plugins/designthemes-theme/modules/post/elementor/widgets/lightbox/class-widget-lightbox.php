<?php
use DTElementor\Widgets\DTElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Lightbox extends DTElementorWidgetBase {

    public function get_name() {
        return 'dt-lightbox';
    }

    public function get_title() {
        return __('Lightbox Image', 'designthemes-theme');
    }

    public function get_icon() {
		return 'fa fa-picture-o';
	}

    protected function register_controls() {

        $this->start_controls_section( 'dt_section_general', array(
            'label' => __( 'General', 'designthemes-theme'),
        ) );

            $this->add_control( 'url', array(
                'type'        => Controls_Manager::MEDIA,
                'label'       => __('Choose Image', 'designthemes-theme'),
				'default'	  => array( 'url' => \Elementor\Utils::get_placeholder_image_src(), ),
                'description' => __( 'Choose any one image from media.', 'designthemes-theme' ),
            ) );

            $this->add_control( 'title', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => __('Title', 'designthemes-theme'),
                'default'     => '',
				'description' => __('Put the image title on preview.', 'designthemes-theme'),
            ) );

            $this->add_control( 'align', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => __('Alignment', 'designthemes-theme'),
                'default' => 'alignnone',
                'options' => array(
                    'alignnone'   => __('None', 'designthemes-theme'),
                    'alignleft'	  => __('Left', 'designthemes-theme'),
                    'aligncenter' => __('Center', 'designthemes-theme'),
                    'alignright'  => __('Right', 'designthemes-theme'),
                ),
            ) );

            $this->add_control( 'class', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => __('Extra class name', 'designthemes-theme'),
                'description' => __('Style particular element differently - add a class name and refer to it in custom CSS', 'designthemes-theme')
            ) );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

        $image = wp_get_attachment_image( $url['id'], 'full' );
        $lurl = wp_get_attachment_image_url( $url['id'], 'full' );
        $url = $image;

		if( !empty( $url ) ):
			if( !empty($class) ):
				$url = str_replace(' class="', ' class="'.$class.' ', $url);
			endif;

			if( !empty($align) ):
				$url = str_replace(' class="', ' class="'.$align.' ', $url);
			endif;

            #if( get_option('elementor_global_image_lightbox') ) :
                echo '<a href="'.$lurl.'" title="'.$title.'">'.$url.'</a>';
            #else:
            #    echo '<a href="'.$lurl.'" title="'.$title.'" class="lightbox-preview-img">'.$url.'</a>';
            #endif;
		endif;
	}

    protected function content_template() {
    }
}