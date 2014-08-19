<?php

class UsersDbMapper {
	/** @var Database  */
	private $Db;

	/** @var Config */
	private $Config;

	/**
	 * @param Database $Db
	 * @param Config $Config
	 */
	public function __construct(Database $Db, Config $Config) {
		$this->Db = $Db;
		$this->Config = $Config;
	}

	/** @param User $User */
	public function insertNewUser(User $User) {
		$login = $User->getLogin();
		$password = $User->getPassword();

		$qry = "INSERT INTO `" . $this->Config->getPrefix() . "users` (`login`, `password`)
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
			FROM `" . $this->Config->getPrefix() . "users`
			WHERE
				login = '" . $this->Db->escape($login) . "'
				AND password = '" . $this->Db->escape($password) . "'");
	}
}
