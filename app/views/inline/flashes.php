<?php
/* @var $FundControl FundControl */
?>
<div id="flash-container" ng-show="flashes">
	<div ng-repeat="FlashMessage in flashes" class="flash {{FlashMessage.getType()}}">
		{{FlashMessage.getMessage()}}
	</div>
</div>
<?