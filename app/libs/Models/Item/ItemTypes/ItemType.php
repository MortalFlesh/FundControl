<?php

class ItemType {
	const OTHER_TYPE_ID = -1;

	private $id;
	private $name;

	/**
	 * @param string $name
	 * @param int $id
	 */
	public function __construct($name, $id = 0) {
		$this->id = (int)$id;
		$this->name = $name;
	}

	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function serialize() {
		$data = array(
			'id' => $this->getId(),
			'name' => $this->getName(),
		);
		return ArrayFunctions::arrayToJson($data);
	}
}
