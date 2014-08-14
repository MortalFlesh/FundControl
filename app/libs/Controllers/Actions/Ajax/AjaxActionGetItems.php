<?

class AjaxActionGetItems implements IAjaxAction {
	/** @var JsonPrinter */
	private $JsonPrinter;

	/** @var FundControl */
	private $FundControl;

	/** @var ItemsService */
	private $ItemsService;

	public function __construct(JsonPrinter $JsonPrinter, FundControl $FundControl, ItemsService $ItemsService) {
		$this->JsonPrinter = $JsonPrinter;
		$this->FundControl = $FundControl;
		$this->ItemsService = $ItemsService;
	}

	public function assignData($data) {
		return $this;
	}

	public function run() {
		$userId = $this->FundControl->getUserId();
		$items = $this->ItemsService->getItems($userId);
		$serializedItems = $this->ItemsService->serializeItems($items);
		$this->JsonPrinter->printAsJsonAndDie($serializedItems);
	}
}
