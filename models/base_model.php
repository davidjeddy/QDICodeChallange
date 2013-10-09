<?php
/**
*Base model for managing data source interaction
*We use the PDO PHP interface and prepard statements
*@author David Eddy <pheagey@gmail.com>
*date 2013-10-08
*/

require_once("../settings.php");

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
	*Container for data to be processed
	*/
	$data = null;


	/**
	*Init. the class, create connection
	*/
	function __construct($data) {
		//Real escape the string, even though the ctrl sanitized it
		//One can never be to safe
		$this->data = $data;


		$this->dbConn = new PDO;
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
	*Read all the data
	*/
	public function read($data) {
		$return_data = array();

		$stmt = "SELECT * FROM ".db_name.".".db_table."";

		try {
			
			foreach ($this->dbConn->query($sql) as $row) {
				$return_data[] = $row;
			}

			return $return_data;
		} Catch (exception $e) {
			return $e;
		}

		//failover
		return false;
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
