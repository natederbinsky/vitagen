<?php
	
	define( 'CUSTOM_DIR_PUBLIC', 'public/_custom/' );
	define( 'CUSTOM_DIR_PRIVATE', 'private/_custom/' );
	define( 'CONFIG_FILE', ( CUSTOM_DIR_PRIVATE . 'config.inc.php' ) );
	
	define( 'ALERT_KEY', 'alert' );
	define( 'SECTION_KEY', 's' );
	
	//

	$config = array(
					
		'name' => 'First Last',
		'email' => 'user@server.com',
		'url' => 'http://localhost',
		'tagline' => '',
		'mug' => '',
		'timezone' => 'America/New_York',
					
		'sections' => array( 'About' ),
		'custom_icons' => false,
					
		'linkedin' => null,
		'googlescholar' => null,
		'googleanalytics' => null,
					
		'check_links' => isset( $_GET['check'] ),
		'no_template' => isset( $_GET['clean'] ),
		'no_analytics' => isset( $_GET['analytics'] ),
					
	);
	$user_keys = array();
	foreach ( $config as $k => $v ) {
		$user_keys[ $k ] = true;
	}
	
	//
	
	@include( CONFIG_FILE );
	
	//
	
	date_default_timezone_set( $config['timezone'] );
	
	//
	
	$sys_keys = array(
		'content'=>2, // make sure this is first (so that content can use others)
		'name'=>0, 'email'=>0,
		'title'=>0, 'pic'=>0, 'custom'=>0, 'sectiondir'=>0,
		'head'=>2, 'nav'=>2, 'alert'=>2, 'footer'=>2, 'js'=>2,
	);
	
	{
		$icons = array( 'fav', 'touch', 'ipad', 'retina', 'ipad-retina' );
		foreach ( $icons as $k => $v ) {
			
			$real = ( 'icon-' . $v );
			$icons[ $k ] = $real;
			$sys_keys[ $real ] = 0;
			
		}
	}
	
	//
	
	foreach ( $sys_keys as $k => $v ) {
		if ( !isset( $user_keys[ $k ] ) ) {
			$config[ $k ] = '';
		}
	}
	
	//
	
	$config[ ALERT_KEY ] = array();
	
	//
	
	if ( !is_array( $config['sections'] ) || count( $config['sections'] ) < 1 ) {
		$config['sections'] = array( 'About' );
	}
	
	if ( isset( $_GET[ SECTION_KEY ] ) && in_array( $_GET[ SECTION_KEY ], $config['sections'] ) ) {
		
		$config[ SECTION_KEY ] = $_GET[ SECTION_KEY ];
		
	} else {
		
		$section_keys = array_keys( $config['sections'] );
		
		$config[ SECTION_KEY ] = $config['sections'][ $section_keys[0] ];
		
	}
	
	$config['custom'] = CUSTOM_DIR_PUBLIC;
	$config['sectiondir'] = section_dir( $config[ SECTION_KEY ] );
	
	////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////
	
	function section_dir($section) {
		return ( CUSTOM_DIR_PUBLIC . strtolower( $section ) . '/' );
	}
	
	function section_url($section) {
		
		global $config;
		
		return ( $config['url'] . '/?' . http_build_query( array( SECTION_KEY=>$section ) ) );
		
	}
	
	////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////
	
	function t($s, $t = 0, $n = true) {
		return ( str_repeat( "\t", $t ) . $s . ( ( $n === true )?( "\n" ):( '' ) ) );
	}
	
	function a($url, $t, $c, $n, $class = '', $other = array()) {
		
		if ( empty( $other ) ) {
			$other = '';
		} else {
			
			foreach ( $other as $k=>$v ) {
				$other[ $k ] = ( $k . '="' . $v . '"' );
			}
			$other = ( ' ' . implode( ' ', $other ) );
					  
		}
		
		return ( '<a ' . ( ( empty( $class ) )?( '' ):( 'class="' . $class . '"' ) ) . ( ( !empty( $url ) )?( 'href="' . u( $url ) . '"' ):( '' ) ) . ( ( $n === true )?( ' target="_blank"' ):( '' ) ) . ' title="' . $t . '"' . $other . '>' . $c . '</a>' );
	}
	
	function q($args) {
		return http_build_query( $args );
	}
	
	////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////
	
	function alert($type, $title, $content) {
		
		global $config;
		$config[ ALERT_KEY ][] = array( $type, $title, $content );
		
	}
	
	function addToHead($content) {
		
		global $config;
		$config['head'] .= $content;
		
	}
	
	////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////
	
	$bad_links = array();
	$good_codes = array( 200=>'OK', 301=>'Moved Permanently', 302=>'Found', 503=>'Service Unavailable' );
	function _check_url($url) {
		
		$ch = curl_init();
		
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_HEADER, 1 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		
		$data = curl_exec( $ch );
		$headers = curl_getinfo( $ch );
		
		curl_close( $ch );
		
		return $headers['http_code'];
		
	}
	
	function u($url) {
		
		global $config;
		if ( $config['check_links'] === true ) {
			
			$parsed = parse_url( $url );
			
			if ( isset( $parsed[ 'host' ] ) ) {
			
				global $good_codes;
				$code = _check_url( $url );
				
				if ( !isset( $good_codes[ $code ] ) ) {
					
					global $bad_links;
					
					$bad_links[] = array( 'url'=>$url, 'code'=>$code );
					
				}
				
			} else if ( !isset( $parsed[ 'scheme' ] ) && isset( $parsed[ 'path' ] ) ) {
				
				if ( !is_readable( $parsed[ 'path' ] ) ) {
					
					global $bad_links;
					
					$bad_links[] = array( 'url'=>$url, 'code'=>0 );
					
				}
				
			}
			
		}
		
		return $url;
		
	}
	
	////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////
	
	ob_start();
	
?>
