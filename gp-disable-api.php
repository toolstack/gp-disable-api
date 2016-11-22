<?php
/*
Plugin Name: GP Disable API
Plugin URI: http://glot-o-matic.com/gp-disable-api
Description: A GlotPress plugin that disables the GP API.
Version: 0.5
Author: GregRoss
Author URI: http://toolstack.com
Tags: glotpress, glotpress plugin, translate
License: GPLv2 or later
*/

class GP_Disable_API {
	public $id = 'disable-api';

	public function __construct() {

	add_filter( 'gp_router_http_methods', array( $this, 'gp_router_http_methods' ) );
	}
	
	public function gp_router_http_methods( $methods ) {
		$api_prefix = GP::$router->api_prefix;
		$real_request_uri = GP::$router->request_uri();

		$api = gp_startswith( $real_request_uri, '/' . $api_prefix . '/' );
		
		if( $api ) {
			gp_tmpl_404();
			exit;
		}
		
		return $methods;
	}
	
}

// Add an action to WordPress's init hook to setup the plugin.  Don't just setup the plugin here as the GlotPress plugin may not have loaded yet.
add_action( 'gp_init', 'gp_disable_api_init' );

// This function creates the plugin.
function gp_disable_api_init() {
	GLOBAL $GP_Disable_API;
	
	$GP_Disable_API = new GP_Disable_API;
}
