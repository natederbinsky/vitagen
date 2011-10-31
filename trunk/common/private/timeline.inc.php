<?php
	
	function timeline_date_format()
	{
		return 'F d Y H:i:s T';
	}
	
	function timeline_events()
	{
		return array( 'onload', 'onresize' );
	}
	
	function timeline_event_name( $e, $id )
	{
		return ( 'timeline_' . $e . '_' . $id );
	}
	
	function timeline_init( $id, $source, $bandInits, $bandChanges, $prefix = '' )
	{
		static $count = 1;
		global $page_info;
		
		// timeline api singleton
		if ( $count == 1 )
		{
			$page_info['head'][] = ( '<script type="text/javascript">' );
			$page_info['head'][] = ( "\t" . 'Timeline_ajax_url="common/public/timeline/timeline_ajax/simile-ajax-api.js";' );
			$page_info['head'][] = ( "\t" . 'Timeline_urlPrefix="common/public/timeline/timeline_js/";' );
			$page_info['head'][] = ( "\t" . 'Timeline_parameters="bundle=true";' );
			$page_info['head'][] = ( '</script>' );
			$page_info['head'][] = ( '<script src="common/public/timeline/timeline_js/timeline-api.js" type="text/javascript"></script>' );
			
			foreach ( timeline_events() as $e )
			{
				if ( !isset( $page_info['body'][ $e ] ) )
				{
					$page_info['body'][ $e ] = '';
				}
			}
		}
		
		// setup body event calls
		foreach ( timeline_events() as $e )
		{
			$page_info['body'][ $e ] .= ( timeline_event_name( $e, $count ) . '();' );
		}
		
		// create event handlers
		echo ( $prefix . '<script type="text/javascript">' . "\n" );
		echo ( $prefix . "\t" . 'var timeline_t' . $count . ';' . "\n" );
		echo ( $prefix . "\t" . 'function ' . timeline_event_name( 'onload', $count ) . '() { ' . "\n" );
		{
			echo ( $prefix . "\t\t" . 'var eventSource = new Timeline.DefaultEventSource();' . "\n" );
			echo ( $prefix . "\t\t" . 'var bandInfos = [' . "\n" );
			{
				$b_c = 1;
				$b_max = count( $bandInits );
				
				foreach ( $bandInits as $b => $info )
				{
					echo ( $prefix . "\t\t\t" . 'Timeline.createBandInfo({' . "\n" );
					
					$info['eventSource'] = 'eventSource';
					$i_c = 1;
					$i_max = count( $info );
					foreach ( $info as $k => $v )
					{
						echo ( $prefix . "\t\t\t\t" . $k . ':' . "\t\t" . $v . ( ( $i_c != $i_max )?(','):('') ) . "\n" );
						
						$i_c++;
					}
					echo ( $prefix . "\t\t\t" . '})' . ( ( $b_c != $b_max )?(','):('') ) . "\n" );
					
					$b_c++;
				}
			}
			echo ( $prefix . "\t\t" . '];' . "\n" );
			
			foreach ( $bandChanges as $b => $info )
			{
				foreach ( $info as $k => $v )
				{
					echo ( $prefix . "\t\t" . 'bandInfos[' . $b . '].' . $k . ' = ' . $v . ';' . "\n" );
				}
			}
			echo ( "\n" );
			
			echo ( $prefix . "\t\t" . 'timeline_t' . $count . '=Timeline.create(document.getElementById("' . $id . '"), bandInfos);' . "\n" );
			echo ( $prefix . "\t\t" . 'Timeline.load' . $source['type'] . '("' . $source['url'] . '", function(data, url) { eventSource.load' . $source['type'] . '(data, url); });' . "\n" );
		}
		echo ( $prefix . "\t" . '}' . "\n" );
		
		echo ( "\n" );
		
		echo ( $prefix . "\t" . 'var timeline_r' . $count . ';' . "\n" );
		echo ( $prefix . "\t" . 'function ' . timeline_event_name( 'onresize', $count ) . '() { ' . "\n" );
		{
			echo ( $prefix . "\t\t" . 'if (timeline_r' . $count . ' == null) {' . "\n" );
			{
				echo ( $prefix . "\t\t\t" . 'timeline_r' . $count . ' = window.setTimeout(function() {' . "\n" );
				echo ( $prefix . "\t\t\t\t" . 'timeline_r' . $count . ' = null;' . "\n" );
				echo ( $prefix . "\t\t\t\t" . 'timeline_t' . $count . '.layout();' . "\n" );
				echo ( $prefix . "\t\t\t" . '}, 500);' . "\n" );
			}
			echo ( $prefix . "\t\t" . '}' . "\n" );
		}
		echo ( $prefix . "\t" . '}' . "\n" );
		
		echo ( $prefix . '</script>' . "\n" );

		
		$count++;
	}

?>
