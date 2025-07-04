<?php 
class DThemes_widget_Flickr extends WP_Widget {
	#1.constructor
	function __construct() {
		$widget_options = array(
			"classname"   => 'widget_flickr',
			'description' => esc_html__('A widget that show last flickr photo streams', 'dt-flickr')
		);
		parent::__construct( false, esc_html__('DThemes Flickr Widget','dt-flickr'), $widget_options );
	}

	#2.widget input form in back-end
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'     =>'',
			'flickr_id' =>'',
			'count'     =>'3',
			'show'      =>'latest',
			't_width'   => 90,
			't_height'  => 90
		) );

		$title     = empty($instance['title']) ?	'' : strip_tags($instance['title']);
		$flickr_id = empty($instance['flickr_id']) ? '' : strip_tags($instance['flickr_id']);
		$count     = empty($instance['count']) ? '' : strip_tags($instance['count']);
		$show      = empty($instance['show']) ? '' : strip_tags($instance['show']);
		$size      = empty($instance['size']) ? '' : strip_tags($instance['size']); ?>
        
        <p>
        	<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
        		<?php esc_html_e('Title:','dt-flickr');?> 
        		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/>
        	</label>
        </p>
           
        <p>
        	<label for="<?php echo esc_attr( $this->get_field_id('flickr_id') ); ?>">
        		<?php esc_html_e('Flickr ID:','dt-flickr');?>
        		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('flickr_id')); ?>" name="<?php echo esc_attr($this->get_field_name('flickr_id')); ?>" type="text" value="<?php echo esc_attr($flickr_id);?>"/>
        	</label>
        </p>

        <p>
        	<label for="<?php echo esc_attr($this->get_field_id('count')); ?>">
        		<?php esc_html_e('How many entries do you want to show:','dt-flickr');?>
        		<select class="widefat" id="<?php echo esc_attr($this->get_field_id('count')); ?>" name="<?php echo esc_attr($this->get_field_name('count')); ?>"><?php
        			for($i = 1; $i <= 30; $i++) :
        				$selected = ($count == $i ) ? "selected='selected'" : "";?>
        				<option <?php echo esc_attr($selected);?> value="<?php echo esc_attr($i);?>"><?php echo esc_attr($i);?></option><?php
        			endfor;?>
        		</select>
        	</label>
        </p>

         <p>
         	<label for="<?php echo esc_attr($this->get_field_id('show'));?>">
         		<?php esc_html_e('What pictures to display','dt-flickr'); ?>
         		<select class="widefat" id="<?php echo esc_attr($this->get_field_id('show')); ?>" name="<?php echo esc_attr($this->get_field_name('show')); ?>"><?php
         			$a = array(
						"latest" => esc_html__("Latest",'dt-flickr'),
						"random" => esc_html__("Random",'dt-flickr')
         			);
         			foreach($a as $key => $value ) :
         				$selected = ($show == $key ) ? "selected='selected'" : ""; ?>
        				<option <?php echo esc_attr( $selected );?> value="<?php echo esc_attr($key);?>"><?php echo esc_attr($value);?></option><?php
        			endforeach;?>
        		</select>
        	</label>
        </p>

		<p>
			<label for="<?php echo $this->get_field_id( 't_width' ); ?>">
				<?php _e( 'Thumbnail width', 'dt-flickr' ); ?>:</label>
				<input class="small-text" type="text" value="<?php echo absint( $instance['t_width'] ); ?>" id="<?php echo $this->get_field_id( 't_width' ); ?>" name="<?php echo $this->get_field_name( 't_width' ); ?>" /> px
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 't_height' ); ?>">
				<?php _e( 'Thumbnail height', 'dt-flickr' ); ?>:</label>
				<input class="small-text" type="text" value="<?php echo absint( $instance['t_height'] ); ?>" id="<?php echo $this->get_field_id( 't_height' ); ?>" name="<?php echo $this->get_field_name( 't_height' ); ?>" /> px
				<small class="howto"><?php _e( 'Note: You can use "0" value for auto height', 'dt-flickr' ); ?></small>
		</p><?php
	}
	
	#3.processes & saves the twitter widget option
	function update($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['title']     = strip_tags($new_instance['title']);
		$instance['count']     = absint($new_instance['count']);
		$instance['flickr_id'] = strip_tags($new_instance['flickr_id']);
		$instance['show']      = strip_tags($new_instance['show']);
		$instance['t_width']   = absint( $new_instance['t_width'] );
		$instance['t_height']  = absint( $new_instance['t_height'] );

		return $instance;
	}
	
	#4.output in front-end
	function widget($args, $instance) {
		extract($args);

		echo $this->dt_flickr_before_after_widget( $before_widget ); 

			$title     = empty($instance['title'])		? '' : strip_tags($instance['title']);
			$flickr_id = empty($instance['flickr_id'])	? '' : strip_tags($instance['flickr_id']);
			$count     = empty($instance['count'])		? '' : absint($instance['count']);
			$t_width   = empty($instance['t_width'])    ? '' : absint($instance['t_width']);
			$t_height  = empty($instance['t_height'])	? '' : absint($instance['t_height']);
			$show      = $instance['show'];

			if( !empty( $title ) ) {

				echo $this->dt_flickr_widget_title( $before_title . $title . $after_title );			
			}

			$photos = $this->get_photos( $flickr_id, $count );
			if ( !empty( $photos ) ) {

				$height = $t_height ? $t_height.'px' : 'auto';
				$style = 'style="width: '.esc_attr( $t_width ).'px; height: '.esc_attr( $height ).';"';

				echo "<ul class='flickr-widget'>";
					foreach ( $photos as $photo ) {
						extract( $photo );
						echo '<li>';
							echo '<a href="'.esc_url( $url ).'" title="'.esc_attr( $title ).'" target="_blank">';
								echo '<img src="'.esc_url( $src ).'" alt="'.esc_attr( $title ).'" title="'.esc_attr( $title ).'" '.$style.'/>';
							echo '</a>';
						echo '</li>';
					}
				echo "</ul>";
			}

		echo $this->dt_flickr_before_after_widget( $after_widget ); 
	}

	function get_photos( $id, $count = 9 ){
		if ( empty( $id ) )
			return false;

		$transient_key = md5( 'dt_flickr_cache_' . $id . $count );
		$cached = get_transient( $transient_key );
		if ( !empty( $cached ) ) {
			return $cached;
		}

		$protocol = is_ssl() ? 'https' : 'http';
		$output = array();
		$rss = $protocol.'://api.flickr.com/services/feeds/photos_public.gne?id='.$id.'&lang=en-us&format=rss_200';
		$rss = fetch_feed( $rss );

		if ( is_wp_error( $rss ) ) {
			//check for group feed
			$rss = $protocol.'://api.flickr.com/services/feeds/groups_pool.gne?id='.$id.'&lang=en-us&format=rss_200';
			$rss = fetch_feed( $rss );
		}

		if ( !is_wp_error( $rss ) ) {
			$maxitems = $rss->get_item_quantity( $count );
			$rss_items = $rss->get_items( 0, $maxitems );
			foreach ( $rss_items as $item ) {
				$temp          = array();
				$temp['url']   = esc_url( $item->get_permalink() );
				$temp['title'] = esc_html( $item->get_title() );

				$content =  $item->get_content();
				preg_match_all( "/<IMG.+?SRC=[\"']([^\"']+)/si", $content, $sub, PREG_SET_ORDER );
				$photo_url   = str_replace( "_m.jpg", ".jpg", $sub[0][1] );
				$temp['src'] = esc_url( $photo_url );
				
				$output[]      = $temp;

			}

			set_transient( $transient_key, $output, 60 * 60 * 24 );			
		}

		return $output;
	}

	/**
	 * Widget:
	 * 	Before, After Widget wp_kses
	 */
	function dt_flickr_before_after_widget ( $content ) {
		$allowed_html = array(
			'aside' => array(
				'id'    => array(),
				'class' => array()
			),
			'div' => array(
				'id'    => array(),
				'class' => array(),
			)
		);

		$data = wp_kses( $content, $allowed_html );

		return $data;
	}

	/**
	 * Widget : Title wp_kses
	 */
	function dt_flickr_widget_title( $content ) {

		$allowed_html = array(
			'div' => array(
				'id'    => array(),
				'class' => array()
			),
			'h2' => array(
				'class' => array()
			),
			'h3' => array(
				'class' => array()
			),				
		);

		$data = wp_kses( $content, $allowed_html );

		return $data;
	}
}?>