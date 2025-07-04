<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<!-- Entry Date -->
<div class="entry-date">
	<?php echo sprintf( esc_html__( '%s ago', 'designthemes-theme' ), human_time_diff( get_the_date('U'), current_time('timestamp') ) ); ?>
</div><!-- Entry Date -->