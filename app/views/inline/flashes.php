<?php
/* @var $FundControl FundControl */
$flashes = $FundControl->getFlashesAndClear();
?>
<div id="flash-container">
	<?
	foreach($flashes as $FlashMessage) {
		?>
		<div class="flash <?=$FlashMessage->getType()?>">
			<?=$FlashMessage->getMessage();?>
		</div>
		<?
	}
	?>
</div>
<?