<?php

class GainTypesService {

	/**
	 * @param string $gainTypeName
	 * @return GainType
	 */
	public function createNewType($gainTypeName) {
		return new GainType($gainTypeName);
	}
}
