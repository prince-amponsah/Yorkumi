<?php

// Ajax Call

if( !function_exists('ajax_infinite_portfolios') ) {

    function ajax_infinite_portfolios() {

        $output = '';

        $settings = json_decode(html_entity_decode(stripslashes($_REQUEST['ajaxcall_json'])), true);
        extract($settings);

        $args = array ();
		if( !empty($portfolio_ids) ):

			$args = array (
				'paged'          => $paged,
				'posts_per_page' => $posts_per_page,
				'post__in'       => explode(',', $portfolio_ids),
				'post_type'      => 'dt_portfolios'
			);

		elseif( empty($categories) && empty($tags) ):

			$args = array (
				'paged'          => $paged,
				'posts_per_page' => $posts_per_page,
				'post_type'      => 'dt_portfolios'
			);

		elseif( !empty($categories) && empty($tags) ):

			$args = array (
				'paged'          => $paged,
				'posts_per_page' => $posts_per_page,
				'post_type'      => 'dt_portfolios',
				'orderby'        => 'ID',
				'order'          => 'ASC',
				'tax_query'      => array (
					array (
						'taxonomy' => 'dt_portfolio_cats',
						'field'    => 'id',
						'operator' => 'IN',
						'terms'    => $categories
					)
				)
			);

		elseif( !empty($tags) && empty($categories) ):

			$args = array (
				'paged'          => $paged,
				'posts_per_page' => $posts_per_page,
				'post_type'      => 'dt_portfolios',
				'orderby'        => 'ID',
				'order'          => 'ASC',
				'tax_query'      => array (
					array (
						'taxonomy' => 'dt_portfolio_tags',
						'field'    => 'id',
						'operator' => 'IN',
						'terms'    => $tags
					)
				)
			);

		else:

			$args = array (
				'paged'          => $paged,
				'posts_per_page' => $posts_per_page,
				'post_type'      => 'dt_portfolios'
			);

        endif;

        $portfolio_query = new WP_Query($args);
        if($portfolio_query->have_posts()):

            // Load Corresponding Template File
            require_once DT_PORTFOLIO_DIR_PATH.'archive/templates/base.php';
            require_once DT_PORTFOLIO_DIR_PATH.'archive/templates/'.$post_style.'/index.php';
			$post_style_class_name = '\DesignThemesPortfolioArchive'.ucfirst($post_style).'Template';

            while( $portfolio_query->have_posts() ):
                $portfolio_query->the_post();

				$current_post = $portfolio_query->current_post;

                // Initialize Loop Class
                $portfolio_id = get_the_ID();
                $pa_dt = new $post_style_class_name($portfolio_id, $settings);
                $output .= $pa_dt->item_setup_loop($current_post);

            endwhile;

            wp_reset_postdata();

		endif;

        echo $output;

        wp_die();

    }
    add_action( 'wp_ajax_dtportfolio_ajax_infinite_portfolios', 'ajax_infinite_portfolios' );
    add_action( 'wp_ajax_nopriv_dtportfolio_ajax_infinite_portfolios', 'ajax_infinite_portfolios' );

}