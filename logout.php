<?php
include_once("config.php");
include_once("function.php");

session_start();
$_SESSION = array();
session_destroy();
$message = "ログアウト成功";
$url = "index.php";
$refresh = "<meta http-equiv='refresh' content='3;URL=$url'>";
?>
<!DOCTYPE html>
<html>
  <head>
<?php include_once("head.php");?>
<?php echo $refresh;?>
  </head>
  <body>
    <div data-role="page" id="logout">
      <div data-role="header">
<?php include_once("header.php");?>
      </div>
      
      <div data-role="content">
        <p><?php echo $message;?></p>
        <p>3秒後に移動します。移動しない場合は<a href="<?php echo $url;?>">こちら</a>をクリック。</p>
      </div>
      
      <div data-role="footer">
<?php include_once("footer.php");?>
      </div>
    </div>
  </body>
</html>
