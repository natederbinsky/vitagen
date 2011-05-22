<?php

	// Useful for debugging
	/*
	error_reporting( -1 );
	ini_set( 'display_errors', 'On' );
	ini_set( 'display_startup_errors', 'On' );
	*/

	// required libraries
	require_once 'jquery.inc.php';
	require_once 'misc.inc.php';

	// "constants"
	$page_info = array();

	$page_info['title'] = '';
	$page_info['align'] = 'left';
	$page_info['head'] = '';
	
	// currently supported: full, mobile
	$page_info['type'] = ( ( ( stripos( $_SERVER['HTTP_USER_AGENT'], 'iphone' ) !== FALSE ) || ( stripos( $_SERVER['HTTP_USER_AGENT'], 'ipod' ) !== FALSE ) || ( stripos( $_SERVER['HTTP_USER_AGENT'], 'Mobile' ) !== FALSE ) )?( 'mobile' ):( 'full' ) );
	
	// mobile-specific
	if ( $page_info['type'] == 'mobile' )
	{
		$page_info['head'] .= ( '<meta name="viewport" content="user-scalable=no, width=device-width" />' . "\n" );
		$page_info['head'] .= ( '<meta name="format-detection" content="telephone=no" />' . "\n" );
	}
	
	// public resources
	{
		$public_prefix = 'common/public/';
		
		// favicon
		$page_info['favico'] = ( $public_prefix . 'favico.ico' );
		if ( !file_exists( $page_info['favico'] ) || !is_readable( $page_info['favico'] ) )
		{
			$page_info['favico'] = ( $public_prefix . 'favico.default.ico' );
		}

		// css
		foreach ( array( 'all', 'print' ) as $css_type )
		{
			$css = ( 'css-' . $css_type );
			
			$page_info[ $css ] = ( $public_prefix . $css . '.inc.php' );
			if ( !file_exists( $page_info[ $css ] ) || !is_readable( $page_info[ $css ] ) )
			{
				$page_info[ $css ] = ( $public_prefix . $css . '.default.php' );
			}
			
			$page_info[ $css ] .= ( '?type=' . $page_info['type'] );
		}
	}
	
	ob_start();

?>
