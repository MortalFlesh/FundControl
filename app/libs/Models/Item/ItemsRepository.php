<?php

class ItemsRepository {

	/** @var ItemsDbMapper */
	private $DbMapper;

	/** @param ItemsDbMapper $ItemsDbMapper */
	public function __construct(ItemsDbMapper $ItemsDbMapper) {
		$this->DbMapper = $ItemsDbMapper;
	}

	/**
	 * @param Item $Item
	 * @param int $userId
	 * @return ItemsRepository
	 */
	public function saveItem(Item $Item, $userId) {
		$this->DbMapper->saveItem($Item, $userId);
		return $this;
	}

	/**
	 * @param type $userId
	 * @return Item[]
	 */
	public function getItems($userId) {
		return $this->DbMapper->loadItems($userId);
	}
}
