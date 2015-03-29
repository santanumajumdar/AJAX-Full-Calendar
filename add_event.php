<?php 
	include('includes/loader.php'); 
	include('tpl/head.php'); 
?>

  <body>

    <?php include('tpl/header.php'); ?>

    <div class="container">
	  
      <a href="dashboard.php" class="btn btn-default pull-right" style="margin-bottom: 20px;">View Events</a>
		
      <div class="clearfix"></div>
        
      <div class="box">
        <div class="header"><h4>Add Event</h4></div>
        <div class="content pad"> 
            
            <form id="add_event">
            
                <label>Title:</label>
                <input type="text" class="validate[required] form-control" name="title" placeholder="Event Title" id="title">
                <label>Description:</label>
                <textarea class="form-control" name="description" id="description" placeholder="Event Description"></textarea>
                <div class="pull-left mr-10">
                <label>Start Date:</label>
                <input type="text" name="start_date" class="form-control input-sm validate[required]" id="datepicker">
                </div>
                <div class="pull-left">
                <label>Start Time:</label>
                <input type="text" class="form-control input-sm" name="start_time" placeholder="HH:MM" id="tp1">
                </div>
                <div class="clearfix"></div>
                <div class="pull-left mr-10">
                <label>End Date:</label>
                <input type="text" class="form-control input-sm" name="end_date" id="datepicker2">
                </div>
                <div class="pull-left">
                <label>End Time:</label>
                <input type="text" class="form-control input-sm" name="end_time" placeholder="HH:MM" id="tp2">
                </div>
                <div class="clearfix"></div>
                <label>Event Color:</label>
                <input type="text" class="form-control input-sm" name="color" id="cp">
                <label>All Day Event:</label>
                <select name="allDay" class="form-control">
                    <option value="true" selected>Yes</option>
                    <option value="false">No</option>
                </select>
                <label>Category:</label>
                <select name="categorie" class="form-control">
				<?php if($calendar->getCategories() !== false) { ?>
                    <?php foreach($calendar->getCategories() as $categorie) { ?>
                    <option value="<?php echo $categorie; ?>"><?php echo $categorie; ?></option>
                    <?php } ?>
                <?php } else { ?>
                	<option value="General">General</option>
                <?php } ?>
                </select>
                <div class="clearfix"></div>
                <div class="pull-left mr-10">
                <label>Repeat:</label>
                <select name="repeat_method" class="form-control">
                    <option value="no" selected>No</option>
                    <option value="every_day">Every Day</option>
                    <option value="every_week">Every Week</option>
                    <option value="every_month">Every Month</option>
                </select>
                </div>
                 <div class="pull-left">
                <label>Times:</label>
                <select name="repeat_times" class="form-control">
                    <option value="1" selected>1</option>
                    <?php
						for($i = 2; $i <= 30; $i++) {
							echo '<option value="'.$i.'">'.$i.'</option>';		
						}
					?>
                </select>
                </div>
                <div class="clearfix"></div>
                <label>Url:</label>
                <input type="text" class="form-control" name="url" id="url" placeholder="http://www.domain.com">
                <p class="help-block">Hint: If this event does not have url please leave blank</p>
    
                <button type="submit" onclick="calendar.save()" class="btn btn-primary pull-right">Add Event</button>
                
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

