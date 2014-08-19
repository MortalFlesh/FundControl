<?php

class ItemsRepository {

	/** @var ItemsDbMapper */
	private $ItemsDbMapper;

	/** @param ItemsDbMapper $ItemsDbMapper */
	public function __construct(ItemsDbMapper $ItemsDbMapper) {
		$this->ItemsDbMapper = $ItemsDbMapper;
	}

	/**
	 * @param Item $Item
	 * @param int $userId
	 * @return ItemsRepository
	 */
	public function saveItem(Item $Item, $userId) {
		$this->ItemsDbMapper->saveItem($Item, $userId);
		return $this;
	}

	/**
	 * @param type $userId
	 * @return Item[]
	 */
	public function getItems($userId) {
		return $this->ItemsDbMapper->getItems($userId);
	}
}
