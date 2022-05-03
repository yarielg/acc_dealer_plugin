<?php

/*
*
* @package Yariko
*
*/

namespace Dp\Inc\Base;

class Enqueue{

    public function register(){

        add_action( 'admin_enqueue_scripts', array( $this , 'wrpl_enqueue_admin' ) ); //action to include script to the backend, in order to include in the frontend is just wp_enqueue_scripts instead admin_enqueue_scripts
        add_action( 'wp_enqueue_scripts', array( $this, 'wrpl_enqueue_frontend'));

    }

    function wrpl_enqueue_frontend(){
        //enqueue all our scripts frontend
    }

    function wrpl_enqueue_admin(){


    }

}