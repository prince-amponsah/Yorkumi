<?php
use DTElementor\Widgets\DTElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Tabs extends DTElementorWidgetBase {

    public function get_name() {
        return 'dt-tabs';
    }

    public function get_title() {
        return esc_html__('Tabs', 'designthemes-theme');
    }

    public function get_icon() {
		return 'eicon-number-field dtel-icon';
	}

	public function get_style_depends() {
		return array( 'dt-tabs' );
	}

	public function get_script_depends() {
		return array( 'dt-flowplayer-tabs', 'dt-tabs' );
	}

    protected function register_controls() {
        $this->start_controls_section( 'dt_section_general', array(
            'label' => esc_html__( 'General', 'designthemes-theme'),
        ) );
			$repeater = new Repeater();
			$repeater->add_control( 'item_type', array(
				'label'   => esc_html__( 'Content Type', 'designthemes-theme' ),
				'type'    => Controls_Manager::SELECT2,
				'default' => 'default',
				'options' => array(
					'default'  => esc_html__( 'Default', 'designthemes-theme' ),
					'template' => esc_html__( 'Template', 'designthemes-theme' ),
				)
			) );
			$repeater->add_control( 'item_title', array(
				'label'       => esc_html__( 'Title', 'designthemes-theme' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Tab Title', 'designthemes-theme' ),
				'default'     => esc_html__( 'Tab Title', 'designthemes-theme' )
			) );
			$repeater->add_control( 'item_content', array(
				'label'       => esc_html__( 'Content', 'designthemes-theme' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'placeholder' => esc_html__( 'Tab Content', 'designthemes-theme' ),
				'default'     => 'Sed ut perspiciatis unde omnis iste natus error sit, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae.',
				'condition'   => array( 'item_type' => 'default' )
			) );
			$repeater->add_control('item_template', array(
				'label'     => esc_html__( 'Select Template', 'designthemes-theme' ),
				'type'      => Controls_Manager::SELECT,
				'label_block' => true,
				'options'   => $this->dt_get_elementor_page_list(),
				'condition' => array( 'item_type' => 'template' )
			) );
			$this->add_control( 'tab_contents', array(
				'type'        => Controls_Manager::REPEATER,
				'label'       => esc_html__('Tab Contents', 'designthemes-theme'),
				'description' => esc_html__('Tab contents is a template which you can choose from Elementor library. Each template will be a carousel content', 'designthemes-theme' ),
				'fields'      => array_values( $repeater->get_controls() ),
			) );
			$this->add_control( 'tab_style', array(
				'label'              => esc_html__( 'Tab Style', 'designthemes-theme' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'horizontal',
				'frontend_available' => true,
				'options'            => array(
					'horizontal' => esc_html__( 'Horizontal', 'designthemes-theme' ),
					'vertical'   => esc_html__( 'Vertical', 'designthemes-theme' ),
				),
			) );
        $this->end_controls_section();

    }

    protected function render() {

		$settings = $this->get_settings();
		extract($settings);

		$output = '';

		if( count( $tab_contents ) > 0 ) {
			$output .= '<div class="dt-sc-tab-container '.esc_attr($tab_style).'">';

				$output .= '<ul class="dt-sc-tab-titles">';
					foreach( $tab_contents as $key => $tab_content ) {
						$output .= '<li>
										<a href="javascript:void(0);">'.esc_html($tab_content['item_title']).'</a>
									</li>';
					}
				$output .= '</ul>';

				$i = 0;
				foreach( $tab_contents as $key => $tab_content ) {
					$style_attr = 'style="display: none;"';
					if($i == 0) {
						$style_attr = 'style="display: block;"';
						$i++;
					}
					$output .= '<div class="dt-sc-tab-content" '.$style_attr.'>';
						if( $tab_content['item_type'] == 'default' ) {
							$output .= esc_html( $tab_content['item_content'] );
						}
						if( $tab_content['item_type'] == 'template' ) {
							$frontend = Elementor\Frontend::instance();
							$output .= $frontend->get_builder_content( $tab_content['item_template'], true );
						}
					$output .= '</div>';
				}

			$output .= '</div>';
		}

		echo $output;

	}

}