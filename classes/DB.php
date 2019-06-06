<?php 
	class DB {
		private static $_instance;

		/**
		 *
		 * Connect to the database
		 *
		 */
		
		public function connect() {
			$host = HOST;
			$user = USER;
			$pass = PASS;
			$name = NAME;

			return mysqli_connect($host, $user, $pass, $name);
		}

		/**
		 *
		 * Get database intance for singlton patter
		 *
		 */
		

		public static function getInstance() {
			if(isset(self::$_instance)) {
				return self::$_instance;
			} else {
				return self::$_instance = new DB();
			}
		}

		/**
		 *
		 * escape function
		 *
		 */
		

		public function escape($string) {
			return mysqli_real_escape_string($this->connect(), $string);
		}

		/**
		 *
		 * main query function
		 * escapes the sql (prevents SQL injection)
		 * then cleans for HTML
		 *
		 */
		
		public function query($sql) {
			$sql = $this->escape($sql);
			$sql = Helpers::clean($sql);
			return mysqli_query($this->connect(), $sql);
		}

		/**
		 *
		 * Inserts fields and values into a database table
		 * Fields and Values must be set arrays
		 * Detailed errors arrays must not be empty
		 * both arrays are converted to strings and a statment is created
		 *
		 */
		

		public function insert($table, $fields, $values) {
			if(is_array($fields)) {
				if(empty($fields)) {
					die("Your fields array was left empty and needs to contain at least one value");
				} else {
					$fieldString = "";
					foreach($fields as $field) {
						$fieldString .= $field . ", ";
					}

					$fieldString = rtrim($fieldString, ', ');
				}
			} else {
				die("The fields varriable {$fields}: must be an array and should be the table fields for the {$table} table in the " . NAME . " database");
			}

			if(is_array($values)) {
				if(empty($fields)) {
					die("Your fields array was left empty and needs to contain at least one value");
				} else {
					$valueString = "";
					foreach($fields as $value) {
						$valueString .= "'" . $value . "', ";
					}

					$valueString = rtrim($valueString, ', ');
				
				}
			} else {
				die("The values varriable {$values}: must be an array and should be the table values for the {$table} table in the " . NAME . " database"); 
			}
			$sql = "INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";
			return $this->query($sql);
		}

		/**
		 *
		 * select statment
		 * This will generate a select statment
		 * determinst the type of select you want if you have items
		 * Lets you select using AND OR NOT
		 *
		 */

		public function select($table, $identifier, $id, $items=[], $operator = []) {
			if(is_array($identifier)) {
				$idString = '';
				if(empty($operator)) {
					die('You must choose an sql operator such as AND or OR');
				} else if(is_array($operator)) {
					if(!in_array('AND', $operator) || !in_array('OR', $operator) || !in_array('NOT', $operator)) {
						die("The operator you chose was invalid");
					}
				} else if(!is_array($operator)) {
					if($operator != "AND" && $operator != "OR" && $operator != "NOT") {
						die('The operator you chose was invalid. CAPS MATTER');
					}
				}
				foreach($identifier as $option) {
					$idString .= $option . " {$operator} ";
				}

				$idString = rtrim($idString, " {$operator} ");
			} else {
				$idString = $identifier;
			}
			if(empty($items)) {
				$sql = "SELECT * FROM {$table} WHERE {$idString} = '{$id}'";
				return $this->query($sql);
			} else {
				$itemString = '';
				foreach($items as $item) {
					$itemString .= $item . ', ';
				}
				$itemString = rtrim($itemString, ', ');
				$sql = "SELECT {$itemString} WHERE {$idString} = '{$id}'";
				return $this->query($sql);
			}
		}
		
		/**
		 *
		 * update 
		 * flexable uses assoc arrays
		 *
		 */
		
		public function update($table, $items, $condition) {
			if(is_array($items) && is_array($condition)) {
				if(Helpers::has_string_keys($items) && Helpers::has_string_keys($condition)) {
					$itemString = "";
					$conditionString = "";

					foreach($items as $item => $value) {
						$itemString .= $item . " = '" . $value . "', ";
					}
					$itemString = rtrim($itemString, ', ');

					foreach($condition as $con => $value) {
						$conditionString .= $con . " = " . "'{$value}'";
					}
					$sql = "UPDATE {$table} SET {$itemString} WHERE {$conditionString}";
					die($sql);
				} else {
					die("Both Items and conditions must be an associative array");
				}
			} else {
				die("Both the items and conditions must be set to a key value array<br> EX: $$items = ['Column1' => 'value']; <br>EX: = $$condition = ['Column ID' => 'column identifier'];");
			}
		}

		public function delete($table, $conditon) {
			if(!is_array($conditon)) {
				die('Conditions For the Delete Function must be an associative array');
			} else {
				$conditions = "";
				foreach($conditon as $con => $value) {
					$conditions .= $con . " = '" . $value . "'";
				} 
				$sql = "DELETE FROM {$table} WHERE {$conditions}";
				return $this->query($sql);
			}
		}

	}