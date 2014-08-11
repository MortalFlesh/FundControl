<?php

class ItemTypesMemMapper implements ItemTypesMapper {
	private $itemTypes = array();

	public function saveNewItemType($itemTypeName) {
		throw new Exception('Not implemented yet: ' . __METHOD__);
	}

	public function getNewItemTypeId() {
		throw new Exception('Not implemented yet: ' . __METHOD__);
	}

	/** @return ItemType[] */
	public function getItemTypes() {
		return $this->itemTypes;
	}

	/**
	 * @param ItemType[] $itemTypes
	 * @return ItemTypesMemMapper
	 */
	public function setItemTypes(array $itemTypes) {
		$this->itemTypes = $itemTypes;
		return $this;
	}

}
