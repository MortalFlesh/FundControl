<?php

class Item {
	private $name;
	private $type;
	private $amount;
	private $createdTime;

	/**
	 * @param string $name
	 * @param string $type
	 * @param string $amount
	 * @param string $createdTime
	 */
	public function __construct($name, $type, $amount, $createdTime) {
		$this->name = $name;
		$this->type = $type;
		$this->amount = $amount;
		$this->createdTime = $createdTime;
	}

	public function serialize() {
		$data = array(
			'name' => $this->name,
			'type' => $this->type,
			'amount' => $this->amount,
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
