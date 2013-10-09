/**
*twbs js for Con-Man
*@author deddy <pheagey@gmail.com>
*@since 0.0.1
*@version 0.0.1
*@date 2013-10-04
*/

//Attach scrollspy to navbar


/* Call to refresh scrollspy navbar when adding/removing DOM elements */
$('[data-spy="scroll"]').each(function () {
  var $spy = $(this).scrollspy('refresh')
})



// jQ plugins for CRUD
/**
 * Execute a CRUD action
 * @author David Eddy pheagey@gmail.com
 * @version 0.3.0
 * @since 2013-7-16
 * @param  {[string]} action   = "read" [description]
 * @param  {[string]} data 	   = "json" [description]
 * @return {[string]} httpType = "post"	[description]
 */
function crudData(action, data, httpType) {
	
	// 'cause IE is a pos and will not let us set params as null in the method decleration
	if(typeof(action) 	=== 'undefined') action = "read";
	if(typeof(data) 	=== 'undefined') data 	= null;
	if(typeof(httpType) === 'undefined') httpType= "post";



	/* Add action and http type to data package */
	out_data = new Object();

	//TODO Refactor this as a loop that is not dependant on a static form element list
	if (data != null) {
		out_data["fname"] = data[0].value;
		out_data["lname"] = data[1].value;
		out_data["city"]  = data[2].value;
		out_data["state"] = data[3].value;
		out_data["zip"]   = data[4].value;
	}

	/* add the AJAX/REST actions */
	out_data["action"] = action;
	out_data["httpType"] = httpType;



    //TODO processing animation
	var promise = $.ajax({
        type: httpType,
        data: out_data,
        dataType: "json",
        url: "./ctrls/ajax_ctrl.php"
    }).done(function(data) {
    	//TODO flash row background green to show action completed
    	console.log( "success: "+JSON.stringify(data, undefined, 2));
  	}).fail(function() {
    	//TODO flash row background red to show action failed
    	console.log( "error: "+data );
	});
};



var current_form_elem = null;



/* the form logic */
/* save the currently focused items data */
$( "form input.form-control, form button.btn").on( "focus", function() {
	
	console.log('Form element focused');

	/* load form data into an array */
	current_form_elem = $(this).closest("form");

	/* enable the save button */
	current_form_elem.children('button').removeClass("disabled");
});

/* Disable button when form is blur'd */
$( "form input.form-control, form button.btn").on( "blur", function() {
	
	console.log('Form element blured');

	/* disable the save button */
	current_form_elem.children('button').addClass("disabled");
});



/* The action button (Save/Add) */
$( "form button.btn" ).on( "click", function() {
	
	return crudData(current_form_elem.attr('action'), current_form_elem.serializeArray());
});



$( document ).ready(function() {
    crudData();
});