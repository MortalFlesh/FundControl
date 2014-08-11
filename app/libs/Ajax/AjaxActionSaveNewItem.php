<?

class AjaxActionSaveNewItem implements IAjaxAction {
	/** @var FundControl */
	private $FundControl;

	/** @var ItemsService */
	private $ItemService;

	private $data = array();
	private $status;

	public function __construct(FundControl $FundControl, ItemsService $ItemService) {
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
		$this->FundControl->printAsJsonAndDie(array('status' => $this->status));
	}

	private function trySaveForm($userId) {
		try {
			$messages = $this->ItemService
				->saveItemForm($userId, $this->data)
				->getMessagesAndClear();

			foreach($messages as $message) {
				$this->FundControl->flashSuccess($message);
			}

			$this->status = 'ok';
		} catch (SaveNewItemException $Exception) {
			$this->status = 'error';
			$this->FundControl->flashError($Exception->getMessage());
		}
	}

}
