<?php
/*
*
* @package yariko


Plugin Name:  Dealer Portal.
Plugin URI:   https://thomasgbennett.com/
Description:  Dealer Portal plugin created by Thomas Bennett Group
Version:      1.0.4
Author:       Thomas Bennett Group
Author URI:   https://thomasgbennett.com/
Tested up to: 5.9.3
Text Domain:  tbg_dealer_portal
Domain Path:  /languages
*/

defined('ABSPATH') or die('You do not have access, sally human!!!');

define ( 'DP_PLUGIN_VERSION', '1.0.1');

if( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php') ){
    require_once  dirname( __FILE__ ) . '/vendor/autoload.php';
}

define('DP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define('DP_PLUGIN_URL' , plugin_dir_url(  __FILE__  ) );
define('DP_ADMIN_URL' , get_admin_url() );
define('DP_PLUGIN_DIR_BASENAME' , dirname(plugin_basename(__FILE__)) );


//include the helpers
include 'inc/Util/helper.php';

/**
 * Check if WooCommerce is activated
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
    if( class_exists( 'Dp\\Inc\\Init' ) ){
        register_activation_hook( __FILE__ , array('Dp\\Inc\\Base\\Activate','activate') );
        register_deactivation_hook( __FILE__ , array('Dp\\Inc\\Base\\Deactivate','deactivate') );
        Dp\Inc\Init::register_services();
    }
}else{

    add_action('admin_notices', function(){
        ?>
            <div class="notice notice-error is-dismissible">
                <p>WR Price List Manager required WooCommerce, please activate it to use <b>WR Price List Manager</b> Plugin</p>
            </div>
        <?php
    });
}

