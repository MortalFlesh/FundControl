<?php

use \DateTime;

class Item {
    private $name;

	/** @var ItemType */
	private $Type;

	private $amount;

	/** @var DateTime */
	private $CreatedTime;

	/**
	 * @param string $name
	 * @param ItemType $Type
	 * @param string $amount
	 * @param \DateTime $CreatedTime
	 */
	public function __construct($name, ItemType $Type, $amount, DateTime $CreatedTime) {
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
			'time' => $this->serializeTime($this->CreatedTime),
		);

		return ArrayFunctions::arrayToJson($data);
	}

    /**
     * @param DateTime $Time
     * @return array
     */
    private function serializeTime(DateTime $Time){
        return [
            'day' => $Time->format('d'),
            'month' => $Time->format('m'),
            'year' => $Time->format('Y'),
            'hour' => $Time->format('H'),
            'minute' => $Time->format('i'),
            'second' => $Time->format('s'),
        ];
    }
}
