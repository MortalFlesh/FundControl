<?php

class MigrationRepository {
	const MIGRATIONS_PATH = 'libs/Infrastructure/Migrations';
	const MIGRATION_START = 'Migration_';

	/** @var Database */
	private $Db;

	/** @var Config */
	private $Config;

	/** @var ServiceFactory */
	private $ServiceFactory;

	/** @var Migration[] */
	private $migrations = [];

	/**
	 * @param Database $Db
	 * @param Config $Config
	 * @param ServiceFactory $ServiceFactory
	 */
	public function __construct(Database $Db, Config $Config, ServiceFactory $ServiceFactory) {
		$this->Db = $Db;
		$this->Config = $Config;
		$this->ServiceFactory = $ServiceFactory;
	}

	/** @return Migration[] */
	public function loadMigrationsToInstall() {
		$this->initMigrations();
		$installedMigrations = $this->loadInstalledMigrations();
		$migrations = $this->getMigrations();
		$migrationsToInstall = [];

		foreach ($migrations as $Migration) {
			if (!in_array($Migration->getId(), $installedMigrations)) {
				$migrationsToInstall[] = $Migration;
			}
		}

		return $migrationsToInstall;
	}

	/** @return array */
	private function loadInstalledMigrations() {
		$installedMigrations = [];

		$res = $this->Db->query('SELECT id FROM `' . $this->Config->getPrefix() . 'installed_migrations`');
		while($row = $this->Db->fetchAssoc($res)) {
			$installedMigrations[$row['id']] = $row['id'];
		}

		return $installedMigrations;
	}

	private function initMigrations() {
		$migrationsPath = $this->Config->getRootDir() . self::MIGRATIONS_PATH;
		foreach(new DirectoryIterator($migrationsPath) as $FileInfo) {
			if ($FileInfo->isDir()) {
				continue;
			}
			
			$fileName = $FileInfo->getFilename();
			if (substr($fileName, 0, strlen(self::MIGRATION_START)) === self::MIGRATION_START) {
				$migrationName = str_replace('.php', '', $fileName);
				$this->registerMigration($migrationName);
			}
		}
	}

	/** @return Migration[] */
	private function getMigrations() {
		return $this->migrations;
	}

	/**
	 * @param string $migration
	 * @throws MigrationNotFoundException
	 */
	public function registerMigration($migration) {
		try {
			$Migration = $this->ServiceFactory->getServiceByName($migration);
			/* @var $Migration Migration */

			$this->migrations[$Migration->getId()] = $Migration;
		} catch (ServiceNotFoundException $Ex) {
			throw new MigrationNotFoundException($migration, $Ex);
		}
	}
}
