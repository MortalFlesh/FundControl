<?php

class MainController implements IController {
	/** @var Config */
	private $Config;

	/** @var FlashMessagesFacade */
	private $Flashes;

	/** @var ActionsFactory */
	private $Factory;

	/**
	 * @param Config $Config
	 * @param FlashMessagesFacade $Flashes
	 * @param ActionsFactory $Factory
	 */
	public function __construct(Config $Config, FlashMessagesFacade $Flashes, ActionsFactory $Factory) {
		$this->Config = $Config;
		$this->Flashes = $Flashes;
		$this->Factory = $Factory;
	}

	public function checkActions() {
		if (isset($_POST['authorize'])) {
			$this
				->runAction('ActionLogout')
				->runAction('ActionLogin', $_POST)
				->reload();
		} elseif (isset($_GET['logout'])) {
			$this
				->runAction('ActionLogout')
				->reload();
		} elseif (isset($_GET['new_user']) && $_GET['new_user'] == 'efa33KFJ41AD3efes') {
			$this
				->runAction('ActionLogout')
				->runAction('ActionRegistration', $_GET)
				->runAction('ActionLogin', $_GET)
				->reload();
		} elseif (isset($_GET['setup']) && $_GET['setup'] == 'fejkA8Dwas7ADW7A88') {
			$this
				->runAction('ActionInstall')
				->reload();
		} elseif (isset($_GET['info']) && $_GET['info'] == 'afej8183fakkjfa') {
		} elseif (isset($_GET['message'])) {
			$this->Flashes->flashSuccess($_GET['message']);
			exit;
		}
	}

	/**
	 * @param string $actionName
	 * @param mixed $data
	 * @return MainController
	 */
	private function runAction($actionName, $data = null) {
		try {
			$Action = $this->Factory->getAction($actionName);
			$Action
				->assignData($data)
				->run();

			return $this;
		} catch (IActionException $Exception) {
			$this->reload();
		}
	}

	/**
	 * Redirect to home URL
	 */
	public function reload() {
		header('Location: ' . $this->Config->getHomeUrl());
		exit;
	}

}
