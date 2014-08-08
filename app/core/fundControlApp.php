<?php
session_start();

// ================= initialization =================

require_once $rootDir . '../vendor/autoload.php';

$kint = 'C:/xampp/htdocs/_pomocne/_kint.php';
if (file_exists($kint)) {
	@require_once $kint;
}


// Nette RobotLoader autoloading
$Loader = new Nette\Loaders\RobotLoader;
$Loader->addDirectory($rootDir . 'libs/');
$Loader->setCacheStorage(new Nette\Caching\Storages\FileStorage($rootDir . 'cache'));
$Loader->register();

$ServiceFactory = new ServiceFactory($rootDir);

$FundControl = $ServiceFactory->getServiceByName('FundControl');
/* @var $FundControl Fundcontrol */

// ================= process requests =================

$MainController = $ServiceFactory->getServiceByName('MainController');
/* @var $MainController MainController */
$MainController->checkActions();

$AjaxController = $ServiceFactory->getServiceByName('AjaxController');
/* @var $AjaxController AjaxController */
$AjaxController->checkActions();
