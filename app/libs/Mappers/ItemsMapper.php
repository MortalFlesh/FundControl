<?php

interface ItemsMapper {
	/**
	 * @param Item $Item
	 * @param string $userId
	 * @return ItemsMapper
	 */
	function saveItem(Item $Item, $userId);

	/**
	 * @param type $userId
	 * @return Item[]
	 */
	function getItems($userId);
}
