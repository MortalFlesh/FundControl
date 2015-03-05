<?

class AjaxActionGetGainTypes implements IAjaxAction {
	/** @var JsonPrinter */
	private $JsonPrinter;

	/** @var GainTypesFacade */
	private $GainTypes;

	public function __construct(JsonPrinter $JsonPrinter, GainTypesFacade $Repository) {
		$this->JsonPrinter = $JsonPrinter;
		$this->GainTypes = $Repository;
	}

	public function assignData($data) {
		return $this;
	}

	public function run() {
		$types = $this->GainTypes->getSerializedGainTypes();
		$this->JsonPrinter->printAsJsonAndDie($types);
	}
}
