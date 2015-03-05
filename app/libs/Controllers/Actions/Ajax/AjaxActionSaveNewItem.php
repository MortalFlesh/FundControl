<?

class AjaxActionSaveNewItem implements IAjaxAction {
	/** @var JsonPrinter */
	private $JsonPrinter;

	/** @var FlashMessagesFacade */
	private $Flashes;

	/** @var UserAuthorizeFacade */
	private $Authorize;

	/** @var AddNewItemFacade */
	private $AddNewItem;

	private $data = [];
	private $status;

	public function __construct(JsonPrinter $JsonPrinter, FlashMessagesFacade $Flashes, UserAuthorizeFacade $Authorize, AddNewItemFacade $ItemService) {
		$this->JsonPrinter = $JsonPrinter;
		$this->Flashes = $Flashes;
		$this->Authorize = $Authorize;
		$this->AddNewItem = $ItemService;
	}

	public function assignData($data) {
		$this->data = $data;
		return $this;
	}

	public function run() {
		if ($this->Authorize->isLogged()) {
			$userId = $this->Authorize->getUserId();
			$this->trySaveForm($userId);
		} else {
			$this->Flashes->flashError('Login required!');
			$this->status = self::STATUS_ERROR;
		}

		$this->JsonPrinter->printAsJsonAndDie(array('status' => $this->status));
	}

	/** @param int $userId */
	private function trySaveForm($userId) {
		try {
			$messages = $this->AddNewItem
				->saveForm($this->data, $userId)
				->getMessagesAndClear();

			foreach($messages as $message) {
				$this->Flashes->flashSuccess($message);
			}

			$this->status = self::STATUS_OK;
		} catch (SaveNewItemException $Exception) {
			$this->status = self::STATUS_ERROR;
			$this->Flashes->flashError($Exception->getMessage());
		}
	}

}
