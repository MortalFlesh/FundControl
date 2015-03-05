<?

class AjaxActionGetUserTabsException extends Exception implements AjaxActionException {
	public function __construct($message, Exception $Previous = null) {
		parent::__construct('ERROR: ' . $message, 0, $Previous);
	}

}
