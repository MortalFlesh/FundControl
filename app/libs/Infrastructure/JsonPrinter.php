<?php

class JsonPrinter {
	/** @param array $data */
	public function printAsJsonAndDie(array $data) {
		echo ArrayFunctions::arrayToJson($data);
		exit;
	}
}
