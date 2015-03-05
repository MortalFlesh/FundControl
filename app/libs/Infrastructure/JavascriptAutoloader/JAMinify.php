<?php

class JAMinify {
	private $rootDir;

	public function __construct($rootDir) {
		$this->rootDir = $rootDir;
	}

	public function minify($scriptContents) {
		return JSMin::minify($scriptContents);
	}
}
