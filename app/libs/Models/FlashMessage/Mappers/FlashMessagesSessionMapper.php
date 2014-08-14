<?php

class FlashMessagesSessionMapper {
	const SESSION_NAME = 'fund_flashes_session';
	private $session;

	public function __construct() {
		$this->session = &$_SESSION[self::SESSION_NAME];
		ArrayFunctions::initArray($this->session);
	}

	/**
	 * @param FlashMessage $Message
	 * @return FlashMessagesSessionMapper
	 */
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

	/** @return FlashMessagesSessionMapper */
	public function clearFlashes() {
		$this->session['flashes'] = array();
		return $this;
	}
}
