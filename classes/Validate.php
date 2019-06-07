<?php  
	class Validate extends DB {
		private $_passed = false, $_errors[]; 

		/**
		 *
		 * The validation must be in array form!
		 * The array must be an accociative array
		 * Each assoc array should be set to an array
		 * the source will be post or get data
		 *
		 */

		public function check($source, $ietems=[]) {
			$this->_errors = [];

			foreach($items as $item => $rules) {
				$display = $rules['display_name'];
				foreach($rules as $rule => $rule_value) {
					$value = trim($source[$item]);

					if($rule === 'required' && empty($rule_value)) {
						$this->addError(["{$display} is a required field!", $item]);
					} else {
						switch ($rule) {
							case 'min':
								if(strlen($value) < $rule_value) {
									$this->addError(["{$display} must be a minimum of {$rule_value} character!", $item]);
								}
								break;
							case 'max':
								if(strlen($value) > $rule_value) {
									$this->addError(["{$display} can only be a maximum of {$rule_value} character!", $item]);
								}
								break;
							case 'matches':
								if($value != $source[$rule_value]) {
									$match = $items[$rule_value]['display'];
									$this->addError(["{$match}  and {$display} must match!", $item]);
								}
								break;
							case 'unique':
								foreach($rule_value as $key) {
									$table = $key['table'];
									$ident = $key['identifier'];
									$id = $key['id'];
								}
								if($this->select($table, $ident, $id)) {
									$this->addError(["{$$display} already exists in our system!", $item]);
								}
								break;
							case 'is_numeric':
								if(!is_numeric($value)) {
									$this->addError(["{$display} may only contain numbers!", $item]);
								}
								break;
							case 'is_email':
								if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
									$this->addError(["{$display} must be a valid emial!", $item]);
								}
								break;
							default:
								# code...
								break;
						}
					}
				}
			}
		}

		public function addError($erorr) {
			$this->_errors[] = $error;

			if(empty($this->_erorrs)) {
				$this->_passed = true;
			} else {
				$this->_passed = false;
			}
		}

		public function errors() {
			return $this->_errors;
		}

		public function passed() {
			return $this->_passed;
		}

		public function display_errors() {
			if(!empty($this->errors())) {
				$errors = $this->errors();
				echo '<div class="alert alert-danger" role="alert">
					  <h4 class="alert-heading">OOPS!</h4>';
				foreach($erorrs as $error) {
					echo "<p>{$error}</p>";
				}
					  
				echo '<hr>
					  <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
					</div>';
			}
		}
	}
?>