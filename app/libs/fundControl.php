<?php

class FundControl {
	const OTHER_TYPE_ID = -1;

	private $rootDir, $homeUrl, $itemTypes, $htmlTitle;

	/** @var Database */
	private $Db;

	/** @var FundSession */
	private $Session;

	private $data;

	public function __construct($homeUrl, $rootDir, Database $Db, FundSession $Session) {
		$this->homeUrl = $homeUrl;
		$this->rootDir = $rootDir;
		$this->Db = $Db;
		$this->Session = $Session;

		$this->htmlTitle = 'FundControl';
	}

	public function getHomeUrl() {
		return $this->homeUrl;
	}

	public function getTitle() {
		return $this->htmlTitle;
	}

	public function isLogged() {
		return $this->Session->isLogged();
	}

	public function view($viewName) {
		$viewFullName = $this->getInlineViewFullName($viewName);

		if (file_exists($viewFullName)) {
			$FundControl = $this;
			require_once $viewFullName;
		}

		return $this;
	}

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
					login = '" . $this->clear($this->data['login']) . "'
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

	private function clear($string) {
		return $this->Db->escape($string);
	}

	private function crypt($password) {
		return crypt($password, 'MF' . md5($password));
	}

	public function flashError($message) {
		$this->Session->addFlash(new FlashMessage($message, FlashMessage::ERROR));
		return $this;
	}

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
					'" . $this->clear($login) . "',
					'" . $this->crypt($password) . "')";
			$this->Db->query($qry);

			$this->flashSuccess('User inserted!');
		}
		$this->reload();
	}

	public function reload() {
		header('Location: ' . $this->homeUrl);
		exit;
	}

	public function getItemTypes($force = false) {
		if(!isset($this->itemTypes) || $force) {
			$this->itemTypes = array();
			$this->itemTypes[0] = '== Choose type ==';

			$res = $this->Db->query("SELECT id, name FROM `" . Setup::PREFIX . "item_types` ORDER BY name");
			while ($row = $this->Db->fetchAssoc($res)) {
				$this->itemTypes[(int)$row['id']] = $row['name'];
			}

			$this->itemTypes[self::OTHER_TYPE_ID] = 'Other';
		}
		return $this->itemTypes;
	}

	public function saveItemForm() {
		$this
			->prepareAndSaveNewType()
			->prepareAndSaveItem();
	}

	private function prepareAndSaveNewType() {
		if (!empty($this->data['new_type'])) {
			$this->Db->query("INSERT INTO `" . Setup::PREFIX . "item_types` (`name`) VALUES
				('" . $this->clear($this->data['new_type']) . "')");

			$this->flashSuccess('New type was added.');
		}
		return $this;
	}

	private function prepareAndSaveItem() {
		$itemTypes = $this->getItemTypes(true);
		$Time = new DateTime();
		$formatedTime = $Time->format(Database::TIME_FORMAT);
		$typeId = (int)$this->data['type'];

		if ($typeId === self::OTHER_TYPE_ID) {
			$type = $this->data['new_type'];
		} else {
			$type = $itemTypes[$typeId];
		}

		$Item = new Item(
			$this->clear($this->data['name']),
			$type,
			$this->clear($this->data['value']),
			$formatedTime
		);

		$this->saveItem($Item, $formatedTime);
		return $this;
	}

	private function saveItem(Item $Item, $time) {
		$userId = $this->Session->getUserId();
		$itemData = $Item->serialize();

		$this->Db->query("INSERT INTO `" . Setup::PREFIX . "items` (`user_id`, `item_data`, `time`) VALUES
			('" . (int)$userId . "', '" . $itemData . "', '" . $time . "')");

		$this->flashSuccess('Item added.');
		return $this;
	}

	public function logout() {
		$this->Session->logout();
		$this
			->flashSuccess('You are no longer logged!')
			->reload();
	}
}