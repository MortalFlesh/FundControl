<?php

class ActionLogout implements IAction {
	/** @var UserAuthorizeFacade */
	private $Authorize;

	/** @var FlashMessagesFacade */
	private $Flashes;

	public function __construct(UserAuthorizeFacade $Authorize, FlashMessagesFacade $Flashes) {
		$this->Authorize = $Authorize;
		$this->Flashes = $Flashes;
	}

	/**
	 * @param array $data
	 * @return ActionRegistration
	 */
	public function assignData($data) {
		return $this;
	}

	public function run() {
		$this->Authorize->logout();
		$this->Flashes->flashSuccess('Successfully logged out!');
	}
}