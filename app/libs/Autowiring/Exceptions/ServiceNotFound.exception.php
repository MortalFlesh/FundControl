<?

class ServiceNotFoundException extends Exception {
	public function __construct($serviceName, Exception $Previous = null) {
		parent::__construct('Service ' . $serviceName . ' not found!', 0, $Previous);
	}

}
