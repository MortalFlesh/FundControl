<?php

class Migration_1 extends Migration {
	public function getId() {
		return 1;
	}

	public function up() {
		$this->Db->query("CREATE TABLE IF NOT EXISTS `" . $this->Db->getPrefix() . "gains` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`user_id` int(11) NOT NULL,
			`gain_data` text NOT NULL,
			`time` datetime NOT NULL,
			PRIMARY KEY (`id`)
		  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8");

		$this->Db->query("CREATE TABLE IF NOT EXISTS `" . $this->Db->getPrefix() . "gain_types` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(100) NOT NULL,
			PRIMARY KEY (`id`)
		  ) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	}

	public function down() {
		$this->Db->query("DROP TABLE `" . $this->Db->getPrefix() . "gains`");
		$this->Db->query("DROP TABLE `" . $this->Db->getPrefix() . "gain_types`");
	}

}