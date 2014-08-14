<?php

class UsersDbMapper {
	/** @var Database  */
	private $Db;

	/** @param Database $Db */
	public function __construct(Database $Db) {
		$this->Db = $Db;
	}

	/** @param User $User */
	public function insertNewUser(User $User) {
		$login = $User->getLogin();
		$password = $User->getPassword();

		$qry = "INSERT INTO `" . Setup::PREFIX . "users` (`login`, `password`)
			VALUES (
				'" . $this->Db->escape($login) . "',
				'" . $this->Db->escape($password) . "')";
		$this->Db->query($qry);
	}

	/**
	 * @param User $User
	 * @return int
	 */
	public function loadUserId(User $User) {
		$login = $User->getLogin();
		$password = $User->getPassword();

		return (int)$this->Db->queryValue("SELECT id
			FROM `" . Setup::PREFIX . "users`
			WHERE
				login = '" . $this->Db->escape($login) . "'
				AND password = '" . $this->Db->escape($password) . "'");
	}
}
