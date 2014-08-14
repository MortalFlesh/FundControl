<?

class AjaxActionSaveNewItem implements IAjaxAction {
	/** @var JsonPrinter */
	private $JsonPrinter;

	/** @var FlashMessagesFacade */
	private $Flashes;

	/** @var FundControl */
	private $FundControl;

	/** @var ItemsService */
	private $ItemService;

	private $data = array();
	private $status;

	public function __construct(JsonPrinter $JsonPrinter, FlashMessagesFacade $Flashes, FundControl $FundControl, ItemsService $ItemService) {
		$this->JsonPrinter = $JsonPrinter;
		$this->Flashes = $Flashes;
		$this->FundControl = $FundControl;
		$this->ItemService = $ItemService;
	}

	public function assignData($data) {
		$this->data = $data;
		return $this;
	}

	public function run() {
		$userId = $this->FundControl->getUserId();
		$this->trySaveForm($userId);
		$this->JsonPrinter->printAsJsonAndDie(array('status' => $this->status));
	}

	private function trySaveForm($userId) {
		try {
			$messages = $this->ItemService
				->saveItemForm($userId, $this->data)
				->getMessagesAndClear();

			foreach($messages as $message) {
				$this->Flashes->flashSuccess($message);
			}

			$this->status = 'ok';
		} catch (SaveNewItemException $Exception) {
			$this->status = 'error';
			$this->Flashes->flashError($Exception->getMessage());
		}
	}

}
