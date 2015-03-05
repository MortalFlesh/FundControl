<?php

class JACompiler {
	/** @var JAMinify */
	private $Minify;

	private $rootDir, $cacheFolderPath;
	private $scripts = [];
	private $compiledScriptName = '';
	private $cacheAllowed = true;

	/**
	 * @param string $cacheFolderPath
	 * @throws JACompilerFolderNotFoundException
	 */
	public function __construct($rootDir, $cacheFolderPath) {
		$this->rootDir = $rootDir;

		if (empty($cacheFolderPath) || !file_exists($this->rootDir . $cacheFolderPath)) {
			throw new JACompilerFolderNotFoundException($cacheFolderPath);
		}

		$cacheFolderPath = str_replace('\\', '/', $cacheFolderPath);
		if (substr($cacheFolderPath, -1) !== '/') {
			$cacheFolderPath .= '/';
		}
		$this->cacheFolderPath = $cacheFolderPath;
	}

	public function setScripts(array $scripts) {
		$this->scripts = $scripts;
		return $this;
	}

	public function denyCache() {
		$this->cacheAllowed = false;
	}

	public function setMinify(JAMinify $JAMinify) {
		$this->Minify = $JAMinify;
		return $this;
	}

	public function compileToOneFile() {
		$this->generateScriptName();

		if (!$this->cacheAllowed || !$this->compiledFileExists()) {
			$this->compileScripts();
		}
			
		return $this;
	}

	private function generateScriptName() {
		$this->compiledScriptName = 'script';

		if (isset($this->Minify)) {
			$this->compiledScriptName .= '-min';
		}
		return $this;
	}

	private function compiledFileExists() {
		$scripFile = $this->getScriptFullPath();
		return file_exists($scripFile);
	}

	private function getScriptFullPath() {
		return $this->rootDir . $this->getCompiledScriptPath();
	}

	private function compileScripts() {
		$scriptContents = '';
		foreach($this->scripts as $script) {
			$scriptContents .= file_get_contents($this->rootDir . $script) . ';';
		}

		if (isset($this->Minify)) {
			$scriptContents = $this->Minify->minify($scriptContents);
		}

		$scriptFile = $this->getScriptFullPath();
		file_put_contents($scriptFile, $scriptContents);

		return $this;
	}

	public function getCompiledScriptPath() {
		return $this->cacheFolderPath . $this->compiledScriptName . JavascriptAutoloader::EXTENSION;
	}

}
