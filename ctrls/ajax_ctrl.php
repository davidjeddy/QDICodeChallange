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
		    	$return_data = $this->create();

		        if ($return_data == false) {
		        	$return_data = array("bool" => false, "msg" => "Could not create contact data.");
		        } else {
		        	$return_data = array("bool" => true, "msg" => "Contact added successfully.");
		        }

		        break;
		    case 'get':
		    	$return_data = $this->read();

		        if ($return_data == false) {
		        	$return_data = array("bool" => false, "msg" => "Could not read contact data.");
		        } else {
		        	$return_data = array("bool" => true, "msg" => $return_data);
		        }

		        break;
		    case 'patch':
		    	$return_data = $this->update();

		        if ($return_data == false) {
		        	$return_data = array("bool" => false, "msg" => "Could not update contact, sorry.");
		        } else {
		        	$return_data = array("bool" => true, "msg" => "Update completed successfully.");
		        }

		        break;
		    case 'delete':
		    	$return_data = $this->delete();

		        if ($return_data == false) {
		        	$return_data = array("bool" => false, "msg" => "Could not delete contact, sorry.");
		        } else {
		        	$return_data = array("bool" => true, "msg" => "Deleted contact successfully.");
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
	private function returnData($data) {

		echo(json_encode($data));
		exit;
	}



	//These are interposer methods that communicate with the model
	//'Fat model, skinny controllers', works well with the CRUD design principle
	/*
	* Create a new data record
	*/
	public function create() {

		try {
			$this->getLocation($this->data->zip);

			return $this->baseModel->create($this->data);

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
		
		try {

			return $this->baseModel->update($this->getLocation($this->data->zip));
		} catch (Exception $e) {

			return $e;
		}


	}

	/*
	* Delete existing data record
	*/
	public function delete() {

		return $this->baseModel->delete($this->data);
	}



	//private methods
	/**
	*Using the ZIP code return city and state
	*/
	private function getLocation() {
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

			//convert the json return to properties of the $this->data object
			foreach ($results as $k => $v) {
				$this->data->{$k} = $v;
			}



			//If the ZIP API errors skip everything else and go straight to returning the error msg
			if (isset($this->data->error)) {
				
				return $this->returnData(array("bool" => false, "msg" => $this->data->error));
			} else {

				return true;
			}
		} catch (Exception $e) {

			return $this->returnData(array("bool" => false, "msg" => $this->data->error));
		}
	}
}


$baseController = new baseController();