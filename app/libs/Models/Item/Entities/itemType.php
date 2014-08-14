<?php

class ItemType {
	const OTHER_TYPE_ID = -1;

	private $id;
	private $name;

	/**
	 * @param int $id
	 * @param string $name
	 */
	public function __construct($id, $name) {
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
