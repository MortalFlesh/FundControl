<?php

interface ItemTypesMapper {
	/**
	 * @param string $itemTypeName
	 * @return ItemTypesMapper
	 */
	function saveNewItemType($itemTypeName);

	/** @return int */
	function getNewItemTypeId();

	/**
	 * @param ItemType[] $itemTypes
	 * @return ItemTypesMapper
	 */
	function setItemTypes(array $itemTypes);

	/** @return ItemType[] */
	function getItemTypes();
}
