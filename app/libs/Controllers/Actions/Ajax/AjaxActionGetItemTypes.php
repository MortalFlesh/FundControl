<?

class AjaxActionGetItemTypes implements IAjaxAction {
	/** @var JsonPrinter */
	private $JsonPrinter;

	/** @var FundControl */
	private $FundControl;

	/** @var ItemTypesService */
	private $ItemTypesService;

	public function __construct(JsonPrinter $JsonPrinter, FundControl $FundControl, ItemTypesService $ItemTypesService) {
		$this->JsonPrinter = $JsonPrinter;
		$this->FundControl = $FundControl;
		$this->ItemTypesService = $ItemTypesService;
	}

	public function assignData($data) {
		return $this;
	}

	public function run() {
		$types = $this->ItemTypesService->getItemTypes();
		$serializedTypes = $this->ItemTypesService->serializeItemTypes($types);
		$this->JsonPrinter->printAsJsonAndDie($serializedTypes);
	}
}
