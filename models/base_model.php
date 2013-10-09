<?php
/**
*Base model for managing data source interaction
*We use the PDO PHP interface and prepard statements
*@author David Eddy <pheagey@gmail.com>
*date 2013-10-08
*/

require_once("./settings.php");

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
	private $data = null;


	/**
	*Init. the class, create connection
	*/
	function __construct($data = null) {

		$this->dbConn = new PDO("mysql:dbname=".db_name.";host=".db_host."", db_user, db_pass);



		if ($data == null) {

			return $this->read();
		} else {

			$this->data = $data;
			return $this->{$this->data->action}();
		}
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
		return true;
	}

	/**
	*Read all the data
	*/
	public function read() {
		$return_data = array();
		$stmt = "SELECT * FROM ".db_name.".".db_table."";

		try {
			
			foreach ($this->dbConn->query($stmt) as $row) {
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
		return true;
	}

	/**
	*Delete a new data record
	*/
	public function delete($data) {
		return true;
	}
}
