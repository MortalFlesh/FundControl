<?

class ActionLoginFailedException extends Exception implements IActionException {
	public function __construct($error, Exception $Previous = null) {
		parent::__construct('Login failed: ' . $error, 0, $Previous);
	}

}
