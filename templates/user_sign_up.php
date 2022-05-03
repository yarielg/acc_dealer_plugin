<?php
if(!isset($_GET['token']) || !isset($_GET['user_id'])){
    wp_safe_redirect(site_url());
    die();
}else{
    $user_id = $_GET['user_id'];
    $token = $_GET['token'];
    $user = get_user_by('ID', $user_id);
    $user_token = get_user_meta($user_id, 'dp_token', true);
    if($user_token != $token){
	    wp_safe_redirect(site_url());
	    die();
    }
    $user = get_user_by('ID', $user_id);
    $name = $user->display_name;
    $name = explode(' ', $name);
    $name = count($name) > 0 ? $name[0] : $user->display_name;
    $email = $user->user_email;
}

?>

<div class="container">
    <div class="row">
        <div class="col-12 text-center" >
            <h3 class="text-center">Dealer Registration</h3>
            <p>Hi <?php echo $name ?>, after choosing a password you will be redirect to your dashboard.</p>
        </div>
    </div>
	<div class="row">

        <div class="col-md-3"></div>
		<div class="col-md-6 box-panel text-center">
			<div class="panel-wrapper">

                <!--<p><strong>User: </strong><?php /*echo $email */?></p>-->
				<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
					<input type="hidden" name="action" value="dp_user_signup">
					<input type="hidden" value="<?php echo $user_id ?>" name="dp_user_id" value="dp_user_id">
					<div class="form-group">
						<input  style="width:300px;margin:0 auto;" required name="dp_password" type="password" class="form-control" id="dp_pass" placeholder="Password">
					</div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="dp_opt_in_marketing" name="dp_opt_in_marketing">
                        <label class="form-check-label" for="dp_opt_in_marketing">Do you want to receive promotion messages?</label>
                    </div>

					<button style="background: #8bc53f;color:white;'proxima nova',sans-serif" type="submit" name="dp_user_signup" class="btn db-submit">Sign Up</button>
				</form>
			</div>
		</div>
        <div class="col-md-6"></div>
	</div>
</div>
<style>
    .dp-submit{
        box-sizing: border-box !important;
        font-size: 1em !important;
        padding: 0.5em 1em !important;
        background: #8bc53f !important;
        color: #ffffff !important;
        border: 1px solid #8bc53f !important;
        border-width: 1px 0 !important;
        -webkit-border-radius: 0em !important;
        -moz-border-radius: 0em !important;
        border-radius: 0em !important;
        text-shadow: 0 1px 0 rgb(0 0 0 / 5%) !important;
    }
</style>