<?php

class ItemTypesService {
	/** @var ItemTypesRepository */
	private $ItemTypesRepository;

	/** @param ItemTypesRepository $ItemTypesRepository */
	public function __construct(ItemTypesRepository $ItemTypesRepository) {
		$this->ItemTypesRepository = $ItemTypesRepository;
	}

	/**
	 * @param string $newTypeName
	 * @return ItemTypesService
	 */
	public function saveNewItem($newTypeName) {
		$this->ItemTypesRepository->saveNewItemType($newTypeName);
		return $this;
	}

	/** @return int */
	public function getNewItemTypeId() {
		return $this->ItemTypesRepository->getNewItemTypeId();
	}

	/**
	 * @param bool $force
	 * @return ItemType[]
	 */
	public function getItemTypes($force = false) {
		return $this->ItemTypesRepository->getItemTypes($force);
	}

	/**
	 * @param ItemType[] $itemTypes
	 * @return array
	 */
	public function serializeItemTypes(array $itemTypes) {
		$serializedTypes = array();
		foreach($itemTypes as $key => $Type) {
			$serializedTypes[$key] = $Type->serialize();
		}
		return $serializedTypes;
	}
}
