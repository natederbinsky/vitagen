<?php

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
			$user['g_analytics'] = NULL;
			$user['tabs'] = array( 'cv'=>'CV', 'links'=>'Links' );
			$user['handler'] = '_example';
			
			// override if available
			@include( 'index.inc.php' );
		}
		
		$page_info['title'] = $user['name'];
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
			
			echo misc_section( 'Goals', 'I have always dreamt of being a doctor.', $prefix );
			echo misc_section( 'Education', misc_list( $education ), $prefix );
			echo misc_section( 'Skills', misc_list( $skills ), $prefix );
			echo misc_section( 'Experience', $experience, $prefix );
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
	}
	
?>

<div id="container">
	<div id="top">
		<div id="mug">
<img style="-moz-border-radius: 6px; border-radius: 6px;" src="<?php echo htmlentities( $user['mug'] ); ?>" alt="<?php echo htmlentities( $user['name'] ); ?>" />
		</div>
	
		<div id="contact">                
			<div class="header"><?php echo htmlentities( $user['name'] ); ?></div>
			<br />

			<span style="font-style: italic">E-Mail</span>: <a href="mailto:<?php echo htmlentities( $user['email'] ); ?>"><?php echo htmlentities( $user['email'] ); ?></a>
			<br />
			<?php echo htmlentities( $user['contact'] ); ?>

			<br /><br />

<?php
				if ( ( $page_info['type'] == 'full' ) && !is_null( $user['linkedin_url'] ) )
				{
					$li = array();
					$li[] = '<div class="noprint">';
					$li[] = ( "\t" . '<a target="_blank" href="' . htmlentities( $user['linkedin_url'] ) . '" style="text-decoration:none;"><span style="font: 80% Arial,sans-serif; color:#0783B6;"><img src="http://www.linkedin.com/img/webpromo/btn_in_20x15.png" width="20" height="15" alt="View ' . htmlentities( $user['name'] ) . '\'s LinkedIn profile" style="vertical-align:middle" border="0"></span></a>' );
					$li[] = '</div>';
					
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
	Last updated on <?php echo htmlentities( date( 'j F Y', filemtime( $_SERVER['SCRIPT_FILENAME'] ) ) . "\n" ); ?>
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
			echo ( "\t\t" . $v . "\n" );
		}
	}
?>

<?php
	
	{
		require 'common/private/end.inc.php';
	}

?>
