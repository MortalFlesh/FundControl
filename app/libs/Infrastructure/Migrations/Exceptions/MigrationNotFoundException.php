<?

class MigrationNotFoundException extends Exception implements MigrationException {
	public function __construct($migration, Exception $Previous = null) {
		parent::__construct('Migration ' . $migration . ' not found!', 0, $Previous);
	}

}
