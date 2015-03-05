<?php

class AddNewGainFacade {
	/** @var GainsService */
	private $GainsService;

	/** @var GainsRepository */
	private $GainsRepository;

	/** @var AddNewGainTypeFacade */
	private $AddNewGainType;

	/** @var GainTypesRepository */
	private $GainTypesRepository;

	private $userId, $newGainTypeId;
	private $data = [];

	private $messages = [];

	public function __construct(
		GainsService $GainsService,
		GainsRepository $GainsRepository,
		AddNewGainTypeFacade $AddNewGainType,
		GainTypesRepository $GainTypesRepository
	) {
		$this->GainsService = $GainsService;
		$this->GainsRepository = $GainsRepository;
		$this->AddNewGainType = $AddNewGainType;
		$this->GainTypesRepository = $GainTypesRepository;
	}

	/**
	 * @param array $data
	 * @param int $userId
	 * @return AddNewGainFacade
	 */
	public function saveForm(array $data, $userId) {
		$this
			->setUserId($userId)
			->assignData($data)
			->validateNewGainType()
			->prepareAndSaveNewType()
			->validateNewItem()
			->prepareAndSaveItem();
		return $this;
	}

	/**
	 * @param int $userId
	 * @return AddNewGainFacade
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
	 * @throws SaveNewGainException
	 */
	private function error($message) {
		throw new SaveNewGainException($message);
	}

	/**
	 * @param array $data
	 * @return AddNewGainFacade
	 */
	private function assignData(array $data) {
		if (empty($data)) {
			$this->error('Form is empty!');
		}
		$this->data = $data;
		return $this;
	}

	/** @return AddNewGainFacade */
	private function validateNewGainType() {
		$typeIdEmpty = empty($this->data['gainType']['id']);
		$otherSelected = (!$typeIdEmpty && (int)$this->data['gainType']['id'] === GainType::OTHER_TYPE_ID);
		$newTypeNameEmpty = empty($this->data['newTypeName']);

		if (($typeIdEmpty || $otherSelected) && $newTypeNameEmpty) {
			$this->error('New type name is needed!');
		}

		return $this;
	}

	/** @return AddNewGainFacade */
	private function prepareAndSaveNewType() {
		if (!empty($this->data['newTypeName'])) {
			$this->newGainTypeId = $this->AddNewGainType
				->saveNewType($this->data['newTypeName'])
				->getNewTypeId();

			$this->messages[] = 'New type was added.';
		}
		return $this;
	}

	/** @return AddNewGainFacade */
	private function validateNewItem() {
		if (empty($this->data['name'])) {
			$this->error('Empty gain name!');
		}
		if (empty($this->data['amount'])) {
			$this->error('Empty gain amount!');
		}
		return $this;
	}

	/** @return AddNewGainFacade */
	private function prepareAndSaveItem() {
		$gainTypes = $this->GainTypesRepository->getGainTypes();

		$typeId = (int)$this->data['gainType']['id'];
		if ($typeId === GainType::OTHER_TYPE_ID && !empty($this->newGainTypeId)) {
			$typeId = $this->newGainTypeId;
		}

		if (!isset($gainTypes[$typeId])) {
			$this->error('Wrong type (' . $typeId . ')');
		}

		$Gain = $this->GainsService->createGain(
			$this->data['name'],
			$gainTypes[$typeId],
			$this->data['amount'],
			new \DateTime()
		);

		$this->GainsRepository->saveGain($Gain, $this->userId);

		$this->messages[] = 'Gain added.';
		return $this;
	}

	/** @return array */
	public function getMessagesAndClear() {
		$messages = $this->messages;
		$this->messages = [];
		return $messages;
	}
}
