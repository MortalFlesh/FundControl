<?php
/* @var $FundControl FundControl */

$Render = new FundFormRender();
?>
<div id="form">
	<form action="" method="post">
		<?
		$Render
			->renderTextFieldset('Name', 'name')
			->renderSelectFieldset('Type', 'type', $FundControl->getItemTypes(), array('id="types-select"'))
			->renderCustom(function(){
				?>
				<fieldset class="input-for" id="new-type-container" style="display:none;">
					<legend class="input-for-title">New type</legend>
					<input type="text" name="new_type" value="" disabled="disabled" />
				</fieldset>
				<?
			})
			->renderNumberFieldset('Amount', 'value')
			->renderSubmitFieldset('Add', 'save');
		?>
	</form>
	<br class="clear" />
</div>