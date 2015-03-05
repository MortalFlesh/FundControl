<?php
$rootDir = __DIR__ . '/../../';
require_once $rootDir . 'core/fundControlApp.php';
/* @var $FundControl FundControl */

$FundControl->requireLogin();
?>
<div content-for="title">
	<span>User Info</span>
</div>

<div id="user-info" class="scrollable">
	<div class="scrollable-content">
		<div class="section container-fluid">

			<ul class="nav nav-tabs">
				<li><a href="#Month" toggle="on" parent-active-class="active">Month</a></li>
				<li><a href="#All" toggle="on" parent-active-class="active">All</a></li>
				<li><a href="#ByTypes" toggle="on" parent-active-class="active">By types</a></li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane"
					 toggleable
					 active-class="active"
					 default="active"
					 id="Month"
					 exclusion-group="myTabs"
					 ng-include="'<?=$FundControl->getHomeUrl()?>views/inline/userTabs/month.php'"
					 onload="loadUserTabsData('month')">
				</div>

				<div class="tab-pane"
					 toggleable
					 active-class="active"
					 id="All"
					 exclusion-group="myTabs"
					 ng-include="'<?=$FundControl->getHomeUrl()?>views/inline/userTabs/all.php'"
					 onload="loadUserTabsData('all')">
				</div>

				<div class="tab-pane"
					 toggleable
					 active-class="active"
					 id="ByTypes"
					 exclusion-group="myTabs"
					 ng-include="'<?=$FundControl->getHomeUrl()?>views/inline/userTabs/byTypes.php'"
					 onload="loadUserTabsData('byTypes')">
				</div>
			</div>

			<div class="btn-group justified nav-tabs">
				<a class="btn btn-default"
				   href="#Month"
				   toggle="on"
				   active-class="active">Month
				</a>

				<a class="btn btn-default"
				   href="#All"
				   toggle="on"
				   active-class="active">All
				</a>

				<a class="btn btn-default"
				   href="#ByTypes"
				   toggle="on"
				   active-class="active">By types
				</a>

			</div>

		</div>
	</div>
</div>