<?php

	// Loader - class and connection
	include('loader.php');
	
	// Catch start, end and id from javascript
	$title = $_POST['title'];
	$description = $_POST['description'];
	$start_date = $_POST['start_date'];
	$start_time = $_POST['start_time'];
	$end_date = $_POST['end_date'];
	$end_time = $_POST['end_time'];
	$color = $_POST['color'];
	$allDay = $_POST['allDay'];
	$url = $_POST['url'];
	
	$extra = array('repeat_method' => 'no', 'repeat_times' => 1);
	
	// All Day Fix
	if($allDay == 'true')
	{
		$allDay = 'false';
	} else {
		$allDay = 'true';	
	}
	
	// Category Handler - Core
	// If you want to have the categories in your creations use this code, some demos does not it because does not make use of category
	if(isset($_POST['categorie']) && strlen($_POST['categorie']) !== 0)
	{
		$extra['categorie'] = $_POST['categorie'];
	} else {
		$extra['categorie'] = '';	
	}
	
	// This demo exclusive
	$extra['user_id'] = get_user("ID");
	
	if(strlen($title) == 0) 
	{
		echo 0;	
	} else {
		$add_event = $calendar->addEvent($title, $description, $start_date, $start_time, $end_date, $end_time, $color, $allDay, $url, $extra);
		if($add_event == true)
		{
			echo 1;
		} else {
			echo 0;	
		}
	}
	

?>