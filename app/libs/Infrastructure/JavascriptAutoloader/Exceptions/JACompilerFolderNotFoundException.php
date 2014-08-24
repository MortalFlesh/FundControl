<?

class JACompilerFolderNotFoundException extends Exception implements JACompilerException {
	public function __construct($folderName, Exception $Previous = null) {
		parent::__construct('Cache folder (' . $folderName . ') not found!', 0, $Previous);
	}

}
