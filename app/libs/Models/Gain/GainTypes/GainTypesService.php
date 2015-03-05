<?php

class GainTypesService {

	/**
	 * @param string $gainTypeName
	 * @return GainType
	 */
	public function createNewType($gainTypeName) {
		return new GainType($gainTypeName);
	}

	/** @param GainType[] $types */
	public function serializeTypes(array $types) {
		$serialized = [];
		foreach($types as $GainType) {
			$serialized[] = $GainType->serialize();
		}
		return $serialized;
	}

	/**
	 * @param int $id
	 * @param string $name
	 * @return GainType
	 */
	public function createGainType($id, $name) {
		return new GainType($name, $id);
	}
}
