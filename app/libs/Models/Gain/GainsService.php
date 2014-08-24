<?php

class GainsService {

	/**
	 * @param string $name
	 * @param GainType $Type
	 * @param string $amount
	 * @param \DateTime $CreationTime
	 * @return Gain
	 */
	public function createGain($name, GainType $Type, $amount, \DateTime $CreationTime) {
		return new Gain($name, $Type, $amount, $CreationTime);
	}
}
