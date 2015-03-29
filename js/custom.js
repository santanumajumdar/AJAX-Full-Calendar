/************************
    Pickers
*************************/
$("#datepicker").datepicker({dateFormat: "yy-mm-dd"});
$("#datepicker2").datepicker({dateFormat: "yy-mm-dd"});
$("#cp").colorpicker({format: 'hex'});
$('#tp1').timepicker();
$('#tp2').timepicker();

/************************
    Validation
*************************/
$("#add_event").validationEngine({promptPosition : "topLeft", scroll: true});