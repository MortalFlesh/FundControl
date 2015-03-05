<?php

class GainTypesDbMapper {
	/** @var Database */
	private $Db;

	private $lastInsertedId;

	/** @param Database $Db */
	public function __construct(Database $Db) {
		$this->Db = $Db;
	}

	/** @param GainType $Type */
	public function saveNewType(GainType $Type) {
		$typeId = $this->loadTypeId($Type);
		if ($typeId > 0) {
			$this->lastInsertedId = $typeId;
			return;
		}

		$this->Db->query("INSERT INTO `" . $this->Db->getPrefix() . "gain_types` (`name`)
			VALUES ('" . $this->Db->escape($Type->getName()) . "')");

		$this->lastInsertedId = $this->Db->lastInsertedId();
	}

	/**
	 * @param GainType $Type
	 * @return int
	 */
	private function loadTypeId(GainType $Type) {
		return (int)$this->Db->queryValue("SELECT `id`
			FROM `" . $this->Db->getPrefix() . "gain_types`
			WHERE `name` LIKE '" . $this->Db->escape($Type->getName()) . "'");
	}

	/** @return int */
	public function getNewItemTypeId() {
		return $this->lastInsertedId;
	}

	/** @return GainType[] */
	public function loadGainTypes() {
		$res = $this->Db->query("SELECT `id`, `name` FROM `" . $this->Db->getPrefix() . "gain_types` ORDER BY `name`");
		return $this->fetchAsGainTypes($res);
	}

	/**
	 * @param resource $resource
	 * @return GainType[]
	 */
	private function fetchAsGainTypes($resource) {
		$types = [];

		while($row = $this->Db->fetchAssoc($resource)) {
			$id = $row['id'];
			$name = $row['name'];

			$types[$id] = new GainType($name, $id);
		}

		return $types;
	}
}
