<?php

	/*************************************************************************
	*	Ajax Full Featured Calendar
	*	- Add Event To Calendar
	*	- Edit Event On Calendar
	*	- Delete Event On Calendar
	*	- View Event On Calendar
	*	- Update Event On Rezise
	*	- Update Event On Drag
	*
	*	Author: Paulo Regina
	*	Version: 1.6.4 (July 2014)
	**************************************************************************/
	
	class calendar
	{
		
		###############################################################################################
		#### Properties
		###############################################################################################
		
		// Initializes A Container Array For All Of The Calendar Events
		var $json_array = array();
		var $categories = '';
		var $connection = '';
				
		############################################################################################### 
		#### Methods
		###############################################################################################
		
		/**
		* Construct
		* Returns connection
		*/
		public function __construct($db_server, $db_username, $db_password, $db_name, $table, $condition=false)
		{
			// Set Internal Variables
			$this->db_server = $db_server;	
			$this->db_username = $db_username;
			$this->db_password = $db_password;
			$this->db_name = $db_name;
			$this->table = $table;	
			
			$this->condition = $condition;
			
			// Connection @params 'Server', 'Username', 'Password'
			$this->connection = mysqli_connect($this->db_server, $this->db_username, $this->db_password, $this->db_name);
			
			// Display Friend Error Message On Connection Failure
			if(!$this->connection) 
			{
				die('Could not connect: ('.mysqli_connect_errno().') - ' . mysqli_connect_error());
			}
			
			// Internal UTF-8
			mysqli_query($this->connection, "SET NAMES 'utf8'");
			mysqli_query($this->connection, 'SET character_set_connection=utf8');
			mysqli_query($this->connection, 'SET character_set_client=utf8');
			mysqli_query($this->connection, 'SET character_set_results=utf8');
			
			// Run The Query
			if($this->condition == false)
			{
				$this->result = mysqli_query($this->connection, "SELECT * FROM $this->table ");
			} else {
				$this->result = mysqli_query($this->connection, "SELECT * FROM $this->table WHERE $this->condition");	
			}
			
		}
		
		/**
		* Function To Transform MySQL Results To jQuery Calendar Json
		* Returns converted json
		*/
		public function json_transform($js = true)
		{
			
			while($this->row = mysqli_fetch_array($this->result, MYSQLI_ASSOC))
			{
				 // Set Variables Data from DB
				 $event_id = $this->row['repeat_id'];
				 $event_original_id = $this->row['id'];
				 $event_title = $this->row['title'];
				 $event_description = $this->row['description'];
				 $event_start = $this->row['start'];
				 $event_end = $this->row['end'];
				 $event_allDay = $this->row['allDay'];
				 $event_color = $this->row['color'];
				 $event_url = $this->row['url'];
				 
				 if($js == true) 
				 {
				 	 // JS MODE
					 
					 if($event_url == '?page=') { $event_url = 'undefined'; }
							
					 // When allDay = false the allDay options appears on the script, when its true it doesnot appear 
					 if($event_url == 'false' && $event_allDay == 'false')
					 {
						 // Build it Without URL & allDay
						 
						 // Stores Each Database Record To An Array (Without URL)
						$build_json = array('id' => $event_id, 'original_id' => $event_original_id, 'title' => $event_title, 'start' => $event_start, 'end' => $event_end, 'allDay' => $event_allDay, 'color' => $event_color);
	
						// Adds Each Array Into The Container Array
						array_push($this->json_array, $build_json);
						
					 } elseif($event_url == 'false' && $event_allDay == 'true') {
						 
						 // Build it Without URL 
						 
						 // Stores Each Database Record To An Array (Without URL)
						$build_json = array('id' => $event_id, 'original_id' => $event_original_id, 'title' => $event_title, 'start' => $event_start, 'end' => $event_end, 'color' => $event_color);
	
						// Adds Each Array Into The Container Array
						array_push($this->json_array, $build_json);
					  
					 } elseif($event_url == 'true' && $event_allDay == 'false') {
						 
						 // Built it Without URL & allDay True
						 
						// Stores Each Database Record To An Array
						$build_json = array('id' => $event_id, 'original_id' => $event_original_id, 'title' => $event_title, 'start' => $event_start, 'end' => $event_end, 'allDay' => $event_allDay, 'color' => $event_color, 'url' => $event_url);
						
						// Adds Each Array Into The Container Array
						array_push($this->json_array, $build_json);
						
					 } else {
						 
						 if($event_allDay == 'false') {
							// Built it With URL & allDay false
							 
							// Stores Each Database Record To An Array
							$build_json = array('id' => $event_id, 'original_id' => $event_original_id, 'title' => $event_title, 'start' => $event_start, 'end' => $event_end, 'allDay' => $event_allDay, 'color' => $event_color);
							if($event_url == '?page=') { } else { $build_json['url'] = $event_url; }
							
							// Adds Each Array Into The Container Array
							array_push($this->json_array, $build_json);
						 } else {
							// Built it With URL & allDay True (fixed on 1.6.4)
							 
							// Stores Each Database Record To An Array
							$build_json = array('id' => $event_id, 'original_id' => $event_original_id, 'title' => $event_title, 'start' => $event_start, 'end' => $event_end, 'color' => $event_color, 'url' => $event_url);
							
							// Adds Each Array Into The Container Array
							array_push($this->json_array, $build_json);	 
						 }
						 
					 }
				 
				 } else {
						
					// PHP MODE
					
					// When allDay = false the allDay options appears on the script, when its true it doesnot appear 
					 if($event_url == 'false' && $event_allDay == 'false')
					 {
						 // Build it Without URL & allDay
						 
						 // Stores Each Database Record To An Array (Without URL)
						$build_json = array('id' => $event_id, 'original_id' => $event_original_id, 'title' => $event_title, 'start' => $event_start, 'end' => $event_end, 'allDay' => $event_allDay, 'color' => $event_color);
	
						// Adds Each Array Into The Container Array
						array_push($this->json_array, $build_json);
						
					 } elseif($event_url == 'false' && $event_allDay == 'true') {
						 
						 // Build it Without URL 
						 
						 // Stores Each Database Record To An Array (Without URL)
						$build_json = array('id' => $event_id, 'original_id' => $event_original_id, 'title' => $event_title, 'start' => $event_start, 'end' => $event_end, 'color' => $event_color);
	
						// Adds Each Array Into The Container Array
						array_push($this->json_array, $build_json);
					  
					 } elseif($event_url == 'true' && $event_allDay == 'false') {
						 
						 // Built it Without URL & allDay True
						 
						// Stores Each Database Record To An Array
						$build_json = array('id' => $event_id, 'original_id' => $event_original_id, 'title' => $event_title, 'start' => $event_start, 'end' => $event_end, 'allDay' => $event_allDay, 'color' => $event_color, 'url' => $event_url);
						
						// Adds Each Array Into The Container Array
						array_push($this->json_array, $build_json);
						
					 } else {
						 
						 if($event_allDay == 'false' && substr($event_url, -4, 1) == '.' || substr($event_url, -3, 1) == '.') { // domain top level checking
							// Built it With URL & allDay false
							 
							// Stores Each Database Record To An Array
							$build_json = array('id' => $event_id, 'original_id' => $event_original_id, 'title' => $event_title, 'start' => $event_start, 'end' => $event_end, 'allDay' => $event_allDay, 'color' => $event_color, 'url' => $event_url);
							
							// Adds Each Array Into The Container Array
							array_push($this->json_array, $build_json);
							
						 } elseif($event_allDay == 'true' && substr($event_url, -4, 1) == '.' || substr($event_url, -3, 1) == '.') {
							
							// Built it With URL & allDay true
							 
							// Stores Each Database Record To An Array
							$build_json = array('id' => $event_id, 'original_id' => $event_original_id, 'title' => $event_title, 'start' => $event_start, 'end' => $event_end,  'color' => $event_color, 'url' => $event_url);
							
							// Adds Each Array Into The Container Array
							array_push($this->json_array, $build_json);
							
						 } elseif($event_allDay == 'false' && isset($event_url)) {
						 	
							// Built it With any URL and allDay false
							
							// Stores Each Database Record To An Array
							$build_json = array('id' => $event_id, 'original_id' => $event_original_id, 'title' => $event_title, 'start' => $event_start, 'end' => $event_end,  'allDay' => $event_allDay, 'color' => $event_color, 'url' => $event_url . $event_original_id);
							
							// Adds Each Array Into The Container Array
							array_push($this->json_array, $build_json);
							
					 	 } else {
							// Built it With URL & allDay True 
							 
							// Stores Each Database Record To An Array
							$build_json = array('id' => $event_id, 'original_id' => $event_original_id, 'title' => $event_title, 'start' => $event_start, 'end' => $event_end, 'color' => $event_color, 'url' => $event_url . $event_original_id);
							
							// Adds Each Array Into The Container Array
							array_push($this->json_array, $build_json);	 
						 }
						 
					 }
					
					 
				 }
				 	  
			} // end while loop
			
			// Output The Json Formatted Data So That The jQuery Call Can Read It
			return json_encode($this->json_array);	
		}
		
		/**
		* This function will check for repetitive events (since 1.6.4)
		* Returns true
		*/
		public function check_repetitive_events($id)
		{
			$query = sprintf('SELECT * FROM %s WHERE repeat_id != id AND id = %d || repeat_id = %d',
				  mysqli_real_escape_string($this->connection, $this->table),
				  mysqli_real_escape_string($this->connection, $id),
				  mysqli_real_escape_string($this->connection, $id)
			);
			
			$res = mysqli_query($this->connection, $query);
			
			if(mysqli_num_rows($res) > 1)
			{
				return true; 
			} elseif(mysqli_num_rows($res) == 1) {
				$row = mysqli_fetch_assoc($res);
				if($row['id'] == $row['repeat_id'])
				{
					return false;
				} else {
					return true;	
				}
			} else {
				return false;	
			}
		}
		
		/**
		* This function will get description (since 1.6.4)
		* Returns true
		*/
		public function get_description($id)
		{
			$query = sprintf('SELECT description FROM %s WHERE id = %d',
				  mysqli_real_escape_string($this->connection, $this->table),
				  mysqli_real_escape_string($this->connection, $id)
			);
			
			$res = mysqli_query($this->connection, $query);

			if(mysqli_num_rows($res) >= 1)
			{
				$result = mysqli_fetch_assoc($res);
				return $result['description'];
			} else {
				return false;	
			}
		}
		
		/**
		* This function updates event drag, resize, repetitive event from jquery fullcalendar
		* Returns true
		*/
		
		// update for repetitive events
		private function update_ui_repetitive($start, $end, $allDay_value, $repeat_type, $id, $extra)
		{
			if(strlen($allDay_value) == 0)
			{
				if(is_array($extra))
				{
					if(isset($extra['url']))
					{
						$url = $extra['url'];
					} else {
						$url = "false";	
					}
					
					$title = $extra['title'];
					$description = $extra['description'];
					$color = $extra['color'];
					
					$the_query = "title = '$title', description = '$description', color = '$color', url = '$url',";	
				} else {
					$the_query = '';	
				}
			} else {
				$the_query = "allDay = '$allDay_value',";	
			}
			
			$query = sprintf('UPDATE %s 
									SET 
										start = "%s",
										end = "%s",
										%s
										repeat_type = "%s"
									WHERE
										id = %d
						',
										mysqli_real_escape_string($this->connection, $this->table),
										mysqli_real_escape_string($this->connection, $start),
										mysqli_real_escape_string($this->connection, $end),
										$the_query,
										$repeat_type,
										mysqli_real_escape_string($this->connection, $id)
						);
			
			// The result
			return $this->result = mysqli_query($this->connection, $query);
		}
		
		// repetitive event procedure (for updates)
		private function repetitive_event_procedure($allDay, $start, $end, $id, $original_id, $extra)
		{
			$current_date = date('d', strtotime($start));
			$current_month = date('m', strtotime($start));
			$current_year = date('Y', strtotime($start));
			$start_time = date('H:i:s', strtotime($start));
			
			$end_current_date = date('d', strtotime($end));
			$end_current_month = date('m', strtotime($end));
			$end_current_year = date('Y', strtotime($end));
			$end_time = date('H:i:s', strtotime($end));
			
			$query = mysqli_query($this->connection, sprintf('SELECT id, repeat_type FROM %s WHERE repeat_id = %d ORDER BY id ASC', 
				mysqli_real_escape_string($this->connection, $this->table),
				mysqli_real_escape_string($this->connection, $id)
			));
			
			while($row = mysqli_fetch_assoc($query))
			{
				$ids[] = $row['id'];
				$rt = $row['repeat_type'];
			}
	
			$num_rows = mysqli_num_rows($query);

			if($num_rows >= 1)
			{ 
				switch($rt)
				{
					case 'every_day':
						for($i = 0; $i <= $num_rows; $i++)
						{
							$start = date('Y-m-d', strtotime("+$i day", strtotime($current_year.'-'.$current_month.'-'.$current_date))) . ' ' .$start_time;
							$end = date('Y-m-d', strtotime("+$i day", strtotime($end_current_year.'-'.$end_current_month.'-'.$end_current_date))) . ' ' .$end_time;
							$this->update_ui_repetitive($start, $end, $allDay_value, 'every_day', $ids[$i], $extra);
						}
						return true;
					break;
					
					case 'every_week':
						for($i = 0; $i <= $num_rows; $i++)
						{
							$start = date('Y-m-d', strtotime("+$i week", strtotime($current_year.'-'.$current_month.'-'.$current_date))) . ' ' .$start_time;
							$end = date('Y-m-d', strtotime("+$i week", strtotime($end_current_year.'-'.$end_current_month.'-'.$end_current_date))) . ' ' .$end_time;
							$this->update_ui_repetitive($start, $end, $allDay_value, 'every_week', $ids[$i], $extra);
						}
						return true;
					break;
					
					case 'every_month':
						for($i = 0; $i <= $num_rows; $i++)
						{
							$start = date('Y-m-d', strtotime("+$i month", strtotime($current_year.'-'.$current_month.'-'.$current_date))) . ' ' .$start_time;
							$end = date('Y-m-d', strtotime("+$i month", strtotime($end_current_year.'-'.$end_current_month.'-'.$end_current_date))) . ' ' .$end_time;
							$this->update_ui_repetitive($start, $end, $allDay_value, 'every_month', $ids[$i], $extra);
						}
						return true;
					break;	
				}
			}	
		}
		
		// normal update (update on drag and resize)
		public function update($allDay, $start, $end, $id, $original_id)
		{			
			// Convert Date Time
			$start = strftime('%Y-%m-%d %H:%M:%S', strtotime(substr($start, 0, 24)));
			$end = strftime('%Y-%m-%d %H:%M:%S', strtotime(substr($end, 0, 24)));
			
			if($allDay == 'false') {
				$allDay_value = 'true';
			} elseif($allDay == 'true') {
				$allDay_value = 'false';	
			}
			
			// Before updating on drag or resize check if it is repetitive event
			$is_rep = $this->check_repetitive_events($original_id);

			if($is_rep == true)
			{
				$process = $this->repetitive_event_procedure($allDay, $start, $end, $id, $original_id, '');
				
				if($process == true)
				{
					return true;
				} else {
					return false;	
				}
			 }
			
			// The update query for normal events
			$query = sprintf('UPDATE %s 
									SET 
										start = "%s",
										end = "%s",
										allDay = "%s"
									WHERE
										repeat_id = %s
						',
										mysqli_real_escape_string($this->connection, $this->table),
										mysqli_real_escape_string($this->connection, $start),
										mysqli_real_escape_string($this->connection, $end),
										mysqli_real_escape_string($this->connection, $allDay_value),
										mysqli_real_escape_string($this->connection, $id)
						);
			
			// The result
			return $this->result = mysqli_query($this->connection, $query);
		}
		
		/**
		* This function updates events to the database (Edit Update)
		* Returns true
		*/
		public function updates($event)
		{	
			$start = $event['start_date'].' '.$event['start_time'].':00';
			$end = $event['end_date'].' '.$event['end_time'].':00';
			
			$id = mysqli_real_escape_string($this->connection, $event['id']);
			
			if(isset($event['rep_id']) && strlen($event['rep_id']) !== 0)
			{
				$is_rep = $this->check_repetitive_events($id);
				
				if($is_rep == true)
				{
					$process = $this->repetitive_event_procedure('', $start, $end, $event['rep_id'], $id, $event);

					if($process == true)
					{
						return true;
					} else {
						return false;	
					}
				 }
			}
			
			// The update query
			$query = sprintf('UPDATE %s 
									SET 
										title = "%s",
										description = "%s",
										color = "%s",
										start = "%s",
										end = "%s",
										url = "%s"
									WHERE
										id = %d
						',
										mysqli_real_escape_string($this->connection, $this->table),
										mysqli_real_escape_string($this->connection, strip_tags($event['title'])),
										mysqli_real_escape_string($this->connection, htmlspecialchars($event['description'], ENT_COMPAT, 'UTF-8')),
										mysqli_real_escape_string($this->connection, htmlspecialchars($event['color'])),
										mysqli_real_escape_string($this->connection, $start),
										mysqli_real_escape_string($this->connection, $end),
										mysqli_real_escape_string($this->connection, htmlspecialchars($event['url'])),
										$id
										
						);
			
			// The result
			return $this->result = mysqli_query($this->connection, $query);
		}
		
		/**
		* This function adds events to the database
		* Returns true
		*/
		public function addEvent($title, $description, $start_date, $start_time, $end_date, $end_time, $color, $allDay, $url, $extra=false)
		{	
			// Avoid empty title
			if(strlen($title) == 0)
			{
				return false;
			}
			
			// Avoid empty start date
			if(strlen($start_date) == 0)
			{
				return false;
			}
			
			// Convert Date Time
			$start = $start_date.' '.$start_time.':00';
			$end = $end_date.' '.$end_time.':00';
			
			// Checking
			if(empty($url)) 
			{
				$url = 'false';
			}
			
			// Check for empty data
			if(empty($title) && empty($start_date))
			{
				return false;	
			}
			
			// Add Data to Database based on users $extra field
			if(isset($extra) && is_array($extra))
			{	
				################### - All Your Extra Fields both from 'quickSave' and from 'Add Event', catch here and procede from here
				
				// Catch extra fields from $_POST
				$category = $extra['categorie'];
				$user_id = $extra['user_id'];
				$repeat_method = $extra['repeat_method'];
				$repeat_time = $extra['repeat_times'];
				
				# your own fields would be: $field = $extra['field_name']; and add them below on the $query as others are
				
				if(strlen($category) == 0) { $category = ''; }
				if(strlen($user_id) == 0) { $user_id = 0; }
				
				// The Advanced Database - Add Event Query
				$query = sprintf('INSERT INTO %s 
										SET 
											title = "%s",
											description = "%s",
											start = "%s",
											end = "%s",
											allDay = "%s",
											color = "%s",
											url = "%s",
											category = "%s",
											user_id = %d,
											repeat_type = "%s"
							',
											mysqli_real_escape_string($this->connection, $this->table),
											mysqli_real_escape_string($this->connection, strip_tags($title)),
											mysqli_real_escape_string($this->connection, htmlspecialchars($description, ENT_COMPAT, 'UTF-8')),
											mysqli_real_escape_string($this->connection, htmlspecialchars($start)),
											mysqli_real_escape_string($this->connection, htmlspecialchars($end)),
											mysqli_real_escape_string($this->connection, $allDay),
											mysqli_real_escape_string($this->connection, htmlspecialchars($color)),
											mysqli_real_escape_string($this->connection, htmlspecialchars($url)),
											mysqli_real_escape_string($this->connection, htmlspecialchars($category, ENT_COMPAT, 'UTF-8')),
											mysqli_real_escape_string($this->connection, htmlspecialchars($user_id)),
											mysqli_real_escape_string($this->connection, htmlspecialchars($repeat_method))
							);
							
				################################################################################################################# --- End
				
			} else {

				// The Basic Database - Add Event Query
				$query = sprintf('INSERT INTO %s 
										SET 
											title = "%s",
											description = "%s",
											start = "%s",
											end = "%s",
											allDay = "%s",
											color = "%s",
											url = "%s"
							',
											mysqli_real_escape_string($this->connection, $this->table),
											mysqli_real_escape_string($this->connection, strip_tags($title)),
											mysqli_real_escape_string($this->connection, htmlspecialchars($description, ENT_COMPAT, 'UTF-8')),
											mysqli_real_escape_string($this->connection, htmlspecialchars($start)),
											mysqli_real_escape_string($this->connection, htmlspecialchars($end)),
											mysqli_real_escape_string($this->connection, $allDay),
											mysqli_real_escape_string($this->connection, htmlspecialchars($color)),
											mysqli_real_escape_string($this->connection, htmlspecialchars($url))
							);
			}
			
			// The result
			$this->result = mysqli_query($this->connection, $query);
			
			$inserted_id = mysqli_insert_id($this->connection);
			
			if($this->result) 
			{
				$up_res = mysqli_query(
					$this->connection, 
					sprintf("UPDATE %s SET repeat_id = %d WHERE id = %d", mysqli_real_escape_string($this->connection, $this->table), $inserted_id, $inserted_id)
				);
				
				if(mysqli_affected_rows($this->connection) == 1)
				{
					if($repeat_method == 'no')
					{
						return true;
					} else {
						$current_date = date('d', strtotime($start_date));
						$current_month = date('m', strtotime($start_date));
						$current_year = date('Y', strtotime($start_date));
						
						$fields = array(
							'table' => mysqli_real_escape_string($this->connection, $this->table),
							'title' => mysqli_real_escape_string($this->connection, strip_tags($title)),
							'description' => mysqli_real_escape_string($this->connection, htmlspecialchars($description, ENT_COMPAT, 'UTF-8')),
							'start_date' => mysqli_real_escape_string($this->connection, htmlspecialchars($start_date)),
							'start_time' => mysqli_real_escape_string($this->connection, htmlspecialchars($start_time)),
							'end_date' => mysqli_real_escape_string($this->connection, htmlspecialchars($end_date)),
							'end_time' => mysqli_real_escape_string($this->connection, htmlspecialchars($end_time)),
							'allDay' => mysqli_real_escape_string($this->connection, $allDay),
							'color' => mysqli_real_escape_string($this->connection, htmlspecialchars($color)),
							'url' => mysqli_real_escape_string($this->connection, htmlspecialchars($url)),
							'category' => mysqli_real_escape_string($this->connection, htmlspecialchars($category, ENT_COMPAT, 'UTF-8')),
							'user_id' => mysqli_real_escape_string($this->connection, htmlspecialchars($user_id)),
							'repeat_id' => $inserted_id,
							'repeat_method' => $repeat_method,
							'repeat_times' => $repeat_time
						);
						$added_repetitive_events = $this->insert_repetitive_events($fields, $current_date, $current_month, $current_year);	
						if($added_repetitive_events)
						{
							return true;	
						}
					}
				} else {
					return false;	
				}
			} else {
				return false;	
			}
		}
		
		/**
		* Repetitive Events (since 1.6.4)
		* Returns true
		*/
		private function insert_repetitive_query($fields, $start, $end)
		{
			$query =  mysqli_query($this->connection, sprintf('INSERT INTO %s 
															SET 
																title = "%s",
																description = "%s",
																start = "%s",
																end = "%s",
																allDay = "%s",
																color = "%s",
																url = "%s",
																category = "%s",
																user_id = %d,
																repeat_id = %d,
																repeat_type = "%s"
												',
													$fields['table'],
													$fields['title'],
													$fields['description'],
													$start,
													$end,
													$fields['allDay'],
													$fields['color'],
													$fields['url'],
													$fields['category'],
													$fields['user_id'],
													$fields['repeat_id'],
													$fields['repeat_method']
												));	
		}
		
		private function insert_repetitive_events($fields, $current_date, $current_month, $current_year)
		{
			$repeat_times = $fields['repeat_times'];
			
			$end_current_date = date('d', strtotime($fields['end_date']));
			$end_current_month = date('m', strtotime($fields['end_date']));
			$end_current_year = date('Y', strtotime($fields['end_date']));
			
			switch($fields['repeat_method'])
			{
				case 'every_day':
					if($repeat_times <= '30')
					{
						for($i = 1; $i <= $repeat_times; $i++)
						{
							$start = date('Y-m-d', strtotime("+$i day", strtotime($current_year.'-'.$current_month.'-'.$current_date))) . ' ' .$fields['start_time'].':00';
							$end = date('Y-m-d', strtotime("+$i day", strtotime($end_current_year.'-'.$end_current_month.'-'.$end_current_date))) . ' ' .$fields['end_time'].':00';
							$this->insert_repetitive_query($fields, $start, $end);
						}
						return true;
					}
				break;
				
				case 'every_week':
					if($repeat_times <= 30)
					{
						for($i = 1; $i <= $repeat_times; $i++)
						{
							$start = date('Y-m-d', strtotime("+$i week", strtotime($current_year.'-'.$current_month.'-'.$current_date))) . ' ' .$fields['start_time'].':00';
							$end = date('Y-m-d', strtotime("+$i week", strtotime($end_current_year.'-'.$end_current_month.'-'.$end_current_date))) . ' ' .$fields['end_time'].':00';
							$this->insert_repetitive_query($fields, $start, $end);
						}
						return true;
					}
				break;
				
				case 'every_month':
					if($repeat_times <= 30)
					{
						for($i = 1; $i <= $repeat_times; $i++)
						{
							$start = date('Y-m-d', strtotime("+$i month", strtotime($current_year.'-'.$current_month.'-'.$current_date))) . ' ' .$fields['start_time'].':00';
							$end = date('Y-m-d', strtotime("+$i month", strtotime($end_current_year.'-'.$end_current_month.'-'.$end_current_date))) . ' ' .$fields['end_time'].':00';
							$this->insert_repetitive_query($fields, $start, $end);
						}
						return true;
					}
				break;
			}
		}
		
		/**
		* Gets all Categories - since version 1.4
		* Returns array
		*/
		public function getCategories()
		{
			// Set default category in case the user do not have categories with events
			$results = $this->categories;
			asort($results);
			$return = array_unique(array_filter($results));
			
			if(count($return) == 0)
			{
				return false;
			} else {
				return $return;	
			}
		}
		
		/**
		* This function deletes event from database
		* Returns true
		*/
		public function delete($id, $rep_id, $method='')
		{
			// Delete Query
			if($method == '')
			{
				$query = "DELETE FROM $this->table WHERE id = $id";		
			} else {
				$query = "DELETE FROM $this->table WHERE repeat_id = $rep_id";		
			}
			
			// Result
			$this->result = mysqli_query($this->connection, $query);
			
			if($this->result) 
			{
				return true;
			} else {
				return false;	
			}
			
		}
		
		/**
		* This function exports each event to the icalendar format and forces a download
		* Returns true
		*/		
		public function icalExport($id, $title, $description, $start_date, $end_date, $url=false)
		{
			
			if($url == 'undefined') 
			{
				$url = '';
			} else {
				$url = ' '.$url.' ';	
			}
			
			$description_fn = $str = str_replace(array("\r","\n","\t"),'\n',$description);
			
			// Build the ics file
$ical = 'BEGIN:VCALENDAR
PRODID:-//Paulo Regina//Ajax Calendar 1.6 MIMEDIR//EN
VERSION:2.0
BEGIN:VEVENT
CREATED:'.date('Ymd\This', time()).'Z'.'
DESCRIPTION:'.$description_fn.' '.$url.'
DTEND:'.$end_date.'
DTSTAMP:'.date('Ymd\This', time()).'Z'.'
DTSTART:'.$start_date.'
LAST-MODIFIED:'.date('Ymd\This', time()).'Z'.'
SUMMARY:'.addslashes($title).'
END:VEVENT
END:VCALENDAR';
			 
			if(isset($id)) {
				return $ical;
			} else {
				return false;
			}
		}
		
		/**
		* Export entire calendar to icalendar (since 1.6.4)
		* Returns true
		*/
		public function icalExport_all()
		{
			
			$query = mysqli_query($this->connection, "SELECT * FROM $this->table");
			
			if(mysqli_num_rows($query) > 0)
			{
				$ical = '';
				
$ical .= 'BEGIN:VCALENDAR' ."\n";
$ical .= 'PRODID:-//Paulo Regina//Ajax Calendar 1.6 MIMEDIR//EN'."\n";
$ical .= 'VERSION:2.0'."\n";
				while($row = mysqli_fetch_assoc($query))
				{
$ical .= 'BEGIN:VEVENT'."\n";
$ical .= 'CREATED:'.date('Ymd\This', time()).'Z'."\n";
$ical .= 'DESCRIPTION:'.str_replace(array("\r","\n","\t"),'\n',$row['description']).' '.$row['url']."\n";
$ical .= 'DTEND:'.$row['end']."\n";
$ical .= 'DTSTAMP:'.date('Ymd\This', time()).'Z'."\n";
$ical .= 'DTSTART:'.$row['start']."\n";
$ical .= 'LAST-MODIFIED:'.date('Ymd\This', time()).'Z'."\n";
$ical .= 'SUMMARY:'.addslashes($row['title'])."\n";
$ical .= 'END:VEVENT'."\n";			
				}
$ical .= 'END:VCALENDAR'."\n";

			return $ical;
			
			} else {
				return false;	
			}
				
		}
		
		/**
		* This function retrieves calendar data
		* Returns true
		*/
		public function retrieve($id)
		{
			// Result Query
			$this->result = mysqli_query($this->connection, sprintf("SELECT * FROM $this->table WHERE id = %s", mysqli_real_escape_string($this->connection, $id)));
			
			if($this->result) {
				return mysqli_fetch_assoc($this->result);
			} else {
				return false;	
			}
				
		}
		
		/**
		* Strip unwanted tags from the calendar
		* Those that want HTML support on the calendar use this function on the 'updates' and 'addEvent' to the $description
		* like this $this->strip_html_tags($description) to filter it and use on the function 'json_transform' htmlspecialchars_decode($event_description)
		* to render html to the event description.
		*/
		private function strip_html_tags($text)
		{
			$text = preg_replace('~<\s*\bscript\b[^>]*>(.*?)<\s*\/\s*script\s*>~is', '', $text);
			$text = preg_replace('~<\s*\bhead\b[^>]*>(.*?)<\s*\/\s*head\s*>~is', '', $text);
			$text = preg_replace('~<\s*\bstyle\b[^>]*>(.*?)<\s*\/\s*style\s*>~is', '', $text);
			$text = preg_replace('~<\s*\bobject\b[^>]*>(.*?)<\s*\/\s*object\s*>~is', '', $text);
			$text = preg_replace('~<\s*\bapplet\b[^>]*>(.*?)<\s*\/\s*applet\s*>~is', '', $text);
			$text = preg_replace('~<\s*\bnoframes\b[^>]*>(.*?)<\s*\/\s*noframes\s*>~is', '', $text);
			$text = preg_replace('~<\s*\bnoscript\b[^>]*>(.*?)<\s*\/\s*noscript\s*>~is', '', $text);
			$text = preg_replace('~<\s*\bframeset\b[^>]*>(.*?)<\s*\/\s*frameset\s*>~is', '', $text);
			$text = preg_replace('~<\s*\bframe\b[^>]*>(.*?)<\s*\/\s*frame\s*>~is', '', $text);
			$text = preg_replace('~<\s*\biframe\b[^>]*>(.*?)<\s*\/\s*iframe\s*>~is', '', $text);
			$text = preg_replace('~<\s*\bform\b[^>]*>(.*?)<\s*\/\s*form\s*>~is', '', $text);
			$text = preg_replace('/on[a-z]+=\".*\"/i', '', $text);
			
			return $text;
			
		}
				
	}

?>