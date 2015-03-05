<?php

class UsersRepository {
	/** @var UsersDbMapper */
	private $DbMapper;

	/** @var UsersSessionMapper */
	private $SessionMapper;

	public function __construct(UsersDbMapper $DbMapper, UsersSessionMapper $SessionMapper) {
		$this->DbMapper = $DbMapper;
		$this->SessionMapper = $SessionMapper;
	}
	
	/** @param User $User */
	public function addNewUser(User $User) {
		$this->DbMapper->insertNewUser($User);
	}

	/**
	 * @param User $User
	 * @return int
	 */
	public function getUserId(User $User) {
		return $this->DbMapper->loadUserId($User);
	}

	/** @param int $userId */
	public function login($userId) {
		$this->SessionMapper
			->setUserId($userId)
			->setIsLogged();
	}

	/** @return bool */
	public function isLogged() {
		return $this->SessionMapper->isLogged();
	}

	/** @return int */
	public function getLoggedUserId() {
		return $this->SessionMapper->getUserId();
	}

	public function logout() {
		$this->SessionMapper->logout();
	}
}
