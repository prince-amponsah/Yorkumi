<?php
use DTElementor\Widgets\DTElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Post_Meta_Group extends DTElementorWidgetBase {

    public function get_name() {
        return 'dt-post-meta-group';
    }

    public function get_title() {
        return __('Post - Meta Group', 'designthemes-theme');
    }

    public function get_icon() {
		return 'fa fa-address-card-o';
	}

    protected function register_controls() {
		
        $this->start_controls_section( 'dt_section_general', array(
            'label' => __( 'General', 'designthemes-theme'),
        ) );

            $content = new Repeater();
            $content->add_control( 'element_value', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => __('Element', 'designthemes-theme'),
                'default' => 'author',
                'options' => array(
                    'author'      => __('Author', 'designthemes-theme'),
                    'date'        => __('Date', 'designthemes-theme'),
                    'comment'     => __('Comments', 'designthemes-theme'),
                    'category'    => __('Categories', 'designthemes-theme'),
                    'tag'         => __('Tags', 'designthemes-theme'),
                    'social'      => __('Social Share', 'designthemes-theme'),
                    'likes_views' => __('Likes & Views', 'designthemes-theme'),
                ),
            ) );

            $this->add_control( 'blog_meta_position', array(
                'type'        => Controls_Manager::REPEATER,
                'label'       => __('Meta Group Positioning', 'designthemes-theme'),
                'fields'      => array_values( $content->get_controls() ),
                'default'     => array(
                    array( 'element_value' => 'author' ),
                ),
                'title_field' => '{{{ element_value.replace( \'_\', \' \' ).replace( /\b\w/g, function( letter ){ return letter.toUpperCase() } ) }}}'
            ) );

            $this->add_control( 'style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => __('Style', 'designthemes-theme'),
                'default' => 'metagroup-space-separator',
                'options' => array(
                    'metagroup-space-separator'  => __('Space', 'designthemes-theme'),
                    'metagroup-slash-separator'  => __('Slash', 'designthemes-theme'),
                    'metagroup-vertical-separator'  => __('Vertical', 'designthemes-theme'),
                    'metagroup-horizontal-separator'  => __('Horizontal', 'designthemes-theme'),
                    'metagroup-dot-separator'  => __('Dot', 'designthemes-theme'),
                    'metagroup-comma-separator'  => __('Comma', 'designthemes-theme'),
                    'metagroup-elements-boxed'  => __('Boxed', 'designthemes-theme'),
                    'metagroup-elements-boxed-curvy'  => __('Boxed Curvy', 'designthemes-theme'),
                    'metagroup-elements-boxed-round'  => __('Boxed Round', 'designthemes-theme'),
                    'metagroup-elements-filled'  => __('Filled', 'designthemes-theme'),
                    'metagroup-elements-filled-curvy'  => __('Filled Curvy', 'designthemes-theme'),
                    'metagroup-elements-filled-round'  => __('Filled Round', 'designthemes-theme'),
                ),
                'description' => __('Select any one of meta group styling.', 'designthemes-theme'),
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

		$newMEles = array();
		$meta_group_position = !empty( $blog_meta_position ) ? $blog_meta_position : explode( ',', $blog_meta_position );

		if( is_array( $meta_group_position[0] ) ) {
			foreach($meta_group_position as $key => $items) {
				$newMEles[$items['element_value']] = $items['element_value'];
			}
		} else {
			foreach($meta_group_position as $item) {
				$newMEles[$item] = $item;
			}
		}

		if( count( $newMEles ) >= 1 ) {

			$out .= '<div class="dt-sc-posts-meta-group '.$style.' '.$el_class.'">';

                $Post_Style = savon_get_single_post_style( $post_id );

                $template_args['post_ID'] = $post_id;
                $template_args['post_Style'] = $Post_Style;
                $template_args = array_merge( $template_args, savon_single_post_params() );

				foreach( $newMEles as $value ):

                    switch( $value ):

                        case 'likes_views':
                        case 'social':
                            $out .= savon_get_template_part( 'post', 'templates/post-extra/'.$value, '', $template_args );
                            break;

                        default:
                            $out .= savon_get_template_part( 'post', 'templates/'.$Post_Style.'/parts/'.$value, '', $template_args );
                            break;

                    endswitch;

				endforeach;

			$out .= '</div>';
		}

		echo $out;
    }

    protected function content_template() {
    }
}