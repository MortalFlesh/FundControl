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

	public function addFlash(FlashMessage $Message) {
		ArrayFunctions::initArray($this->session['flashes']);

		$this->session['flashes'][] = array(
			'message' => $Message->getMessage(),
			'type' => $Message->getType()
		);
		return $this;
	}

	/** @return FlashMessage[] */
	public function getFlashes() {
		$flashes = array();
		if (is_array($this->session['flashes'])) {
			foreach($this->session['flashes'] as $flashData) {
				$flashes[] = new FlashMessage($flashData['message'], $flashData['type']);
			}
		}
		return $flashes;
	}

	public function clearFlashes() {
		$this->session['flashes'] = array();
		return $this;
	}

	public function logout() {
		unset($this->session['userId'], $this->session['logged']);
		return $this;
	}
}