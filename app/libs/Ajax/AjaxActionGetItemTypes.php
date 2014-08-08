<?

class AjaxActionGetItemTypes implements IAjaxAction {
	/** @var FundControl */
	private $FundControl;

	public function __construct(FundControl $FundControl) {
		$this->FundControl = $FundControl;
	}

	public function run() {
		$types = $this->FundControl->getItemTypes();
		$this->FundControl->printAsJsonAndDie($types);
	}
}
