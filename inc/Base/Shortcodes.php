<?php

/*
*
* @package yariko
*
*/
namespace Dp\Inc\Base;

class Shortcodes{

	public function register(){

		//Dealer registration Shortcode
		add_shortcode( 'dp_dealer_signup', array($this, 'userSignUp') );

		//Processing the user signup
		add_action( 'admin_post_dp_user_signup', array($this, 'processUserSignUp') );
		add_action( 'admin_post_nopriv_dp_user_signup', array($this, 'processUserSignUp') );
	}

	/**
	 * Shortcode to output the form for user to register
	 */
	public function userSignUp(){

		$output = dp_template(DP_PLUGIN_PATH . 'templates/user_sign_up.php' , []);
		return $output;
	}

	/**
	 * Receive the $_POST data to save the user info
	 */
	public function processUserSignUp(){
		if(isset($_POST['dp_password'])  && isset($_POST['dp_user_id'])){
			$user_id = $_POST['dp_user_id'];
			$user = get_user_by('ID', $user_id );

			if ( !is_wp_error( $user ) ){

				wp_set_password( $_POST['dp_password'], $user->ID);

				update_user_meta($user_id,'dp_status','Accepted' );
				update_user_meta($user_id,'dp_opt_in_marketing',isset($_POST['dp_opt_in_marketing']) ? 1 : 0 );

				wp_clear_auth_cookie();
				wp_set_current_user ( $user->ID );
				wp_set_auth_cookie  ( $user->ID );

				$redirect_to = get_option('siteurl') . '/my-account';
				wp_safe_redirect( $redirect_to );
				exit();
			}

		}else{
			echo "Error, We couldn't process the request. Please contact the admin.";
			die();
		}
	}
}
