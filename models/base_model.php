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


		try {
			$query = "
				INSERT INTO ".db_name.".".db_table." (fname, lname, city, state, zip)
				VALUES (:fname,:lname,:city,:state,:zip)
			";
			
			$stmt = $this->dbConn->prepare($query);

			$stmt->execute(array(
				':fname'=>$data->fname,
				':lname'=>$data->lname,
				':city'=>$data->city,
				':state'=>$data->state,
				':zip'=>$data->zip,
			));

			return true;
		} catch (PDOException $e) {
			return false;
		}

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
			ORDER BY fname ASC, lname ASC, ZIP ASC
		";

		try {
			
			foreach ($this->dbConn->query($stmt) as $row) {
				$return_data[] = $row;
			}

			return $return_data;
		} catch (exception $e) {
			return false;
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
				UPDATE ".db_name.".".db_table."
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
			
			return false;
		}
	}

	/**
	*Delete a new data record
	*/
	public function delete($data) {
		
		//NEVER really delete data. Just mark it as deleted with the datetime of action
		try {

			$query = "
				UPDATE ".db_name.".".db_table." 
				SET  deleted = '".date('Y-m-d h:m:s')."'
				WHERE id = :id
			";

			$stmt = $this->dbConn->prepare($query);

			$stmt->execute(array(
				':id' => $data->id
			));



			$stmt->execute();

			return true;
		} catch (Exception $e) {
			return true;
		}
	}
}
