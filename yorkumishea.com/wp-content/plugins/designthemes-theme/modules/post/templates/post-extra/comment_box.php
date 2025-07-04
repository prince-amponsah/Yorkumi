<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

    <?php if( ! $enable_disqus_comments ) : ?>

	    <section class="commententries <?php echo esc_attr($post_commentlist_style); ?>">
	        <?php comments_template('', true); ?>
	    </section>

	<?php else :

		$sitename = $post_disqus_shortname; ?>

	    <section class="commententries">
			<div id="disqus_thread"><?php if( $sitename == '' ) { echo '<div class="dt-sc-disqus-msg"><p class="error-msg">'.esc_html__('Put correct shortname from your Disqus account in Customizer settings.', 'designthemes-theme').'</p></div>'; } ?></div>
			<script>
			/**
			*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
			*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/

			var disqus_config = function () {
			this.page.url = '<?php echo get_permalink($post_ID); ?>';  // Replace PAGE_URL with your page's canonical URL variable
			this.page.identifier = '<?php echo get_permalink($post_ID); ?>'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
			};

			(function() { // DON'T EDIT BELOW THIS LINE
			var d = document, s = d.createElement('script');
			s.src = 'https://<?php echo "{$sitename}"; ?>.disqus.com/embed.js';
			s.setAttribute('data-timestamp', +new Date());
			(d.head || d.body).appendChild(s);
			})();
			</script>
			<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>    	
	    </section>
	<?php endif; ?>