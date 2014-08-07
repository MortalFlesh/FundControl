<?php
$rootDir = __DIR__ . '/../../';
require_once $rootDir . 'core/fundControlApp.php';
/* @var $FundControl FundControl */
?>
<div content-for="title">
	<span><?=$FundControl->getTitle()?> / Items</span>
</div>

<input type="search" class="form-control app-search" placeholder="Search.." />

<div class="scrollable">
	<div class="scrollable-content">
		<div class="list-group">
			<a ng-repeat="item in scrollItems" href="#" class="list-group-item">
				{{ item}} <i class="fa fa-chevron-right pull-right"></i>
			</a>
		</div>
	</div>
</div>