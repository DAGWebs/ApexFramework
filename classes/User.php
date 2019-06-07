<?php 
class User extends DB {
	private $_table;
	/*
	*
	* The constructor sets the table
	*
	*/
	public function __construct() {
		$this->_table = "Users";
	}
	
	/*
	*
	* Findes user by ID
	*
	*/
	
	public function getByID($id) {
		if($this->select($this->_table, 'user_id', $id)) {
			return $this->select($this->_table, 'user_id', $id);
		} else {
			//echo "Sorry no user found";
		}
	}
	
	/*
	*
	* Findes user by username
	*
	*/
	
	public function getByUsername($username) {
		if($this->select($this->_table, 'user_username', $username)) {
			return $this->select($this->_table, 'user_username', $username);
		} else {
			//echo "Sorry no user found";
		}
	}
	
	/*
	*
	* Findes user by Email
	*
	*/

	public function getByEmail($email) {
		if($this->select($this->_table, 'user_email', $email)) {
			return $this->select($this->_table, 'user_email', $email);
		} else {
			//echo "Sorry no user found";
		}
	}
	
	/*
	*
	* Combindes top three functions to auto select the right function to use
	* This is the main function to use to find a user
	* Decided not to echo out the error, because I plan on to extend the user class to the longin/register class for error checking
	*
	*/
	
	public function findUser($id) {
		if($this->getByEmail($id)){
			return $this->getByEmail($id);	
		} else if($htis->getByUsername($id)) {
			return $htis->getByUsername($id);
		} else if($this->getByID($id)){
			return $this->getByID($id);
		} else {
			//echo "Sorry no user was found by the identifier: ID";
		}
	}
	
	/*
	*
	* get user data
	*
	*/
	
	public function getUser($id) {
		if($this->findUser($id)) {
		
		} else {
			die("The user identified by: {$id} does not exist");
		}
	}
}
	
