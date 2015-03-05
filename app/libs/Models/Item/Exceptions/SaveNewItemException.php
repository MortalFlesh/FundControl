<?php

class SaveNewItemException extends Exception implements ItemException {
	public function __construct($message, Exception $Previous = null) {
		parent::__construct('Save new item error: ' . $message, 0, $Previous);
	}
}
