<?php
include_once("config.php");
include_once("function.php");

session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['id']!=='snowman8765') {
  echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
  exit();
}

$message = '';
if(isset($_POST['id'])) {
  if(update_user_admin($_POST['id'], isset($_POST['is_admin'])?TRUE:FALSE)) {
    $message = '変更しました。';
    $_SESSION['user'] = get_user($_POST['id']);
  } else {
    $message = '失敗しました。';
  }
}

$all_user_id = get_all_user_id();
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
        <form action="admin.php" method="post">
          <div data-role="fieldcontain">
            <label for="id">ID:</label>
            <select id="id" name="id">
<?php
for($i=0; $i<count($all_user_id); $i++) {
  echo '<option>'.$all_user_id[$i].'</option>';
}
?>
            </select>
          </div>
          <div data-role="fieldcontain">
            <label for="is_admin">先生権限:</label>
            <input type="checkbox" id="is_admin" name="is_admin" value="" />
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
