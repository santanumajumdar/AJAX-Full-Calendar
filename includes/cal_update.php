<?php

	// Loader - class and connection
	include('loader.php');

	// Catch start, end and id from javascript
	$start = $_POST['start'];
	$end = $_POST['end'];
	$id = $_POST['id'];
	$allDay = $_POST['allDay'];
	$original_id = $_POST['original_id'];
	
	echo $calendar->update($allDay, $start, $end, $id, $original_id);

?>