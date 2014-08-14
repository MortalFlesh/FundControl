<?

class ActionNotFoundException extends Exception {
	public function __construct($actionName, Exception $Previous = null) {
		parent::__construct('Action ' . $actionName . ' not found!', 0, $Previous);
	}

}
