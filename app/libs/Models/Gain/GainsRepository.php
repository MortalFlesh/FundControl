<?php

class GainsRepository {
	
	/** @var GainsDbMapper */
	private $DbMapper;

	public function __construct(GainsDbMapper $DbMapper) {
		$this->DbMapper = $DbMapper;
	}

	/**
	 * @param Gain $Gain
	 * @param int $userId
	 */
	public function saveGain(Gain $Gain, $userId) {
		$this->DbMapper->saveGain($Gain, $userId);
		return $this;
	}
}
