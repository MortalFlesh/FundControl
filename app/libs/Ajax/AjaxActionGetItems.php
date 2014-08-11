<?

class AjaxActionGetItems implements IAjaxAction {
	/** @var FundControl */
	private $FundControl;

	/** @var ItemsService */
	private $ItemsService;

	/**
	 * @param FundControl $FundControl
	 * @param ItemsService $ItemsService
	 */
	public function __construct(FundControl $FundControl, ItemsService $ItemsService) {
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
		$this->FundControl->printAsJsonAndDie($serializedItems);
	}
}
