<?php
session_start();

// ================= initialization =================

require_once $rootDir . '../vendor/autoload.php';

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
