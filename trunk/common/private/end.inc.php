<?php
	
	// get page content
	{
		$temp = ob_get_clean();
		ob_start();
		
		if ( $page_info['type'] != 'blank' )
		{
			$temp = explode( "\n", $temp );
			foreach ( $temp as $k => $v )
			{
				$temp[ $k ] = ( "\t\t" . $v );
			}
			
			$page_info['content'] = implode( "\n", $temp );
		}
		else
		{
			$page_info['content'] = $temp;
		}
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
	
	// head prefix = 2 tabs
	{
		$head = $page_info['head'];
		foreach ( $head as $k => $v )
		{
			$head[ $k ] = ( "\t\t" . $v );
		}
		
		$page_info['head'] = trim( implode( "\n", $head ) );
	}
	
	// body events
	{
		$body = 'body';
		foreach ( $page_info['body'] as $event => $action )
		{
			$body .= ( ' ' . htmlentities( $event ) . '="' . $action . '"' );
		}
		
		$page_info['body'] = $body;
	}
	
	// replace values in the template
	foreach ( $page_info as $key => $val )
	{
		$template = str_replace( ( '{' . $key . '}' ), $val, $template );
	}
		
	// output the page
	echo trim( $template );
    
?>
