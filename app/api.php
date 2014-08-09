<?php
$rootDir = __DIR__ . '/';
require_once $rootDir . 'core/fundControlApp.php';
/* @var $FundControl FundControl */

$AjaxController = $ServiceFactory->getServiceByName('AjaxController');
/* @var $AjaxController AjaxController */
$AjaxController->checkActions();
