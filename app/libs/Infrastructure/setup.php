<?php

class Setup {
	/** @var Database */
	private $Db;

	/** @var Config */
	private $Config;

	/** @var MigrationRepository */
	private $MigrationLoader;

	/**
	 * @param Database $Db
	 * @param Config $Config
	 * @param MigrationRepository $MigrationLoader
	 */
	public function __construct(Database $Db, Config $Config, MigrationRepository $MigrationLoader) {
		$this->Db = $Db;
		$this->Config = $Config;

		$this->MigrationLoader = $MigrationLoader;
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

		$this->Db->query("CREATE TABLE IF NOT EXISTS `" . $this->Config->getPrefix() . "installed_migrations` (
			`id` int(11) NOT NULL COMMENT 'id of migration - timestamp',
			`time_installed` datetime NOT NULL COMMENT 'time of the migration install',
			PRIMARY KEY (`id`)
		  ) ENGINE=MyISAM DEFAULT CHARSET=utf8");

		$this->installMigrations();
	}

	private function installMigrations() {
		$migrationsToInstall = $this->MigrationLoader->loadMigrationsToInstall();
		
		foreach($migrationsToInstall as $Migration) {
			$this->installMigration($Migration);
		}
	}

	private function installMigration(Migration $Migration) {
		$Migration->up();
		
		$this->Db->query("INSERT INTO `" . $this->Config->getPrefix() . 'installed_migrations`
			(`id`, `time_installed`) VALUES
			(' . $Migration->getId() . ', "' . (new DateTime())->format(Database::TIME_FORMAT) . '")');
	}

	private function uninstallMigration(Migration $Migration) {
		$Migration->down();
	}
}
