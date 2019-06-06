<?php 
class Helpers {
	public static function clean($string) {
		return htmlentities($string, ENT_QUOTES, 'UTF-8');
	}

	public static function has_string_keys(array $array) {
		return count(array_filter(array_keys($array), 'is_string')) > 0;
	}
}