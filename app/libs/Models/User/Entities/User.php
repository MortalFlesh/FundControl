<?php

class User {
	/** @var string */
	private $login;

	/** @var string */
	private $password;

	/**
	 * @param string $login
	 * @param string $password
	 * @param int $id
	 */
	public function __construct($login, $password) {
		$this->login = $login;
		$this->password = $password;
	}

	/** @var string */
	public function getLogin() {
		return $this->login;
	}

	/** @var string */
	public function getPassword() {
		return $this->password;
	}

}
