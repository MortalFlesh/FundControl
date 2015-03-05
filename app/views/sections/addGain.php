<?php
$rootDir = __DIR__ . '/../../';
require_once $rootDir . 'core/fundControlApp.php';
/* @var $FundControl FundControl */

$FundControl->requireLogin();

$Render = new FundFormRender();
?>
<div content-for="title">
	<span>Add Gain</span>
</div>

<div id="add-gain" class="scrollable">
	<div class="scrollable-content section">

		<form name="newGainForm" ng-controller="newGainController">

			<div bs-panel title="New Gain">
				<?
				$Render
					->renderTextModel('addingGain.name', 'Name', 'name', 'gain name')
					->renderSelectModel(
						'addingGain.gainType',
						'Type',
						'type',
						'gainType.getName() for gainType in gainTypes',
						'ng-change="newGainTypeCheck(gainType)"'
					)
					->renderCustom(function() use ($Render) {
						?>
						<div ng-show="addingGain.addNewGain">
							<?
							$Render->renderTextModel('addingGain.newTypeName', 'New', 'newGainType', 'New gain type name');
							?>
						</div>
						<?
					})
					->renderNumberModel('addingGain.amount', 'Amount', 'amount', 'amount')
					->renderSubmitModel('Add Gain', 'save', 'saveNewGain()');
				?>
			</div>
		</form>

	</div>
</div>