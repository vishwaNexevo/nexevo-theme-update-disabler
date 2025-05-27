<?php
/**
 * Plugin Name: Nexevo - Theme Update & File Edit Disabler
 * Plugin URI: https://www.nexevo.in/plugins/theme-update-disabler
 * Description: Completely disables theme updates, plugin updates, core updates, and prevents manual update actions or file editing in WordPress.
 * Version: 1.0.0
 * Author: Nexevo Technologies
 * Author URI: https://www.nexevo.in/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: auto-update-disabler
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Load plugin textdomain
function nexevo_load_textdomain() {
    load_plugin_textdomain( 'auto-update-disabler', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'nexevo_load_textdomain' );

// Disable file modifications (install, update, delete plugins/themes)
if ( ! defined( 'DISALLOW_FILE_MODS' ) ) {
    define( 'DISALLOW_FILE_MODS', true );
}

// Disable file editing via admin
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
    define( 'DISALLOW_FILE_EDIT', true );
}

// Disable theme update checks
add_filter( 'site_transient_update_themes', function( $value ) {
    if ( is_object( $value ) ) {
        $value->response = [];
    }
    return $value;
} );

// Disable plugin update checks
add_filter( 'site_transient_update_plugins', function( $value ) {
    if ( is_object( $value ) ) {
        $value->response = [];
    }
    return $value;
} );

// Disable WordPress core update checks
add_filter( 'pre_site_transient_update_core', '__return_null' );

// Disable automatic updates
add_filter( 'automatic_updater_disabled', '__return_true' );

// Admin notice
add_action( 'admin_notices', function() {
    echo '<div class="notice notice-warning is-dismissible">
        <p><strong>' . esc_html__( 'Nexevo Notice:', 'auto-update-disabler' ) . '</strong> ' . esc_html__( 'All WordPress updates and file editing are currently disabled.', 'auto-update-disabler' ) . '</p>
    </div>';
});
