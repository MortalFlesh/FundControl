<?php

class AddNewItemFacade {
	/** @var ItemsService */
	private $ItemsService;

	/** @var ItemsRepository */
	private $ItemsRepository;

	/** @var AddNewItemTypeFacade */
	private $AddNewItemType;

	/** @var ItemTypesRepository */
	private $ItemTypesRepository;

	private $userId, $newItemTypeId;
	private $data = [];

	private $messages = [];

	public function __construct(
		ItemsService $ItemsService,
		ItemsRepository $ItemsRepository,
		AddNewItemTypeFacade $AddNewItemType,
		ItemTypesRepository $ItemTypesRepository
	) {
		$this->ItemsService = $ItemsService;
		$this->ItemsRepository = $ItemsRepository;
		$this->AddNewItemType = $AddNewItemType;
		$this->ItemTypesRepository = $ItemTypesRepository;
	}

	/**
	 * @param array $data
	 * @param int $userId
	 * @return AddNewItemFacade
	 */
	public function saveForm(array $data, $userId) {
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
	 * @return AddNewItemFacade
	 */
	private function setUserId($userId) {
		if (empty($userId) || $userId <= 0) {
			$this->error('Not logged!');
		}
		$this->userId = $userId;
		return $this;
	}

	/**
	 * @param string $message
	 * @throws SaveNewItemException
	 */
	private function error($message) {
		throw new SaveNewItemException($message);
	}

	/**
	 * @param array $data
	 * @return AddNewItemFacade
	 */
	private function assignData(array $data) {
		if (empty($data)) {
			$this->error('Form is empty!');
		}
		$this->data = $data;
		return $this;
	}

	/** @return AddNewItemFacade */
	private function validateNewItemType() {
		$typeIdEmpty = empty($this->data['itemType']['id']);
		$otherSelected = (!$typeIdEmpty && (int)$this->data['itemType']['id'] === ItemType::OTHER_TYPE_ID);
		$newTypeNameEmpty = empty($this->data['newTypeName']);

		if (($typeIdEmpty || $otherSelected) && $newTypeNameEmpty) {
			$this->error('New type name is needed!');
		}

		return $this;
	}

	/** @return AddNewItemFacade */
	private function prepareAndSaveNewType() {
		if (!empty($this->data['newTypeName'])) {
			$this->newItemTypeId = $this->AddNewItemType
				->saveNewType($this->data['newTypeName'])
				->getNewTypeId();

			$this->messages[] = 'New type was added.';
		}
		return $this;
	}

	/** @return AddNewItemFacade */
	private function validateNewItem() {
		if (empty($this->data['name'])) {
			$this->error('Empty item name!');
		}
		if (empty($this->data['amount'])) {
			$this->error('Empty item amount!');
		}
		return $this;
	}

	/** @return AddNewItemFacade */
	private function prepareAndSaveItem() {
		$itemTypes = $this->ItemTypesRepository->getItemTypes();

		$typeId = (int)$this->data['itemType']['id'];
		if ($typeId === ItemType::OTHER_TYPE_ID && !empty($this->newItemTypeId)) {
			$typeId = $this->newItemTypeId;
		}

		if (!isset($itemTypes[$typeId])) {
			$this->error('Wrong type (' . $typeId . ')');
		}

		$Item = $this->ItemsService->createItem(
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
}

