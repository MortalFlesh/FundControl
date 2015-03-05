<?php

class JavascriptAutoloader {
	const EXTENSION = '.js';

	/** @var JACompiler */
	private $Compiler;

	/** @var JAMinify */
	private $Minify;

	/** @var JAPrinter */
	private $Printer;

	private $rootDir;

	/** @var JADirInfo[] */
	private $directories = [];

	private $scripts = [];

	private $cacheAllowed = true;

	/** @param JAPrinter $Printer */
	public function __construct(JAPrinter $Printer) {
		$this->Printer = $Printer;
	}

	public function setRootDir($rootDir) {
		$this->rootDir = $rootDir;
		return $this;
	}

	public function setDenyCache() {
		$this->cacheAllowed = false;
		return $this;
	}

	/**
	 * @param JACompiler $Compiler
	 * @return JavascriptAutoloader
	 */
	public function setCompileToOneFile(JACompiler $Compiler) {
		$this->Compiler = $Compiler;
		return $this;
	}

	public function setMinifyOutput(JAMinify $Minify) {
		$this->Minify = $Minify;
		return $this;
	}

	public function addDirectory($directory, $recursively = false) {
		$this->directories[] = new JADirInfo($this->rootDir . $directory, $recursively);
		return $this;
	}

	public function autoload() {
		$this->initScripts();

		if (!$this->cacheAllowed) {
			$this->Printer->denyCache();
		}

		if (isset($this->Compiler)) {
			if (isset($this->Minify)) {
				$this->Compiler->setMinify($this->Minify);
			}
			if (!$this->cacheAllowed) {
				$this->Compiler->denyCache();
			}

			$compiledScript = $this->Compiler
				->setScripts($this->scripts)
				->compileToOneFile()
				->getCompiledScriptPath();

			$this->Printer->printScript($compiledScript);
		} else {
			$this->Printer->printScripts($this->scripts);
		}
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
			$scriptFileName = str_replace([$this->rootDir, '\\'], ['', '/'], $scriptPathName);
			$this->autoloadScript($scriptFileName);
		}
	}

	private function autoloadScript($scriptFileName) {
		$extLen = strlen(self::EXTENSION);
		if (substr($scriptFileName, -$extLen) === self::EXTENSION) {
			$this->scripts[] = $scriptFileName;
		}
	}
}