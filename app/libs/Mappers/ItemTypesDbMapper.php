<?php

class ItemTypesDbMapper implements ItemTypesMapper {
	/** @var Database */
	private $Db;

	private $newItemTypeId;

	/** @param Database $Db */
	public function __construct(Database $Db) {
		$this->Db = $Db;
	}

	/**
	 * @param string $itemTypeName
	 * @return ItemTypesDbMapper
	 */
	public function saveNewItemType($itemTypeName) {
		$this->Db->query("INSERT INTO `" . Setup::PREFIX . "item_types` (`name`) VALUES
			('" . $this->Db->escape($itemTypeName) . "')");

		$this->newItemTypeId = $this->Db->lastInsertedId();

		return $this;
	}

	/** @return int */
	public function getNewItemTypeId() {
		return $this->newItemTypeId;
	}

	/** @return ItemType[] */
	public function getItemTypes() {
		$itemTypes = array();

		$res = $this->Db->query("SELECT id, name FROM `" . Setup::PREFIX . "item_types` ORDER BY name");
		while ($row = $this->Db->fetchAssoc($res)) {
			$itemTypes[(int)$row['id']] = new ItemType($row['id'], $row['name']);
		}

		$itemTypes[ItemType::OTHER_TYPE_ID] = new ItemType(ItemType::OTHER_TYPE_ID, 'Other');

		return $itemTypes;
	}

	public function setItemTypes(array $itemTypes) {
		throw new Exception('Not implemented yet: ' . __METHOD__);
	}

}
