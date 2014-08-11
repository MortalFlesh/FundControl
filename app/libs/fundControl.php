<?php

class FundControl {
	private $rootDir, $homeUrl, $htmlTitle;

	/** @var Database */
	private $Db;

	/** @var FundSession */
	private $Session;

	private $data = array();

	/**
	 * @param string $htmlTitle
	 * @param string $homeUrl
	 * @param string $rootDir
	 * @param Database $Db
	 * @param FundSession $Session
	 */
	public function __construct($htmlTitle, $homeUrl, $rootDir, Database $Db, FundSession $Session) {
		$this->homeUrl = $homeUrl;
		$this->rootDir = $rootDir;
		$this->Db = $Db;
		$this->Session = $Session;

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
				$this->flashSuccess('Successfuly logged in.');
			} else {
				$this->flashError('Invalid user data!');
			}
		} else {
			$this->flashError('Empty user data!');
		}
		$this->reload();
	}

	private function crypt($password) {
		return crypt($password, 'MF' . md5($password));
	}

	/**
	 * @param string $message
	 * @return FundControl
	 */
	public function flashError($message) {
		$this->Session->addFlash(new FlashMessage($message, FlashMessage::ERROR));
		return $this;
	}

	/**
	 * @param string $message
	 * @return FundControl
	 */
	public function flashSuccess($message) {
		$this->Session->addFlash(new FlashMessage($message, FlashMessage::SUCCESS));
		return $this;
	}

	/** @return FlashMessage[] */
	public function getFlashesAndClear() {
		$flashes = $this->Session->getFlashes();
		$this->Session->clearFlashes();
		return $flashes;
	}

	public function newUser($login, $password) {
		if (empty($login) || empty($password)) {
			$this->flashError('Empty user data!');
		} else {
			$qry = "INSERT INTO `" . Setup::PREFIX . "users` (`login`, `password`)
				VALUES (
					'" . $this->Db->escape($login) . "',
					'" . $this->crypt($password) . "')";
			$this->Db->query($qry);

			$this->flashSuccess('User inserted!');
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
		$this
			->flashSuccess('You are no longer logged!')
			->reload();
	}

	/** @param array $data */
	public function printAsJsonAndDie(array $data) {
		echo ArrayFunctions::arrayToJson($data);
		exit;
	}

	/**
	 * If user is not logged, this will kill the script and show error message
	 */
	public function requireLogin() {
		if (!$this->isLogged()) {
			$this
				->flashError('This page need login!')
				->view('flashesServer');
			exit;
		}
	}

	/** @return int */
	public function getUserId() {
		return $this->Session->getUserId();
	}
}