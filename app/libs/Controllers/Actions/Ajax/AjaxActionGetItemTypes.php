<?

class AjaxActionGetItemTypes implements IAjaxAction {
	/** @var JsonPrinter */
	private $JsonPrinter;

	/** @var ItemTypesFacade */
	private $ItemTypes;

	public function __construct(JsonPrinter $JsonPrinter, ItemTypesFacade $ItemTypes) {
		$this->JsonPrinter = $JsonPrinter;
		$this->ItemTypes = $ItemTypes;
	}

	public function assignData($data) {
		return $this;
	}

	public function run() {
		$types = $this->ItemTypes->getSerializedItemTypes();
		$this->JsonPrinter->printAsJsonAndDie($types);
	}
}
