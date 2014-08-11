<?php

class Config {
	private $config = array(
		'db' => array(
			'host' => 'localhost',
			'user' => 'root',
			'password' => '',
			'database' => 'fundcontrol',
			'encoding' => 'utf8'
		),
		'homeUrl' => 'http://fundcontrol/app/',
		'htmlTitle' => 'FundControl',
		'debug' => false,
	);

	public function getDbConfig() {
		return $this->config['db'];
	}

	public function getHomeUrl() {
		return $this->config['homeUrl'];
	}

	public function isDebug() {
		return ($this->config['debug'] === true);
	}

	public function getHtmlTitle() {
		return $this->config['htmlTitle'];
	}
}
