<?php
/**
*Base controller for managing business level logic
*Not much to really do here as the app is AJAX based.
*But this may come in handy later on in dev.
*@author David Eddy <pheagey@gmail.com>
*date 2013-10-08
*/

require_once("./settings.php");
require_once("./views/base_view.php");
require_once("./models/base_model.php");

class baseController
{
	/**
	*view container
	*/
	public $baseView = null;
	


	/**
	*Instantiate class and direct logic based on the URL in the POST data
	*/
	function __construct() {

		$this->baseView = new baseView();

	}
}

$baseController = new baseController();