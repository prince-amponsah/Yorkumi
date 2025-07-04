<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<!-- Entry Date -->
<div class="entry-date">
	<div class="date-wrap">
		<i class="dticon-clock"> </i>
		<?php echo get_the_date ( get_option('date_format') ); ?>
	</div>
</div><!-- Entry Date -->