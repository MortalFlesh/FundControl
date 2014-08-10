<?php
$rootDir = __DIR__ . '/../../';
require_once $rootDir . 'core/fundControlApp.php';
/* @var $FundControl FundControl */
?>
<div content-for="title">
	<span><?=$FundControl->getTitle()?> / Item Types</span>
</div>

<input type="search" class="form-control app-search" placeholder="Search.." ng-model="searchItemType" />

<div class="scrollable">
	<div class="scrollable-content">
		<accordion close-others="oneAtATime" class="panel-body-no-padding">
			<accordion-group ng-repeat="type in itemTypes | filter:searchItemType" is-open="status.open" class="list-group" ng-class="{'list-group-opened': status.open}">
				<accordion-heading>
					<a href="#" class="list-group-item" ng-class="{'list-group-item-opened': status.open, 'list-group-item-closed': !status.open}">
						{{type.getName()}} <i class="pull-right glyphicon fa" ng-class="{'fa-chevron-down': status.open, 'fa-chevron-right': !status.open}"></i>
					</a>
				</accordion-heading>

				<div class="list-group-empty" ng-hide="filteredItems.length">This type does not have any items added yet.</div>
				<div class="list-group">
					<a href="#" class="list-group-item"
						ng-repeat="item in filteredItems = (items | filter:{ itemTypeId: type.id})"
					>
						<strong>Name:</strong><span class="ng-scope">{{item.getName()}}</span> |
						<strong>Amount:</strong><span class="ng-scope">{{item.getAmount()}}</span>
					</a>
				</div>
			</accordion-group>
		</accordion>
	</div>
</div>
