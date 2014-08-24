<?php

class JavascriptAutoloader {
	private $rootDir;

	/** @var JADirInfo[] */
	private $directories = [];

	private $homeUrl;

	private $scripts = [];

	private $cacheAllowed = true;

	public function __construct() {
	}

	public function setHomeUrl($homeUrl) {
		$this->homeUrl = $homeUrl;
		return $this;
	}

	public function setRootDir($rootDir) {
		$this->rootDir = $rootDir;
		return $this;
	}

	public function setDenyCache() {
		$this->cacheAllowed = false;
		return $this;
	}

	public function addDirectory($directory, $recursively = false) {
		$this->directories[] = new JADirInfo($this->rootDir . $directory, $recursively);
		return $this;
	}

	public function autoload() {
		$this->initScripts();
		$this->printScripts();
	}

	private function initScripts() {
		foreach($this->directories as $JADirInfo) {
			$this->autoloadDirectory($JADirInfo);
		}
	}

	private function autoloadDirectory(JADirInfo $JADirInfo) {
		foreach(new DirectoryIterator($JADirInfo->getDirName()) as $FileInfo) {
			if ($FileInfo->isDot() || ($FileInfo->isDir() && !$JADirInfo->getRecursively())) {
				continue;
			} elseif ($FileInfo->isDir() && $JADirInfo->getRecursively()) {
				$this->autoloadDirectory(new JADirInfo($FileInfo->getPathname(), true));
			}

			$scriptPathName = $JADirInfo->getDirName() . '/' . $FileInfo->getFilename();
			$scriptFileName = str_replace($this->rootDir, '', $scriptPathName);
			$this->autoloadScript($scriptFileName);
		}
	}

	private function autoloadScript($scriptFileName) {
		$this->scripts[] = $scriptFileName;
	}

	private function printScripts() {
		foreach($this->scripts as $scriptFileName) {
			$this->printScript($scriptFileName);
		}
	}

	private function printScript($scriptFileName) {
		$scriptUrl = $this->homeUrl . $scriptFileName;
		if (!$this->cacheAllowed) {
			$scriptUrl .= '?t=' . time();
		}
		?><script type="text/javascript" src="<?=$scriptUrl?>"></script><?
	}
}