<?php

class Database {
	const TIME_FORMAT = 'Y-m-d H:i:s';

	private $connection, $lastQuery;
    private $host, $user, $password, $database, $encoding;

	/** @var LogWriter */
	private $Log;

	/** @var Config */
	private $Config;

	public function __construct(Config $Config, LogWriter $Log) {
        $this->Config = $Config;
        $this->Log = $Log;

        $dbConfig = $this->Config->getDbConfig();
        $this->host = $dbConfig['host'];
        $this->user = $dbConfig['user'];
        $this->password = $dbConfig['password'];
        $this->database = $dbConfig['database'];
        $this->encoding = $dbConfig['encoding'];
    }

    private function connect(){
        if (isset($this->connection)) {
            return;
        }
        $this->connection = mysql_connect($this->host, $this->user, $this->password);

        if ($this->connection === false) {
            $this->log('connectoion false');
            exit;
        }

        $this->query("USE `{$this->database}`");

        if (!empty($this->encoding)) {
            $this->query("SET NAMES {$this->encoding}");
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
        $this->connect();
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
        return $string;
		return mysql_real_escape_string($string, $this->connection);
	}

	public function lastInsertedId() {
		return mysql_insert_id($this->connection);
	}

	public function getPrefix() {
		return $this->Config->getPrefix();
	}
}
