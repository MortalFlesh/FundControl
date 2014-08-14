<?php

class ServiceFactory {
	private $rootDir;
	private $servicesCache = array();

	/** @param string $rootDir */
	public function __construct($rootDir) {
		$this->rootDir = $rootDir;
	}

	/** @return ServiceFactory */
	private function getServiceFactory() {
		return $this;
	}

	/** @return Config */
	private function getConfig() {
		return new Config($this->rootDir);
	}

	/** @return LogWriter */
	private function getLogWriter() {
		$Config = $this->getConfig();

		$LogWriter = new LogWriter(
			$Config->getRootDir() . 'logs/log.log',
			10024000,
			($Config->isDebug() ? LogWriter::ENABLED : LogWriter::DISABLED)
		);
		return $LogWriter;
	}

	/**
	 * @param string $serviceName
	 * @return object<ServiceType>
	 * @throws ServiceNotFoundException
	 */
	public function getServiceByName($serviceName) {
		if (isset($this->servicesCache[$serviceName])) {
			$Service = $this->servicesCache[$serviceName];
		} elseif(method_exists($this, 'get' . $serviceName)) {
			$Service = $this->{'get' . $serviceName}();
		} elseif (class_exists($serviceName, $autoload = true)) {
			$ReflectionClass = new ReflectionClass($serviceName);
			$constructor = $ReflectionClass->getConstructor();

			if (is_null($constructor)) {
				$Service = new $serviceName();
			} else {
				$Service = $ReflectionClass->newInstanceArgs(Helpers::autowireArguments($constructor, $this));
			}
		}

		if (isset($Service)) {
			$this->servicesCache[$serviceName] = $Service;
			return $Service;
		} else {
			throw new ServiceNotFoundException($serviceName);
		}
	}
}
