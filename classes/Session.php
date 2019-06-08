<?php 
class Session {
	public static function create($name, $value) {
		return $_SESSION[$name] = $value;
	}

	public static function exists($name) {
		if(isset($_SESSION[$name])) {
			return ture;
		} else {
			return false;
		}
	}

	public static function delete($name) {
		if(self::exists($name)) {
			unset($_SESSION[$name]);
		}
	}
}