<?php

/**
 * @author Koen Veelenturf
 * @version 1.0.3
 * This is the database class used for comminucation between server and database
 */

class Database {
	/* default variables */
	private $databaseConfigPresent = false;
	private $databaseConfigValid = false;
	private $databaseConnectionStatus = "none";
	/* database variables */
	private $host = "localhost";
	private $username = "virt_database";
	private $password = "pvirt";
	private $database = "virt_database";
	/* database link variable */
	private $databaseConnection;
	/* last query result cache */
	private $queryCache;
	
	public function _construct() {
		/* check if database credentials are set, if true update databaseConfigPresent variable */
		if(isset($this->host) == true && isset($this->username) == true && isset($this->password) == true && isset($this->database) == true) {
			$this->databaseConfigPresent = true;
		}
		/* establish a mysqli database connection, if true update databaseConfigValid variable */
		if($this->databaseConfigPresent == true) {
			if($this->openConnection() == true)	{
				$this->databaseConfigValid = true;	
			}
		}
		/* check if database connection is working, if true databaseConnectionStatus variable will be updated */
		if($this->databaseConfigValid == true) {
			$this->checkConnection();
		}
	}
	
	/**
	 * The openConnection function can be used to open a database connection with provided credentials
	 * the function will only be exucted while their is not an active database connection
	 * @return openConnection will return true if a connection was establist otherwise it dies with error message
	 */
	public function openConnection() {
		/* if database connection is not working or not set, create a new one */
		if($this->databaseConnectionStatus == "none" || $this->databaseConnectionStatus == "broken") {
			/* init the mysqli instance */
			$this->databaseConnection = mysqli_init();
			if(!$this->databaseConnection) {
				die('MySQLi failed to init!');
			}
			/* open a mysqli connection */
			if(!$this->databaseConnection->real_connect($this->host, $this->username, $this->password, $this->database)) {
			    die('MySQLi failed to connect (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
			} else {
				return true;	
			}
		}
	}
	
	/**
	 * The closeConnection function can be used to close the current database connection,
	 * the function will only be exucted while their is an active database connection
	 */
	public function closeConnection() {
		/* if database connection is working and set, then close the connection */
		if($this->databaseConnectionStatus == "working") {
			$this->databaseConnection->close();
		}
	}
	
	/**
	 * The checkConnection function can be used to test the current database connection
	 * @return checkConnection will return true if database connection is working, otherwise it will return false
	 */
	private function checkConnection() {
		if(isset($this->databaseConnection)) {
			if(!$this->databaseConnection->connect_errno && $this->databaseConnection->ping() == true) {
				$this->databaseConnectionStatus = "working";
			} else {
				$this->databaseConnectionStatus = "broken";	
			}
		} else {
			$this->databaseConnectionStatus = "none";	
		}
	}
	
	/**
	 * The getConnectionStatus function can be used to get the current database connection status
	 * @return databaseConnectionStatus, wich can be 'working', 'broken' or 'none'
	 */
	public function getConnectionStatus() {
		$this->checkConnection();
		return $this->databaseConnectionStatus;
	}
	
	/**
	 * The doQuery function can be used to perform SQL query's with the database, such as INSERT or UPDATE
	 * @return doQuery will return the affected rows on the perforemd SQL query, if query failed -1 is returned
	 */
	public function doQuery($query) {
        //$query2 = real_escape_string($query);
        
    	$succes = $this->databaseConnection->query($query);
		//* update queryCache */
		$this->queryCache = $succes;
		/* return affected rows, -1 if query failed */
       	return $this->databaseConnection->affected_rows;
	}
	
	/**
	 * The getQuery function can be used to perform SQL query's with the database, such as SELECT
	 * @return getQuery will return an object representing the values collected by the SQL query, if query failed null is returned
	 */
	public function getQuery($query) {
    	$result = $this->databaseConnection->query($query);
		/* update queryCache */
		$this->queryCache = $result;
		$affectedRows = $this->databaseConnection->affected_rows;
		/* if affected rows is 1, then return that row as assoc array */
		if($affectedRows == 1) {
			return mysqli_fetch_assoc($result);
		}
		/* if affected rows is greater than 1, then return as 2-dimension array */
		else if($affectedRows > 1) {
			$counter = 0;
			$returnable = Array();
			while ($row = mysqli_fetch_assoc($result)) {
				$returnable[$counter] = $row;
				$counter++;
			}
			return $returnable;
		}
		/* if affected row is not 1 or greater, then return null */
		else {
			return null;
		}
	}
	
	/**
	 * The affectedRows function can be used to get the affected rows from the last performed query
	 * @return affecedRows will return the affected rows from the last performed query, if last query failed -1 is returned
	 */
	public function affectedRows() {
		return $this->databaseConnection->affected_rows; 	
	}
	
	/**
	 * The getResult function can be used to get the raw results form the last performed query based
	 */
	public function getResult() {
		return $this->queryCache;		 
	}
	 
}

?>