<?php

class Item {
	private $name;

	/** @var ItemType */
	private $Type;

	private $amount;
	private $createdTime;

	/**
	 * @param string $name
	 * @param ItemType $Type
	 * @param string $amount
	 * @param string $createdTime
	 */
	public function __construct($name, ItemType $Type, $amount, $createdTime) {
		$this->name = $name;
		$this->Type = $Type;
		$this->amount = $amount;
		$this->createdTime = $createdTime;
	}

	public function serialize() {
		$data = array(
			'name' => $this->name,
			'itemType' => $this->Type->serialize(),
			'amount' => $this->amount,
			'createdTime' => $this->createdTime,
		);

		return ArrayFunctions::arrayToJson($data);
	}
}
