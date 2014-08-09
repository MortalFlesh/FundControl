<?
/* @var $FundControl FundControl */

$Render = new FundFormRender();
?>
<div id="user-panel">
	<form action="<?=$FundControl->getHomeUrl()?>api.php" method="post">
		<div bs-panel title="Login">
			<?
			$Render
				->renderTextModel('Login.login', 'Login', 'login')
				->renderPasswordModel('Login.password', 'Password', 'password')
				->renderSubmitModel('Submit', 'authorize', '');
			?>
		</div>
	</form>
</div>