<?php 
class User extends DB {
	private $_table;

	public function __construct() {
		$this->_table = "Users";
	}

	public function getByID($id) {
		if($this->select($this->_table, 'user_id', $id)) {
			return $this->select($this->_table, 'user_id', $id);
		} else {
			echo "Sorry no user found";
		}
	}

	public function getByUsername($username) {
		if($this->select($this->_table, 'user_username', $username)) {
			return $this->select($this->_table, 'user_username', $username);
		} else {
			echo "Sorry no user found";
		}
	}

	public function getByEmail($email) {
		if($this->select($this->_table, 'user_email', $email)) {
			return $this->select($this->_table, 'user_email', $email);
		} else {
			echo "Sorry no user found";
		}
	}
}
	