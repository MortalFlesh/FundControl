<?php
/* @var $FundControl FundControl */

$Render = new FundFormRender();
?>
<div id="form">
	<form action="" method="post">
		<?
		$Render
			->renderTextFieldset('Název', 'name')
			->renderSelectFieldset('Typ', 'type', $FundControl->getItemTypes(), array('id="types-select"'))
			->renderCustom(function(){
				?>
				<fieldset class="input-for" id="new-type-container" style="display:none;">
					<legend class="input-for-title">Nový typ</legend>
					<input type="text" name="new_type" value="" disabled="disabled" />
				</fieldset>
				<?
			})
			->renderNumberFieldset('Hodnota', 'value')
			->renderSubmitFieldset('Přidat', 'save');
		?>
	</form>
	<br class="clear" />
</div>