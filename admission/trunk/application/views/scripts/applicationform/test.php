<?php
	$jpeg_data = file_get_contents('php://input');
	$filename = "uploads/my_file.jpg";
	$result = file_put_contents( $filename, $jpeg_data );
	
	
?>