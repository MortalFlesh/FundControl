<?php
session_start();

// ================= initialization =================

require_once $rootDir . '../vendor/autoload.php';
require_once $rootDir . 'core/config.php';

if ($config['debug']) {
	$kint = 'C:/xampp/htdocs/_pomocne/_kint.php';
	if (file_exists($kint)) {
		require_once $kint;
	}
}

$Log = new LogWriter($rootDir. 'logs/log.log', 10024000, ($config['debug'] ? LogWriter::ENABLED : LogWriter::DISABLED));

$Db = new Database(
	$config['db']['host'],
	$config['db']['user'],
	$config['db']['password'],
	$config['db']['database'],
	$config['db']['encoding'],
	$Log
);

$Session = new FundSession();

$FundControl = new FundControl($config['homeUrl'], $rootDir, $Db, $Session);

// ================= process requests =================

if (isset($_POST['save'])) {
	$FundControl
		->assignData($_POST)
		->saveItemForm();
} elseif(isset($_POST['authorize'])) {
	$FundControl
		->assignData($_POST)
		->authorize();
} elseif(isset($_GET['logout'])) {
	$FundControl->logout();
} elseif (isset($_GET['new_user']) && $_GET['new_user'] == 'efa33KFJ41AD3efes') {
	$userName = $_GET['name'];
	$password = $_GET['pass'];
	$FundControl->newUser($userName, $password);
} elseif (isset($_GET['setup']) && $_GET['setup'] == 'fejkA8Dwas7ADW7A88') {
	$Setup = new Setup($Db);
	$Setup->install();

	$FundControl
		->flashSuccess('Installed')
		->reload();
} elseif (isset($_GET['info']) && $_GET['info'] == 'afej8183fakkjfa') {
	/*
	$res = $Db->query("SELECT * FROM `" . Setup::PREFIX . "users`");
	while($row = $Db->fetchAssoc($res)) {
		var_dump($row);
	}
	//*/
}