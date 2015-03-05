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

?>
<!-- index.html -->
<html>
<head>
    <title>Hello React</title>
    <script src="//fb.me/react-0.12.2.js"></script>
    <script src="//fb.me/JSXTransformer-0.12.2.js"></script>
    <script src="//code.jquery.com/jquery-1.10.0.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/showdown/0.3.1/showdown.min.js"></script>
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