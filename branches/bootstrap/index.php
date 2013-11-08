<?php
	
	require 'private/start.inc.php';
	
	////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////
	
	// page title
	$config['title'] = htmlentities( $config['name'] . ' - ' . $config[ SECTION_KEY ] );
	
	// custom css
	{
		
		$cand_css = ( CUSTOM_DIR_PUBLIC . 'custom.css' );
		
		if ( is_file( $cand_css ) && is_readable( $cand_css ) ) {
			addToHead( t( '<link rel="stylesheet" href="' . $cand_css . '" media="all" />' ) );
		}
		
	}
	
	// default mug
	{
		
		$cand_pic = ( CUSTOM_DIR_PUBLIC . $config['mug'] );
		
		if ( is_file( $cand_pic ) && is_readable( $cand_pic ) ) {
			$config['pic'] = $cand_pic;
		} else {
			$config['pic'] = 'public/img/mug.png';
		}
		
	}
	
	// page navigation
	{
		
		$nav = '';
		$d = 0;
		
		$nav .= t( '<div class="navbar navbar-inverse navbar-fixed-top hidden-print">', $d++ );
		$nav .= t( '<div class="container">', $d++ );
		
		//
		
		$nav .= t( '<div class="navbar-header">', $d++ );
		
		$nav .= t( '<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">', $d++ );
		$nav .= t( '<span class="icon-bar"></span>', $d );
		$nav .= t( '<span class="icon-bar"></span>', $d );
		$nav .= t( '<span class="icon-bar"></span>', $d );
		$nav .= t( '</button>', --$d );
		
		{
			
			$brand = a( '?', htmlentities( $config['name'] ), htmlentities( $config['name'] ), false, 'navbar-brand' );
			
			if ( !is_null( $config['linkedin'] ) ) {
				$brand .= a( u( 'http://www.linkedin.com/in/' . $config['linkedin'] ), 'LinkedIn', ( '<img class="img-rounded" width="20" height="20" src="public/img/linkedin.png" />' ), true, 'navbar-brand' );
			}
			
			if ( !is_null( $config['googlescholar'] ) ) {
				$brand .= a( u( 'http://scholar.google.com/citations?' . q( array( 'user'=>'gVyIIJYAAAAJ', 'hl'=>'en' ) ) ), 'Google Scholar', ( '<img  class="img-rounded" width="20" height="20" src="public/img/scholar.ico" />' ), true, 'navbar-brand' );
			}
			
			$nav .= t( $brand, $d );
			
		}
		
		$nav .= t( '</div>', --$d );
		
		//
		
		$nav .= t( '<div class="navbar-collapse collapse">', $d++ );
		$nav .= t( '<ul class="nav navbar-nav">', $d++ );
		
		foreach ( $config['sections'] as $section ) {
			$nav .= t( '<li' . ( ( $section == $config[ SECTION_KEY ] )?( ' class="active"' ):( '' ) ) . '>' . a( ( '?' . q( array( SECTION_KEY=>$section ) ) ), htmlentities( $section ), htmlentities( $section ), false ) . '</li>', $d );
		}
		
		$nav .= t( '</ul>', --$d );
		$nav .= t( '</div>', --$d );

		//
		
		$nav .= t( '</div>', --$d );
		$nav .= t( '</div>', --$d );
		
		$config['nav'] = $nav;
		
	}
	
	// icons
	{
		
		foreach ( $icons as $v ) {
			
			$ext = ( '.' . ( ( $v == 'icon-fav' )?( 'ico' ):( 'png' ) ) );
			
			$custom = $config['custom_icons'];
			if ( $custom ) {
				$custom = is_readable( CUSTOM_DIR . $v . $ext );
			}
			
			$config[ $v ] = ( ( ( $custom )?( CUSTOM_DIR ):( 'public/img/' ) ) . $v . $ext );
			
		}
		
	}
	
	// analytics
	{
		
		if ( !is_null( $config['googleanalytics'] ) ) {
			
			$js = '<script type="text/javascript">var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www."); document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));</script>';
			$js .= '<script type="text/javascript"> try{ var pageTracker = _gat._getTracker("' . $config['googleanalytics'] . '"); pageTracker._trackPageview(); } catch(err) {} </script>';
			
			$config['js'] = $js;
			
		}
		
	}
	
	// determine content source
	$content_file = null;
	{
		
		$content_file = ( CUSTOM_DIR_PRIVATE . strtolower( $config[ SECTION_KEY ] ) . '.inc.php' );
		if ( !is_readable( $content_file ) ) {
			
			alert( 'warning', 'Missing Content!', $content_file );
			$content_file = 'private/default.inc.html';
			
		}
		
	}
	
	// footer
	{
		
		$d = 0;
		
		$newest_date = @filemtime( CONFIG_FILE );
		{
			
			$content_date = @filemtime( $content_file );
			
			if ( ( $content_date !== false ) && ( $content_date > $newest_date ) ) {
				$newest_date = $content_date;
			}
			
		}
		
		$footer = t( '<div class="hidden-print">', $d++ );
		$footer .= t( '<hr />', $d );
		$footer .= t( '<div class="container">', $d++ );
		$footer .= t( '<footer>', $d++ );
		$footer .= t( ( '<small>&copy; ' . a( 'mailto:' . $config['email'], '', htmlentities( $config['name'] ), false ) . ' ' . date( 'Y' ) . '</small>' ), $d );
		$footer .= t( '<br />', $d );
		$footer .= t( ( '<small><em>last updated on ' . htmlentities( date( 'j F Y', $newest_date ) ) . '</em></small>' ), $d );
		$footer .= t( '</footer>', --$d );
		$footer .= t( '</div>', --$d );
		$footer .= t( '</div>', --$d );
		
		$config['footer'] = $footer;
		
	}
	
	// get content
	require $content_file;
	
	////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////
	
	require 'private/end.inc.php';
	
?>
