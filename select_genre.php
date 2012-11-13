<?php
include_once("config.php");
include_once("function.php");

session_start();
if(!isset($_SESSION['user'])) {
  echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
  exit();
}

$genre_list = get_all_genre();
?>
<!DOCTYPE html>
<html>
  <head>
<?php include_once("head.php");?>
  </head>
  <body>
    <div data-role="page" id="select_genre">
      <div data-role="header">
<?php include_once("header.php");?>
      </div>
      
      <div data-role="content" class="content">
        <h3>ジャンルの選択</h3>
        <ul data-role="listview" data-inset="true">
<?php
for($i=0; $i<count($genre_list); $i++) {
  $id = $genre_list[$i]['id'];
  $genre = $genre_list[$i]['name'];
  $num = get_big_question_count($id);
  echo <<<HTML
<li><a href="select_q.php?genre_id=$id">$genre<span class="ui-li-count">$num</span></a></li>
HTML;
}
?>
        </ul>
      </div>
      
      <div data-role="footer">
<?php include_once("footer.php");?>
      </div>
    </div>
  </body>
</html>
