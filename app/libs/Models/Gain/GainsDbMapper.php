<?php

class GainsDbMapper {
	/** @var Database */
	private $Db;

	/** @param Database $Db */
	public function __construct(Database $Db) {
		$this->Db = $Db;
	}

	/**
	 * @param Gain $Gain
	 * @param int $userId
	 */
	public function saveGain(Gain $Gain, $userId) {
		$gainData = $Gain->serialize();
		$Time = $Gain->getCreatedTime();

		$this->Db->query("INSERT INTO `" . $this->Db->getPrefix() . "gains` (`user_id`, `gain_data`, `time`) VALUES
			('" . (int)$userId . "', '" . $this->Db->escape($gainData) . "', '" . $Time->format(Database::TIME_FORMAT) . "')");
	}
}
