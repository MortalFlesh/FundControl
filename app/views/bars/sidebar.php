<?php
$rootDir = __DIR__ . '/../../';
require_once $rootDir . 'core/fundControlApp.php';
/* @var $FundControl FundControl */
?>
<h1 class="app-name"><?=$FundControl->getTitle()?></h1>

<div class="scrollable sidebar-scrollable">
	<div class="scrollable-content">
		<div class="list-group" toggle="off" bubble target="mainSidebar">
			<a class="list-group-item" href="<?=$FundControl->getHomeUrl()?>#/">Home <i class="fa fa-chevron-right pull-right"></i></a>
			<?
			if ($FundControl->isLogged()) {
				?>
				<a class="list-group-item" href="<?=$FundControl->getHomeUrl()?>#/addItem">Add Item <i class="fa fa-chevron-right pull-right"></i></a>
				<a class="list-group-item" href="<?=$FundControl->getHomeUrl()?>#/addGain">Add Gain <i class="fa fa-chevron-right pull-right"></i></a>
				<a class="list-group-item" href="<?=$FundControl->getHomeUrl()?>#/userInfo">User Info <i class="fa fa-chevron-right pull-right"></i></a>
				<a class="list-group-item" href="<?=$FundControl->getHomeUrl()?>#/items">Items <i class="fa fa-chevron-right pull-right"></i></a>
				<a class="list-group-item" href="<?=$FundControl->getHomeUrl()?>#/itemTypes">Item Types <i class="fa fa-chevron-right pull-right"></i></a>
				<a class="list-group-item" href="<?=$FundControl->getHomeUrl()?>#/gains">Gains <i class="fa fa-chevron-right pull-right"></i></a>
				<a class="list-group-item" href="<?=$FundControl->getHomeUrl()?>#/gainTypes">Gain Types <i class="fa fa-chevron-right pull-right"></i></a>
				<?
			}
			?>
		</div>
	</div>
</div>
