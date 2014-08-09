<?

class AjaxActionGetFlashMessages implements IAjaxAction {
	/** @var FundControl */
	private $FundControl;

	public function __construct(FundControl $FundControl) {
		$this->FundControl = $FundControl;
	}

	public function assignData($data) {
		return $this;
	}

	public function run() {
		$flashes = $this->FundControl->getFlashesAndClear();

		$flashesData = array();
		foreach($flashes as $FlashMessage) {
			$flashesData[] = $FlashMessage->toArray();
		}

		$this->FundControl->printAsJsonAndDie($flashesData);
	}
}
