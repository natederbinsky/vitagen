<?php
	header("Content-Type: text/css");

	$type = 'full';
	if ( isset( $_GET['type'] ) && ( $_GET['type'] == 'mobile' ) )
	{
		$type = 'mobile';
	}
?>

a
{
	text-decoration: none;
	color: black;
}

#footer
{
	display:none;
}

#arrow
{
	display: none;
}

.noprint
{
	display: none;
}

.ui-tabs
{
	border: none;
}

.ui-tabs-nav 
{ 
	display: none; 
}

.ui-tabs .ui-tabs-hide 
{ 
	display: none; 
}
