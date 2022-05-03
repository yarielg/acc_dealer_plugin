<?php

/*
*
* @package Yariko
*
*/

namespace Dp\Inc\Base;

class Pages{

    public function register(){

        add_action('admin_menu', function(){
            add_menu_page('Dealer Portal', 'Dealer Portal', 'manage_options', 'dp-main-menu', array($this,'index') );
        });

        add_action('admin_menu',function(){
            $index =  add_submenu_page( 'dp-main-menu', __('Products','wr_price_list'), __('Products','wr_price_list'),'manage_options', 'dp-main-menu', array($this,'index'));
            add_action( 'load-' . $index, function(){
                add_action( 'admin_enqueue_scripts',function (){

	                wp_enqueue_style('dp-bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css'  );

	                //wp_enqueue_style('dp-admin-app-css', DP_PLUGIN_URL . '/assets/css/main.css'  );
	                wp_enqueue_style('dp-app-css', DP_PLUGIN_URL . '/dist/app.css'  );
	                wp_enqueue_style('dp-vendors-css', DP_PLUGIN_URL . '/dist/vendors.css'  );
	                wp_enqueue_script( 'dp-bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js');
	                wp_enqueue_style('main_admin_styles',  DP_PLUGIN_URL . '/assets/css/admin/main.css' );

	                wp_enqueue_script( 'dp-runtime-js', DP_PLUGIN_URL . '/dist/runtime.wec.bundle.js', '1.00', true);
	                wp_enqueue_script( 'dp-vendors-js', DP_PLUGIN_URL . '/dist/vendors.wec.bundle.js', array('dp-runtime-js'),'1.00', true);

	                wp_enqueue_script( 'dp-app-js', DP_PLUGIN_URL . '/dist/app.wec.bundle.js', array('dp-runtime-js', 'dp-vendors-js'),'1.00', true);

	                $args = array(
		                'ajax_url'=> admin_url('admin-ajax.php'),
		                'plugin_url' => DP_PLUGIN_URL,
		                'plugin_path' => DP_PLUGIN_PATH,
	                );
	                wp_localize_script( 'dp-app-js', 'dp_params', $args );

                });
            });

        });

    }

    function index(){
	    ?>
        <div id="dp-app"></div>
	    <?php
    }

}
?>