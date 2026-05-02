<?php
/**
 * Plugin Name: Strangeday Core
 * Description: Core content model and project-level logic for Strangeday.
 * Version: 0.1.0
 * Author: hardcodeisdead
 * Text Domain: strangeday-core
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/includes/post-types.php';

register_activation_hook( __FILE__, 'strangeday_core_activate' );
register_deactivation_hook( __FILE__, 'strangeday_core_deactivate' );

add_action( 'acf/init', 'strangeday_core_bootstrap_acf_sync', 1 );

/**
 * Deactivates matching ACF UI post types and registers rewrite rules.
 *
 * @return void
 */
function strangeday_core_activate() {
	strangeday_core_sync_acf_post_types( false );
	strangeday_core_register_post_types();
	flush_rewrite_rules();
}

/**
 * Reactivates the matching ACF UI post types if present and flushes rewrites.
 *
 * @return void
 */
function strangeday_core_deactivate() {
	strangeday_core_sync_acf_post_types( true );
	flush_rewrite_rules();
}

/**
 * Keeps ACF UI post type definitions inactive so plugin code stays authoritative.
 *
 * @return void
 */
function strangeday_core_bootstrap_acf_sync() {
	strangeday_core_sync_acf_post_types( false );
}
