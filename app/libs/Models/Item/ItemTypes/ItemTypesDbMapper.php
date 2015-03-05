<?php

class ItemTypesDbMapper {
	/** @var Database */
	private $Db;

	private $lastInsertedId;

	/**
	 * @param Database $Db
	 * @param Config $Config
	 */
	public function __construct(Database $Db) {
		$this->Db = $Db;
	}

	/** @param ItemType $Type */
	public function saveNewType(ItemType $Type) {
		$typeId = $this->loadTypeId($Type);
		if ($typeId > 0) {
			$this->lastInsertedId = $typeId;
			return;
		}

		$this->Db->query("INSERT INTO `" . $this->Db->getPrefix() . "item_types` (`name`)
			VALUES ('" . $this->Db->escape($Type->getName()) . "')");

		$this->lastInsertedId = $this->Db->lastInsertedId();
	}

	/**
	 * @param ItemType $Type
	 * @return int
	 */
	private function loadTypeId(ItemType $Type) {
		return (int)$this->Db->queryValue("SELECT `id`
			FROM `" . $this->Db->getPrefix() . "item_types`
			WHERE `name` LIKE '" . $this->Db->escape($Type->getName()) . "'");
	}

	/** @return int */
	public function getNewItemTypeId() {
		return $this->lastInsertedId;
	}

	/** @return ItemType[] */
	public function loadItemTypes() {
		$res = $this->Db->query("SELECT `id`, `name` FROM `" . $this->Db->getPrefix() . "item_types` ORDER BY `name`");
		return $this->fetchAsItemTypes($res);
	}

	/**
	 * @param resource $resource
	 * @return ItemType[]
	 */
	public function fetchAsItemTypes($resource) {
		$itemTypes = [];
		while ($row = $this->Db->fetchAssoc($resource)) {
			$itemTypes[(int)$row['id']] = new ItemType($row['name'], $row['id']);
		}
		return $itemTypes;
	}
}
