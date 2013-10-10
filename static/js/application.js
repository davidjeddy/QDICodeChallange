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



/**
*Generate a new HTML row for the content area
* Execute a CRUD action
* @author David Eddy pheagey@gmail.com
* @version 0.0.4
* @since 2013-10-09
*/
function addRow(data) {

	return_data = '\
	<div class="bs-example">\
	    <form>\
	        <input type="hidden"    class="form-control" name="id" 		maxlength="11" value="'+data.id+'" />\
	        <input type="text"      class="form-control" name="fname" 	maxlength="32" value="'+data.fname+'" />\
	        <input type="text"      class="form-control" name="lname" 	maxlength="32" value="'+data.lname+'" />\
	        <input type="text"      class="form-control" name="city" 	maxlength="32" value="'+data.city+'" disabled />\
	        <input type="text"      class="form-control" name="state" 	maxlength="2" value="'+data.state+'" disabled />\
	        <input type="text"      class="form-control" name="zip" 	maxlength="5" value="'+data.zip+'" />\
	        <button type="button"   class="btn btn-success update_data_button disabled" data-loading-text="Update" >Update</button>\
	        <button type="button" 	class="btn btn-warning delete_data_button disabled" data-loading-text="Delete" >Delete</button>\
	    </form>\
	</div>';

	return return_data;
}

/**
 * Execute a CRUD action
 * @author David Eddy pheagey@gmail.com
 * @version 0.3.0
 * @since 2013-7-16
 * @param  {[string]} action   = "read" [description]
 * @param  {[string]} data 	   = "json" [description]
 * @return {[string]} httpType = "post"	[description]
 */
function crudData(action, data) {
	
	// 'cause IE is a pos and will not let us set params as null in the method decleration
	if(typeof(action) 	=== 'undefined') action = "get";
	if(typeof(data) 	=== 'undefined') data 	= null;



	/* Add action and http type to data package */
	out_data = new Object();

	if (data != null) {
		$.each(data, function(i){
			out_data[data[i].name] = data[i].value;
		});
	}

	/* add the AJAX/REST actions */
	out_data["action"] = action;



    //TODO processing animation
	$.ajax({
        type: "get",
        data: out_data,
        dataType: "json",
        url: "./ctrls/ajax_ctrl.php"
    }).done(function(data) {

    	//empty status bar
    	$("#flash_msg").empty();



		//create
 		if (action == "post") {

    		//show message
    		$("#flash_msg").html(data.msg);

    		if (data.bool == true) {
				//TODO get all the data again, slide content up, empty content, relist content, slide down
    			
    			//add a new entry
				$("#data_container").append(addRow(data.msg[0]));

    		}
		//read
		} else if (action == "get") {

			if (data.bool == true) {
				
				$.each(data.msg, function(i){

					$("#data_container").append(addRow(data.msg[i]));
				});

				$("#flash_msg").html('Contacts loaded.');
			} else {
				$("#flash_msg").html('Contacts could not be loaded.');
			}
		//update
		} else if (action == "patch") {

    		//show message
    		$("#flash_msg").html(data.msg);

			//if successful - update data from out_data
			if (data.bool == true) {

			//not successful
			}
		//delete
		} else if (action == "delete") {

    		//show message
    		$("#flash_msg").html(data.msg);

    		if (data.bool == true) {
    			//slide row up to look like it has been removed
    			$("input[value='"+out_data["id"]+"']").parent().slideUp('slow');
    		}
		}



  	}).fail(function(data) {

    	//TODO flash row background red to show action failed
    	console.log( "error: "+JSON.stringify(data, undefined, 2));
	});
};



var current_form_elem = null;
var current_field_val = null;



/* the form logic */
/* save the currently focused items data */
$( document ).on( "focus", "form input.form-control, form button.btn", function() {
	
	console.log('Form element focused');

	/* load form data into an array */
	current_form_elem = $(this).closest("form");

	/* enable the save button */
	current_form_elem.children('button').removeClass("disabled");
});

/* Disable button when form is blur'd */
$( document ).on( "blur", "form input.form-control, form button.btn", function() {
	
	console.log('Form element blured');

	/* disable the save button */
	current_form_elem.children('button').addClass("disabled");
});

/*TODO enable delete button on hover */
//This would be done but jquery does not propigate events on disabled elements.

/* What to do when a bttn is pressed */
$( document ).on( "click", "form button.btn", function() {

	//Determine HTTP request method based on the class the button contains
	var http_method = "get"; //default for reading

	if ($(this).hasClass("create_data_button")) {
		http_method = "post";
	//'Read' would be here but is set by default
	} else if ($(this).hasClass("update_data_button")) {
		http_method = "patch";
	} else if ($(this).hasClass("delete_data_button")) {
		http_method = "delete";
	}

	return crudData(http_method, current_form_elem.serializeArray());
});



/* create form, clear fields as focused */
$( document ).on( "focus", "form#create_form input", function() {

	current_field_val = $(this).val();
	$(this).val("");
});

$( document ).on( "blur", "form#create_form input", function() {

	if ($(this).val() === "") {
		$(this).val(current_field_val);	
	}	
});



$( document ).ready(function() {
    
    //inital data loading once the document hasa loaded
    crudData("get", null);
});