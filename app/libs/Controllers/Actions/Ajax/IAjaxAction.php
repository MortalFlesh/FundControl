<?php

interface IAjaxAction {
	/**
	 * @param string $data
	 * @return IAjaxAction
	 */
	function assignData($data);
	function run();
}
