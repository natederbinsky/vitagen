<?php
	header("Content-Type: text/css");
	
	$type = 'full';
	if ( isset( $_GET['type'] ) && ( $_GET['type'] == 'mobile' ) )
	{
		$type = 'mobile';
	}
?>

html
{
	height: 100%;
}

body
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: black;
	
	padding: 0px;
	margin: 10px;
}

a
{
	text-decoration: none;
	color: #cc0000;
}

a:hover
{
	text-decoration: underline;
}

.important
{
	font-weight: bold;
}

#container
{
	<?php echo ( ( $type == 'mobile' )?('width: device-width;'):('width: 765px;') . "\n" ); ?>
	margin: 20px 5px;
}

#top
{
	<?php echo ( ( $type == 'mobile' )?('height: 80px;'):('height: 120px;') . "\n" ); ?>
}

#mug
{
	float: left;
	margin-right: 15px;
	
	<?php echo ( ( $type == 'mobile' )?('width: 55px;'):('width: 82.5px;') . "\n" ); ?>
	<?php echo ( ( $type == 'mobile' )?('height: 80px;'):('height: 120px;') . "\n" ); ?>
}

#mug img
{
	height: 100%;
	width: 100%;
	-moz-border-radius: 6px; 
	border-radius: 6px;
}

#contact
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: black;
	
	float: left;
	padding: 0;
	margin: 0;
	height: 100%;
}

#contact .header
{
	font-size: 16px;
	font-weight: bold;
	margin-bottom: 4px;
}

#content
{
	clear: both;
	padding: 15px 0px;
}

#content li
{
	line-height: 15px;
	margin-bottom: 5px;
}

#content ul
{
	margin-top: 5px;
	margin-bottom: 10px;
	padding-left: 16px;
}

#content .section
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: black;
	
	margin-bottom: 15px;
}

#content .header
{
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 20px;
	
	margin-bottom: 10px;
}

#content .self
{
	font-weight: 600;
}

#footer
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: italic;
	color: black;
	
	clear: both;
	padding-bottom: 5px;
}
