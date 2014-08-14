<?php

class ActionsFactory {
	/** @var ServiceFactory */
	private $ServiceFactory;

	public function __construct(ServiceFactory $ServiceFactory) {
		$this->ServiceFactory = $ServiceFactory;
	}

	/**
	 * @param string $actionName
	 * @return IAction
	 * @throws ActionNotFoundException
	 */
	public function getAction($actionName) {
		try {
			$Service = $this->ServiceFactory->getServiceByName($actionName);
			return $Service;
		} catch (ServiceNotFoundException $ServiceNotFoundException) {
			throw new ActionNotFoundException($actionName, $ServiceNotFoundException);
		}
	}
}
