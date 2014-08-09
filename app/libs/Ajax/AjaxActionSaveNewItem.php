<?

class AjaxActionSaveNewItem implements IAjaxAction {
	/** @var FundControl */
	private $FundControl;

	private $data = array();

	public function __construct(FundControl $FundControl) {
		$this->FundControl = $FundControl;
	}

	public function assignData($data) {
		$this->data = $data;
		return $this;
	}

	public function run() {
		$this->FundControl
			->assignData($this->data)
			->saveItemForm();
	}

}
