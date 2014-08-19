<?php

interface IAction {
	/**
	 * @param array $data
	 * @return IAction
	 */
	function assignData($data);
	function run();
}
