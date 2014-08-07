<?php

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