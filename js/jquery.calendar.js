/*
 *	jQuery FullCalendar Extendable Plugin
 *	An Ajax (PHP - Mysql - jquery) script that extends the functionalities of the fullcalendar plugin
 *  Dependencies: 
 *   - jquery
 *   - jquery Ui
 * 	 - jquery colorpicker (since 1.6.4)
 *   - jquery timepicker (since 1.6.4)
 *   - jquery Fullcalendar
 *   - Twitter Bootstrap
 *  Author: Paulo Regina
 *  Website: www.pauloreg.com
 *  Contributions: Patrik Iden, Jan-Paul Kleemans, Bob Mulder
 *	Version 1.6.4, July - 2014 
 *  Fullcalendar 1.6.4
 *	Released Under Envato Regular or Extended Licenses
 */
 
(function($, undefined) 
{
	$.fn.extend 
	({
		// FullCalendar Extendable Plugin
		FullCalendarExt: function(options) 
		{	
			// Default Configurations (General)
            var defaults = 
			{
				calendarSelector: '#calendar',
								
				ajaxJsonFetch: 'includes/cal_events.php',
				ajaxUiUpdate: 'includes/cal_update.php',
				ajaxEventSave: 'includes/cal_save.php',
				ajaxEventQuickSave: 'includes/cal_quicksave.php',
				ajaxEventDelete: 'includes/cal_delete.php',
				ajaxEventEdit: 'includes/cal_edit_update.php',
				ajaxEventExport: 'includes/cal_export.php',
				ajaxRepeatCheck: 'includes/cal_check_rep_events.php',
				ajaxRetrieveDescription: 'includes/cal_description.php',
				
				modalViewSelector: '#cal_viewModal',
				modalEditSelector: '#cal_editModal',
				modalQuickSaveSelector: '#cal_quickSaveModal',
				modalPromptSelector: '#cal_prompt',
				modalEditPromptSelector: '#cal_edit_prompt_save',
				formAddEventSelector: 'form#add_event',
				formFilterSelector: 'form#filter-category select',
				formEditEventSelector: 'form#edit_event', // php version
				formSearchSelector:"form#search",
				
				successAddEventMessage: 'Successfully Added Event',
				successDeleteEventMessage: 'Successfully Deleted Event',
				successUpdateEventMessage: 'Successfully Updated Event',
				failureAddEventMessage: 'Failed To Add Event',
				failureDeleteEventMessage: 'Failed To Delete Event',
				failureUpdateEventMessage: 'Failed To Update Event',
				generalFailureMessage: 'Failed To Execute Action',
				ajaxError: 'Failed to load content',
				
				visitUrl: 'Visit Url:',
				titleText: 'Title:',
				descriptionText: 'Description:',
				colorText: 'Color:',
				startDateText: 'Start Date:',
				startTimeText: 'Start Time:',
				endDateText: 'End Date:',
				endTimeText: 'End Time:',
				categoryText: 'Category:',
				eventText: 'Event: ',
				repetitiveEventActionText: 'This is a repetitive event, what do you want to do?',
								
				isRTL: false,				
				monthNames: ['January','February','March','April','May','June','July','August','September','October','November','December'],
				monthNamesShort: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
				dayNames: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
				dayNamesShort: ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
				today: 'today',
				month: 'month',
				week: 'week',
				day: 'day',
				weekNumberTitle: 'W',
				allDayText: 'all-day', 
				
				defaultColor: '#587ca3',
				
				weekType: 'agendaWeek', // basicWeek
				dayType: 'agendaDay', // basicDay
				
				editable: true,
				disableDragging: false,
				disableResizing: false,
				ignoreTimezone: true,
				lazyFetching: true,
				filter: true,
				quickSave: true,
				firstDay: 0,
				
				gcal: false,
				
				version: 'modal',
				
				quickSaveCategory: '',
				
				colorpickerArgs: {format: 'hex'},
				
				defaultView: 'month', // basicWeek or basicDay or agendaWeek
				aspectRatio: 1.35, // will make day boxes bigger
				weekends: true, // show (true) the weekend or not (false)
				weekNumbers: false, // show week numbers (true) or not (false)
				weekNumberCalculation: 'iso',
				
				hiddenDays: [], // [0,1,2,3,4,5,6] to hide days as you wish
				
				theme: false,
				themePrev: 'circle-triangle-w',
				themeNext: 'circle-triangle-e',
				
				titleFormatMonth: 'MMMM yyyy',
				titleFormatWeek: "MMM d[ yyyy]{ '&#8212;'[ MMM] d yyyy}",
				titleFormatDay: 'dddd, MMM d, yyyy',
				columnFormatMonth: 'ddd',
				columnFormatWeek: 'ddd M/d',
				columnFormatDay: 'dddd M/d',
				timeFormat: 'H:mm - {H:mm}',
				
				weekMode: 'fixed', // 'fixed', 'liquid', 'variable'
				
				allDaySlot: true, // ture, false
				axisFormat: 'h(:mm)tt',
				
				slotMinutes: 30,
				minTime: 0,
				maxTime: 24,
				
				slotEventOverlap: true,
								
				savedRedirect: 'index.php',
				removedRedirect: 'index.php',
				updatedRedirect: 'index.php',
				
				ajaxLoaderMarkup: '<div class="loadingDiv"></div>',
				prev: "<span class='fc-text-arrow'>&lsaquo;</span>",
				next: "<span class='fc-text-arrow'>&rsaquo;</span>",
				prevYear: "<span class='fc-text-arrow'>&laquo;</span>",
				nextYear: "<span class='fc-text-arrow'>&raquo;</span>",  
            }

			var options =  $.extend(defaults, options);
			
			var opt = options;
									
			if(opt.gcal == true) { opt.weekType = ''; opt.dayType = ''; }
			
			// fullCalendar
			$(opt.calendarSelector).fullCalendar
			({
				
				defaultView: opt.defaultView,
				aspectRatio: opt.aspectRatio,
				weekends: opt.weekends,
				weekNumbers: opt.weekNumbers,
				weekNumberCalculation: opt.weekNumberCalculation,
				weekNumberTitle: opt.weekNumberTitle,
				titleFormat: {
					month: opt.titleFormatMonth,
					week: opt.titleFormatWeek,
					day: opt.titleFormatDay
				},
				columnFormat: {
					month: opt.columnFormatMonth,
					week: opt.columnFormatWeek,
					day: opt.columnFormatDay
				},
				isRTL: opt.isRTL,
				hiddenDays: opt.hiddenDays,
				theme: opt.theme,
				buttonIcons: {
					prev: opt.themePrev,
					next: opt.themeNext
				},
				weekMode: opt.weekMode,
				allDaySlot: opt.allDaySlot,
				allDayText: opt.allDayText,
				axisFormat: opt.axisFormat,
				slotMinutes: opt.slotMinutes,
				minTime: opt.minTime,
				maxTime: opt.maxTime,
				slotEventOverlap: opt.slotEventOverlap,
				
				timeFormat: opt.timeFormat,
				header: 
				{
						left: 'prev,next',
						center: 'title',
						right: 'month,'+opt.weekType+','+opt.dayType	
				},
				monthNames: opt.monthNames,
				monthNamesShort: opt.monthNamesShort,
				dayNames: opt.dayNames,
				dayNamesShort: opt.dayNamesShort,
				buttonText: {
					prev: opt.prev,
					next: opt.next,
					prevYear: opt.prevYear,
					nextYear: opt.nextYear, 
					today: opt.today,
					month: opt.month,
					week: opt.week,
					day: opt.day
				},
				editable: opt.editable,
				disableDragging: opt.disableDragging,
				disableResizing: opt.disableResizing,
				ignoreTimezone: opt.ignoreTimezone,
				firstDay: opt.firstDay,
				lazyFetching: opt.lazyFetching,
				selectable: opt.quickSave,
				selectHelper: opt.quickSave,
				select: function(start, end, allDay) 
				{
					if(opt.version == 'modal')
					{
						calendar.quickModal(start, end, allDay);
						$(opt.calendarSelector).fullCalendar('unselect');
					}
				},
				eventSources: [{url: opt.ajaxJsonFetch, allDayDefault: false}],
				eventDrop: 
					function(event) 
					{ 
						var ed_startDate = $.fullCalendar.formatDate(event.start, 'yyyy-MM-dd');
						var ed_startTime = $.fullCalendar.formatDate(event.start, 'HH:mm');
						var ed_endDate = $.fullCalendar.formatDate(event.end, 'yyyy-MM-dd');
						var ed_endTime = $.fullCalendar.formatDate(event.end, 'HH:mm');
						
						event.start = ed_startDate+' '+ed_startTime;
						if(event.end === null || event.end === 'null')
						{
							event.end = ed_startDate+' '+ed_startTime;	
						} else {
							event.end = ed_endDate+' '+ed_endTime;	
						}
						
						$.post(opt.ajaxUiUpdate, event, function(response) {
							$(opt.calendarSelector).fullCalendar('refetchEvents');
						});
					},
				eventResize:
					function(event) 
					{ 
						var er_startDate = $.fullCalendar.formatDate(event.start, 'yyyy-MM-dd');
						var er_startTime = $.fullCalendar.formatDate(event.start, 'HH:mm');
						var er_endDate = $.fullCalendar.formatDate(event.end, 'yyyy-MM-dd');
						var er_endTime = $.fullCalendar.formatDate(event.end, 'HH:mm');
						
						event.start = er_startDate+' '+er_startTime;
						if(event.end === null || event.end === 'null')
						{
							event.end = er_startDate+' '+er_startTime;	
						} else {
							event.end = er_endDate+' '+er_endTime;	
						}
						
						$.post(opt.ajaxUiUpdate, event, function(response){
							$(opt.calendarSelector).fullCalendar('refetchEvents');
						});
					},
				eventRender: 
					function(event, element) 
					{	
						var d_color = event.color;	
						var d_startDate = $.fullCalendar.formatDate(event.start, 'yyyy-MM-dd');
						var d_startTime = $.fullCalendar.formatDate(event.start, 'HH:mm');
						var d_endDate = $.fullCalendar.formatDate(event.end, 'yyyy-MM-dd');
						var d_endTime = $.fullCalendar.formatDate(event.end, 'HH:mm');
						
						if(opt.version == 'modal')
						{	
							// Open action  (modalView Mode)
							element.attr('data-toggle', 'modal');
							element.attr('href', 'javascript:void(0);');
							element.attr('onclick', 'calendar.openModal("' + event.title + '","' + event.url + '","' + event.original_id + '","' + event.id + '","' + event.start + '","' + event.end + '","' + d_color + '","' + d_startDate + '","' + d_startTime + '","' + d_endDate + '","' + d_endTime + '");');  
						} 
					}	
				}); //fullCalendar
				
				 // Function to Open Modal
				calendar.openModal = function(title, url, id, rep_id, eStart, eEnd, color, startDate, startTime, endDate, endTime)
				{
					 $(".modal-body").html(opt.ajaxLoaderMarkup); // clear data
					 
					 // Setup variables
					 calendar.title = title;
					 calendar.url = url;
					 calendar.id = id;
					 calendar.rep_id = rep_id;
					 
					 calendar.eventStart = eStart;
					 calendar.eventEnd = eEnd;
					  
					 calendar.color = color;	
					 calendar.startDate = startDate;
					 calendar.startTime = startTime;
					 calendar.endDate = endDate;
					 calendar.endTime = endTime;
					  					  
					  var dataString = 'id='+calendar.id;
					  
					  $.ajax({
						type: "POST",
						url: opt.ajaxRetrieveDescription,
						data: dataString,
						cache: false,
						beforeSend: function() { $('.loadingDiv').show(); $('.modal-footer').hide() },
						error: function() { $('.loadingDiv').hide(); alert(opt.ajaxError) },
						success: function(description) 
						{
							$('.loadingDiv').hide(); 
							$('.modal-footer').show();
							if(calendar.url === 'undefined' || calendar.url === undefined) 
					 		{
					  			$(".modal-body").html(opt.ajaxLoaderMarkup+description); 
					  		} else {
					  			$(".modal-body").html(opt.ajaxLoaderMarkup+description+'<br /><br />'+opt.visitUrl+' <a href="'+calendar.url+'">'+calendar.url+'</a>'); 	  
					  		}
							
							// Delete button
							$(".modal-footer").delegate('[data-option="remove"]', 'click', function(e) 
							{
								calendar.remove(calendar.id);	
								e.preventDefault();
							 });
							 
							 // Export button
							$(".modal-footer").delegate('[data-option="export"]', 'click', function(e) 
							{
								calendar.exportIcal(calendar.id, calendar.title, calendar.description, calendar.eventStart, calendar.eventEnd, calendar.url);	
								e.preventDefault();
							 });
						}
					  });
					  									
					  $(".modal-header").html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+'<h4>'+calendar.title+'</h4>'); 
					  
					  $(opt.modalViewSelector).modal('show');
						
					  	// Edit Button
						$(".modal-footer").delegate('[data-option="edit"]', 'click', function(e) 
						{
							$(opt.modalViewSelector).modal('hide');
							$(".modal-body").html(opt.ajaxLoaderMarkup); // clear data
							
							var dataString2 = 'id='+calendar.id+'&mode=edit';
							
							$.ajax({
								type: "POST",
								url: opt.ajaxRetrieveDescription,
								data: dataString2,
								cache: false,
								beforeSend: function() { $('.loadingDiv').show(); $('.modal-footer').hide() },
								error: function() { $('.loadingDiv').hide(); alert(opt.ajaxError) },
								success: function(description2) 
								{
									$('.loadingDiv').hide(); 
									$('.modal-footer').show()
									if(calendar.url === 'undefined') 
									{
										$(".modal-header").html(
											'<form id="event_title_e">' +
												'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
												'<label>'+opt.titleText+' </label>' +
												'<input type="text" class="form-control" name="title_update" value="'+calendar.title+'">' +
											'</form>'
										);
										$(".modal-body").html(
											'<form id="event_description_e">' +
												'<label>'+opt.descriptionText+' </label>' +
												'<textarea class="form-control" name="description_update">'+description2+'</textarea>' +
												'<label>'+opt.colorText+' </label>' +
												'<input type="text" class="form-control" id="color_update_picker" name="color_update" value="'+color+'">' +
												'<div class="pull-left" style="margin-right: 10px;">' +
													'<label>'+opt.startDateText+' </label>' +
													'<input type="text" class="form-control" id="date_datepicker" name="update_start_date" value="'+startDate+'">' +
												'</div>' +
												'<div class="pull-left">' +
													'<label>'+opt.startTimeText+'</label>' +
													'<input type="text" class="form-control input-sm" name="update_start_time" id="time_update_picker" placeholder="HH:MM:SS" value="'+startTime+'">' +
												'</div>' +
												'<div class="clearfix"></div>' +
												'<div class="pull-left" style="margin-right: 10px;">' +
													'<label>'+opt.endDateText+' </label>' +
													'<input type="text" class="form-control input-sm" id="date_datepicker_second" name="update_end_date" value="'+endDate+'">' +
												'</div>' +
												'<div class="pull-left">' +
													'<label>'+opt.endTimeText+'</label>' +
													'<input type="text" class="form-control input-sm" name="update_end_time" id="time_update_picker_second" placeholder="HH:MM:SS" value="'+endTime+'">' +
												'</div>' +
											'</form>'
										);
									} else {
										$(".modal-header").html(
											'<form id="event_title_e">' +
												'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
												'<label>'+opt.titleText+' </label>' +
												'<input type="text" class="form-control" name="title_update" value="'+calendar.title+'">' +
											'</form>'
										);
										$(".modal-body").html(
											'<form id="event_description_e">' +
												'<label>'+opt.descriptionText+' </label>' +
												'<textarea class="form-control" name="description_update">'+description2+'</textarea>' +
												'<label>'+opt.colorText+' </label>' +
												'<input type="text" class="form-control" id="color_update_picker" name="color_update" value="'+color+'">' +
												'<div class="pull-left" style="margin-right: 10px;">' +
													'<label>'+opt.startDateText+' </label>' +
													'<input type="text" id="date_datepicker" name="update_start_date" value="'+startDate+'">' +
												'</div>' +
												'<div class="pull-left">' +
													'<label>'+opt.startTimeText+'</label>' +
													'<input type="text" class="form-control input-sm" name="update_start_time" id="time_update_picker" placeholder="HH:MM" value="'+startTime+'">' +
												'</div>' +
												'<div class="clearfix"></div>' +
												'<div class="pull-left" style="margin-right: 10px;">' +
													'<label>'+opt.endDateText+' </label>' +
													'<input type="text" id="date_datepicker_second" name="update_end_date" value="'+endDate+'">' +
												'</div>' +
												'<div class="pull-left">' +
													'<label>'+opt.endTimeText+'</label>' +
													'<input type="text" class="form-control input-sm" name="update_end_time" id="time_update_picker_second" placeholder="HH:MM" value="'+endTime+'">' +
												'</div>' +
												'<div class="clearfix"></div>' +
												'<label>URL: </label>'+'<input type="text" class="form-control" name="url_update" value="'+calendar.url+'">' +
											'</form>'
											);	
									}
									
									 // Pickers
									 $('input#color_update_picker').colorpicker(opt.colorpickerArgs);	
									 
									 $('input#date_datepicker').datepicker({
										dateFormat: 'yy-mm-dd',
										minDate: new Date(),
										onSelect: function(dateText, obj) { $('input#date_datepicker').val(dateText); }
									 });
									 
									 $('input#date_datepicker_second').datepicker({
										dateFormat: 'yy-mm-dd',
										minDate: new Date(),
										onSelect: function(dateText, obj) { $('input#date_datepicker_second').val(dateText); }
									 });
									 
										 $(document).on('click','a.ui-datepicker-next',function() {
											 $('input#date_datepicker').datepicker('setDate', 'c+1w');
											 $('input#date_datepicker_second').datepicker('setDate', 'c+1w');
										 });
										 
										  $(document).on('click','a.ui-datepicker-prev', function(){
											 $('input#date_datepicker').datepicker('setDate', 'c-1w');
											 $('input#date_datepicker_second').datepicker('setDate', 'c-1w');
										 });
									 
									 $('input#time_update_picker').timepicker();
									 $('input#time_update_picker_second').timepicker();
								}
					  		});
							
							$(opt.modalEditSelector).modal('show'); 
							
							  // On Modal Hidden
							 $(opt.modalEditSelector).on('hidden', function() {
								 $('.modal-body').html(''); // clear data
								// $(opt.calendarSelector).fullCalendar('refetchEvents'); (by uncommenting this fixes multiply loads bug)
							 })
							 
							 // Close Button - This is due cache to prevent data being saved on another view
							 $(".modal-footer").delegate('[data-dismiss="modal"]', 'click', function(e) 
							 {
								 $('.modal-body').html(''); // clear data
								 // $(opt.calendarSelector).fullCalendar('refetchEvents'); (by uncommenting this fixes multiply loads bug)
								 e.preventDefault();
							 });
						 	 
							// After all step above save
							// Update button
							$(".modal-footer").off('click').delegate('[data-option="save"]', 'click', function(e) 
							{	
								var event_title_e = $("form#event_title_e").serializeArray(); 
								var event_description_e = $("form#event_description_e").serializeArray();
								var event_url = $("form#event_description_e").serializeArray();
																		
								calendar.update(calendar.id, event_title_e[1], event_description_e, event_url);
								
								e.preventDefault();
							});
							 
							e.preventDefault();
						});
						
				} // openModal

				// Function to quickModal
				calendar.quickModal = function(start, end, allDay)
				{
					$(".modal-header").html(
						'<form id="event_title">' +
							'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
							'<label>'+opt.titleText+' </label>' +
							'<input type="text" class="form-control" name="title" value="">' +
						'</form>'
						);
					
					$(".modal-body").html(
						'<form id="event_description">' +
							'<label>'+opt.descriptionText+' </label>' +
						    '<textarea class="form-control" name="description"></textarea>' + opt.quickSaveCategory +
						 '</form>'
						 );
						
					$(opt.modalQuickSaveSelector).modal('show');
					
					calendar.start = start;
					calendar.end = end;
					calendar.allDay = allDay;
					
					// Save button
					$(".modal-footer").off('click').delegate('[data-option="quickSave"]', 'click', function(e) 
					{	
						var event_title = $("form#event_title").serializeArray();
						var event_description = $("form#event_description").serializeArray();
						
						if(opt.quickSaveCategory !== '') { calendar.category = event_description[5].value; } else { calendar.category = ''; }
						calendar.quickSave(event_title[2], event_description[2], calendar.start, calendar.end, calendar.allDay);
						
						e.preventDefault();
					});
					
					// e.preventDefault(); prevented duplication

				} // end quickModal
					
				// Function quickSave 
				calendar.quickSave = function(event_title, event_description, start, end, allDay)
				{
					var start_factor = $.fullCalendar.formatDate(start, 'yyyy-MM-dd');
					var startTime_factor = $.fullCalendar.formatDate(start, 'HH:mm');
					var end_factor = $.fullCalendar.formatDate(end, 'yyyy-MM-dd');
					var endTime_factor = $.fullCalendar.formatDate(end, 'HH:mm');

					if(opt.quickSaveCategory !== '')
					{
						var constructor = 'title='+event_title.value+'&description='+event_description.value+'&start_date='+start_factor+'&start_time='+startTime_factor+'&end_date='+end_factor+'&end_time='+endTime_factor+'&url=false&color='+opt.defaultColor+'&allDay='+allDay+'&categorie='+calendar.category;
					} else {
						var constructor = 'title='+event_title.value+'&description='+event_description.value+'&start_date='+start_factor+'&start_time='+startTime_factor+'&end_date='+end_factor+'&end_time='+endTime_factor+'&url=false&color='+opt.defaultColor+'&allDay='+allDay;
					}
					
					$.post(opt.ajaxEventQuickSave, constructor, function(response) 
					{	
						if(response == 1) 
						{
							$(opt.modalQuickSaveSelector).modal('hide');
							$(opt.calendarSelector).fullCalendar('refetchEvents');
						} else {
							alert(opt.failureAddEventMessage);	
						}
					});	
					// e.preventDefault(); prevented duplication
				} // end quickSave
					   
				// Function to Save Data to the Database 
				calendar.save = function()
				{
					$(opt.formAddEventSelector).on('submit', function(e)
					{
						$.post(opt.ajaxEventSave, $(this).serialize(), function(response) 
						{
							if(response == 1) 
							{
								alert(opt.successAddEventMessage);
								document.location.reload();
							} else {
								alert(opt.failureAddEventMessage);
								document.location.reload();
							}
							
						});	
						e.preventDefault();
					}); 
				};
					
				// Function to Remove Event ID from the Database
				calendar.remove = function(id)
				{
					var construct = "id="+id;

					// First check if the event is a repetitive event
					$.ajax({
						type: "POST",
						url: opt.ajaxRepeatCheck,
						data: construct,
						cache: false,
						success: function(response) {
							if(response == 'REP_FOUND') 
							{
								// prompt user
								$(opt.modalViewSelector).modal('hide');
								
								if(opt.version == 'modal')
								{
									$(opt.modalPromptSelector+" .modal-header").html('<h4>'+opt.eventText+calendar.title+'</h4>');
									$(opt.modalPromptSelector+" .modal-body").html(opt.repetitiveEventActionText);	
								} else {
									$(opt.modalPromptSelector+" .modal-header").html('<h4>'+opt.eventText+'</h4>');
									$(opt.modalPromptSelector+" .modal-body").html(opt.repetitiveEventActionText);		
								}
								
								$(opt.modalPromptSelector).modal('show');
								
								// Action - remove this
								$(".modal-footer").delegate('[data-option="remove-this"]', 'click', function(e) 
								{
									calendar.remove_this(construct);
									$(opt.modalPromptSelector).modal('hide');
									e.preventDefault();
								 });
								
								// Action - remove repetitive
								$(".modal-footer").delegate('[data-option="remove-repetitives"]', 'click', function(e) 
								{
									if(opt.version == 'modal')
									{
										var construct = "id="+id+'&rep_id='+calendar.rep_id+'&method=repetitive_event';
									} else {
										var construct = "id="+id+'&rep_id='+$("input#rep_id").val()+'&method=repetitive_event';
									}
									
									calendar.remove_this(construct);
									$(opt.modalPromptSelector).modal('hide');
									e.preventDefault();
								 });
								
							} else {
								calendar.remove_this(construct);
							}
						},
						error: function(response) {
							alert(opt.generalFailureMessage);	
						}
					});	
				};
				
				// Functo to Remove Event from the database
				calendar.remove_this = function(construct)
				{
					// just remove this	
					$.post(opt.ajaxEventDelete, construct, function(response) 
					{
						if(response == '') 
						{
							if(opt.version == 'modal')
							{
								$(opt.modalViewSelector).modal('hide');
								$(opt.calendarSelector).fullCalendar('refetchEvents');	
							} else {
								document.location.reload();		
							}
						} else {
							alert(opt.failureDeleteEventMessage);
						}
					});			
				}
					
				// Function to Update Event to the Database
				calendar.update = function(id, title, description, url)
				{
					var construct = "id="+id;
					
					if(opt.version == 'php')
					{
						var title = $('input#title_update').val();
						
						var description = { 
							'6' : $('textarea#description_update').val(),
							'7' : opt.defaultColor,
							'8' : $('input#datepicker').val(),
							'9' : $('input#tp1').val(),
							'10': $('input#datepicker2').val(),
							'11': $('input#tp2').val()
						};
						
						calendar.url = 'undefined';
					}
					
					// First check if the event is a repetitive event
					$.ajax({
						type: "POST",
						url: opt.ajaxRepeatCheck,
						data: construct,
						cache: false,
						success: function(response) {
							if(response == 'REP_FOUND') 
							{
								// prompt user	
								$(opt.modalEditSelector).modal('hide');	
								
								if(opt.version == 'modal')
								{
									$(opt.modalEditPromptSelector+" .modal-header").html('<h4>'+opt.eventText+calendar.title+'</h4>');
									$(opt.modalEditPromptSelector+" .modal-body-custom").css('padding', '15px').html(opt.repetitiveEventActionText);
								} else {
									$(opt.modalEditPromptSelector+" .modal-header").html('<h4>'+opt.eventText+'</h4>');
									$(opt.modalEditPromptSelector+" .modal-body-custom").css('padding', '15px').html(opt.repetitiveEventActionText);
								}
								
								$(opt.modalEditPromptSelector).modal('show');
								
								// Action - save this
								$(".modal-footer").delegate('[data-option="save-this"]', 'click', function(e) 
								{
									calendar.update_this(id, title, description, url);
									$(opt.modalEditPromptSelector).modal('hide');
									$(opt.modalEditSelector).modal('hide');
									e.preventDefault();
								 });
								
								// Action - save repetitives
								$(".modal-footer").delegate('[data-option="save-repetitives"]', 'click', function(e) 
								{
									if(opt.version == 'modal')
									{
										var construct_two = '&rep_id='+calendar.rep_id+'&method=repetitive_event';
									} else {
										var construct_two = '&rep_id='+$("input#rep_id").val()+'&method=repetitive_event';	
									}
									
									calendar.update_this(id, title, description, url, construct_two);
									$(opt.modalEditPromptSelector).modal('hide');
									$(opt.modalEditSelector).modal('hide');
									e.preventDefault();
								 });
								
							} else {
								calendar.update_this(id, title, description, url);
							}
						},
						error: function(response) {
							alert(opt.generalFailureMessage);	
						}
					});	
				}
				
				// Function to update single and repetitive events
				calendar.update_this = function(id, title, description, url, construct_two)
				{
					if(opt.version == 'modal')
					{
						// modalView Mode
						if(calendar.url === 'undefined' || calendar.url === undefined) {
							var construct = "id="+id+"&title="+title.value+"&description="+description[6].value+"&color="+description[7].value+"&start_date="+description[8].value+"&start_time="+description[9].value+"&end_date="+description[10].value+"&end_time="+description[11].value;	
						} else {
							var construct = "id="+id+"&title="+title.value+"&description="+description[7].value+"&color="+description[8].value+"&start_date="+description[9].value+"&start_time="+description[10].value+"&end_date="+description[11].value+"&end_time="+description[12].value+"&url="+description[13].value;			
						}
					} else {
						// PHP Mode
						var construct = "id="+id+"&title="+title+"&description="+description[6]+"&color="+description[7]+"&start_date="+description[8]+"&start_time="+description[9]+"&end_date="+description[10]+"&end_time="+description[11];
					}	
					
					if(construct_two === undefined)
					{
						var main_construct = construct;	
					} else {
						var main_construct = construct+construct_two;	
					}
										
					$.ajax({
						type: "POST",
						url: opt.ajaxEventEdit,
						data: main_construct,
						cache: false,
						success: function(response) {
							if(response == '') 
							{
								if(opt.version == 'modal')
								{
									$(opt.modalEditSelector).modal('hide');
									$(opt.calendarSelector).fullCalendar('refetchEvents');
								} else {
									document.location.reload();	
								}
							} else {
								alert(opt.failureUpdateEventMessage);	
							}
						},
						error: function(response) {
							alert(opt.failureUpdateEventMessage);	
						}
					});	
				}
				
				// Function to Export Calendar
				calendar.exportIcal = function(expID, expTitle, expDescription, expStart, expEnd, expUrl)
				{ 
					var start_factor = $.fullCalendar.formatDate($.fullCalendar.parseDate(expStart), 'yyyy-MM-dd HH:mm:ss');
					var end_factor = $.fullCalendar.formatDate($.fullCalendar.parseDate(expEnd), 'yyyy-MM-dd HH:mm:ss');
					
					var construct = 'method=export&id='+expID+'&title='+expTitle+'&description='+expDescription+'&start_date='+start_factor+'&end_date='+end_factor+'&url='+expUrl;	

					$.post(opt.ajaxEventExport, construct, function(response) 
					{
						
						$(opt.modalViewSelector).modal('hide');
						window.location = 'includes/Event-'+expID+'.ics';
						var construct2 = 'id='+expID;
						$.post(opt.ajaxEventExport, construct2, function() {});
					});
				}
			
			// Commons - modal + phpversion
			// Fiter
			if(opt.filter == true)
			{
				$(opt.formFilterSelector).on('change', function(e) 
				{
					 selected_value = $(this).val();
					 
					 construct = 'filter='+selected_value;
					 
					 $.post('includes/loader.php', construct, function(response) 
					{
						$(opt.calendarSelector).fullCalendar('refetchEvents');
					});	
					 
					 e.preventDefault();  
				});
				
			// Search Form
			// keypress
			$(opt.formSearchSelector).keypress(function(e) 
			{
				if(e.which == 13)
				{
					search_me();
					e.preventDefault();
				}
			});
			
			// submit button
			$(opt.formSearchSelector+' button').on('click', function(e) 
			{
				search_me();
			});
			
			function search_me()
			{
				 value = $(opt.formSearchSelector+' input').val();
				 
				 construct = 'search='+value;
				 
				 $.post('includes/loader.php', construct, function(response) 
				{
					$(opt.calendarSelector).fullCalendar('refetchEvents');
				});		
			}
				
			}
					   
		} // FullCalendar Ext
		
	}); // fn
	 
})(jQuery);

// define object at end of plugin to fix ie bug
var calendar = {};
