<?php

class UserAuthorizeFacade {
	/** @var UsersRepository */
	private $Repository;

	/** @var UsersService */
	private $Service;

	public function __construct(UsersRepository $Repository, UsersService $Service) {
		$this->Repository = $Repository;
		$this->Service = $Service;
	}

	/**
	 * @param string $login
	 * @param string $password
	 */
	public function login($login, $password) {
		$User = $this->Service->create($login, $password);
		$userId = $this->Repository->getUserId($User);

		if ($userId > 0) {
			$this->Repository->login($userId);
		}
	}

	/** @return bool */
	public function isLogged() {
		return $this->Repository->isLogged();
	}

	/** @return int */
	public function getUserId() {
		return $this->Repository->getLoggedUserId();
	}

	public function logout() {
		$this->Repository->logout();
	}
}
