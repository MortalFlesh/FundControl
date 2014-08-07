<?php

class Item {
	private $name;
	private $type;
	private $value;
	private $createdTime;

	/**
	 * @param string $name
	 * @param string $type
	 * @param string $value
	 * @param string $createdTime
	 */
	public function __construct($name, $type, $value, $createdTime) {
		$this->name = $name;
		$this->type = $type;
		$this->value = $value;
		$this->createdTime = $createdTime;
	}

	public function serialize() {
		$data = array(
			'name' => $this->name,
			'type' => $this->type,
			'value' => $this->value,
			'createdTime' => $this->createdTime,
		);

		return $this->arrayToJson($data);
	}

	private function arrayToJson(array $array) {
		$jsonArray = array();
		foreach($array as $id => $value) {
			if (is_array($value)) {
				$value = $this->arrayToJson($value);
			} else {
				$value = '"' . $value . '"';
			}
			$jsonArray[] = '"' . $id . '":' . $value;
		}
		return '{' . implode(',', $jsonArray) . '}';
	}
}
