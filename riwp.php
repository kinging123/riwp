<?php
/*
Plugin Name: Rest In WordPress (RIWP)
Version: 1.0
Author: Reuven Karasik
Description: A perpetuation plugin, made on behalf of and for Barfeld.co.il.
Text Domain: riwp
License: GPLv3
*/

if ( ! defined( 'RIWP_PATH' ) ) {
	define( 'RIWP_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'RIWP_POSTS_PER_PAGE' ) ) {
	define( 'RIWP_POSTS_PER_PAGE', 12 );
}

require 'jewish-date-helpers.php';
require 'memorial-cpt.php';


add_action( 'plugins_loaded', 'riwp_load_textdomain' );
function riwp_load_textdomain() {
	load_plugin_textdomain( 'riwp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action( 'wp_enqueue_scripts', 'riwp_enqueue_scripts', 11 );
function riwp_enqueue_scripts() {

	wp_enqueue_style( 'riwp-style', plugin_dir_url( __FILE__ ) . '/assets/css/style.css' );

	wp_enqueue_script( 'riwp-scripts', plugin_dir_url( __FILE__ ) . '/assets/js/script.js', array( 'jquery' ) );
	wp_localize_script( 'riwp-scripts', 'RIWP', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'posts_per_page' => RIWP_POSTS_PER_PAGE,
		'error_msg' => __( 'There was an error. More information:', 'riwp' ),
	) );

}

// Shortcodes
function riwp_index_shortcode() {
	ob_start();
	include 'shortcodes/riwp-index.php';
	$riwp_index_template = ob_get_clean();
	return $riwp_index_template;
}

function riwp_latest_shortcode() {
	ob_start();
	include 'shortcodes/riwp-latest.php';
	$riwp_latest_template = ob_get_clean();
	return $riwp_latest_template;
}

function riwp_mid_month_countdown() {
	ob_start();
	include 'shortcodes/riwp-mid-month-countdown.php';
	$riwp_latest_template = ob_get_clean();
	return $riwp_latest_template;
}

function riwp_register_shortcodes() {
	add_shortcode( 'riwp-index', 'riwp_index_shortcode' );
	add_shortcode( 'riwp-latest', 'riwp_latest_shortcode' );
	add_shortcode( 'riwp-mid-month-countdown', 'riwp_mid_month_countdown' );
}

add_action( 'init', 'riwp_register_shortcodes' );


function riwp_load_more_memorials() {
	$riwp_pagination_page = $_GET['paged'];
	$riwp_sort_by = $_GET['sort_by'];
	$riwp_search_by = $_GET['search_by'];
	$riwp_loop_type = 'clean';
	include 'loop/memorials.php';
	die();
}

add_action( 'wp_ajax_riwp_load_more_memorials', 'riwp_load_more_memorials' );
add_action( 'wp_ajax_nopriv_riwp_load_more_memorials', 'riwp_load_more_memorials' );
