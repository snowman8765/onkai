<?php
include_once("config.php");
include_once("function.php");

session_start();
if(!isset($_SESSION['user']) && $_SESSION['user']['is_admin']) {
  echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
  exit();
}

if(isset($_POST['title'])){
  if(add_big_q($_POST['genre_id'], $_POST['title'], $_POST['about'])) {
    //登録成功
  }
}

$genre_id = $_GET['genre_id'];
$genre_name = get_genre_name($genre_id);

$big_question_list = get_big_question_list($genre_id);
?>
<!DOCTYPE html>
<html>
  <head>
<?php include_once("head.php");?>
  </head>
  <body>
    <div data-role="page" id="create_big_q">
      <div data-role="header">
<?php include_once("header.php");?>
      </div>
      
      <div data-role="content" class="content">
        <div data-role="collapsible">
          <h3>大問の追加</h3>
          <form action="create_big_q.php?genre_id=<?php echo $genre_id;?>" method="post">
            <input type="hidden" name="genre_id" value="<?php echo $genre_id;?>" />
            <div data-role="fieldcontain">
              <label for="title">タイトル:</label>
              <input type="text" id="title" name="title" value="" />
            </div>
            <div data-role="fieldcontain">
              <label for="about">概要:</label>
              <textarea id="about" name="about" style="width: 600px;"></textarea>
            </div>
            <input type="submit" name="submit" value="登録" />
          </form>
        </div>
        
        <h3>問題の選択(<?php echo $genre_name['name'];?>)</h3>
        <ul data-role="listview" data-inset="true">
<?php
for($i=0; $i<count($big_question_list); $i++) {
  $id = $big_question_list[$i]['id'];
  $genre_id = $big_question_list[$i]['genre_id'];
  $title = $big_question_list[$i]['title'];
  $about = $big_question_list[$i]['about'];
  $num = get_question_count($id);
  echo <<<HTML
<li><a href="edit_q.php?big_q_id=$id">
  <h3>$title</h3>
  <p>$about</p>
  <span class="ui-li-count">$num</span>
</a></li>
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
