<?php

class SaveNewGainException extends Exception implements GainException {
	public function __construct($message, Exception $Previous = null) {
		parent::__construct('Save new gain error: ' . $message, 0, $Previous);
	}
}
