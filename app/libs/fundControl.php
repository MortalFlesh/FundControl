<?php

class FundControl {
	private $rootDir, $homeUrl, $htmlTitle;

	/** @var Database */
	private $Db;

	/** @var FundSession */
	private $Session;

	/** @var FlashMessagesFacade */
	private $Flashes;

	private $data = array();

	/**
	 * @param string $htmlTitle
	 * @param string $homeUrl
	 * @param string $rootDir
	 * @param Database $Db
	 * @param FundSession $Session
	 */
	public function __construct($htmlTitle, $homeUrl, $rootDir, Database $Db, FundSession $Session, FlashMessagesFacade $Flashes) {
		$this->homeUrl = $homeUrl;
		$this->rootDir = $rootDir;
		$this->Db = $Db;
		$this->Session = $Session;
		$this->Flashes = $Flashes;

		$this->htmlTitle = $htmlTitle;
	}

	/** @return string */
	public function getHomeUrl() {
		return $this->homeUrl;
	}

	/** @return string */
	public function getTitle() {
		return $this->htmlTitle;
	}

	/** @return bool */
	public function isLogged() {
		return $this->Session->isLogged();
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
		return $this->rootDir . 'views/inline/' . $viewName . '.php';
	}

	public function assignData(array $data) {
		$this->data = $data;
		return $this;
	}

	public function authorize() {
		if (!empty($this->data['login']) && !empty($this->data['password'])) {
			$userId = $this->Db->queryValue("SELECT id
				FROM `" . Setup::PREFIX . "users`
				WHERE
					login = '" . $this->Db->escape($this->data['login']) . "'
					AND password = '" . $this->crypt($this->data['password']) . "'");

			$userId;
			if ($userId > 0) {
				$this->Session
					->setUserId($userId)
					->setIsLogged();
				$this->Flashes->flashSuccess('Successfuly logged in.');
			} else {
				$this->Flashes->flashError('Invalid user data!');
			}
		} else {
			$this->Flashes->flashError('Empty user data!');
		}
		$this->reload();
	}

	private function crypt($password) {
		return crypt($password, 'MF' . md5($password));
	}

	/** @return FlashMessage[] */
	public function getFlashes() {
		return $this->FlashMessagesRepository->getFlashes();
	}

	public function newUser($login, $password) {
		if (empty($login) || empty($password)) {
			$this->Flashes->flashError('Empty user data!');
		} else {
			$qry = "INSERT INTO `" . Setup::PREFIX . "users` (`login`, `password`)
				VALUES (
					'" . $this->Db->escape($login) . "',
					'" . $this->crypt($password) . "')";
			$this->Db->query($qry);

			$this->Flashes->flashSuccess('User inserted!');
		}
		$this->reload();
	}

	/**
	 * Redirect to home URL
	 */
	public function reload() {
		header('Location: ' . $this->homeUrl);
		exit;
	}

	/**
	 * Logout current user
	 */
	public function logout() {
		$this->Session->logout();
		$this->Flashes->flashSuccess('You are no longer logged!');
		$this->reload();
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

	/** @return int */
	public function getUserId() {
		return $this->Session->getUserId();
	}
}