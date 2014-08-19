<?php

class ItemsService {

	/** @var ItemsRepository */
	private $ItemsRepository;

	/** @var ItemTypesService */
	private $ItemTypesService;

	private $data = [];
	private $messages = [];
	private $newItemTypeId, $userId;

	/**
	 * @param ItemsRepository $ItemsRepository
	 * @param ItemTypesService $ItemTypesService
	 */
	public function __construct(ItemsRepository $ItemsRepository, ItemTypesService $ItemTypesService) {
		$this->ItemsRepository = $ItemsRepository;
		$this->ItemTypesService = $ItemTypesService;
	}

	/**
	 * @param int $userId
	 * @param array $data
	 * @return ItemsService
	 */
	public function saveItemForm($userId, array $data) {
		$this
			->setUserId($userId)
			->assignData($data)
			->validateNewItemType()
			->prepareAndSaveNewType()
			->validateNewItem()
			->prepareAndSaveItem();
		return $this;
	}

	/**
	 * @param int $userId
	 * @return ItemsService
	 */
	private function setUserId($userId) {
		if (empty($userId) || $userId <= 0) {
			$this->error('Not logged!');
		}
		$this->userId = $userId;
		return $this;
	}

	/**
	 * @param array $data
	 * @return ItemsService
	 */
	private function assignData(array $data) {
		if (empty($data)) {
			$this->error('Form is empty!');
		}
		$this->data = $data;
		return $this;
	}

	/**
	 * @param string $message
	 * @throws SaveNewItemException
	 */
	private function error($message) {
		throw new SaveNewItemException($message);
	}

	/** @return ItemsService */
	private function validateNewItemType() {
		$itemTypeIdEmpty = empty($this->data['itemType']['id']);
		$otherSelected = (!$itemTypeIdEmpty && (int)$this->data['itemType']['id'] === ItemType::OTHER_TYPE_ID);
		$newTypeNameEmpty = empty($this->data['newTypeName']);

		if (($itemTypeIdEmpty || $otherSelected) && $newTypeNameEmpty) {
			$this->error('New type name is needed!');
		}

		return $this;
	}

	/** @return ItemsService */
	private function prepareAndSaveNewType() {
		if (!empty($this->data['newTypeName'])) {
			$this->newItemTypeId = $this->ItemTypesService
				->saveNewItem($this->data['newTypeName'])
				->getNewItemTypeId();

			$this->messages[] = 'New type was added.';
		}
		return $this;
	}

	/** @return ItemsService */
	private function validateNewItem() {
		if (empty($this->data['name'])) {
			$this->error('Empty item name!');
		}
		if (empty($this->data['amount'])) {
			$this->error('Empty item amount!');
		}
		return $this;
	}

	/** @return ItemsService */
	private function prepareAndSaveItem() {
		$itemTypes = $this->ItemTypesService->getItemTypes(true);

		$typeId = (int)$this->data['itemType']['id'];
		if ($typeId === ItemType::OTHER_TYPE_ID && !empty($this->newItemTypeId)) {
			$typeId = $this->newItemTypeId;
		}

		if (!isset($itemTypes[$typeId])) {
			$this->error('Wrong type (' . $typeId . ')');
		}

		$Item = new Item(
			$this->data['name'],
			$itemTypes[$typeId],
			$this->data['amount'],
			new \DateTime()
		);

		$this->ItemsRepository->saveItem($Item, $this->userId);

		$this->messages[] = 'Item added.';
		return $this;
	}

	/** @return array */
	public function getMessagesAndClear() {
		$messages = $this->messages;
		$this->messages = [];
		return $messages;
	}

	/**
	 * @param type $userId
	 * @return Item[]
	 */
	public function getItems($userId) {
		return $this->ItemsRepository->getItems($userId);
	}

	/**
	 * @param Item[] $items
	 * @return array
	 */
	public function serializeItems(array $items) {
		$serializedItems = [];
		foreach($items as $key => $Item) {
			$serializedItems[$key] = $Item->serialize();
		}
		return $serializedItems;
	}
}
