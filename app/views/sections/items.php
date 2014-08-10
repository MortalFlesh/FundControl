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
		<accordion close-others="oneAtATime">
			<accordion-group ng-repeat="item in items | filter:searchItems" is-open="status.open" class="list-group" ng-class="{'list-group-opened': status.open}">
				<accordion-heading>
					<a href="#" class="list-group-item" ng-class="{'list-group-item-opened': status.open, 'list-group-item-closed': !status.open}">
						{{item.getName()}} <i class="pull-right glyphicon fa" ng-class="{'fa-chevron-down': status.open, 'fa-chevron-right': !status.open}"></i>
					</a>
				</accordion-heading>
				<strong>Amount:</strong>{{item.getAmount()}} | <strong>Type:</strong>{{item.getItemType().getName()}}
			</accordion-group>
		</accordion>
	</div>
</div>