<?php
$withoutMainController = true;

$rootDir = __DIR__ . '/../app/';
require_once $rootDir . 'core/fundControlApp.php';
/* @var $FundControl FundControl */

$statusRootDir = __DIR__ . '/';
$statusHomeUrl = str_replace('app', 'status', $FundControl->getHomeUrl());

$JavascriptAutoloader = new JavascriptAutoloader(new JAPrinter($statusHomeUrl));
$JavascriptAutoloader
    ->setRootDir($statusRootDir)
    ->setCompileToOneFile(new JACompiler($statusRootDir, 'cache'))
    ->setMinifyOutput(new JAMinify($statusRootDir));

if (isset($_GET['denyCache']) && (int)$_GET['denyCache'] === 1) {
    $JavascriptAutoloader->setDenyCache();
}

$JSCoreLoader = new JavascriptAutoloader(new JAPrinter($statusHomeUrl));
$JSCoreLoader
    ->setRootDir($statusRootDir)
    ->setCompileToOneFile(new JACompiler($statusRootDir, 'cache'));
?>
<!-- index.html -->
<html>
<head>
    <title>Hello React</title>
    <?php
    $JSCoreLoader
        ->addDirectory('src/core')
        ->autoload();
    ?>
</head>
<body>
<div id="content"></div>
<?php
ob_start();
$JavascriptAutoloader
    ->addDirectory('src')
    ->autoload();
$script = ob_get_clean();
echo str_replace('text/javascript', 'text/jsx', $script);
?>
</body>
</html>