<?php

class AjaxActionsFactory {
	const ACTION_GET_ITEM_TYPES = 'get-item-types';

	/** @var ServiceFactory */
	private $ServiceFactory;

	public function __construct(ServiceFactory $ServiceFactory) {
		$this->ServiceFactory = $ServiceFactory;
	}

	/**
	 * @param string $actionName
	 * @return IAjaxAction
	 * @throws AjaxActionNotFoundException
	 */
	public function getAction($actionName) {
		switch($actionName) {
			case self::ACTION_GET_ITEM_TYPES: return $this->getService('AjaxActionGetItemTypes');
			default: throw new AjaxActionNotFoundException($actionName);
		}
	}

	/**
	 * @param string $actionName
	 * @return object<ServiceType>
	 * @throws AjaxActionNotFoundException
	 */
	private function getService($actionName) {
		try {
			$Service = $this->ServiceFactory->getServiceByName($actionName);
			return $Service;
		} catch (ServiceNotFoundException $ServiceNotFoundException) {
			throw new AjaxActionNotFoundException($actionName, $ServiceNotFoundException);
		}
	}
}
