<?php

class Setup {
	const PREFIX = 'fundcontrol_';

	/** @var Database */
	private $Db;

	public function __construct(Database $Db) {
		$this->Db = $Db;
	}

	public function install() {
		$this->Db->query("CREATE TABLE IF NOT EXISTS `" . self::PREFIX . "items` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`user_id` int(11) NOT NULL,
			`item_data` text NOT NULL,
			`time` datetime NOT NULL,
			PRIMARY KEY (`id`)
		  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8");

		$this->Db->query("CREATE TABLE IF NOT EXISTS `" . self::PREFIX . "item_types` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(100) NOT NULL,
			PRIMARY KEY (`id`)
		  ) ENGINE=MyISAM DEFAULT CHARSET=utf8");

		$this->Db->query("CREATE TABLE IF NOT EXISTS `" . self::PREFIX . "users` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`login` varchar(100) NOT NULL,
			`password` varchar(100) NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `login` (`login`)
		  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8");
	}
}
