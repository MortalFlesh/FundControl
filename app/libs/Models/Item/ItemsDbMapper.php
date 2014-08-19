<?php

class ItemsDbMapper implements ItemsMapper {

	/** @var Database */
	private $Db;

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
	 * @param Item $Item
	 * @param int $userId
	 * @return ItemsDbMapper
	 */
	public function saveItem(Item $Item, $userId) {
		$itemData = $Item->serialize();
		$Time = $Item->getCreatedTime();

		$this->Db->query("INSERT INTO `" . $this->Config->getPrefix() . "items` (`user_id`, `item_data`, `time`) VALUES
			('" . (int)$userId . "', '" . $this->Db->escape($itemData) . "', '" . $Time->format(Database::TIME_FORMAT) . "')");

		return $this;
	}

	/**
	 * @param int $userId
	 * @return Item[]
	 */
	public function getItems($userId) {
		$items = [];

		$res = $this->Db->query("SELECT `id`, `item_data`, `time`
			FROM `" . $this->Config->getPrefix() . "items`
			WHERE user_id = " . (int)$userId);

		while($row = $this->Db->fetchAssoc($res)) {
			$itemData = json_decode($row['item_data'], true);

			$Item = new Item(
				$itemData['name'],
				new ItemType(
					$itemData['itemType']['id'],
					$itemData['itemType']['name']
				),
				$itemData['amount'],
				\DateTime::createFromFormat(Database::TIME_FORMAT, $row['time'])
			);

			$items[$row['id']] = $Item;
		}

		return $items;
	}

}
