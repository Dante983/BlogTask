
<?php
	session_start();
	// connect to database
	$conn = mysqli_connect("localhost", "root", "", "BlogLocal");

	if (!$conn) {
		die("Error connecting to database: " . mysqli_connect_error());
	}
    // definisi globalne konstante
        define ('ROOT_PATH', '/Users/nikolasavic/BlogTask/');
        define('BASE_URL', 'http://blog.local.com/');
?>