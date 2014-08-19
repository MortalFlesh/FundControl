<?php

class Setup {
	/** @var Database */
	private $Db;

	/** @var Config */
	private $Config;

	public function __construct(Database $Db, Config $Config) {
		$this->Db = $Db;
		$this->Config = $Config;
	}

	public function install() {
		$this->Db->query("CREATE TABLE IF NOT EXISTS `" . $this->Config->getPrefix() . "items` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`user_id` int(11) NOT NULL,
			`item_data` text NOT NULL,
			`time` datetime NOT NULL,
			PRIMARY KEY (`id`)
		  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8");

		$this->Db->query("CREATE TABLE IF NOT EXISTS `" . $this->Config->getPrefix() . "item_types` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(100) NOT NULL,
			PRIMARY KEY (`id`)
		  ) ENGINE=MyISAM DEFAULT CHARSET=utf8");

		$this->Db->query("CREATE TABLE IF NOT EXISTS `" . $this->Config->getPrefix() . "users` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`login` varchar(100) NOT NULL,
			`password` varchar(100) NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `login` (`login`)
		  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8");
	}
}
