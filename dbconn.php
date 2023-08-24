<?php
	# Stop Hacking attempt
	if(!defined('__APP__')) {
		die("Hacking attempt");
	}
	
	# Connect to MySQL database
	$user = mysqli_connect("localhost","root","","user") or die('Error connecting to MySQL server.');