<?

class AjaxActionGetItemTypes implements IAjaxAction {
	/** @var FundControl */
	private $FundControl;

	/** @var ItemTypesService */
	private $ItemTypesService;

	/**
	 * @param FundControl $FundControl
	 * @param ItemTypesService $ItemTypesService
	 */
	public function __construct(FundControl $FundControl, ItemTypesService $ItemTypesService) {
		$this->FundControl = $FundControl;
		$this->ItemTypesService = $ItemTypesService;
	}

	public function assignData($data) {
		return $this;
	}

	public function run() {
		$types = $this->ItemTypesService->getItemTypes();
		$serializedTypes = $this->ItemTypesService->serializeItemTypes($types);
		$this->FundControl->printAsJsonAndDie($serializedTypes);
	}
}
