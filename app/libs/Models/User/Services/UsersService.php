<?php

class UsersService {
	/** @var PasswordEncoder */
	private $Encoder;

	/** @param PasswordEncoder $Encoder */
	public function __construct(PasswordEncoder $Encoder) {
		$this->Encoder = $Encoder;
	}

	/**
	 * @param string $login
	 * @param string $password
	 * @return User
	 */
	public function create($login, $password) {
		$passwordHash = $this->Encoder->encode($password);
		return new User($login, $passwordHash);
	}
}
