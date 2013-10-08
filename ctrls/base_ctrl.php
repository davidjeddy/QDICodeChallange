<?php
/**
*Base controller for managing business level logic
*@author David Eddy <pheagey@gmail.com>
*date 2013-10-08
*/

require_once("../models/base_model.php");

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

		//Now, based on the form action, determine our next move
		switch ($this->data->action) {
		    case 'create':
		        $this->returnData($this->create($this->data));
		        break;
		    case 'read':
		        $this->returnData($this->read($this->data));
		        break;
		    case 'update':
		        $this->returnData($this->update($this->data));
		        break;
		    case 'delete':
		        $this->returnData($this->delete($this->data));
		        break;
		    default:
		    	$this->returnData(null, "No valid action found.");
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
	*Return all processed data as legit json object
	*This is the termination of the logic
	*/
	private function returnData($data = null, $msg = null) {

		//Return the error message if it exists
		if ($msg) {
			echo json_encode($msg);
			exit;

			//Encode and return data
		} elseif (!empty($data) && is_array($data)) {
			echo json_encode($data);
			exit;

			//Catch all error return
		} elseif (is_string($data)) {
			echo "Unable to process request. Error: ".$data;
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

		return $this->model->create($this->data);
	}

	/**
	* Read existing data record
	*/
	public function read() {

		return $this->model->read($this->data);
	}

	/**
	* Update existing data record
	*/
	public function update() {

		return $this->model->update($this->data);
	}

	/*
	* Delete existing data record
	*/
	public function delete() {

		return $this->model->delete($this->data);
	}
}

$baseController = new baseController();