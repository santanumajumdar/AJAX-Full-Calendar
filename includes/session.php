<?php
	
	define('USERS_TABLE', 'users');
	
	// Right Away on Login
	if(isset($_POST['username']) && isset($_POST['password'])) 
	{ 
		$ok = authenticate($_POST['username'], $_POST['password'], USERS_TABLE);
		
		if($ok == false)
		{
			$_SESSION['c_loginMessage'] = 'Invalid Credentials';
			header('Location: index.php');
			exit();		
		} elseif(in_array('error_found', $ok)) {
			$_SESSION['c_loginMessage'] = $ok['error'];
			header('Location: index.php');
			exit();
		}
	}
	
	// Will check all pages that does need authentication - direct access example
	// The current pages are those to skip authentication
	if(
		basename($_SERVER['PHP_SELF']) !== 'index.php'
	   )
	{
		if(!isset($_SESSION['c_username']) && !isset($_SESSION['c_authenticated']) && $_SESSION['c_authenticated'] !== 'true') 
		{
			$_SESSION['c_loginMessage'] = 'Failed to log in';
			header('Location: index.php');
			exit();	
		}
	}
	
?>
<?php
	
	// Session Related Functions
	
	function authenticate($username, $password, $user_table)
	{
		$link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DATABASE);
		
		if($username && $password) 
		{
			$query = sprintf("SELECT * FROM %s WHERE username = '%s' and password = '%s' LIMIT 1", 
								mysqli_real_escape_string($link, $user_table),
								mysqli_real_escape_string($link, $username), 
								mysqli_real_escape_string($link, sha1($password))
							);
							
			$result = mysqli_query($link, $query);
			
			$results = mysqli_fetch_assoc($result);

			// gave a result and was authenticated
			if(!empty($results))
			{
				$_SESSION['c_username'] = $username;
				$_SESSION['c_authenticated'] = 'true';
				return $results;		
			} elseif(mysqli_error($link)) {
				 return array('error_found' => 'true', 'error' => mysqli_error($link));
			} else {
				return false;	
			}
			
		}	
	}
	
	function add_user($username, $password, $user_table)
	{
		$link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DATABASE);
		
		$query = sprintf('INSERT INTO %s SET username = "%s", password = "%s"', 
							mysqli_real_escape_string($link, $user_table),
							mysqli_real_escape_string($link, $username), 
							mysqli_real_escape_string($link, sha1($password))
						);
						
		$result = mysqli_query($link, $query);
		
		if($result)
		{
			return true;	
		} else {
			return false;
		}
				
	}
	
	function get_user($identifier)
	{
		$link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DATABASE);
		
		$username = $_SESSION['c_username'];
	
		if(isset($username))
		{	
			$query =  mysqli_query($link, "SELECT users.id as id, users.username FROM users WHERE username = '{$username}'");
			
			while($row = mysqli_fetch_array($query))
			{
				//get logged user id and username
				$users_username = $row['username'];
				$users_id = $row['id'];
			}
			
				if($username == $users_username)
				{
					if($identifier == "id" || $identifier == "ID")
					{
						return $users_id;
					}
					
					if($identifier == "username" || $identifier == "USERNAME" || $identifier == "Username")
					{
						return $users_username;
					}
					
				} else {
					header('Location: index.php');
					exit();	
				}
			
			} else {
				header('Location: index.php');
				exit();	
			}
		
	}
?>