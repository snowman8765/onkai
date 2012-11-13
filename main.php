<?php
include_once("config.php");
include_once("function.php");

session_start();
if(!isset($_SESSION['user'])) {
  echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
  exit();
}

$user_count = get_user_count();
$ranking = get_ranking($_SESSION['user']['id']);
$all_q_count = get_all_question_count();

?>
<!DOCTYPE html>
<html>
  <head>
<?php include_once("head.php");?>
  </head>
  <body>
    <div data-role="page" id="main">
      <div data-role="header">
<?php include_once("header.php");?>
      </div>
      
      <div data-role="content" class="content">
        <ul data-role="listview" data-inset="true">
          <li><a href="select_genre.php">学習を始める<span class="ui-li-count"><?php echo $all_q_count;?></span></a></li>
          <li><a href="ranking.php">ランキングをみる<span class="ui-li-count"><?php echo $ranking;?></span></a></li>
          <?php if($_SESSION['user']['is_admin']){ echo '<li><a href="create_genre.php">問題を作成する</a></li>';}?>
          <?php if($_SESSION['user']['is_admin']){ echo '<li><a href="uploda/index.php" target="_blank">問題用のファイルアップロード</a></li>';}?>
          <li><a href="user_config.php">ユーザ情報を変更する</a></li>
          <li><a href="about.php">このアプリケーションについて</a></li>
        </ul>
      </div>
      
      <div data-role="footer">
<?php include_once("footer.php");?>
      </div>
    </div>
  </body>
</html>
