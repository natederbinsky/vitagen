<?php
	
    function jquery_button( $id )
    {
        return '<script type="text/javascript">$("#' . $id . '").button();</script>';
    }

    function _jquery_tabs( $id )
    {
        return '<script type="text/javascript">$(function() {$("#' . $id . '").tabs(); });</script>';
    }

    // tabs  = array( id=>title )
    // callback = 'function_name' || array( object, 'function_name' ) : ( $id, $prefix )
    function jquery_create_tabs( $tab_id, $tabs, $callback, $prefix = '' )
    {
        global $page_info;

        $page_info['head'][] = _jquery_tabs( $tab_id );

        echo ( $prefix . '<div id="' . htmlentities( $tab_id ) . '">' . "\n" );

        echo ( $prefix . "\t" . '<ul>' . "\n" );
        foreach ( $tabs as $tk => $tv )
        {
            echo ( $prefix . "\t\t" . '<li><a href="#' . htmlentities( $tk ) . '">' . htmlentities( $tv ) . '</a></li>' . "\n" );
        }
        echo ( $prefix . "\t" . '</ul>' . "\n" );

        foreach ( $tabs as $tk => $tv )
        {
            echo ( $prefix . "\t" . '<div id="' . htmlentities( $tk ) . '">' . "\n" );

            call_user_func_array( $callback, array( $tk, ( $prefix . "\t\t" ) ) );

            echo ( $prefix . "\t" . '</div>' . "\n" );
        }

        echo ( $prefix . '</div>' . "\n" );
    }

?>
