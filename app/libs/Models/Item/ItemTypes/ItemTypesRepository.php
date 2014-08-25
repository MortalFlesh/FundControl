<?php

class ItemTypesRepository {

	/** @var ItemTypesDbMapper */
	private $ItemTypesDbMapper;

	/** @var ItemTypesMemMapper */
	private $ItemTypeMemMapper;

	private $itemTypesInMemory = false;

	/**
	 * @param ItemTypesDbMapper $ItemTypesDbMapper
	 * @param ItemTypesMemMapper $ItemTypeMemMapper
	 */
	public function __construct(ItemTypesDbMapper $ItemTypesDbMapper, ItemTypesMemMapper $ItemTypeMemMapper) {
		$this->ItemTypesDbMapper = $ItemTypesDbMapper;
		$this->ItemTypeMemMapper = $ItemTypeMemMapper;
	}

	/**
	 * @param string $newItemTypeName
	 * @return ItemTypesRepository
	 */
	public function saveNewItemType($newItemTypeName) {
		$this->ItemTypesDbMapper->saveNewItemType($newItemTypeName);
		return $this;
	}

	/** @return int */
	public function getNewItemTypeId() {
		return $this->ItemTypesDbMapper->getNewItemTypeId();
	}

	/**
	 * @param bool $force
	 * @return ItemType[]
	 */
	public function getItemTypes($force = false) {
		if(!$this->itemTypesInMemory || $force) {
			$this->itemTypesInMemory = true;

			$itemTypes = $this->ItemTypesDbMapper->getItemTypes();
			$this->ItemTypeMemMapper->setItemTypes($itemTypes);
		}
		return $this->ItemTypeMemMapper->getItemTypes();
	}
}
