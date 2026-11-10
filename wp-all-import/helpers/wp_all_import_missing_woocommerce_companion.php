<?php

/**
 * Why WooCommerce Import Add-On Pro 5.x cannot import this entity yet: its free companion is not running. '' when it can.
 */
function wp_all_import_missing_woocommerce_companion_message( $post_type ) {
	if ( ! class_exists( 'WooCommerce' ) || ! defined( 'PMWI_PRO_VERSION' ) ) {
		return '';
	}
	if ( 'product' === $post_type && ! class_exists( 'PMWI_Plugin' ) ) {
		if ( wp_all_import_woocommerce_product_companion_is_outdated() ) {
			return __( 'WP All Import - WooCommerce Add-On must be updated to version 2.0.0 or later to import products.', 'wp-all-import' );
		}
		return __( 'WP All Import - WooCommerce Add-On must be installed and activated to import products.', 'wp-all-import' );
	}
	if ( 'shop_order' === $post_type && ! class_exists( 'PMWOI_Plugin' ) ) {
		$message = function_exists( 'pmwoi_update_required_message' ) ? (string) pmwoi_update_required_message() : '';
		return '' !== $message ? $message : __( 'WP All Import - WooCommerce Order Import Add-On must be installed and activated to import orders.', 'wp-all-import' );
	}
	return '';
}

// Add-On Pro 5.x stands the released 1.x product plugin aside, so an old copy can be installed without running.
function wp_all_import_woocommerce_product_companion_is_outdated() {
	$version = defined( 'PMWI_FREE_VERSION' ) ? PMWI_FREE_VERSION : '';
	if ( '' === $version ) {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$plugins = get_plugins();
		$version = isset( $plugins['woocommerce-xml-csv-product-import/plugin.php']['Version'] ) ? $plugins['woocommerce-xml-csv-product-import/plugin.php']['Version'] : '';
	}
	return '' !== $version && version_compare( $version, '2.0.0', '<' );
}

function wp_all_import_missing_woocommerce_companion_notice( $post_type ) {
	$message = wp_all_import_missing_woocommerce_companion_message( $post_type );
	if ( '' === $message ) {
		return '';
	}
	return sprintf(
		'<div class="wpallimport-upgrade-notice" rel="%1$s"><p>%2$s</p><a href="%3$s" class="upgrade_link">%4$s</a></div>',
		esc_attr( $post_type ),
		esc_html( $message ),
		esc_url( admin_url( 'plugins.php' ) ),
		esc_html__( 'Go to Plugins', 'wp-all-import' )
	);
}
