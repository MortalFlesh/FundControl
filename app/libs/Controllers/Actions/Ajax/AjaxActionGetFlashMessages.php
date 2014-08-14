<?

class AjaxActionGetFlashMessages implements IAjaxAction {
	/** @var JsonPrinter */
	private $JsonPrinter;

	/** @var FlashMessagesFacade */
	private $Flashes;

	/**
	 * @param JsonPrinter $JsonPrinter
	 * @param FlashMessagesFacade $Flashes
	 */
	public function __construct(JsonPrinter $JsonPrinter, FlashMessagesFacade $Flashes) {
		$this->JsonPrinter = $JsonPrinter;
		$this->Flashes = $Flashes;
	}

	public function assignData($data) {
		return $this;
	}

	public function run() {
		$flashes = $this->Flashes->getFlashes();

		$flashesData = array();
		foreach($flashes as $FlashMessage) {
			$flashesData[] = $FlashMessage->serialize();
		}

		$this->JsonPrinter->printAsJsonAndDie($flashesData);
	}
}
