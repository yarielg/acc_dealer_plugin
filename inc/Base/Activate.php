<?php

/*
*
* @package yariko		
*
*/
namespace Dp\Inc\Base;

class Activate{

    public static function activate(){
	    add_role( 'dealer', 'Dealer', get_role( 'subscriber' )->capabilities );
    }
}
