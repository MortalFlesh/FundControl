<?php

abstract class Migration {
	/** @var Database */
	protected $Db;

	/** @param Database $Db */
	public function __construct(Database $Db) {
		$this->Db = $Db;
	}

	abstract function getId();
	abstract function up();
	abstract function down();
}
