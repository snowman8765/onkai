<?php
include_once("config.php");
include_once("function.php");

session_start();
if(!isset($_SESSION['user'])) {
  echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
  exit();
}

$message = '';
if(isset($_POST['id'])) {
  if(update_user($_POST['id'], $_POST['name'], $_POST['chara_id'])) {
    $message = '変更しました。';
    $_SESSION['user'] = get_user($_POST['id']);
  } else {
    $message = '失敗しました。';
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
<?php include_once("head.php");?>
  </head>
  <body>
    <div data-role="page" id="user_confg">
      <div data-role="header">
<?php include_once("header.php");?>
      </div>
      
      <div data-role="content" class="content">
        <h3>ユーザ情報の変更</h3>
        <span><?php echo $message;?></span>
        <form action="user_config.php" method="post">
          <div data-role="fieldcontain">
            <label for="id">ID:</label>
            <input type="text" id="id" name="id" value="<?php echo $_SESSION['user']['id'];?>" readonly="readonly" />
          </div>
          <div data-role="fieldcontain">
            <label for="name">ニックネーム:</label>
            <input type="text" id="name" name="name" value="<?php echo $_SESSION['user']['name'];?>" />
          </div>
          <div data-role="fieldcontain">
            <label for="chara_id">キャラクター:</label>
            <select id="chara_id" name="chara_id">
              <option value="1">くま</option>
              <option value="2">ねこ</option>
              <option value="3">はと</option>
              <option value="4">かえる</option>
            </select>
          </div>
          <input type="submit" name="submit" value="更新" />
        </form>
      </div>
      
      <div data-role="footer">
<?php include_once("footer.php");?>
      </div>
    </div>
  </body>
</html>
