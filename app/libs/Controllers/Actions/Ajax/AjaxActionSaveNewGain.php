<?php

class AjaxActionSaveNewGain implements IAjaxAction {
	const STATUS_OK = 'OK';
	const STATUS_ERROR = 'ERROR';

	/** @var AddNewGainFacade */
	private $AddNewGain;
	
	/** @var FlashMessagesFacade */
	private $Flashes;

	/** @var JsonPrinter */
	private $JsonPrinter;

	/** @var UserAuthorizeFacade */
	private $Authorize;

	/** @var array */
	private $data;

	private $status;

	public function __construct(
		AddNewGainFacade $AddNewGain,
		FlashMessagesFacade $Flashes,
		JsonPrinter $JsonPrinter,
		UserAuthorizeFacade $Authorize
	) {
		$this->AddNewGain = $AddNewGain;
		$this->Flashes = $Flashes;
		$this->JsonPrinter = $JsonPrinter;
		$this->Authorize = $Authorize;
	}

	public function assignData(array $data) {
		$this->data = $data;
		return $this;
	}

	public function run() {
		if ($this->Authorize->isLogged()) {
			$userId = $this->Authorize->getUserId();
			$this->trySaveForm($userId);
		}

		$this->JsonPrinter->printAsJsonAndDie(['status' => $this->status]);
	}

	private function trySaveForm($userId) {
		try {
			$messages = $this->AddNewGain
				->saveForm($this->data, $userId)
				->getMessageAndClear();

			foreach($messages as $message) {
				$this->Flashes->flashSuccess($message);
			}

			$this->status = self::STATUS_OK;
		} catch (SaveNewGainException $Exception) {
			$this->status = self::STATUS_ERROR;
			$this->Flashes->flashError($Exception->getMessage());
		}
	}
}
