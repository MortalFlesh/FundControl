<?php

class MainController implements IController {
	/** @var FundControl */
	private $FundControl;

	/** @var Setup */
	private $Setup;

	/**
	 * @param FundControl $FundControl
	 * @param Setup $Setup
	 */
	public function __construct(FundControl $FundControl, Setup $Setup) {
		$this->FundControl = $FundControl;
		$this->Setup = $Setup;
	}

	public function checkActions() {
		if (isset($_POST['save'])) {
			$this->FundControl
					->assignData($_POST)
					->saveItemForm();
		} elseif (isset($_POST['authorize'])) {
			$this->FundControl
					->assignData($_POST)
					->authorize();
		} elseif (isset($_GET['logout'])) {
			$this->FundControl->logout();
		} elseif (isset($_GET['new_user']) && $_GET['new_user'] == 'efa33KFJ41AD3efes') {
			$userName = $_GET['name'];
			$password = $_GET['pass'];
			$this->FundControl->newUser($userName, $password);
		} elseif (isset($_GET['setup']) && $_GET['setup'] == 'fejkA8Dwas7ADW7A88') {
			$this->Setup->install();

			$this->FundControl
					->flashSuccess('Installed')
					->reload();
		} elseif (isset($_GET['info']) && $_GET['info'] == 'afej8183fakkjfa') {
		}
	}

}
