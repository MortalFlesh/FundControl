<?php

class ActionRegistration implements IAction {
	/** @var UserRegistrationFacade */
	private $Registration;

	/** @var FlashMessagesFacade */
	private $Flashes;

	private $data;

	/**
	 * @param array $data
	 * @return ActionRegistration
	 */
	public function assignData($data) {
		$this->data = $data;
		return $this;
	}

	public function run() {
		$login = $this->data['login'];
		$password = $this->data['password'];

		if (empty($login) || empty($password)) {
			$this->Flashes->flashError('Empty user data!');
			throw new ActionRegistrationFailedException('Empty user data!');
		} else {
			$this->Registration->registerNewUser($login, $password);
			$this->Flashes->flashSuccess('User registered!');
		}
	}
}