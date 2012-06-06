<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

function tpc_slideshow_uninstall() {
	global $wpdb;

	delete_option( 'tpc_slideshow_version' );

	$table_name = $wpdb->prefix . "tpc_slideshow";

	$wpdb->query( "DROP TABLE IF EXISTS $table_name" );
}

tpc_slideshow_uninstall();

?>