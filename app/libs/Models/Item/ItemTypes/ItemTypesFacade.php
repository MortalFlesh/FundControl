<?php

class ItemTypesFacade {
	/** @var ItemTypesService */
	private $Service;

	/** @var ItemTypesRepository */
	private $Repository;

	/**
	 * @param ItemTypesService $Service
	 * @param ItemTypesRepository $Repository
	 */
	public function __construct(ItemTypesService $Service, ItemTypesRepository $Repository) {
		$this->Service = $Service;
		$this->Repository = $Repository;
	}

	/** @return array */
	public function getSerializedItemTypes() {
		$types = $this->Repository->getItemTypes();
		$types[ItemType::OTHER_TYPE_ID] = $this->Service->createItemType(ItemType::OTHER_TYPE_ID, 'Other');
		return $this->Service->serializeTypes($types);
	}
}
