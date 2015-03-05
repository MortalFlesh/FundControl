<?php

class AjaxActionGetUserTabs implements IAjaxAction {

	/** @var JsonPrinter */
	private $JsonPrinter;

	private $data;

	public function __construct(JsonPrinter $JsonPrinter) {
		$this->JsonPrinter = $JsonPrinter;
	}

	public function assignData($data) {
		$this->data = $data;
		return $this;
	}

	public function run() {
		if (empty($this->data['tabName'])) {
			throw new AjaxActionGetUserTabsException('empty tab name!');
		}

		switch($this->data['tabName']) {
			case 'month': $data = $this->buildMonthData(); break;
			default: throw new AjaxActionGetUserTabsException('wrong tab name!');
		}

		$this->JsonPrinter->printAsJsonAndDie([
			'tabName' => $this->data['tabName'],
			'tabData' => $data,
		]);
	}

	private function buildMonthData() {
		$totalGained = 23000;
		$totalSpent = 20 + 10;
		
		$status = 'red';
		if ($totalGained / 2 > $totalSpent) {
			$status = 'green';
		} elseif ($totalGained > $totalSpent) {
			$status = 'orange';
		}

		return [
			'gains' => [
				[
					'name' => 'vyplata',
					'amount' => '23000',
					'type' => 'vyplata',
				],
			],
			'items' => [
				[
					'name' => 'rohliky',
					'amount' => '20',
					'type' => 'jidlo',
				],
				[
					'name' => 'jogurt',
					'amount' => '10',
					'type' => 'jidlo',
				],
			],
			'balance' => [
				'totalGained' => $totalGained,
				'totalSpent' => $totalSpent,
				'totalBalance' => ($totalGained - $totalSpent),
				'status' => $status,
			],
		];
	}

}
