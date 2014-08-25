<?php

class ItemsFacade {
	/** @var ItemsService */
	private $Service;

	/** @var ItemsRepository */
	private $Repository;

	public function __construct(ItemsService $Service, ItemsRepository $Repository) {
		$this->Service = $Service;
		$this->Repository = $Repository;
	}

	/**
	 * @param int $userId
	 * @return Item[]
	 */
	public function getSerializedItemsFor($userId) {
		$items = $this->Repository->getItems($userId);
		return $this->Service->serializeItems($items);
	}
}
