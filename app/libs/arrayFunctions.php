<?

class ArrayFunctions {
	public static function isArray($array) {
		return is_array($array);
	}

	public static function initArray(&$array) {
		if (!self::isArray($array)) {
			$array = array();
		}
	}

	public static function isArrayAndHasItems($array) {
		return (self::isArray($array) && count($array) > 0);
	}
}