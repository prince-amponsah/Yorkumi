<?php
use DTElementor\Widgets\DTElementorWidgetBase;
use Elementor\Controls_Manager;

class Elementor_Mailchimp extends DTElementorWidgetBase {

	public function get_name() {
		return 'dt-mailchimp';
	}

	public function get_title() {
		return esc_html__( 'Mailchimp', 'designthemes-theme' );
	}

    public function get_icon() {
		return 'eicon-mailchimp dtel-icon';
	}

	public function get_script_depends() {
		return array( 'dt-mailchimp' );
	}

	public function get_style_depends() {
		return array( 'dt-mailchimp' );
	}

	public function list_ids() {

		$lists = array();

		$apiKey = get_option( 'elementor_dt_mailchimp_api_key' );

		if( !empty( $apiKey ) ) {

        	$dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        	$url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/';

        	$ch = curl_init($url);
        	curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        	$result = curl_exec($ch);
        	curl_close($ch);

        	$result_decode = json_decode($result, true);

        	$results = ( isset($result_decode['lists']) && !empty($result_decode['lists']) ) ? $result_decode['lists'] : array();
        	$results = is_array( $results ) ? $results : array();

        	foreach( $results as $list  ) {
        		$lists[$list['id']] = $list['name'];
        	}
        }

        return $lists;
	}

	protected function register_controls() {

		$this->start_controls_section( 'general_settings', array(
			'label' => esc_html__( 'General', 'designthemes-theme' ),
		));

			$key = get_option( 'elementor_dt_mailchimp_api_key' );
			if( !$key ) {

				$this->add_control( 'api_key_info', array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf(
						__('To display customized Mailchimp widget without an issue, you need to configure API key. Please configure API key from <a href="%s" target="_blank" rel="noopener">here</a>.', 'designthemes-theme'),
						add_query_arg( array('page' => 'elementor#tab-designthemes' ), esc_url( admin_url( 'admin.php') ) )
					),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				) );
			}

			$this->add_control( 'title', array(
				'label'   => esc_html__( 'Title', 'designthemes-theme' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title', 'designthemes-theme' ),
			) );

			$this->add_control( 'listid', array(
				'label'     => esc_html__('List', 'designthemes-theme'),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => $this->list_ids()
			) );

		$this->end_controls_section();

		$this->start_controls_section( 'label_settings', array(
			'label' => esc_html__( 'Label', 'designthemes-theme' ),
		));

			$this->add_control( 'label_email', array(
				'label'   => esc_html__( 'Email', 'designthemes-theme' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Your Email', 'designthemes-theme' ),
			) );

			$this->add_control( 'label_button', array(
				'label'   => esc_html__( 'Button', 'designthemes-theme' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Subscribe Now', 'designthemes-theme' ),
			) );

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		extract( $settings );


		$this->add_render_attribute( 'wrapper', array(
			'id'    => 'dtel-mailchimp-'.esc_attr( $this->get_id() ),
			'class' => 'dtel-mailchimp-wrapper'
		) );

		echo '<div '.$this->get_render_attribute_string( 'wrapper' ).'>';

			if(!empty($title))
				echo "<h2>{$title}</h2>";

			$apiKey = get_option( 'elementor_dt_mailchimp_api_key' );
			echo '<form class="dt-sc-subscribe-frm" name="frmsubscribe" action="#" method="post">';

				echo "<input type='email' name='dt_mc_emailid' required='required' placeholder='{$label_email}' value=''>";

				echo "<input type='hidden' name='ajax' value='".admin_url('admin-ajax.php')."' />";
				echo "<input type='hidden' name='dt_mc_apikey' value='$apiKey' />";
				echo "<input type='hidden' name='dt_mc_listid' value='$listid' />";

				echo "<input type='submit' name='mc_submit' value='{$label_button}'>";

			echo '</form>';

			echo '<div class="dt_ajax_subscribe_msg"></div>';

		echo '</div>';
	}

	protected function content_template() {}
}