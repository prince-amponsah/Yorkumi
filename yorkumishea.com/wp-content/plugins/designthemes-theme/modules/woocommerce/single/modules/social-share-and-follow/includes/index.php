<?php

/*
* Sociable Share or Follow Frontend
*/

if( ! function_exists( 'dtshop_single_product_sociable_share_follow' ) ) {
	function dtshop_single_product_sociable_share_follow($product_id, $share_follow_type, $social_icon_style, $social_icon_radius, $social_icon_inline_alignment) {

		$sstitle = get_the_title($product_id);
		$ssurl = get_permalink($product_id);

		$output = '';

		$social_icon_style_cls = '';
		if($social_icon_style != '') {
			$social_icon_style_cls = 'style-'.$social_icon_style;
		}

		$social_icon_radius_cls = '';
		if($social_icon_radius != '') {
			$social_icon_radius_cls = 'radius-'.$social_icon_radius;
		}

		$social_icon_inline_alignment_cls = '';
		if($social_icon_inline_alignment == 'true') {
			$social_icon_inline_alignment_cls = 'align-inline';
		}

	    if($share_follow_type == 'share') {

			$output .= '<div class="dt-sc-single-product-share-container '.esc_attr($social_icon_style_cls).' '.esc_attr($social_icon_radius_cls).' '.esc_attr($social_icon_inline_alignment_cls).'">';

				$output .= '<a class="dt-sc-single-product-share-item-icon">'.esc_html__('Share:', 'designthemes-theme').'</a>';

                $output .= '<ul class="dt-sc-single-product-share-list">';

				$settings = dt_woo_single_core()->woo_default_settings();
				extract($settings);

					if($product_show_sharer_facebook) {
						$output .= '<li> <a href="//www.facebook.com/sharer.php?u='.esc_url($ssurl).'&amp;t='.urlencode($sstitle).'" title="facebook" target="_blank"> <span class="dticon-facebook"></span>  </a> </li>';
					}
					if($product_show_sharer_delicious) {
						$output .= '<li> <a href="//del.icio.us/post?url='.esc_url($ssurl).'&amp;title='.urlencode($sstitle).'" title="delicious" target="_blank"> <span class="dticon-delicious"></span>  </a> </li>';
					}
					if($product_show_sharer_digg) {
						$output .= '<li> <a href="//digg.com/submit?phase=2&amp;url='.esc_url($ssurl).'&amp;title='.urlencode($sstitle).'" title="digg" target="_blank"> <span class="dticon-digg"></span>  </a> </li>';
					}
					if($product_show_sharer_twitter) {
						$output .= '<li> <a href="//twitter.com/home/?status='.esc_url($ssurl).':'.urlencode($sstitle).'" title="twitter" target="_blank"> <span class="dticon-twitter"></span>  </a> </li>';
					}
					if($product_show_sharer_linkedin) {
						$output .= '<li> <a href="//www.linkedin.com/shareArticle?mini=true&amp;title='.urlencode($sstitle).'&amp;url='.esc_url($ssurl).'" title="linkedin" target="_blank"> <span class="dticon-linkedin"></span>  </a> </li>';
					}
					if($product_show_sharer_pinterest) {

						$featured_image_id = get_post_thumbnail_id($product_id);
						$image_details = wp_get_attachment_image_src($featured_image_id, 'full');

						$media = $image_details[0];

						$output .= '<li> <a href="//pinterest.com/pin/create/button/?url='.esc_url($ssurl).'&amp;media='.esc_url($media).'" title="pinterest" target="_blank"> <span class="dticon-pinterest"></span>  </a> </li>';

					}
					if($product_show_sharer_stumbleupon == 'true') {
						$output .= '<li> <a href="//www.stumbleupon.com/submit?url='.esc_url($ssurl).'&amp;title='.urlencode($sstitle).'" title="stumbleupon" target="_blank"> <span class="dticon-stumbleupon"></span>  </a> </li>';
					}
					if($product_show_sharer_googleplus == 'true') {
						$output .= '<li> <a href="//plus.google.com/share?url='.esc_url($ssurl).'" title="googleplus" target="_blank" onclick="javascript:window.open(this.href,\"\",\"menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\");return false;"> <span class="dticon-google-plus"></span>  </a> </li>';
					}

				$output .= '</ul>';

			$output .= '</div>';

		} else if($share_follow_type == 'follow') {

			$social_follow = dtshop_sociable_follow_list();

			$list = '';
			$socials_selected = array ();
			foreach($social_follow as $socialfollow_key => $socialfollow) {

				$show_follow_option = dt_customizer_settings( 'dt-single-product-show-follow-'.$socialfollow_key );
				if($show_follow_option == 'true') {
					$follow_link = dt_customizer_settings( 'dt-single-product-follow-'.$socialfollow_key.'-link' );
					$list .= '<li class="'.esc_attr( $socialfollow_key ).'"><a target="_blank" href="'.esc_url( $follow_link ).'"></a></li>';
				}

			}

			if(!empty( $list )) {

				$output .= '<div class="dt-sc-single-product-follow-container '.esc_attr($social_icon_style_cls).' '.esc_attr($social_icon_radius_cls).' '.esc_attr($social_icon_inline_alignment_cls).'">';
					$output .= '<a class="dt-sc-single-product-follow-item-icon">'.esc_html__('Follow', 'designthemes-theme').'</a>';
					$output .= '<ul class="dt-sc-single-product-follow-list">'.$list.'</ul>';
				$output .= '</div>';

			}

		}

		return $output;
	}
}

