<?php
include_once("config.php");
include_once("function.php");

$refresh = '';
if(isset($_POST['id']) && add_admin($_POST['id'], $_POST['password'], $_POST['name'])) {
  $message = "ログイン成功";
  $url = "main.php";
  session_start();
  $_SESSION['user'] = get_user($_POST['id']);
  $refresh = "<meta http-equiv='refresh' content='3;URL=$url'>";
}
?>
<!DOCTYPE html>
<html>
  <head>
<?php include_once("head.php");?>
<?php echo $refresh;?>
  </head>
  <body>
    <div data-role="page" id="create_admin">
      <div data-role="header">
<?php include_once("header.php");?>
      </div>
      
      <div data-role="content">
        <div data-role="collapsible-set">
          <div data-role="collapsible" data-collapsed="false">
            <h3>ログイン</h3>
            <form action="login.php" method="post">
              <div data-role="fieldcontain">
                <label for="id">ID:</label>
                <input type="text" id="id" name="id" style="ime-mode:disabled;" required />
              </div>
              <div data-role="fieldcontain">
                <label for="password">パスワード:</label>
                <input type="password" id="password" name="password" value="" required />
              </div>
              <input type="submit" name="submit" value="上記でログイン" />
            </form>
            <form action="login.php" method="post">
              <input type="hidden" id="id" name="id" value="guest" />
              <input type="hidden" id="password" name="password" value="guest" />
              <input type="submit" name="submit" value="ゲストでログイン" />
            </form>
          </div>
          <div data-role="collapsible" data-collapsed="true">
            <h3>問題作成者を作る</h3>
            <form action="create_admin.php" method="post">
              <div data-role="fieldcontain">
                <label for="new_id">ID:</label>
                <input type="text" id="new_id" name="id" style="ime-mode:disabled;" required />
              </div>
              <div data-role="fieldcontain">
                <label for="new_name">ユーザ名:</label>
                <input type="text" id="new_name" name="name" required />
              </div>
              <div data-role="fieldcontain">
                <label for="new_password">パスワード:</label>
                <input type="password" id="new_password" name="password" required />
              </div>
              <input type="submit" name="submit" value="新規登録" />
            </form>
          </div>
        </div>
      </div>
      
      <div data-role="footer">
<?php include_once("footer.php");?>
      </div>
    </div>
  </body>
</html>
