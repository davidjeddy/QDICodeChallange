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
	*Container for data to be processed
	*/
	private $data = null;


	/**
	*Init. the class, create connection
	*/
	function __construct($data = null) {

		$this->dbConn = new PDO("mysql:dbname=".db_name.";host=".db_host."", db_user, db_pass);

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


			
			$query = "
				INSERT INTO ".db_name."contacts (fname, lname, city, state, zip)
				VALUES (:fname,:lname,:city,:state,:zip)
			";
			
			$stmt = $this->dbConn->prepare($query);

			print_r($stmt->execute(array(
				':fname'=>$data->fname,
				':lname'=>$data->lname,
				':city'=>$data->city,
				':state'=>$data->state,
				':zip'=>$data->zip,
			)));exit;

	}

	/**
	*Read all the data
	*/
	public function read() {

		$return_data = array();

		$stmt = "
			SELECT *
			FROM ".db_name.".".db_table."
			WHERE `deleted` IS Null
		";

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

		try{

			$stmt = $this->dbConn->prepare("
				UPDATE ".db_name.".contacts 

		    	SET ".db_table.".fname = ?,
		    		".db_table.".lname = ?,
		    		".db_table.".city = ?,
		    		".db_table.".state = ?,
		    		".db_table.".zip = ?

		    	WHERE ".db_table.".id = ?
		    ");

			$stmt->execute(array(
				$data->fname,
				$data->lname,
				$data->city,
				$data->state,
				$data->zip,
				$data->id)
			);

			return true;
		} catch (PDOException $e) {
			
			return "Connection error, because: ".$e->getMessage();
		}
	}

	/**
	*Delete a new data record
	*/
	public function delete($data) {
		
		//NEVER really delete data. Just mark it as deleted with the datetime of action
		$stmt = $this->dbConn->prepare("
			UPDATE ".db_name.".contacts 

			SET  ".db_table.".deleted = '".date('Y-m-d h:m:s')."'

			WHERE ".db_table.".id = ?
		");
		
		return $stmt->execute(array($data->id));

	}
}
