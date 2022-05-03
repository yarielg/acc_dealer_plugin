<?php
/** HELPERS **/
function dp_template( $file, $args ){
	// ensure the file exists
	if ( !file_exists( $file ) ) {
		return '';
	}

	// Make values in the associative array easier to access by extracting them
	if ( is_array( $args ) ){
		extract( $args );
	}

	// buffer the output (including the file is "output")
	ob_start();
	include $file;
	return ob_get_clean();
}

function dp_generate_string($len){
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';

	for ($i = 0; $i < $len; $i++) {
		$index = rand(0, strlen($characters) - 1);
		$randomString .= $characters[$index];
	}

	return $randomString;
}

function dp_send_user_invitation($email,$data){
	$title   = 'You got an invitation from ACC Crappie Stix';
	$content = dp_template(DP_PLUGIN_PATH . '/templates/user_invitation.php',$data);
	$headers = array('Content-Type: text/html; charset=UTF-8');
	// ...
	wp_mail( $email, $title, $content,$headers);
}