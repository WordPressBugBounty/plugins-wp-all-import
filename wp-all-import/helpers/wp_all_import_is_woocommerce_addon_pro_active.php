<?php

if ( ! function_exists('wp_all_import_is_woocommerce_addon_pro_active') ) {
    function wp_all_import_is_woocommerce_addon_pro_active() {
        return defined('PMWI_PRO_VERSION') || ( defined('PMWI_EDITION') && 'paid' === PMWI_EDITION );
    }
}
