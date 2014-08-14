<?php

class FundSession {
	const SESSION_NAME = 'fund_session';
	private $session;

	public function __construct() {
		$this->session = &$_SESSION[self::SESSION_NAME];
		ArrayFunctions::initArray($this->session);
	}

	public function isLogged() {
		return ($this->session['logged'] === true);
	}

	public function setUserId($userId) {
		$this->session['userId'] = (int)$userId;
		return $this;
	}

	public function getUserId() {
		if (!$this->isLogged()) {
			return 0;
		}
		return $this->session['userId'];
	}

	public function setIsLogged() {
		$this->session['logged'] = true;
		return $this;
	}

	public function logout() {
		unset($this->session['userId'], $this->session['logged']);
		return $this;
	}
}