<?php
/*
Plugin Name: User Role Blocker
Plugin URI:
Description:
Version: 1.0
Author: Arif Islam
Author URI: arifislam.techviewing.com
License: GPLv2 or later
Text Domain: urb
Domain Path: /languages/
*/

add_action( 'init', function () {
	add_role( 'urb_user_blocked', __( 'Blocked', 'user-role-blocker' ), array( 'blocked' => true ) );
	add_rewrite_rule( 'blocked/?$', 'index.php?blocked=1', 'top' );
} );

add_action( 'init', function () {
	if ( is_admin() && current_user_can( 'blocked' ) ) {
		wp_redirect( get_home_url() . '/blocked' );
		die();
	}
} );

add_filter( 'query_vars', function ( $query_vars ) {
	$query_vars[] = 'blocked';
	return $query_vars;
} );

add_action( 'template_redirect', function () {
	$is_blocked = intval( get_query_var( 'blocked' ) );
	if ( $is_blocked || current_user_can( 'blocked' ) ) {
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title><?php _e( 'Blocked User', 'user-role-blocker' );?></title>
			<?php
			wp_head();
			?>
		</head>
		<body>
		<h2 style="text-align: center"><?php _e( 'You are blocked', 'user-role-blocker' );?></h2>
		<?php
		wp_footer();
		?>
		</body>
		</html>
		<?php
		die();
	}
} );