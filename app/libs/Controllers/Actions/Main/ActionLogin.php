<?php

class ActionLogin implements IAction {
	/** @var UserAuthorizeFacade */
	private $Authorize;

	/** @var FlashMessagesFacade */
	private $Flashes;

	private $data;

	public function __construct(UserAuthorizeFacade $Authorize, FlashMessagesFacade $Flashes) {
		$this->Authorize = $Authorize;
		$this->Flashes = $Flashes;
	}

	/**
	 * @param array $data
	 * @return ActionRegistration
	 */
	public function assignData($data) {
		$this->data = $data;
		return $this;
	}

	public function run() {
		if (empty($this->data['login']) || empty($this->data['password'])) {
			$this->error('Empty login data!');
		} else {
			$this->Authorize->login($this->data['login'], $this->data['password']);

			if ($this->Authorize->isLogged()) {
				$this->Flashes->flashSuccess('Successfully logged in!');
			} else {
				$this->error('Bad login credentials!');
			}
		}
	}

	/**
	 * @param string $message
	 * @throws ActionLoginFailedException
	 */
	private function error($message) {
		$this->Flashes->flashError($message);
		throw new ActionLoginFailedException($message);
	}
}