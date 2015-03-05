<?php

class FlashMessagesRepository {
	/** @var FlashMessagesSessionMapper */
	private $FlashMessagesSessionMapper;

	/** @param FlashMessagesSessionMapper $FlashMessagesSessionMapper */
	public function __construct(FlashMessagesSessionMapper $FlashMessagesSessionMapper) {
		$this->FlashMessagesSessionMapper = $FlashMessagesSessionMapper;
	}

	/** @param FlashMessage $FlashMessage */
	public function addFlashMessage(FlashMessage $FlashMessage) {
		$this->FlashMessagesSessionMapper->addFlash($FlashMessage);
	}

	/** @return FlashMessage[] */
	public function getFlashes() {
		$flashes = $this->FlashMessagesSessionMapper->getFlashes();
		$this->FlashMessagesSessionMapper->clearFlashes();
		return $flashes;
	}
}
