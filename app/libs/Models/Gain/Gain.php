<?php

use \DateTime;

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
			'time' => $this->serializeTime($this->CreatedTime),
		];
		
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
