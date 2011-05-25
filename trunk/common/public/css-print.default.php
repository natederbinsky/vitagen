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

#content .self
{
	font-weight: normal;
}

#footer
{
	display:none;
}

.noprint
{
	display: none;
}

.ui-tabs-nav 
{ 
	display: none; 
}

.ui-tabs
{
	border: none;
}

.ui-tabs .ui-tabs-panel
{
	padding: 0px;
}

.ui-tabs .ui-tabs-hide 
{ 
	display: none; 
}
