<?

class AjaxActionNotFoundException extends Exception {
	public function __construct($actionName, Exception $Previous = null) {
		parent::__construct('AjaxAction ' . $actionName . ' not found!', 0, $Previous);
	}

}
