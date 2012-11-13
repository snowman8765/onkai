<?php
include_once("config.php");
include_once("function.php");

session_start();
if(!isset($_SESSION['user']) && $_SESSION['user']['is_admin']) {
  echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
  exit();
}

if(isset($_POST['new_genre'])){
  if(add_genre($_POST['new_genre'])) {
    //登録成功
  }
}

$genre_list = get_all_genre();
?>
<!DOCTYPE html>
<html>
  <head>
<?php include_once("head.php");?>
  </head>
  <body>
    <div data-role="page" id="create_genre">
      <div data-role="header">
<?php include_once("header.php");?>
      </div>
      
      <div data-role="content" class="content">
        <div data-role="collapsible">
          <h3>ジャンルの追加</h3>
          <form action="create_genre.php" method="post">
            <div data-role="fieldcontain">
              <label for="new_genre">ジャンル名:</label>
              <input type="text" id="new_genre" name="new_genre" value="" />
            </div>
            <input type="submit" name="submit" value="登録" />
          </form>
        </div>
        
        <h3>ジャンルの選択</h3>
        <ul data-role="listview" data-inset="true">
<?php
for($i=0; $i<count($genre_list); $i++) {
  $id = $genre_list[$i]['id'];
  $genre = $genre_list[$i]['name'];
  $num = get_big_question_count($id);
  echo <<<HTML
<li><a href="create_big_q.php?genre_id=$id">$genre<span class="ui-li-count">$num</span></a></li>
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
