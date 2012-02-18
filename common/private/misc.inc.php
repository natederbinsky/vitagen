<?php
	
	function misc_param( $name, $default = '' )
	{
		$return_val = $default;
		
		if ( isset( $_GET[ $name ] ) )
		{
			$return_val = $_GET[ $name ];
		}
		else if ( isset( $_POST[ $name ] ) )
		{
			$return_val = $_POST[ $name ];
		}
		
		if ( is_string( $return_val ) )
		{
			$return_val = trim( $return_val );
			
			if ( get_magic_quotes_gpc() )
			{
				$return_val = stripslashes( $return_val );
			}
		}
		
		return $return_val;
	}

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
			
			$return_val .= ( implode( "\n", $temp ) . "\n" );
		}
		
		$return_val .= ( $prefix . '</div>' . "\n" );
		
		return $return_val;
	}
	
	function misc_list( $items, $prefix = '', $list_style = NULL )
	{
		$return_val = '';
		
		$return_val .= ( $prefix . '<ul' . ( ( is_null( $list_style ) )?(''):( ' style="' . $list_style . '"' ) ) . '>' . "\n" );
		foreach ( $items as $item )
		{
			$return_val .= ( $prefix . "\t" . '<li>' . $item . '</li>' . "\n" );
		}
		$return_val .= ( $prefix . '</ul>' . "\n" );
		
		return $return_val;
	}
	
?>
