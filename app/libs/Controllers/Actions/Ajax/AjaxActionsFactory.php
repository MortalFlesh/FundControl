<?php

class AjaxActionsFactory {
	const ACTION_GET_ITEM_TYPES = 'get-item-types';
	const ACTION_GET_FLASH_MESSAGES = 'get-flash-messages';
	const ACTION_SAVE_NEW_ITEM = 'save-new-item';
	const ACTION_GET_ITEMS = 'get-items';
	const ACTION_SAVE_NEW_GAIN = 'save-new-gain';
	const ACTION_GET_GAIN_TYPES = 'get-gain-types';
	const ACTION_GET_GAINS = 'get-gains';
	const ACTION_GET_USER_TABS = 'get-user-tabs';

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
			case self::ACTION_GET_FLASH_MESSAGES: return $this->getService('AjaxActionGetFlashMessages');
			case self::ACTION_SAVE_NEW_ITEM: return $this->getService('AjaxActionSaveNewItem');
			case self::ACTION_GET_ITEMS: return $this->getService('AjaxActionGetItems');
			case self::ACTION_SAVE_NEW_GAIN: return $this->getService('AjaxActionSaveNewGain');
			case self::ACTION_GET_GAIN_TYPES: return $this->getService('AjaxActionGetGainTypes');
			case self::ACTION_GET_GAINS: return $this->getService('AjaxActionGetGains');
			case self::ACTION_GET_USER_TABS: return $this->getService('AjaxActionGetUserTabs');
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
