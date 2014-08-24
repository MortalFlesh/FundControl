<?php

class JAPrinter {
	private $baseUrl;
	private $cacheAllowed = true;

	public function __construct($baseUrl) {
		if (substr($baseUrl, -1) !== '/') {
			$baseUrl .= '/';
		}
		$this->baseUrl = $baseUrl;
	}

	public function denyCache() {
		$this->cacheAllowed = false;
	}

	public function printScripts(array $scripts) {
		foreach($scripts as $scriptFileName) {
			$this->printScript($scriptFileName);
		}
	}

	public function printScript($scriptFileName) {
		$scriptUrl = $this->baseUrl . $scriptFileName;

		if (!$this->cacheAllowed) {
			$scriptUrl .= '?t=' . time();
		}
		?><script type="text/javascript" src="<?=$scriptUrl?>"></script><?
	}
}
