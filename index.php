<?php
$rootDir = __DIR__ . '/';

require_once $rootDir . 'app/libs/config.php';
$Config = new Config($rootDir);

header('location: ' . $Config->getHomeUrl());
exit;