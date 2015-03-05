<?php

class ItemTypesMemMapper {
	private $itemTypes = [];

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
