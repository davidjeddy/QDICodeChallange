<?php
/**
*AJAX controller to manage AJAX requests
*@author David Eddy <pheagey@gmail.com>
*date 2013-10-08
*/
require_once("../settings.php");
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
	private $baseModel = null;



	/**
	*Instantiate class and direct logic based on the URL in the POST data
	*/
	public function __construct() {

		//Data is sanitized, init. the model
		$this->baseModel = new baseModel();

		$this->data = $this->sanitize($_REQUEST);			

		$this->switchBoard();

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



		//if get request, only the action needs to be get
		//OR if not get must have 3 elements: fname, lname, zip
		if ($return_data->action == "get"
			|| ($return_data->action
				&& is_string($return_data->fname)
				&& is_string($return_data->lname)
				&& is_numeric($return_data->zip)
			)
		) {
			
			return $return_data;
		} else {
			
			$this->returnData(null, "Not enough data to process or data incorrect.");
		}
	}

	/**
	*Determine where to go based on the actiom of the form
	*Eventuall this could be iterated to be RESTful as well
	*/
	private function switchBoard() {

		$return_data = null;
		
		//Now, based on the form action, determine our next move
		//This is the HTTP rewquest type <-> CRUD convertion
		//TODO this can be refactored into a single action->method call. No need to repeat
		switch ($this->data->action) {
		    case 'post':
		        if ($this->create()) {

		        	if (!$this->data->error) {
		        		$return_data = "Create completed successfully.";
		        	} else {
		        		$return_data = $this->data->error;
		        	}
		        } else {
		        	$return_data = false;
		        }

		        break;
		    case 'get':

		    	$return_data = $this->read();

		        if (is_bool($return_data)) {
		        	$return_data = false;
		        }

		        break;
		    case 'patch':
		        if ($this->update()) {
		        	$return_data = array("Update completed successfully.");
		        } else {
		        	$return_data = false;
		        }

		        break;
		    case 'delete':
		        if ($this->delete()) {
		        	$return_data = "Deleted action successfull.";
		        } else {
		        	$return_data = false;
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
			echo(json_encode($data));
			exit;

		} else {
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

		try {	
			//This is where we hook into the location provider and use the zip code
			//to return the city and state values like this:http://ZiptasticAPI.com/ZIPCODE
			$api_res = curl_init( "http://ZiptasticAPI.com/".$this->data->zip );
			$options = array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
			);
			curl_setopt_array( $api_res, $options );
			$results =  json_decode (curl_exec($api_res));

			foreach ($results as $k => $v) {
				$this->data->{$k} = $v;
			}

			// go save the data if valid
			if ($this->data->error) {
				
				return $this->data->error;
				//or return an error
			} else {
				
				return $this->baseModel->create($this->data);
			}
		} catch (Exception $e) {

			return $e;
		}
	}

	/**
	* Read existing data record
	*/
	public function read() {

		return $this->baseModel->read();
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