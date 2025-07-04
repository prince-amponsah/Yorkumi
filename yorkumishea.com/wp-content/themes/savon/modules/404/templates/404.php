<?php
    if( isset( $enable_404message ) && ( $enable_404message == 1 || $enable_404message == true )  ) {
        $class = $notfound_style;
        $class .= ( isset( $notfound_darkbg ) && ( $notfound_darkbg == 1 ) ) ? " dt-sc-dark-bg" :"";
    ?>
    <div class="wrapper <?php echo esc_attr( $class );?>">
        <div class="container">
            <div class="center-content-wrapper">
                <div class="center-content">
                    <div class="error-box square">
                        <div class="error-box-inner">
                            <h3><?php esc_html_e("Oops!", "savon"); ?></h3>
                            <h2>404</h2>
                            <h4><?php esc_html_e("Page Not Found", "savon"); ?></h4>
                        </div>
                    </div>
                    <div class="dt-sc-hr-invisible-xsmall"></div>
                    <p><?php esc_html_e("It seems you've ventured too far.", "savon"); ?></p>
                    <div class="dt-sc-hr-invisible-xsmall"></div>
                    <a class="dt-sc-button filled small" target="_self" href="<?php echo esc_url(home_url('/'));?>"><?php esc_html_e("Back to Home","savon");?></a>
                </div>                    
            </div>
        </div>
    </div><?php
}?>