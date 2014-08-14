<?

class AjaxActionSaveNewItem implements IAjaxAction {
	/** @var JsonPrinter */
	private $JsonPrinter;

	/** @var FlashMessagesFacade */
	private $Flashes;

	/** @var UserAuthorizeFacade */
	private $Authorize;

	/** @var ItemsService */
	private $ItemService;

	private $data = array();
	private $status;

	public function __construct(JsonPrinter $JsonPrinter, FlashMessagesFacade $Flashes, UserAuthorizeFacade $Authorize, ItemsService $ItemService) {
		$this->JsonPrinter = $JsonPrinter;
		$this->Flashes = $Flashes;
		$this->Authorize = $Authorize;
		$this->ItemService = $ItemService;
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
			$messages = $this->ItemService
				->saveItemForm($userId, $this->data)
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
