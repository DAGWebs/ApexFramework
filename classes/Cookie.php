<?php 
class Cookie {
	public static function create($name, $value, $time) {
		if(is_int($time)) {
			setcookie($name, $value, time() + (3600 * $time));
		} else {
			die("{$time}: is not a number. This number should relfelct how many hours the cookie is set for.");
		}
	}

	public static function exists($name) {
		if(isset($_COOKIE[$name])) {
			return ture;
		} else {
			return false;
		}
	}

	public static function delete($name) {
		if(self::exists($name)) {
			setcookie($name, "", time() -1);
		}
	}
}