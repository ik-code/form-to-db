<?php

$path = preg_replace( '/wp-content.*$/', '', __DIR__ );

require_once( $path . "wp-load.php" );

if ( function_exists( 'shortcode_method' ) ) {
	//echo "<pre>"; print_r($_POST) ;echo "</pre>";

	if(isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'] ,'form_to_db_nonce')){
		wp_safe_redirect( $_POST['redirect_to']  );
	}else{
	 die('Sorry,  _nonce is bad!');
	}
} else {
	echo 'function not exits!';
}
