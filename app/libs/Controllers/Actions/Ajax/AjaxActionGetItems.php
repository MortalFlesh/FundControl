<?

class AjaxActionGetItems implements IAjaxAction {
	/** @var JsonPrinter */
	private $JsonPrinter;

	/** @var FundControl */
	private $FundControl;

	/** @var ItemsFacade */
	private $Items;

	/** @var UserAuthorizeFacade */
	private $Authorize;

	public function __construct(JsonPrinter $JsonPrinter, FundControl $FundControl, ItemsFacade $Items, UserAuthorizeFacade $Authorize) {
		$this->JsonPrinter = $JsonPrinter;
		$this->FundControl = $FundControl;
		$this->Items = $Items;
		$this->Authorize = $Authorize;
	}

	public function assignData($data) {
		return $this;
	}

	public function run() {
		$items = [];

		if ($this->Authorize->isLogged()) {
			$userId = $this->Authorize->getUserId();
			$items = $this->Items->getSerializedItemsFor($userId);
		}
		
		$this->JsonPrinter->printAsJsonAndDie($items);
	}
}
