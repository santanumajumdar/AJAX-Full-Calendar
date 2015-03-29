<!DOCTYPE HTML>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Paulo">
    <meta name="author" content="Paulo Regina">
    
	<title>iCalendar Installation</title>
    
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap-responsive.css" rel="stylesheet" media="screen">
    <link href="css/style.css" rel="stylesheet" media="screen">
    
    <!--[if lt IE 9]>
    <link href="css/ie-hacks.css" rel="stylesheet" media="screen">
    <![endif]--> 
</head>
<body>
	
    <div class="container">
    	<div class="wrap">
        	
            <!-- page -->
            <div id="page">
            
				<div id="header"><h1 class="img-force-center">iCalendar</h1></div>
                
                <p>
                	Welcome to iCalendar one click install. Before start using iCalendar, we need some
            		information for the application configuration:
            	</p>
                
                <?php
					$_host = '';
					$_username = '';
					$_password = '';
					$_dbname = '';
					$_admin_username = '';
					$_admin_password = '';
				?>
                
               <?php
					if(isset($_POST['e_install']) && !empty($_POST['db_name']) && !empty($_POST['db_username']) && !empty($_POST['db_password']) && !empty($_POST['db_host']) && !empty($_POST['add_username']) && !empty($_POST['add_password']))
					{
						$_host = $_POST['db_host'];
						$_username = $_POST['db_username'];
						$_password = $_POST['db_password'];
						$_dbname = $_POST['db_name'];
						
						$_admin_username = $_POST['add_username'];
						$_admin_password = $_POST['add_password'];
						
						
						// Check connection
						if(@mysqli_connect($_host, $_username, $_password)) 
						{
							$test_connection = @mysqli_connect($_host, $_username, $_password);
														
							$test_db = @mysqli_select_db($test_connection, $_dbname);
							
							if($test_db)
							{
								// Everything is ok
								// - save to a file the configs
								$file_write = 
"<?php
	
	// DB Connection Configuration
	define('DB_HOST', '".$_host."'); 
	define('DB_USERNAME', '".$_username."'); 
	define('DB_PASSWORD', '".$_password."'); 
	define('DATABASE', '".$_dbname."'); 
	define('TABLE', 'calendar');
	define('USERS_TABLE', 'users');
	
	// Default Categories
	".'$categories = '.'array("General","Party","Work");'."
	
?>";
								
								$file = dirname(__FILE__).'/'.'connection.php';
								
								if($handle = fopen($file, 'w'))
								{
									fwrite($handle, $file_write);
									fclose($handle);
									chmod($file, 0777); // make file writable	
								} else {
									echo '
										<div class="alert alert-error">Installation Failed: Cannot create configuration file</div>
									';		
								}
								
								// - save to database the scheme
								$easyLetters_table = mysqli_query($test_connection,
								"
									CREATE TABLE IF NOT EXISTS `calendar` (
									  `id` int(11) NOT NULL AUTO_INCREMENT,
									  `title` varchar(160) NOT NULL,
									  `description` text NOT NULL,
									  `start` datetime NOT NULL,
									  `end` datetime NOT NULL,
									  `allDay` varchar(5) NOT NULL,
									  `color` varchar(7) NOT NULL,
									  `url` varchar(255) NOT NULL,
									  `category` varchar(255) NOT NULL,
									  PRIMARY KEY (`id`)
									) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
								");
								
								$users_table = mysqli_query($test_connection, 
								"
									CREATE TABLE IF NOT EXISTS `users` (
									  `id` int(11) NOT NULL AUTO_INCREMENT,
									  `username` varchar(255) NOT NULL,
									  `password` varchar(64) NOT NULL,
									  PRIMARY KEY (`id`),
									  UNIQUE KEY `username` (`username`)
									) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


								");
								
								$sha1 = sha1($_admin_password);
								
								$dump_users_table = mysqli_query($test_connection, 
								"
									INSERT INTO `users` (`id`, `username`, `password`) VALUES
									(NULL, '$_admin_username', '$sha1');
								");
								
								echo '<div class="alert alert-success">Congratulations! Installation was a success</div>';
								
								header('Location: '.$_SERVER['PHP_SELF']);
								exit();
								
							} else {
								echo '
									<div class="alert alert-info">Database do not exist</div>
								';	
							}
							
						} else {
							echo '
								<div class="alert alert-info">Invalid database configuration</div>
							';	
						}
						
					} elseif(isset($_POST['e_install']) && empty($_POST['db_name']) && empty($_POST['db_username']) && empty($_POST['db_password']) && empty($_POST['db_host'])) {
						$_host = $_POST['db_host'];
						$_username = $_POST['db_username'];
						$_password = $_POST['db_password'];
						$_dbname = $_POST['db_name'];
						echo '
							<div class="alert alert-info">All fields cannot be empty</div>
						';	
					}
			   ?>
                
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <table class="table">
                        <tr>
                            <th scope="row"><label>DB Name:</label></th>
                            <td>
                                <input name="db_name" class="input-xlarge" id="req" type="text" size="32" value="<?php echo $_dbname; ?>" />
                                <p class="help-block">The Database Name</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>DB User Name:</label></th>
                            <td>
                            	<input name="db_username" class="input-xlarge" id="req" type="text" size="32" value="<?php echo $_username; ?>" />
                                <p class="help-block">The Database Username</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>DB Password:</label></th>
                            <td>
                            	<input name="db_password" class="input-xlarge" id="req" type="text" size="32" value="<?php echo $_password; ?>" />
                                <p class="help-block">The Database Password</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>DB Host:</label></th>
                            <td>
                            	<input name="db_host" class="input-xlarge" id="req" type="text" size="32" value="<?php echo $_host; ?>" />
                                <p class="help-block">The Database Host</p>
                            </td>
                        </tr>
                        <tr><th></th><td></td></tr>
                        <tr>
                            <th scope="row"><label>Login Username:</label></th>
                            <td>
                            	<input name="add_username" class="input-xlarge" id="req" type="text" size="32" value="<?php echo $_admin_username; ?>" />
                                <p class="help-block">Your username to login to the system</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Login Password:</label></th>
                            <td>
                            	<input name="add_password" class="input-xlarge" id="req" type="text" size="32" value="<?php echo $_admin_password; ?>" />
                                <p class="help-block">Your  password</p>
                            </td>
                        </tr>
                    </table>
                    <input type="submit" class="btn btn-primary pull-right" name="e_install" value="Install" />
                </form>
                
                <div class="clear"></div>
                
            </div>
            <!-- // page -->
                        
        </div>
    </div>
	

</body>
</html>