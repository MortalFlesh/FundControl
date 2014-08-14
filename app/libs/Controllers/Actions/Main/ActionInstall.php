<?php

class ActionInstall implements IAction {

	/** @var Setup */
	private $Setup;

	/** @var FlashMessagesFacade */
	private $Flashes;

	/**
	 * @param Setup $Setup
	 * @param FlashMessagesFacade $Flashes
	 */
	public function __construct(Setup $Setup, FlashMessagesFacade $Flashes) {
		$this->Setup = $Setup;
		$this->Flashes = $Flashes;
	}

	/**
	 * @param array $data
	 * @return ActionInstall
	 */
	public function assignData($data) {
		return $this;
	}

	public function run() {
		$this->Setup->install();
		$this->Flashes->flashSuccess('Installed');
	}

}
