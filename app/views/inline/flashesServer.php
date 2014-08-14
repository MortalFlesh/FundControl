<?php
/* @var $FundControl FundControl */

$flashes = $FundControl->getFlashes();
?>
<div id="flash-container">
	<?
	foreach($flashes as $Flash) {
		?>
		<div class="flash <?=$Flash->getType()?>">
			<?=$Flash->getMessage()?>
		</div>
		<?
	}
	?>
</div>
<?