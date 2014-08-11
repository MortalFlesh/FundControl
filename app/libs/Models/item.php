<?php

class Item {
	private $name;

	/** @var ItemType */
	private $Type;

	private $amount;

	/** @var \DateTime */
	private $CreatedTime;

	/**
	 * @param string $name
	 * @param ItemType $Type
	 * @param string $amount
	 * @param \DateTime $CreatedTime
	 */
	public function __construct($name, ItemType $Type, $amount, \DateTime $CreatedTime) {
		$this->name = $name;
		$this->Type = $Type;
		$this->amount = $amount;
		$this->CreatedTime = $CreatedTime;
	}

	public function getCreatedTime() {
		return $this->CreatedTime;
	}

	public function serialize() {
		$data = array(
			'name' => $this->name,
			'itemType' => $this->Type->serialize(),
			'amount' => $this->amount,
		);

		return ArrayFunctions::arrayToJson($data);
	}
}
