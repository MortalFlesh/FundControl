<?php
$rootDir = __DIR__ . '/';
require_once $rootDir . 'core/fundControlApp.php';
/* @var $FundControl FundControl */

$JavascriptAutoloader = new JavascriptAutoloader();
?>
<!doctype html>
<html lang="cs">
	<head>
		<meta charset="utf-8" />
		<base href="/app/" />
		<title><?=$FundControl->getTitle()?></title>

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimal-ui" />
		<meta name="apple-mobile-web-app-status-bar-style" content="yes" />
		<meta name="apple-mobile-web-app-title" content="Fund Control">
		<link rel="apple-touch-icon" href="<?=$FundControl->getHomeUrl()?>imgs/logo.png">
		<link rel="shortcut icon" href="<?=$FundControl->getHomeUrl()?>imgs/favicon.png" type="image/x-icon" />
		<link rel="stylesheet" href="<?=$FundControl->getHomeUrl()?>../dist/css/mobile-angular-ui-hover.min.css" />
		<link rel="stylesheet" href="<?=$FundControl->getHomeUrl()?>../dist/css/mobile-angular-ui-base.min.css" />
		<link rel="stylesheet" href="<?=$FundControl->getHomeUrl()?>../dist/css/mobile-angular-ui-desktop.min.css" />
		<link rel="stylesheet" href="<?=$FundControl->getHomeUrl()?>styles/app.css" />
		<link rel="stylesheet" href="<?=$FundControl->getHomeUrl()?>styles/style.css" />

		<script type="text/javascript">
			var homeUrl = '<?=$FundControl->getHomeUrl()?>';
		</script>
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.15/angular.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.15/angular-route.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.15/angular-touch.min.js"></script>
		<script src="<?=$FundControl->getHomeUrl()?>../dist/js/mobile-angular-ui.min.js"></script>
		<?
		$JavascriptAutoloader
			->setHomeUrl($FundControl->getHomeUrl())
			->setRootDir($rootDir)
			->addDirectory('scripts')
			->addDirectory('scripts/models')
			->addDirectory('scripts/services')
			->addDirectory('scripts/directives')
			->addDirectory('scripts/controllers')
			->autoload();
		?>
	</head>
	<body ng-app="FundControlApp" ng-controller="MainController">

		<!-- Sidebars -->
		<div ng-include="'<?=$FundControl->getHomeUrl()?>views/bars/sidebar.php'" class="sidebar sidebar-left" toggleable parent-active-class="sidebar-left-in" id="mainSidebar"></div>

		<div ng-include="'<?=$FundControl->getHomeUrl()?>views/bars/sidebarRight.php'" class="sidebar sidebar-right" toggleable parent-active-class="sidebar-right-in" id="rightSidebar"></div>

		<div class="app">
			<!-- Top Navbar -->
			<div class="navbar navbar-app navbar-absolute-top">
				<div class="navbar-brand navbar-brand-center" yield-to="title">
					<span><?=$FundControl->getTitle()?></span>
				</div>
				<div class="btn-group pull-left">
					<div ng-click="toggle('mainSidebar')" class="btn btn-navbar sidebar-toggle">
						<i class="fa fa-bars"></i> Menu
					</div>
				</div>
				<?
				if ($FundControl->isLogged()) {
					$FundControl->view('userPanel');
				}
				?>
			</div>

			<!-- Bottom Navbar -->
			<div class="navbar navbar-app navbar-absolute-bottom">
				<div class="btn-group justified">
					<a href="#" class="btn btn-navbar"><i class="fa fa-home fa-navbar"></i> ?</a>
					<a href="#" class="btn btn-navbar"><i class="fa fa-github fa-navbar"></i> ?</a>
					<a href="#" class="btn btn-navbar"><i class="fa fa-exclamation-circle fa-navbar"></i> ?</a>
				</div>
			</div>

			<!-- App Body -->
			<div class="app-body" ng-class="{loading: loading}">
				<div ng-show="loading" class="app-content-loading">
					<i class="fa fa-spinner fa-spin loading-spinner"></i>
				</div>

				<?
				$FundControl->view('flashes');
				$FundControl->view('flashesServer');
				?>

				<ng-view class="app-content" ng-hide="loading"></ng-view>
			</div>
		</div>
	</body>
</html>
