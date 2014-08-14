<?

class ActionRegistrationFailedException extends Exception implements IActionException {
	public function __construct($error, Exception $Previous = null) {
		parent::__construct('Registration failed: ' . $error, 0, $Previous);
	}

}
