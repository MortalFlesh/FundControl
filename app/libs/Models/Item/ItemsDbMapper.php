<?php

class ItemsDbMapper {

	/** @var Database */
	private $Db;

	/**
	 * @param Database $Db
	 * @param Config $Config
	 */
	public function __construct(Database $Db) {
		$this->Db = $Db;
	}

	/**
	 * @param Item $Item
	 * @param int $userId
	 * @return ItemsDbMapper
	 */
	public function saveItem(Item $Item, $userId) {
		$itemData = $Item->serialize();
		$Time = $Item->getCreatedTime();

		$this->Db->query("INSERT INTO `" . $this->Db->getPrefix() . "items` (`user_id`, `item_data`, `time`) VALUES
			('" . (int)$userId . "', '" . $this->Db->escape($itemData) . "', '" . $Time->format(Database::TIME_FORMAT) . "')");

		return $this;
	}

	/**
	 * @param int $userId
	 * @return Item[]
	 */
	public function loadItems($userId) {
		$items = [];

		$res = $this->Db->query("SELECT `id`, `item_data`, `time`
			FROM `" . $this->Db->getPrefix() . "items`
			WHERE user_id = " . (int)$userId);

		while($row = $this->Db->fetchAssoc($res)) {
			$itemData = json_decode($row['item_data'], true);

			$Item = new Item(
				$itemData['name'],
				new ItemType(
					$itemData['itemType']['name'],
					$itemData['itemType']['id']
				),
				$itemData['amount'],
				\DateTime::createFromFormat(Database::TIME_FORMAT, $row['time'])
			);

			$items[$row['id']] = $Item;
		}

		return $items;
	}

}
