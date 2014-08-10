<?php
require_once __DIR__ . '/app/libs/config.php';
$Config = new Config();

header('location: ' . $Config->getHomeUrl());
exit;