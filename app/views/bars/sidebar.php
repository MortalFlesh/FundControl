<?php
$rootDir = __DIR__ . '/../../';
require_once $rootDir . 'core/fundControlApp.php';
/* @var $FundControl FundControl */
?>
<h1 class="app-name"><?=$FundControl->getTitle()?></h1>

<div class="scrollable sidebar-scrollable">
	<div class="scrollable-content">
		<div class="list-group" toggle="off" bubble target="mainSidebar">
			<a class="list-group-item" href="#/">Home <i class="fa fa-chevron-right pull-right"></i></a>
			<?
			if ($FundControl->isLogged()) {
				?>
				<a class="list-group-item" href="#/addItem">Add Item <i class="fa fa-chevron-right pull-right"></i></a>
				<a class="list-group-item" href="#/userInfo">User Info <i class="fa fa-chevron-right pull-right"></i></a>
				<a class="list-group-item" href="#/items">Items <i class="fa fa-chevron-right pull-right"></i></a>
				<a class="list-group-item" href="#/itemTypes">Item Types <i class="fa fa-chevron-right pull-right"></i></a>
				<?
			}
			?>
		</div>
	</div>
</div>
