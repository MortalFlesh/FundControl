<?php

class GainTypesRepository {
	/** @var GainTypesDbMapper */
	private $DbMapper;

	/** @param GainTypesDbMapper $DbMapper */
	public function __construct(GainTypesDbMapper $DbMapper) {
		$this->DbMapper = $DbMapper;
	}

	/**
	 * @param GainType $Type
	 * @return GainTypesRepository
	 */
	public function saveNewType(GainType $Type) {
		$this->DbMapper->saveNewType($Type);
		return $this;
	}

	/** @return int */
	public function getNewItemTypeId() {
		return $this->DbMapper->getNewItemTypeId();
	}

	/** @return GainType[] */
	public function getGainTypes() {
		return $this->DbMapper->loadGainTypes();
	}
}
