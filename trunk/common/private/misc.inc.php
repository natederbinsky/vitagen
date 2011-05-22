<?php

	function misc_section( $title, $content, $prefix = '', $print = true, $page_break = false )
	{
		$return_val = '';
		
		$return_val .= ( $prefix . '<div class="section' . ( ( $print )?(''):(' noprint') ) . '"' . ( ( $page_break )?(' style="page-break-before: always"'):('') ) . '>' . "\n" );
		
		$return_val .= ( $prefix . "\t" . '<div class="header">' . htmlentities( $title ) . '</div>' . "\n" );
		
		{
			$temp = explode( "\n", $content );
			foreach ( $temp as $k => $v )
			{
				$temp[ $k ] = ( $prefix . "\t" . $v );
			}
			
			$return_val .= ( $prefix . "\t" . implode( "\n", $temp ) . "\n" );
		}
		
		$return_val .= ( $prefix . '</div>' . "\n" );
		
		return $return_val;
	}
	
	function misc_list( $items, $prefix = '' )
	{
		$return_val = '';
		
		$return_val .= ( $prefix . '<ul>' . "\n" );
		foreach ( $items as $item )
		{
			$return_val .= ( $prefix . "\t" . '<li>' . $item . '</li>' . "\n" );
		}
		$return_val .= ( $prefix . '</ul>' . "\n" );
		
		return $return_val;
	}
	
?>
