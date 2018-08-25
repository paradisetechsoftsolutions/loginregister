<?php

	ob_start();
	session_start();

	require('database/database.php');
	require('user/user.php');
	require('profile/profile.php');
	require('server.php');
	
	

	$host  = $_SERVER['HTTP_HOST'];
	$uri   = (strlen(dirname($_SERVER['PHP_SELF'])) < 2 ) ? null : dirname($_SERVER['PHP_SELF']);
	$site_url = 'http://'. $host . $uri.'/';


	if(User::logged_in()) {
		$account_user_id = (isset($_SESSION['id']) == true) ? $_SESSION['id'] : $_COOKIE['id'];
		$account = new User($account_user_id);
	}

	//redirect function
	function redirect($new_page = 'index') {		
		header('Location: '. $site_url . $new_page);
		die();
	}

?>