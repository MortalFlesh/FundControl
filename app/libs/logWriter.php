<?php

class LogWriter {
	const ENABLED = true;
	const DISABLED = false;

	private $file, $enabled;

	/**
	 * @param string $file
	 * @param int $max_log_size
	 * @param bool $enabled
	 */
	public function __construct($file, $max_log_size = null, $enabled = self::ENABLED) {
		$this->enabled = $enabled;
		if ($this->enabled) {
			$this->open($file, $max_log_size);
		}
	}

	/**
	 * Otevře log soubor v módu append.
	 *
	 * @param $filename název souboru
	 * @param $max_log_size maximální velikost souboru (před rotací)
	 * @return bool
	 */
	public function open($filename, $max_log_size = 1024000) {
		$this->rotateLog($filename, $max_log_size);

		$this->file = @fopen($filename, "a");
		if ($this->file === false) {
			$this->file = null;
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Pokud je log soubor větší než MAX_LOG_SIZE, tak log zabalí gzipem a uloží
	 * do zálohy. Uchovává se pouze 1 záloha
	 */
	private function rotateLog($filename, $max_log_size) {
		if (file_exists($filename) && (filesize($filename) > $max_log_size)) {
			$this->gzip($filename, $filename . '.gz');
			unlink($filename);
		}
	}

	/**
	 * Komprese souborů gzipem
	 *
	 * @param string $in
	 * @param string $out
	 * @return bool
	 */
	private function gzip($in, $out)	{
		if (!extension_loaded('zlib')) {
			return false;
		}

		if (!file_exists($in) || !is_readable($in)) {
			return false;
		}

		if ((!file_exists($out) && !is_writable(dirname($out)) || (file_exists($out) && !is_writable($out)) )) {
			return false;
		}

		$in_file = fopen($in, "rb");
		if (!$out_file = gzopen($out, "wb9")) {
			return false;
		}

		while (!feof($in_file)) {
			$buffer = fgets ($in_file, 4096);
			gzwrite ($out_file, $buffer, 4096);
		}

		fclose ($in_file);
		gzclose ($out_file);
		return true;
	}

	/**
	 * Zapíše řetězec do souboru spolu s aktuálním datem a časem
	 *
	 * @param $str řetězec k zápisu
	 * @return string
	 */
	public function write($str) {
		$out = '';
		if ($this->file != null && $this->enabled) {
			$out = date("Y-m-d H:i:s") . ": $str\n";
			fputs($this->file, $out);
			fflush($this->file);
		}
		return $out;
	}

	/**
	 * Zavře otevřený log soubor
	 */
	public function close() {
		if ($this->file != null) {
			fclose($this->file);
			$this->file = null;
		}
	}
}
