<?php
$rootDir = __DIR__ . '/../../';
require_once $rootDir . 'core/fundControlApp.php';
/* @var $FundControl FundControl */
?>
<div content-for="title">
	<span><?=$FundControl->getTitle()?> / Items</span>
</div>

<input type="search" class="form-control app-search" placeholder="Search.." ng-model="searchItems" />

<div class="scrollable">
	<div class="scrollable-content">
		<div class="list-group">
			<a ng-repeat="item in items | filter:searchItems" href="#" class="list-group-item">
				{{item.getName()}} <i class="fa fa-chevron-right pull-right"></i>
			</a>
		</div>
	</div>
</div>