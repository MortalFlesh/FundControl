<?php

class Helpers {

	/**
	 * @param ReflectionFunctionAbstract $Constructor
	 * @param ServiceFactory $ServiceFactory
	 * @return array
	 * @throws ReflectionException
	 */
	public static function autowireArguments(ReflectionFunctionAbstract $Constructor, ServiceFactory $ServiceFactory) {
		$res = [];
		foreach ($Constructor->getParameters() as $Parameter) {	/* @var $Parameter ReflectionParameter */
			$className = $Parameter->getClass()->name;
			$Service = $ServiceFactory->getServiceByName($className);
			$res[] = $Service;
		}
		return $res;
	}
}
