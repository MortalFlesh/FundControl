<?php

class AjaxController implements IController {
	private $data = [];

	/** @var AjaxActionsFactory */
	private $Factory;

	public function __construct(AjaxActionsFactory $Factory) {
		$this->Factory = $Factory;
	}

	public function checkActions() {
		$this->loadData();

		if (empty($this->data['action'])) {
			return;
		}

		$this->runAction();
	}

	private function loadData() {
		$requestBody = file_get_contents('php://input');

		if (!empty($requestBody)) {
			$this->data = json_decode($requestBody, true);
		} elseif(ArrayFunctions::isArrayAndHasItems($_REQUEST)) {
			$this->data = $_REQUEST;
		}
	}

	private function runAction() {
		try {
			$AjaxAction = $this->Factory->getAction($this->data['action']);
			$AjaxAction
				->assignData($this->data['data'])
				->run();
		} catch (AjaxActionNotFoundException $Exception) {
			echo 'ERROR: ' . $Exception->getMessage();
		}
	}
}
