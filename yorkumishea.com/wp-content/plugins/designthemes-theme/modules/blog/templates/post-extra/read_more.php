<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	if( $archive_readmore_text != '' ) :
		echo '<!-- Entry Button --><div class="entry-button">';
			echo '<a href="'.get_permalink().'" title="'.the_title_attribute('echo=0').'" class="dt-sc-button">'.$archive_readmore_text.'<span class="dticon-long-arrow-right"></span></a>';
		echo '</div><!-- Entry Button -->';
	endif; ?>