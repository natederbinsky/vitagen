<?php

	define( 'INC_FILE', 'index.inc.php' );
	
	{
		require 'common/private/start.inc.php';
		
		$user = array();
		{
			// set some defaults
			$user['name'] = 'First Last';
			$user['mug'] = 'common/public/mug.default.png';
			$user['email'] = 'user@domain.com';
			$user['contact'] = 'City, State';
			$user['linkedin_url'] = NULL;
			$user['flickr_url'] = NULL;
			$user['scholar_id'] = NULL;
			$user['g_analytics'] = NULL;
			$user['tabs'] = array( 'cv'=>'CV', 'links'=>'Links' );
			$user['handler'] = '_example';
			$user['timezone'] = 'America/Detroit';
			$user['favico'] = NULL;
			$user['css_base_all'] = true;
			$user['css_base_print'] = true;
			$user['css_custom_all'] = NULL;
			$user['css_custom_print'] = NULL;
			$user['footer'] = NULL;
			
			// override if available
			@include( INC_FILE );
		}
		
		$page_info['title'] = $user['name'];
		
		date_default_timezone_set( $user['timezone'] );
		
		// favico
		if ( !is_null( $user['favico'] ) && is_readable( $user['favico'] ) )
		{
			$page_info['favico'] = $user['favico'];
		}
		
		// css
		foreach ( array( 'all', 'print' ) as $css )
		{				
			if ( !$user[ 'css_base_' . $css ] )
			{
				$page_info[ 'css-' . $css ] = '';
			}
			
			if ( !is_null( $user[ 'css_custom_' . $css ] ) && is_readable( $user[ 'css_custom_' . $css ] ) )
			{
				$page_info['head'][] = ( '<link href="' . htmlentities( $user[ 'css_custom_' . $css ] ) . '?type=' . $page_info['type'] . '" rel="stylesheet" type="text/css" media="' . htmlentities( $css ) . '" />' );
			}
		}
	}
	
	function _example( $id, $prefix )
	{
		if ( $id == 'cv' )
		{
			$education = array(
			'B.A. in English (2000, 4.000/4.000 GPA), Erudition College, Montpelier, VT',
			);
			
			$skills = array(
			'readin\'',
			'\'ritin\'',
			'\'rithmetic',
			);
			
			$experience = ( 
				'Sacred Heart Hospital, <i>Sanitation Engineer</i><br />North Hollywood, CA (2001-2009)<br />' . misc_list( array('Sweep', 'Mop', 'Mess with JD') ) . '<br />' .
				'Springfield Elementary School, <i>Bus Driver</i><br />Springfield (1990-present)<br />' . misc_list( array( 'Drive', 'Air Guitar' ) )
			);
			
			$t_bands_init = array();
			$t_bands_change = array();
			{
				$t_bands_init[0] = array();
				$t_bands_init[0]['width'] = '"70%"';
				$t_bands_init[0]['intervalUnit'] = 'Timeline.DateTime.DAY';
				$t_bands_init[0]['intervalPixels'] = '100';
				
				$t_bands_init[1] = array();
				$t_bands_init[1]['width'] = '"20%"';
				$t_bands_init[1]['intervalUnit'] = 'Timeline.DateTime.WEEK';
				$t_bands_init[1]['intervalPixels'] = '200';
				$t_bands_init[1]['layout'] = '"overview"';
				
				$t_bands_init[2] = array();
				$t_bands_init[2]['width'] = '"10%"';
				$t_bands_init[2]['intervalUnit'] = 'Timeline.DateTime.YEAR';
				$t_bands_init[2]['intervalPixels'] = '350';
				$t_bands_init[2]['layout'] = '"overview"';
								
				$t_bands_change[1] = array( 'syncWith'=>'0', 'highlight'=>'true' );
				$t_bands_change[2] = array( 'syncWith'=>'0', 'highlight'=>'true' );
			}
			
			echo misc_section( 'Goals', 'I have always dreamt of being a doctor.', $prefix );
			echo misc_section( 'Education', misc_list( $education ), $prefix );
			echo misc_section( 'Skills', misc_list( $skills ), $prefix );
			echo misc_section( 'Experience', $experience, $prefix );
			
			timeline_init( 'foo1', array('type'=>'XML', 'url'=>( $_SERVER['SCRIPT_NAME'] . '?' . http_build_query( array( 'blank'=>'Y', 'tab'=>'data' ) ) )), $t_bands_init, $t_bands_change, $prefix );
			echo ( $prefix . '<span class="noprint">' . "\n" );
			{
				echo misc_section( 'Timeline', '<div id="foo1" style="height: 200px; border: 1px solid #aaa"></div>', ( $prefix . "\t" ) );
			}
			echo ( $prefix . '</span>' . "\n" );
		}
		else if ( $id == 'links' )
		{
			$work = array(
			'Google: <a href="http://www.google.com" target="_blank">http://www.google.com</a>',
			'Google Scholar: <a href="http://scholar.google.com" target="_blank">http://scholar.google.com</a>',
			);
			
			$procrastination = array(
			'YouTube: <a href="http://www.youtube.com" target="_blank">http://www.youtube.com</a>',
			'Hulu: <a href="http://www.hulu.com" target="_blank">http://www.hulu.com</a>',
			);
			
			echo misc_section( 'Work', misc_list( $work ), $prefix );
			echo misc_section( 'Procrastination', misc_list( $procrastination ), $prefix );
		}
		else if ( $id == 'data' )
		{
			header('Content-type: text/xml');
			
			$doc = new DomDocument('1.0');
			$root = $doc->createElement('data');
			$root = $doc->appendChild( $root );
			
			$child = $doc->createElement('event', 'all my troubles seemed so far away');
			$child->setAttribute( 'start', date( timeline_date_format(), strtotime('yesterday') ) );
			$child->setAttribute( 'title', 'yesterday' );
			$child->setAttribute( 'image', 'common/public/mug.default.png' );
			$child = $root->appendChild( $child );
			
			$child = $doc->createElement('event', 'is a different day');
			$child->setAttribute( 'start', date( timeline_date_format(), strtotime('tomorrow') ) );
			$child->setAttribute( 'title', 'tomorrow' );
			$child->setAttribute( 'link', ( 'http://www.wolframalpha.com/input/?' . http_build_query( array( 'i'=>'what day is tomorrow' ) ) ) );
			$child = $root->appendChild( $child );
			
			$child = $doc->createElement('event', 'while the blossoms still cling to the vine');
			$child->setAttribute( 'start', date( timeline_date_format(), strtotime('today') ) );
			$child->setAttribute( 'icon', 'common/public/favico.default.ico' );
			$child->setAttribute( 'title', 'today' );
			$child = $root->appendChild( $child );
			
			$child = $doc->createElement('event', 'I went to Philadelphia, but it was closed');
			$child->setAttribute( 'start', date( timeline_date_format(), strtotime('monday last week') ) );
			$child->setAttribute( 'end', date( timeline_date_format(), strtotime('friday last week') ) );
			$child->setAttribute( 'title', 'last week' );
			$child->setAttribute( 'durationEvent', 'true' );
			$child->setAttribute( 'color', 'red' );
			$child->setAttribute( 'textColor', 'green' );
			$child = $root->appendChild( $child );
			
			$child = $doc->createElement('event', 'I\'ll do something');
			$child->setAttribute( 'start', date( timeline_date_format(), strtotime('monday next week') ) );
			$child->setAttribute( 'end', date( timeline_date_format(), strtotime('friday next week') ) );
			$child->setAttribute( 'title', 'next week' );
			$child->setAttribute( 'durationEvent', 'true' );
			$child->setAttribute( 'textColor', 'green' );
			$child = $root->appendChild( $child );
			
			echo $doc->saveXML();
		}
	}
