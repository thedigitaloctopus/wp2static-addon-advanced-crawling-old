<?php

/**
 * Plugin Name:       WP2Static Add-on: Advanced Crawling
 * Plugin URI:        https://wp2static.com
 * Description:       Advanced crawling add-on for WP2Static.
 * Version:           0.1
 * Author:            Leon Stafford
 * Author URI:        https://ljs.dev
 * License:           Unlicense
 * License URI:       http://unlicense.org
 * Text Domain:       wp2static-addon-advanced-crawling
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WP2STATIC_ADVANCED_CRAWLING_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP2STATIC_ADVANCED_CRAWLING_VERSION', '0.1' );

require WP2STATIC_ADVANCED_CRAWLING_PATH . 'vendor/autoload.php';

function run_wp2static_addon_advanced_crawling() {
	$controller = new WP2StaticAdvancedCrawling\Controller();
	$controller->run();
}

register_activation_hook(
    __FILE__,
    [ 'WP2StaticAdvancedCrawling\Controller', 'activate' ]
);

register_deactivation_hook(
    __FILE__,
    [ 'WP2StaticAdvancedCrawling\Controller', 'deactivate' ]
);

run_wp2static_addon_advanced_crawling();

