<?

class ArrayFunctions {
	public static function isArray($array) {
		return is_array($array);
	}

	public static function initArray(&$array) {
		if (!self::isArray($array)) {
			$array = [];
		}
	}

	public static function isArrayAndHasItems($array) {
		return (self::isArray($array) && count($array) > 0);
	}

	public static function arrayToJson(array $array) {
		$jsonArray = [];
		foreach($array as $id => $value) {
			if (is_array($value)) {
				$value = self::arrayToJson($value);
			} elseif (!self::isJson($value)) {
				$value = '"' . $value . '"';
			}
			$jsonArray[] = '"' . $id . '":' . $value;
		}
		return '{' . implode(',', $jsonArray) . '}';
	}

	private static function isJson($value) {
		return (substr($value, 0, 1) === '{' && substr($value, -1, 1) === '}');
	}
}