?>

<?php	
if ( $page_info['type'] != 'blank' )
{
?>

<div id="container">
	<div id="top">
		<div id="mug">
			<img src="<?php echo htmlentities( $user['mug'] ); ?>" alt="<?php echo htmlentities( $user['name'] ); ?>" />
		</div>
	
		<div id="contact">                
			<div class="header"><?php echo htmlentities( $user['name'] ); ?></div>

			<span style="font-style: italic">E-Mail</span>: <a href="mailto:<?php echo htmlentities( $user['email'] ); ?>"><?php echo htmlentities( $user['email'] ); ?></a>
			<br />
			<?php echo htmlentities( $user['contact'] ); ?>

			<br /><br />

<?php
				if ( ( $page_info['type'] == 'full' ) && !is_null( $user['scholar_id'] ) )
				{
					$li = array();
					$li[] = '<span class="noprint">';
					$li[] = ( "\t" . '<a target="_blank" href="http://scholar.google.com/citations?user=' . htmlentities( $user['scholar_id'] ) . '&hl=en" style="text-decoration:none;"><span style="font: 80% Arial,sans-serif; color:#0783B6;"><img src="common/public/scholar.png" width="15" height="15" alt="View ' . htmlentities( $user['name'] ) . '\'s Google Scholar Citations" style="vertical-align:middle" border="0"></span></a>' );
					$li[] = '</span>';
					$li[] = '&nbsp;&nbsp;';
					
					foreach ( $li as $v )
					{
						echo ( "\t\t\t" . $v . "\n" );
					}
				}
	
?>

<?php
	
				if ( ( $page_info['type'] == 'full' ) && !is_null( $user['linkedin_url'] ) )
				{
					$li = array();
					$li[] = '<span class="noprint">';
					$li[] = ( "\t" . '<a target="_blank" href="' . htmlentities( $user['linkedin_url'] ) . '" style="text-decoration:none;"><span style="font: 80% Arial,sans-serif; color:#0783B6;"><img src="common/public/linkedin.png" width="20" height="15" alt="View ' . htmlentities( $user['name'] ) . '\'s LinkedIn profile" style="vertical-align:middle" border="0"></span></a>' );
					$li[] = '</span>';
					$li[] = '&nbsp;';
					
					foreach ( $li as $v )
					{
						echo ( "\t\t\t" . $v . "\n" );
					}
				}
?>

<?php
				if ( ( $page_info['type'] == 'full' ) && !is_null( $user['flickr_url'] ) )
				{
					$li = array();
					$li[] = '<span class="noprint">';
					$li[] = ( "\t" . '<a target="_blank" href="' . htmlentities( $user['flickr_url'] ) . '" style="text-decoration:none;"><img src="common/public/flickr.ico" width="15" height="15" alt="View ' . htmlentities( $user['name'] ) . '\'s Flickr pictures" style="vertical-align: middle; border: none;"></a>' );
					$li[] = '</span>';
					$li[] = '&nbsp;&nbsp;';
					
					foreach ( $li as $v )
					{
						echo ( "\t\t\t" . $v . "\n" );
					}
				}
?>

		</div>
	</div>
	
	<div id="content">
<?php 
		if ( count( $user['tabs'] ) > 1 )
		{
			jquery_create_tabs( 'tabs', $user['tabs'], $user['handler'], "\t\t" ); 
		}
		else if ( count( $user['tabs'] ) == 1 )
		{
			$keys = array_keys( $user['tabs'] );
			
			call_user_func_array( $user['handler'], array( $keys[0], "\t\t" ) );
		}
?>
	</div>
</div>

<div id="footer">
<?php
	$footer = array();
	if ( !is_null( $user['footer'] ) )
	{
		$temp = explode( "\n", $user['footer'] );
		foreach ( $temp as $t )
		{
			$footer[] = $t;
		}
	}
	$footer[] = ( 'last updated on ' . htmlentities( date( 'j F Y', filemtime( ( is_readable( INC_FILE ) )?( INC_FILE ):( $_SERVER['SCRIPT_FILENAME'] ) ) ) ) . ' | powered by <a href="http://vitagen.googlecode.com" target="_blank">vitagen</a>' );
	
	foreach ( $footer as $f )
	{
		echo ( "\t" . $f . '<br />' . "\n" );
	}
?>
</div>

<?php
	if ( !is_null( $user['g_analytics'] ) )
	{
		$g = array();
		
		$g[] = ( '<script type="text/javascript">' );
		$g[] = ( "\t" . 'var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");' );
		$g[] = ( "\t" . 'document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));' );
		$g[] = ( '</script>' );
		$g[] = ( '<script type="text/javascript">' );
		$g[] = ( "\t" . 'try {' );
		$g[] = ( "\t\t" . 'var pageTracker = _gat._getTracker("' . htmlentities( $user['g_analytics'] ) . '");' );
		$g[] = ( "\t\t" . 'pageTracker._trackPageview();' );
		$g[] = ( "\t" . '} catch(err) {}' );
		$g[] = ( '</script>' );
		
		foreach ( $g as $v )
		{
			echo ( $v . "\n" );
		}
	}
}
else
{
	$tab = misc_param( 'tab' );
	if ( empty( $tab ) )
	{
		$keys = array_keys( $user['tabs'] );
		$tab = $keys[0];
	}
	
	call_user_func_array( $user['handler'], array( $tab, "" ) );
}
?>

<?php
	
	{
		require 'common/private/end.inc.php';
	}

?>
