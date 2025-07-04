<?php

// Load All Include Files

$include_modules = array (
    'listings/includes/utils',
    'listings/includes/loop-start-end',
    'listings/includes/content-utils',
    'listings/includes/content-thumb',
    'listings/includes/content-content'
);

if( is_array( $include_modules ) && !empty( $include_modules ) ) {
    foreach( $include_modules as $include_module ) {

        if( $file_content = savon_woo_locate_file( $include_module ) ) {
            include_once $file_content;
        }

    }
}