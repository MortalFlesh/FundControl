<?

class AjaxActionGetItems implements IAjaxAction {
	/** @var JsonPrinter */
	private $JsonPrinter;

	/** @var FundControl */
	private $FundControl;

	/** @var ItemsService */
	private $ItemsService;

	/** @var UserAuthorizeFacade */
	private $Authorize;

	public function __construct(JsonPrinter $JsonPrinter, FundControl $FundControl, ItemsService $ItemsService, UserAuthorizeFacade $Authorize) {
		$this->JsonPrinter = $JsonPrinter;
		$this->FundControl = $FundControl;
		$this->ItemsService = $ItemsService;
		$this->Authorize = $Authorize;
	}

	public function assignData($data) {
		return $this;
	}

	public function run() {
		$serializedItems = [];

		if ($this->Authorize->isLogged()) {
			$userId = $this->Authorize->getUserId();
			$items = $this->ItemsService->getItems($userId);
			$serializedItems = $this->ItemsService->serializeItems($items);
		}
		
		$this->JsonPrinter->printAsJsonAndDie($serializedItems);
	}
}
