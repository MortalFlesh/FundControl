<?php
$rootDir = __DIR__ . '/../../';
require_once $rootDir . 'core/fundControlApp.php';
/* @var $FundControl FundControl */
?>
<div class="scrollable">
	<div class="scrollable-content">

		<div class="list-group">
			<div class="list-group-item">
				<h1>Welcome<br/>
					<small>This is <?=$FundControl->getTitle()?></small>
				</h1>
			</div>

			<?
			if (!$FundControl->isLogged()) {
				$FundControl->view('login');
			}
			?>

			<?
			/*
			?>
			<div class="list-group-item media">
				<div class="pull-right">
					<i class="fa fa-stethoscope feature-icon  text-primary"></i>
				</div>
				<div class="media-body">
					<h3 class="media-heading">Submit an issue</h3>
					Please submit any issue you'll find. It would help a lot!<br>
					Just in case, don't forget to indicate your user agent string:<br>
					{{userAgent}}
				</div>
			</div>
			<?
			//*/
			?>
		</div>

	</div>
</div>
