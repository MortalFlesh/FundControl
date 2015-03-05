<?php

class AddNewItemTypeFacade {
	/** @var ItemTypesService */
	private $Service;

	/** @var ItemTypesRepository */
	private $Repository;

	public function __construct(ItemTypesService $Service, ItemTypesRepository $Repository) {
		$this->Service = $Service;
		$this->Repository = $Repository;
	}

	/**
	 * @param string $itemTypeName
	 * @return AddNewItemTypeFacade
	 */
	public function saveNewType($itemTypeName) {
		$ItemType = $this->Service->createNewType($itemTypeName);
		$this->Repository->saveNewType($ItemType);
		return $this;
	}

	/** @return int */
	public function getNewTypeId() {
		return $this->Repository->getNewItemTypeId();
	}
}
