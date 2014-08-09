<?

class AjaxActionGetItems implements IAjaxAction {
	/** @var FundControl */
	private $FundControl;

	public function __construct(FundControl $FundControl) {
		$this->FundControl = $FundControl;
	}

	public function assignData($data) {
		return $this;
	}

	public function run() {
		$items = $this->FundControl->getItems();
		$this->FundControl->printAsJsonAndDie($items);
	}
}
