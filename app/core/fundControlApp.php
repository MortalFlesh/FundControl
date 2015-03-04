<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

// ================= initialization =================

require_once $rootDir . '../vendor/autoload.php';

// Nette RobotLoader autoloading
$Loader = new Nette\Loaders\RobotLoader;
$Loader->addDirectory($rootDir . 'libs/');
$Loader->setCacheStorage(new Nette\Caching\Storages\FileStorage($rootDir . 'cache'));
$Loader->register();

$ServiceFactory = new ServiceFactory($rootDir);

$FundControl = $ServiceFactory->getServiceByName('FundControl');
/* @var $FundControl Fundcontrol */

// ================= process requests =================

$initMainController = (isset($withoutMainController) && $withoutMainController === true ? false : true);

if ($initMainController) {
    $MainController = $ServiceFactory->getServiceByName('MainController');
    /* @var $MainController MainController */
    $MainController->checkActions();
}
