<?php

class UsersSessionMapper {
	const SESSION_NAME = 'fund_user_session';
	private $session;

	public function __construct() {
		$this->session = &$_SESSION[self::SESSION_NAME];
		ArrayFunctions::initArray($this->session);
	}

	/** @return bool */
	public function isLogged() {
		return ($this->session['logged'] === true);
	}

	/**
	 * @param int $userId
	 * @return UsersSessionMapper
	 */
	public function setUserId($userId) {
		$this->session['userId'] = (int)$userId;
		return $this;
	}

	/** @return int */
	public function getUserId() {
		if (!$this->isLogged()) {
			return 0;
		}
		return (int)$this->session['userId'];
	}

	/** @return UsersSessionMapper */
	public function setIsLogged() {
		$this->session['logged'] = true;
		return $this;
	}

	/** @return UsersSessionMapper */
	public function logout() {
		unset($this->session['userId'], $this->session['logged']);
		return $this;
	}
}
