/**
*twbs js for Con-Man
*@author deddy <pheagey@gmail.com>
*@since 0.0.1
*@version 0.0.1
*@date 2013-10-04
*/

//Attach scrollspy to navbar


//Call to refresh scrollspy navbar when adding/removing DOM elements
$('[data-spy="scroll"]').each(function () {
  var $spy = $(this).scrollspy('refresh')
})



// jQ plugins for CRUD
/**
 * Execute a CRUD action
 * @author David Eddy
 * @version 0.2.0
 * @since 2013-7-16
 * @param  {[string]} action   = "read" [description]
 * @param  {[string]} dataType = "json" [description]
 * @return {[boolean]} 					[description]
 */
function crudData(action, data, dataType) {
	
	// 'cause IE is a pos and will not let us set params as null in the method decleration
	if(typeof(action)==='undefined') 		action = "read";
		if(typeof(data)==='undefined') 		data = null;
		if(typeof(dataType)==='undefined') 	dataType = "json";



	var out_data = Object();

	// Extra data to  		
	out_data.action 	= action;
	out_data.data 		= data;	
	out_data.dataType 	= dataType;
	out_data.start_date = $("#start_date").val();
	out_data.end_date 	= $("#end_date").val();

	console.log(out_data);

	var promise = $.ajax({
        type: "POST",
        data: {data: out_data},
        dataType: dataType,
        url: "../app.py"
    });

    promise.success(function(data) {

		console.log('AJAX request successful.');
    });

    promise.error(function(data) {
    	alert('Error during processing; please try again later.');
    	console.log("AJAX error: " + data);
    	return false;
    });

    promise.complete(function(){

		console.log("AJAX request completed.");
    });
};



var current_data = null;


/* save the currently focused items data */
$( "form input.form-control").on( "click", function() {
	current_data = $(this).val();
});



/* if the data changes, enable the save option */
$( "form input.form-control").on( "keyup keypress blur chang", function() {
	
	// if the value of the field is different that original enable to save option when changed.
	if (current_data != $(this).val()) {
	 	
	 	$(this).siblings().removeClass('disabled');
	} else if (current_data == $(this).val()) {
		
		$(this).siblings('button.btn').addClass('disabled');
	}

	console.log(current_data);
	console.log($(this).val());
});



/* save changed data */
$( "div#data_container.scrollspy div#a.bs-example button.btn" ).on( "click", function() {
	var data = $(this).parent().serialize();
	console.log(data);
});



/* for adding new entries */
$( "button#add_data_button" ).on( "click", function() {
	return crudData("create", $(this).parent().serialize());
});

