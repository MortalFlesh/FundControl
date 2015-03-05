<?php

class GainTypesFacade {
	/** @var GainTypesService */
	private $Service;

	/** @var GainTypesRepository */
	private $Repository;

	/**
	 * @param GainTypesService $Service
	 * @param GainTypesRepository $Repository
	 */
	public function __construct(GainTypesService $Service, GainTypesRepository $Repository) {
		$this->Service = $Service;
		$this->Repository = $Repository;
	}

	/** @return array */
	public function getSerializedGainTypes() {
		$types = $this->Repository->getGainTypes();
		$types[GainType::OTHER_TYPE_ID] = $this->Service->createGainType(GainType::OTHER_TYPE_ID, 'Other');
		return $this->Service->serializeTypes($types);
	}
}
