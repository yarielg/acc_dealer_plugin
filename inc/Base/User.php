<?php

/*
*
* @package yariko
*
*/
namespace Dp\Inc\Base;

class User{

	public function register(){

		//Add user
		add_action( 'wp_ajax_dp_add_user', array($this,'add_user' ));

		//Get dealers
		add_action( 'wp_ajax_get_dealers', array($this,'get_dealers' ));

		//Remove user
		add_action( 'wp_ajax_dp_remove_user', array($this,'remove_user' ));
	}

	//Add a dealer user
	function add_user(){
		$first = $_POST['first'];
		$last = $_POST['last'];
		$email = $_POST['email'];
		$password = dp_generate_string(12);
		$token = dp_generate_string(22);

		if(email_exists($email)){

			echo json_encode(array('success' => false,'msg'=> 'There is an account associated with this email'));
			wp_die();
		}

		$user_id = wp_insert_user( array(
			'first_name' => $first,
			'last_name' => $last,
			'user_email' => $email,
			'user_login' => $email,
			'user_pass' => $password,
			'role' => 'dealer'
		));

		if( $user_id > 0){
			update_user_meta($user_id,'dp_token',$token);
			update_user_meta($user_id,'dp_status','Sent');
			update_user_meta($user_id,'dp_created',date("m/d/Y"));

			$link = site_url() . '/dealer-registration?user_id=' . $user_id . '&token=' . $token;
			dp_send_user_invitation($email, array('email' => $email, 'first' => $first, 'last' => $last, 'logo' => DP_PLUGIN_URL . '/assets/img/logo.png', 'link' => $link));

			echo json_encode(array('success' => true,'msg'=> 'User added successfully'));
			wp_die();
		}else{
			echo json_encode(array('success' => false,'msg'=> 'The account was not created'));
			wp_die();
		}
	}

	/**
	 * Get all the user with role dealer
	 */
	function get_dealers(){
		$search = $_POST['search'];
		$length = $_POST['length'];
		$start = $_POST['start'];

		$args = array(
			'role'    => 'dealer',
			'orderby' => 'ID',
			'order'   => 'ASC'
		);

		$users = get_users( $args );
		$users_data = array();

		$total = count($users);

		foreach ($users as $user){

			if($search != ''){
				if(strpos($user->user_email,$search) !== false){
					$user->created = get_user_meta($user->ID, 'dp_created') ? get_user_meta($user->ID, 'dp_created',true) : '-';
					$user->status = get_user_meta($user->ID, 'dp_status') ? get_user_meta($user->ID, 'dp_status',true) : '-';
					$user->token = get_user_meta($user->ID, 'dp_token') ? get_user_meta($user->ID, 'dp_token',true) : '-';
					$user->dp_opt_in_marketing = intval(get_user_meta($user->ID, 'dp_opt_in_marketing')) == 1 ? 'Yes' : 'No';
					array_push($users_data, $user->data);
				}else{
					continue;
				}

			}else{
				$user->created = get_user_meta($user->ID, 'dp_created') ? get_user_meta($user->ID, 'dp_created',true) : '-';
				$user->status = get_user_meta($user->ID, 'dp_status') ? get_user_meta($user->ID, 'dp_status',true) : '-';
				$user->token = get_user_meta($user->ID, 'dp_token') ? get_user_meta($user->ID, 'dp_token',true) : '-';
				$user->dp_opt_in_marketing = intval(get_user_meta($user->ID, 'dp_opt_in_marketing')) == 1 ? 'Yes' : 'No';
				array_push($users_data, $user->data);
			}
		}

		$totalMatches = count($users_data);
		$sliced_users = array_slice($users_data, $start, $length);

		echo json_encode(array('success' => true,'users'=> $sliced_users, 'total' => $total, 'totalMatches' => $totalMatches));
		wp_die();
	}

	function remove_user(){
		wp_delete_user($_POST['id']);

		echo json_encode(array('success' => true,'msg'=> 'User removed succesfully'));
		wp_die();
	}
}
