<?php
	
	// get page content
	{
		$config['content'] = ob_get_clean();
		ob_end_clean();
	}
	
	// get the template
	$template = '';
	{
		if ( $config['no_template'] ) {
			$template = '{content}';
		} else {
			$template = @file_get_contents( 'template.inc.html', true );
		}
	}
	
	// tack on link checking
	if ( $config['check_links'] && !empty( $bad_links ) ) {
		
		$t = '';
		foreach ( $bad_links as $l ) {
			$t .= ( $l['code'] . ': ' . htmlentities( '<' . $l['url'] . '>' ) . '<br />' );
		}
		
		alert( 'danger', 'Bad Links!', $t );
		
	}
	
	// convert alerts to content
	{
		
		foreach ( $config[ ALERT_KEY ] as $k => $a ) {
			
			$t = t( '<div class="alert alert-' . htmlentities( $a[0] ) . '">' );
			$t .= t( '<button type="button" class="close" data-dismiss="alert">&times;</button>', 1 );
			$t .= t( ( '<h4>' . $a[1] . '</h4>' . $a[2] ), 1 );
			$t .= t( '</div>' );
			
			//
			
			$config[ ALERT_KEY ][ $k ] = $t;
			
		}
		
		$config[ ALERT_KEY ] = implode( "\n", $config[ ALERT_KEY ] );
		
	}
	
	// replace values in the template
	{
		
		$search = array();
		$replace = array();
		foreach ( $sys_keys as $k => $t ) {
			
			$search[] = ( '{' . $k . '}' );
			
			$r = explode( "\n", $config[ $k ] );
			foreach ( $r as $kk => $vv ) {
				$r[ $kk ] = t( $vv, $t, false );
			}
			
			$replace[] = implode( "\n", $r );
			
		}
		
		$template = str_replace( $search, $replace, $template );
		
	}
	
	// output the page
	echo trim( $template );
	
?>
