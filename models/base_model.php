<?php
/**
*Base model for managing data source interaction
*We use the PDO PHP interface and prepard statements
*@author David Eddy <pheagey@gmail.com>
*date 2013-10-08
*/

class baseModel
{

	/**
	*Database connection container
	*/
	private $dbConn = null;

	/**
	*Status to return to the calling CTL
	*Typicall boolean or error string
	*/
	private $returnStatus = null;


	/**
	*Init. the class, create connection
	*/
	function __construct() {

		//Real escape the string, even though the ctrl sanitized it
		//One can never be to safe
	}

	/**
	*What to do when the object is destroyed
	*/
	function __destruct() {

		//Null, close and destroy the connection

	}



	//These are the 'action' methods
	/**
	*Create a new data record
	*/
	public function create($data) {

	}

	/**
	*Read a new data record
	*/
	public function read($data) {

	}

	/**
	*Update a new data record
	*/
	public function update($data) {

	}

	/**
	*Delete a new data record
	*/
	public function delete($data) {

	}
}

$baseModel = new baseModel();