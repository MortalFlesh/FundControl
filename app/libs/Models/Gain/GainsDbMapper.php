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

	/**
	 * @param int $userId
	 * @return Gain[]
	 */
	public function loadGains($userId) {
		$res = $this->Db->query("SELECT `gain_data`, `time`
			FROM `" . $this->Db->getPrefix() . "gains`
			WHERE `user_id` = " . (int)$userId);

		return $this->fetchAsGains($res);
	}

	/**
	 * @param resource $resource
	 * @return Gain[]
	 */
	private function fetchAsGains($resource) {
		$gains = [];
		while($row = $this->Db->fetchAssoc($resource)) {
			$gainData = json_decode($row['gain_data'], true);

			$Gain = new Gain(
				$row['name'],
				new GainType(
					$gainData['gainType']['name'],
					$gainData['gainType']['id']
				),
				$row['amount'],
				\DateTime::createFromFormat(Database::TIME_FORMAT, $row['time'])
			);

			$gains[$row['id']] = $Gain;
		}
		return $gains;
	}
}
