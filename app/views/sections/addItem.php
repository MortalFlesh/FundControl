<?php
$rootDir = __DIR__ . '/../../';
require_once $rootDir . 'core/fundControlApp.php';
/* @var $FundControl FundControl */

$Render = new FundFormRender();
?>
<div content-for="title">
	<span><?=$FundControl->getTitle()?> / Add Item</span>
</div>

<div id="add-item" class="scrollable">
	<div class="scrollable-content section">

		<form name="newItemForm" ng-controller="newItemController">

			<div bs-panel title="New Item">
				<?
				$Render
					->renderTextModel('addingItem.name', 'Name', 'name', 'item name')
					->renderSelectModel(
						'addingItem.itemType',
						'Type',
						'type',
						'itemType.getName() for itemType in itemTypes',
						'ng-change="newItemTypeCheck(itemType)"'
					)
					->renderCustom(function() use ($Render) {
						?>
						<div ng-show="addingItem.addNewItem">
							<?
							$Render->renderTextModel('addingItem.newTypeName', 'New Type', 'newItemType', 'New item type name');
							?>
						</div>
						<?
					})
					->renderNumberModel('addingItem.amount', 'Amount', 'amount', 'amount')
					->renderSubmitModel('Add Item', 'save', '');
				?>
			</div>
		</form>

	</div>
</div>