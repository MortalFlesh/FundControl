<?php

class ItemTypesService {

	/**
	 * @param string $itemTypeName
	 * @return ItemType
	 */
	public function createNewType($itemTypeName) {
		return new ItemType($itemTypeName);
	}

	/** @param ItemType[] $types */
	public function serializeTypes(array $types) {
		$serialized = [];
		foreach($types as $ItemType) {
			$serialized[] = $ItemType->serialize();
		}
		return $serialized;
	}

	/**
	 * @param int $id
	 * @param string $name
	 * @return ItemType
	 */
	public function createItemType($id, $name) {
		return new ItemType($name, $id);
	}
}
