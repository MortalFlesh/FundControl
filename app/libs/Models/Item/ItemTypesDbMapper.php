<?php

class ItemTypesDbMapper implements ItemTypesMapper {
	/** @var Database */
	private $Db;

	private $newItemTypeId;

	/** @var Config */
	private $Config;

	/**
	 * @param Database $Db
	 * @param Config $Config
	 */
	public function __construct(Database $Db, Config $Config) {
		$this->Db = $Db;
		$this->Config = $Config;
	}

	/**
	 * @param string $itemTypeName
	 * @return ItemTypesDbMapper
	 */
	public function saveNewItemType($itemTypeName) {
		$typeId = $this->loadTypeId($itemTypeName);
		if ($typeId > 0) {
			$this->newItemTypeId = $typeId;
			return;
		}

		$this->Db->query("INSERT INTO `" . $this->Config->getPrefix() . "item_types` (`name`) VALUES
			('" . $this->Db->escape($itemTypeName) . "')");

		$this->newItemTypeId = $this->Db->lastInsertedId();

		return $this;
	}

	/**
	 * @param string $itemTypeName
	 * @return int
	 */
	private function loadTypeId($itemTypeName) {
		return (int)$this->Db->queryValue("SELECT `id`
			FROM `" . $this->Db->getPrefix() . "item_types`
			WHERE `name` LIKE '" . $this->Db->escape($itemTypeName) . "'");
	}

	/** @return int */
	public function getNewItemTypeId() {
		return $this->newItemTypeId;
	}

	/** @return ItemType[] */
	public function getItemTypes() {
		$itemTypes = [];

		$res = $this->Db->query("SELECT id, name FROM `" . $this->Config->getPrefix() . "item_types` ORDER BY name");
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
