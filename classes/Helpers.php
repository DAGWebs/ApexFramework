<?php 
class Helpers {
	/**
	 *
	 * Clean function cleans the html
	 *
	 */
	
	public static function clean($string) {
		return htmlentities($string, ENT_QUOTES, 'UTF-8');
	}

	/**
	 *
	 * has_string_keys determins the array type
	 *
	 */
	

	public static function has_string_keys(array $array) {
		return count(array_filter(array_keys($array), 'is_string')) > 0;
	}

	/*=============================================
	=            Form Helpers comment block       =
	=============================================*/

	//NOTE ALL FORMS FUNCTIONS RELIEY ON BOOTSTRAP

	/**
	 *
	 * Gets an imput only requires type and name
	 * autocomplete is off by default
	 *
	 */
	

	public static function getImput($type, $name, $classes=[], $value='', $id='', $autocomplete='off') {
		$className = '';

		if(!empty($classes)) {
			foreach($classes as $class) {
				$className .= $class . " ";
			}
			$className = rtrim($className, " ");
		}
		$input = "<input type='{$type}' name='{$name}' ";
		$input .= "class='{$className}' value='{$value}' ";
		$input .= "id='{$id}' autocomplete='{$autocomplete}'>";

		echo "<div class='form-group'>";
		echo $input;
		echo "</div>";
	}

	/**
	 *
	 * creates a select field needs name id
	 * options should be in array form only
	 *
	 */
	
	
	public static function getSelect($name, $id, $options) {
		if(!is_array($options)) {
			die("The options for the getSelect method must be an array");
		} else {
			$optionString = '';
			foreach($options as $option) {
				$optionString .= "<option value='{$option}'>{$option}</option>";
			}

			echo "<div class='form-group'>";
			echo "<select name='{$name}' id='{$id}'>";
			echo $optionString;
			echo "</select>";
			echo "</div>";
		}
	}

	public static function token() {
		$token = md5(uniqid());
		Session::create('token', $token);
		$input = "<input type='hidden' value='{$token}'>";
		echo $input;
	}
}

/*=====  End of Form Helpers comment block  ======*/