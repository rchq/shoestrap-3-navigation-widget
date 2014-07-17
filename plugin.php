<?php
/*
Plugin Name: Shoestrap Navigation Widget
Plugin URI: http://wpmu.io
Description: Adds Navigation Widget to the Shoestrap theme.
Version: 0.1
Author: Jon Brim
Author URI:  http://rchq.com
*/

if ( !defined( 'REDUX_OPT_NAME' ) )
	define( 'REDUX_OPT_NAME', 'shoestrap' );

// plugin folder url
if ( !defined( 'S3NW_PLUGIN_URL' ) )
	define( 'S3NW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// plugin folder path
if ( !defined( 'S3NW_PLUGIN_DIR' ) )
	define( 'S3NW_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// plugin root file
if ( !defined( 'S3NW_PLUGIN_FILE' ) )
	define( 'S3NW_PLUGIN_FILE', __FILE__ );

function shoestrap_nw_include_files() {
	include_once( S3NW_PLUGIN_DIR . 'includes/admin.php' );
	include_once( S3NW_PLUGIN_DIR . 'includes/functions.php' );
}
add_action( 'shoestrap_include_files', 'shoestrap_nw_include_files' );