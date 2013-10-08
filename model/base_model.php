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
	$dbConn = null;

	/**
	*Status to return to the calling CTL
	*Typicall boolean or error string
	*/
	$returnStatus = null;


	/**
	*Init. the class, create connection
	*/
	function __constructor() {

		//Real escape the string, even though the ctrl sanitized it
		//One can never be to safe
	}

	/**
	*What to do when the object is destroyed
	*/
	function __destructor() {

		//Null, close and destroy the connection

	}



	//These are the 'action' methods
	/**
	*Create a new data record
	*/
	function public create($data) {

	}

	/**
	*Read a new data record
	*/
	function public read($data) {

	}

	/**
	*Update a new data record
	*/
	function public update($data) {

	}

	/**
	*Delete a new data record
	*/
	function public delete($data) {

	}
}