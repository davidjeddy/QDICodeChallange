<?php
/**
*Base controller for managing business level logic
*@author David Eddy <pheagey@gmail.com>
*date 2013-10-08
*/

require_once("./views/base_view.php");
require_once("./models/base_model.php");

class baseController
{
	/**
	*Request data
	*/
	private $data = null;

	/**
	*The model container
	*/
	private $model = null;



	/**
	*Instantiate class and direct logic based on the URL in the POST data
	*/
	function __construct() {

		//Go sanitize the REQUEST data
		$this->data = $this->sanitize($_REQUEST);

		//Data is sanitized, init. the model
		$this->model = new baseModel();

		//Get all the data on the initial execution or if
		//no action is specified
		if ($this->data == null || empty($this->data)) {

			$this->read();
		} else {
			
			$this->switchBoard();
		}
	}

	/**
	*Sanitize all incoming data before logic is applied
	*/
	private function sanitize(array $data) {
		
		// Local return container
		$return_data = new stdClass();
		
		// Remove all non-alphanumeric characters ( and . and spaces)
		// Reconstruct in $return_data
		foreach ($data as $key => $value) {

			// Data must be a string to process
			if (is_string($value)) {

				//TODO Not the best way but will do for now
				$key = preg_replace("/[^a-z0-9. ]+/i", "", $key);
				$return_data->{$key} = preg_replace("/[^a-z0-9. ]+/i", "", $value);
			} else {
				
				$this->returnData(null, "Data not in string format.");
			}

		}



		// Should have a 6 or more fields for processing.
		if (count((array)$return_data) >= 6) {
			return $return_data;
		} else {
			$this->returnData(null, "Not enough data to process.");
		}
	}

	/**
	*Determine where to go based on the actiom of the form
	*Eventuall this could be iterated to be RESTful as well
	*/
	private function switchBoard() {

		$return_data = array();
		
		//Now, based on the form action, determine our next move
		//This is the HTTP rewquest type <-> CRUD convertion
		//TODO this can be refactored into a single action->method call. No need to repeat
		switch ($this->data->action) {
		    case 'post':
		        if ($this->create($this->data)) {
		        	$return_data[] = "Create completed successfully.";
		        } else {
		        	$return_data[] = "Create failed.";
		        }

		        break;
		    case 'get':
		        if ($return_data = $this->read($this->data)) {
		        	$return_data[] = $return_data;
		        } else {
		        	$return_data[] = "Read failed.";
		        }

		        break;
		    case 'patch':
		        if ($this->update($this->data)) {
		        	$return_data[] = "Update completed successfully.";
		        } else {
		        	$return_data[] = "Update failed.";
		        }

		        break;
		    case 'delete':
		        if ($this->delete($this->data)) {
		        	$return_data[] = "Deleted action successfull.";
		        } else {
		        	$return_data[] = "Deleted failed.";
		        }

		        break;
		    default:
		    	$this->returnData(null, "No valid action found.");
		}

		$this->returnData($return_data);
	}

	/**
	*Return all processed data as legit json object
	*This is the termination of the ctrl logic
	*/
	private function returnData($data, $msg = null) {

		//Return the error message if it exists
		if (is_null($data) && $msg) {
			print_r($msg);
			exit;

			//Encode and return data
		} elseif (!empty($data) && is_array($data)) {
			print_r(json_encode($data));
			exit;

		}

		//...and for safe measure
		exit;
	}



	//These are interposer methods that communicate with the model
	//'Fat model, skinny controllers', works well with the CRUD design
	/*
	* Create a new data record
	*/
	public function create() {

		return $this->baseModel->create($this->data);
	}

	/**
	* Read existing data record
	*/
	public function read() {

		return $this->mobaseModeldel->read();
	}

	/**
	* Update existing data record
	*/
	public function update() {
		return $this->baseModel->update($this->data);
	}

	/*
	* Delete existing data record
	*/
	public function delete() {

		return $this->baseModel->delete($this->data);
	}
}

$baseController = new baseController();