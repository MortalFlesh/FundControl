<?php

class Config {
	private $config = array(
		'db' => array(
			'host' => 'localhost',
			'user' => 'root',
			'password' => '',
			'database' => 'fundcontrol_dummy',
			'encoding' => 'utf8',
			'prefix' => 'fundcontrol_',
		),
		'homeUrl' => 'http://localhost/FundControl/app/',
		'htmlTitle' => 'FundControl',
		'debug' => true,
		'rootDir' => '',
	);

	/** @param string $rootDir */
	public function __construct($rootDir) {
		$this->config['rootDir'] = $rootDir;
	}

	/** @return array */
	public function getDbConfig() {
		return $this->config['db'];
	}

	/** @return string */
	public function getPrefix() {
		return $this->config['db']['prefix'];
	}

	/** @return string */
	public function getHomeUrl() {
		return $this->config['homeUrl'];
	}

	/** @return bool */
	public function isDebug() {
		return ($this->config['debug'] === true);
	}

	/** @return string */
	public function getHtmlTitle() {
		return $this->config['htmlTitle'];
	}

	/** @return string */
	public function getRootDir() {
		return $this->config['rootDir'];
	}
}
