<?php

class Gain {
	private $name;

	/** @var GainType */
	private $Type;

	private $amount;

	/** @var DateTime */
	private $CreatedTime;

	/**
	 * @param string $name
	 * @param GainType $Type
	 * @param string $amount
	 * @param DateTime $CreatedTime
	 */
	public function __construct($name, GainType $Type, $amount, DateTime $CreatedTime) {
		$this->name = $name;
		$this->Type = $Type;
		$this->amount = $amount;
		$this->CreatedTime = $CreatedTime;
	}

	/** @return DateTime */
	public function getCreatedTime() {
		return $this->CreatedTime;
	}

	/** @return string JSON */
	public function serialize() {
		$data = [
			'name' => $this->name,
			'gainType' => $this->Type->serialize(),
			'amount' => $this->amount,
		];
		
		return ArrayFunctions::arrayToJson($data);
	}
}
