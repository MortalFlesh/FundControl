<?php

class Database {
	const TIME_FORMAT = 'Y-m-d H:i:s';

	private $connection, $lastQuery;

	/** @var LogWriter */
	private $Log;

	public function __construct(Config $Config, LogWriter $Log) {
		$dbConfig = $Config->getDbConfig();
		$host = $dbConfig['host'];
		$user = $dbConfig['user'];
		$password = $dbConfig['password'];
		$database = $dbConfig['database'];
		$encoding = $dbConfig['encoding'];

		$this->connection = mysql_connect($host, $user, $password);
		$this->Log = $Log;

		if ($this->connection === false) {
			$this->log('connectoion false');
			exit;
		}

		$this->query("USE `{$database}`");

		if (!empty($encoding)) {
			$this->query("SET NAMES {$encoding}");
		}
	}

	private function log($msg) {
		$data = array(
			'class' => __CLASS__,
			'data' => $msg
		);
		$this->Log->write(var_export($data, true));
	}

	public function query($sql) {
		$this->lastQuery = $sql;
		$resource = mysql_query($sql, $this->connection);

		$error = mysql_error($this->connection);
		if (!empty($error)) {
			$data = array(
				'Database->query' => 'error',
				'error' => $error,
				'query' => $sql
			);
			$this->Log->write(var_export($data, true));
		}

		return $resource;
	}

	public function fetchAssoc($resource) {
		return ($resource !== false ? mysql_fetch_assoc($resource) : []);
	}

	public function rows($resource) {
		return mysql_num_rows($resource);
	}

	public function queryValue($sql) {
		$resource = $this->query($sql);
		$fetch = $this->fetchAssoc($resource);

		if ($fetch === false) {
			return null;
		}

		return array_shift($fetch);
	}

	public function getLastQuery() {
		return $this->lastQuery;
	}

	public function escape($string) {
		return mysql_real_escape_string($string, $this->connection);
	}

	public function lastInsertedId() {
		return mysql_insert_id($this->connection);
	}
}
