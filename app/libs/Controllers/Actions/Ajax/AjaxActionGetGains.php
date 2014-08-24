<?

class AjaxActionGetGains implements IAjaxAction {
	/** @var JsonPrinter */
	private $JsonPrinter;

	/** @var UserAuthorizeFacade */
	private $Authorize;

	/** @var GainsFacade */
	private $Gains;

	public function __construct(JsonPrinter $JsonPrinter, UserAuthorizeFacade $Authorize, GainsFacade $Gains) {
		$this->JsonPrinter = $JsonPrinter;
		$this->Authorize = $Authorize;
		$this->Gains = $Gains;
	}

	public function assignData($data) {
		return $this;
	}

	public function run() {
		$gains = [];

		if ($this->Authorize->isLogged()) {
			$userId = $this->Authorize->getUserId();
			$gains = $this->Gains->getSerializedGainsFor($userId);
		}
		
		$this->JsonPrinter->printAsJsonAndDie($gains);
	}
}