/*
* Sociable Follow List
*/

if( !function_exists( 'dtshop_sociable_follow_list' ) ) {

	function dtshop_sociable_follow_list() {

		  $social_follow = array (
			'delicious'   => esc_html__('Delicious', 'designthemes-theme'),
			'deviantart'  => esc_html__('Deviantart', 'designthemes-theme'),
			'digg'        => esc_html__('Digg', 'designthemes-theme'),
			'dribbble'    => esc_html__('Dribbble', 'designthemes-theme'),
			'envelope'    => esc_html__('Envelope', 'designthemes-theme'),
			'facebook'    => esc_html__('Facebook', 'designthemes-theme'),
			'flickr'      => esc_html__('Flickr', 'designthemes-theme'),
			'google-plus' => esc_html__('Google Plus', 'designthemes-theme'),
			'gtalk'       => esc_html__('GTalk', 'designthemes-theme'),
			'instagram'   => esc_html__('Instagram', 'designthemes-theme'),
			'lastfm'      => esc_html__('Lastfm', 'designthemes-theme'),
			'linkedin'    => esc_html__('Linkedin', 'designthemes-theme'),
			'myspace'     => esc_html__('Myspace', 'designthemes-theme'),
			'picasa'      => esc_html__('Picasa', 'designthemes-theme'),
			'pinterest'   => esc_html__('Pinterest', 'designthemes-theme'),
			'reddit'      => esc_html__('Reddit', 'designthemes-theme'),
			'rss'         => esc_html__('RSS', 'designthemes-theme'),
			'skype'       => esc_html__('Skype', 'designthemes-theme'),
			'stumbleupon' => esc_html__('Stumbleupon', 'designthemes-theme'),
			'technorati'  => esc_html__('Technorati', 'designthemes-theme'),
			'tumblr'      => esc_html__('Tumblr', 'designthemes-theme'),
			'twitter'     => esc_html__('Twitter', 'designthemes-theme'),
			'viadeo'      => esc_html__('Viadeo', 'designthemes-theme'),
			'vimeo'       => esc_html__('Vimeo', 'designthemes-theme'),
			'yahoo'       => esc_html__('Yahoo', 'designthemes-theme'),
			'youtube'     => esc_html__('Youtube', 'designthemes-theme')
		);

		  return $social_follow;

	}

}