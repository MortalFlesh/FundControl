<?php

class FlashMessagesFacade {
	/** @var FlashMessagesService */
	private $Service;

	/** @var FlashMessagesRepository */
	private $Repository;

	/**
	 * @param FlashMessagesService $FlashMessagesService
	 * @param FlashMessagesRepository $FlashMessagesRepository
	 */
	public function __construct(FlashMessagesService $FlashMessagesService, FlashMessagesRepository $FlashMessagesRepository) {
		$this->Service = $FlashMessagesService;
		$this->Repository = $FlashMessagesRepository;
	}

	/** @param string $message */
	public function flashSuccess($message) {
		$FlashMessage = $this->Service->createSuccessFlash($message);
		$this->Repository->addFlashMessage($FlashMessage);
	}

	/** @param string $message */
	public function flashError($message) {
		$FlashMessage = $this->Service->createErrorFlash($message);
		$this->Repository->addFlashMessage($FlashMessage);
	}

	/** @return FlashMessage[] */
	public function getFlashes() {
		return $this->Repository->getFlashes();
	}
}
