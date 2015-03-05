<?php

class FlashMessagesService {
	/**
	 * @param string $message
	 * @return FlashMessage
	 */
	public function createSuccessFlash($message) {
		return new FlashMessage($message, FlashMessage::SUCCESS);
	}

	/**
	 * @param string $message
	 * @return FlashMessage
	 */
	public function createErrorFlash($message) {
		return new FlashMessage($message, FlashMessage::ERROR);
	}
}
