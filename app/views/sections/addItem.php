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

		<form action="" method="post">

			<div bs-panel title="Invoice">
				<?
				$Render
						//->renderTextModel('invoice.customer', 'Customer', 'customer', 'Customer Name')
						//*/
						->renderTextFieldset('Name', 'name')
						->renderSelectFieldset('Type', 'type', $FundControl->getItemTypes(), array('id="types-select"'))
						->renderCustom(function() {
							?>
							<fieldset class="input-for" id="new-type-container" style="display:none;">
								<legend class="input-for-title">New type</legend>
								<input type="text" name="new_type" value="" disabled="disabled" />
							</fieldset>
							<?
						})
						->renderNumberFieldset('Amount', 'value')
						->renderSubmitFieldset('Add', 'save')
				//*/
				;
				?>

				<input
					bs-form-control

					type="text"
					ng-model="invoice.customer"
					label="Customer"
					label-class="col-xs-3 col-sm-2 col-lg-1"
					class="col-xs-9 col-sm-10 col-lg-11"
					placeholder="Customer Name"
					/>

				<switch
					bs-form-control
					ng-change="switchChanged()"
					ng-model="invoice.payed"
					ng-click="switchClicked()"
					label="Payed"
					label-class="col-xs-3 col-sm-2 col-lg-1"
					class="col-xs-9 col-sm-10 col-lg-11"
					>
				</switch>
				<div class="form-group has-success has-feedback">
					<label class="control-label" for="inputSuccess2">Input with success</label>
					<input type="text" class="form-control" id="inputSuccess2">
					<span class="glyphicon glyphicon-ok form-control-feedback"></span>
				</div>
				<input
					bs-form-control

					type="number"
					ng-model="invoice.amount"
					label="Amount"
					label-class="col-xs-3 col-sm-2 col-lg-1"
					class="col-xs-9 col-sm-10 col-lg-11"

					/>

				<input
					bs-form-control
					type="date"
					ng-model="invoice.date"
					label="Date"
					label-class="col-xs-3 col-sm-2 col-lg-1"
					class="col-xs-9 col-sm-10 col-lg-11"

					/>
			</div>

			<div bs-panel title="Notes">
				<textarea type="text" ng-model="customer.mailing_address" label="Address" bs-form-control></textarea>
			</div>

			<div bs-panel class="form-actions">
				<div content-for="navbarAction" duplicate>
					<button class="btn btn-primary">
						Save
					</button>
				</div>
			</div>
		</form>

	</div>
</div>