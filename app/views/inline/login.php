<?
/* @var $FundControl FundControl */

$Render = new FundFormRender();
?>
<div id="user-panel">
	<form action="<?=$FundControl->getHomeUrl()?>index.php" method="post">
		<div bs-panel title="Login">
			<?
			$Render
				->renderTextModel('Login.login', 'Login', 'login')
				->renderPasswordModel('Login.password', 'Password', 'password')
				->renderSubmitModel('Submit', 'authorize', 'login()');
			?>
		</div>
	</form>
</div>