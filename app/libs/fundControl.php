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

		$FundControl = $this;

		if (file_exists($viewFullName)) {
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
				$this->flashSuccess('Úspěšně přihlášen.');
			} else {
				$this->flashError('Špatné uživatelské údaje!');
			}
		} else {
			$this->flashError('Prázdné uživatelské údaje!');
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
			$this->flashError('Prázdné uživatelské údaje!');
		} else {
			$qry = "INSERT INTO `" . Setup::PREFIX . "users` (`login`, `password`)
				VALUES (
					'" . $this->clear($login) . "',
					'" . $this->crypt($password) . "')";
			$this->Db->query($qry);

			$this->flashSuccess('Uživatel přidán');
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
			$this->itemTypes[0] = '== Vyberte typ ==';

			$res = $this->Db->query("SELECT id, name FROM `" . Setup::PREFIX . "item_types` ORDER BY name");
			while ($row = $this->Db->fetchAssoc($res)) {
				$this->itemTypes[(int)$row['id']] = $row['name'];
			}

			$this->itemTypes[self::OTHER_TYPE_ID] = 'Jiný';
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

			$this->flashSuccess('Nový typ přidán.');
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

		$this->flashSuccess('Položka přidána.');
		return $this;
	}

	public function logout() {
		$this->Session->logout();
		$this
			->flashSuccess('Úspěšně odhlášen')
			->reload();
	}
}

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

class FlashMessage {
	const SUCCESS = 'success';
	const ERROR = 'error';

	private $type;
	private $message;

	public function __construct($message, $type = self::SUCCESS) {
		$this->message = $message;
		$this->type = $type;
	}

	public function getType() {
		return $this->type;
	}

	public function getMessage() {
		return $this->message;
	}
}