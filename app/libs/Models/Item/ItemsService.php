<?php

class ItemsService {
	
	/**
	 * @param string $name
	 * @param ItemType $Type
	 * @param string $amount
	 * @param \DateTime $CreationTime
	 * @return Item
	 */
	public function createItem($name, ItemType $Type, $amount, \DateTime $CreationTime) {
		return new Item($name, $Type, $amount, $CreationTime);
	}

	/**
	 * @param Item[] $items
	 * @return array
	 */
	public function serializeItems(array $items) {
		$serialized = [];

		foreach($items as $key => $Item) {
			$serialized[$key] = $Item->serialize();
		}

		return $serialized;
	}
}
