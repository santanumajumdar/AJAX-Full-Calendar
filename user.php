<?php include('includes/loader.php'); ?>

  <?php include('tpl/head.php'); ?>

  <body>

    <?php include('tpl/header.php'); ?>
	
    <div class="container">
	  
      <a href="dashboard.php" class="btn btn-primary pull-right" style="margin-bottom: 20px;">View Events</a>
		
      <div class="clearfix"></div>
        
      <div class="box">
        <div class="header"><h4>Add User</h4></div>
        <div class="content pad"> 
            
                <?php
					if(isset($_POST['addUser']))
					{
						if(strlen($_POST['add_username']) !== 0 && strlen($_POST['add_password']) !== 0)
						{
							$add_user = add_user($_POST['add_username'], $_POST['add_password'], USERS_TABLE);
							
							if($add_user) {
								?>
                                <div class="alert alert-info">
                                Successfully added user
                                </div>
                                <?php
							} else {
								?>
                                <div class="alert alert-info">
                                User already exist
                                </div>
                                <?php	
							}
						} else {
							?>
                            <div class="alert alert-info">
                            Fields cannot be empty
                            </div>
                            <?php	
						}
					} 
				?>
    
            <form id="add_user" method="post" action="user.php">
            
                <label>Username:</label>
                <input type="text" class="form-control" name="add_username" placeholder="Username">
                
                <label>Password:</label>
                <input type="text" class="form-control" name="add_password" placeholder="Password">
                
                <div style="padding-top: 15px;"></div>
                
                <button type="submit" name="addUser" class="btn btn-primary pull-right">Add User</button>
                
            </form>
            
        </div> 
    </div>
    
    </div> <!-- /container -->
    
    <?php include('tpl/scripts.php'); ?>
    
    <script type="text/javascript">
		$().FullCalendarExt();
	</script>

  </body>
</html>