<?

class AjaxActionNotFoundException extends Exception implements AjaxActionException {
	public function __construct($actionName, Exception $Previous = null) {
		parent::__construct('AjaxAction ' . $actionName . ' not found!', 0, $Previous);
	}

}
