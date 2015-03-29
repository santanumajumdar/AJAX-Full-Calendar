<?php

	// Loader - class and connection
	include('loader.php');
	
	if(isset($_POST['method']) && $_POST['method'] == 'repetitive_event')
	{
		$method = true;
		$rep_id = $_POST['rep_id'];
		$id = $_POST['id'];
	} else {
		$method = '';
		$rep_id = $_POST['id'];
		$id = $_POST['id'];	
	}
	
	$calendar->delete($id, $rep_id, $method);

?>