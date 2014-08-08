<?php

class JADirInfo {
	private $dirName;
	private $recursively;

	public function __construct($dirName, $recursively) {
		$this->dirName = $dirName;
		$this->recursively = ($recursively === true);
	}

	public function getDirName() {
		return $this->dirName;
	}

	public function getRecursively() {
		return $this->recursively;
	}
}
