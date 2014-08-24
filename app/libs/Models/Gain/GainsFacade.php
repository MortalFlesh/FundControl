<?php

class GainsFacade {
	/** @var GainsService */
	private $Service;

	/** @var GainsRepository */
	private $Repository;

	public function __construct(GainsService $Service, GainsRepository $Repository) {
		$this->Service = $Service;
		$this->Repository = $Repository;
	}

	/**
	 * @param int $userId
	 * @return Gain[]
	 */
	public function getSerializedGainsFor($userId) {
		$gains = $this->Repository->getGains($userId);
		return $this->Service->serializeGains($gains);
	}
}
