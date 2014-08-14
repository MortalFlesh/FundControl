<?php

interface IAction {
	/**
	 * @param string $data
	 * @return IAction
	 */
	function assignData($data);
	function run();
}
