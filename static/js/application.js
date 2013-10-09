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
    	//console.log( "success: "+JSON.stringify(data, undefined, 2));

    	//todo objects alphabetically based on fname
		$("#data_container.scrollspy").empty();

		var new_html = "";
		//TODO refactor this to loop over all the fields returned, stoping @ count 6
		$.each(data, function(i){

			//TODO add this starter when w new letter is reached: '<div class="bs-example id="//first letter//">
			new_html += '\
			<div class="bs-example">\
                <form action="patch">\
                    <input type="hidden"    class="form-control" name="fname"    value="'+data[i].id+'" />\
                    <input type="text"      class="form-control" name="fname"    value="'+data[i].fname+'" />\
                    <input type="text"      class="form-control" name="lname"    value="'+data[i].lname+'" />\
                    <input type="text"      class="form-control" name="city"     value="'+data[i].city+'" />\
                    <input type="text"      class="form-control" name="state"    value="'+data[i].state+'" />\
                    <input type="text"      class="form-control" name="zip"      value="'+data[i].zip+'" />\
                    <button type="button"   class="btn btn-success update_data_button disabled" data-loading-text="Update" >Update</button>\
                    <button type="button" 	class="btn btn-warning delete_data_button disabled" data-loading-text="Delete" >Delete</button>\
                </form>\
            </div>';

			console.log(data);
		});

	$("#data_container.scrollspy").append(new_html);

	//TODO re-init all the buttons that just got added



  	}).fail(function() {
    	//TODO flash row background red to show action failed
    	console.log( "error: "+data );
	});
};



var current_form_elem = null;



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



/* The action button (Save/Add) */
$( document ).on( "form button.btn", function() {
	
	return crudData(current_form_elem.attr('action'), current_form_elem.serializeArray());
});



$( document ).ready(function() {
    var data = crudData();


});