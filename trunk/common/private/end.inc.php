<?php
	
	// get page content
	{
		$temp = explode( "\n", ob_get_clean() );
		foreach ( $temp as $k => $v )
		{
			$temp[ $k ] = ( "\t\t" . $v );
		}
		
		$page_info['content'] = implode( "\n", $temp );
	}
	
	// get the template
	$template = '';
	
	if ( in_array( $page_info['type'], array( 'full', 'mobile' ) ) )
	{
		require 'template.inc.php';
		$template = ob_get_clean();
	}
	else if ( $page_info['type'] == 'blank' )
	{
		$template = '{content}';
	}
	ob_end_clean();
	
	// replace values in the template
	foreach ( $page_info as $key => $val )
	{
		$template = str_replace( ( '{' . $key . '}' ), $val, $template );
	}
		
	// output the page
	echo trim( $template );
    
?>
