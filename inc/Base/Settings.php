<?php

/*
*
* @package Yariko
*
*/

namespace Dp\Inc\Base;

class Settings{

	public function register(){

		add_action('wp_head', array($this, 'no_index'));

	}

	function no_index(){
		global $wp_query;
		$post_obj = $wp_query->get_queried_object();
		var_dump($post_obj);
		if($post_obj->post_type == 'page' && $post_obj->post_name == 'dealer-registration'){
			echo "\t<meta name='robots' content='noindex, nofollow' />\r\n";
		}

	}
}