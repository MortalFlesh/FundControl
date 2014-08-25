<?php

class ItemTypesRepository {

	/** @var ItemTypesDbMapper */
	private $DbMapper;

	/** @var ItemTypesMemMapper */
	private $MemMapper;
	private $itemTypesInMemory = false;

	/**
	 * @param ItemTypesDbMapper $ItemTypesDbMapper
	 * @param ItemTypesMemMapper $ItemTypeMemMapper
	 */
	public function __construct(ItemTypesDbMapper $ItemTypesDbMapper, ItemTypesMemMapper $ItemTypeMemMapper) {
		$this->DbMapper = $ItemTypesDbMapper;
		$this->MemMapper = $ItemTypeMemMapper;
	}

	/**
	 * @param ItemType $Type
	 * @return ItemTypesRepository
	 */
	public function saveNewType(ItemType $Type) {
		$this->DbMapper->saveNewType($Type);
		$this->itemTypesInMemory = false;
		return $this;
	}

	/** @return int */
	public function getNewItemTypeId() {
		return $this->DbMapper->getNewItemTypeId();
	}

	/** @return ItemType[] */
	public function getItemTypes() {
		if(!$this->itemTypesInMemory) {
			$this->itemTypesInMemory = true;

			$itemTypes = $this->DbMapper->loadItemTypes();
			$this->MemMapper->setItemTypes($itemTypes);
		}
		return $this->MemMapper->getItemTypes();
	}
}
