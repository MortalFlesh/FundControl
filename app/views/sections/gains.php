<?php
$rootDir = __DIR__ . '/../../';
require_once $rootDir . 'core/fundControlApp.php';
/* @var $FundControl FundControl */

$FundControl->requireLogin();
?>
<div content-for="title">
	<span>Gains</span>
</div>

<input type="search" class="form-control app-search" placeholder="Search.." ng-model="searchGains" />

<div class="scrollable">
	<div class="scrollable-content">
		<accordion close-others="oneAtATime">
			<accordion-group ng-repeat="gain in gains | filter:searchGains" is-open="status.open" class="list-group" ng-class="{'list-group-opened': status.open}">
				<accordion-heading>
					<a href="#" class="list-group-item" ng-class="{'list-group-item-opened': status.open, 'list-group-item-closed': !status.open}">
						{{gain.getName()}} <i class="pull-right glyphicon fa" ng-class="{'fa-chevron-down': status.open, 'fa-chevron-right': !status.open}"></i>
					</a>
				</accordion-heading>
				<strong>Amount:</strong>{{gain.getAmount()}} | <strong>Type:</strong>{{gain.getGainType().getName()}}
			</accordion-group>
		</accordion>
	</div>
</div>