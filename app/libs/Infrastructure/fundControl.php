<?php

class FundControl {
	/** @var Config */
	private $Config;

	/** @var FlashMessagesFacade */
	private $Flashes;

	/** @var UserAuthorizeFacade */
	private $Authorize;

	/**
	 * @param Config $Config
	 * @param FlashMessagesFacade $Flashes
	 * @param UserAuthorizeFacade $Authorize
	 */
	public function __construct(Config $Config, FlashMessagesFacade $Flashes, UserAuthorizeFacade $Authorize) {
		$this->Config = $Config;
		$this->Flashes = $Flashes;
		$this->Authorize = $Authorize;
	}

	/** @return string */
	public function getHomeUrl() {
		return $this->Config->getHomeUrl();
	}

	/** @return string */
	public function getTitle() {
		return $this->Config->getHtmlTitle();
	}

	/** @return bool */
	public function isLogged() {
		return $this->Authorize->isLogged();
	}

	/**
	 * @param string $viewName
	 * @return FundControl
	 */
	public function view($viewName) {
		$viewFullName = $this->getInlineViewFullName($viewName);

		if (file_exists($viewFullName)) {
			$FundControl = $this;
			require_once $viewFullName;
		}

		return $this;
	}

	/**
	 * @param string$viewName
	 * @return string
	 */
	private function getInlineViewFullName($viewName) {
		$rootDir = $this->Config->getRootDir();
		return $rootDir . 'views/inline/' . $viewName . '.php';
	}

	/** @return FlashMessage[] */
	public function getFlashes() {
		return $this->Flashes->getFlashes();
	}

	/**
	 * If user is not logged, this will kill the script and show error message
	 */
	public function requireLogin() {
		if (!$this->isLogged()) {
			$this->Flashes->flashError('This page need login!');
			$this->view('flashesServer');
			exit;
		}
	}
}