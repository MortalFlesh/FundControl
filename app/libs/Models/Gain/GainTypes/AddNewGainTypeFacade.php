<?php

class AddNewGainTypeFacade {

	/** @var GainTypesService */
	private $Service;
	
	/** @var GainTypesRepository */
	private $Repository;

	public function __construct(GainTypesService $Service, GainTypesRepository $Repository) {
		$this->Service = $Service;
		$this->Repository = $Repository;
	}

	/**
	 * @param string $gainTypeName
	 * @return AddNewGainTypeFacade
	 */
	public function saveNewType($gainTypeName) {
		$GainType = $this->Service->createNewType($gainTypeName);
		$this->Repository->saveNewType($GainType);
		return $this;
	}

	/** @return int */
	public function getNewTypeId() {
		return $this->Repository->getNewItemTypeId();
	}
}
