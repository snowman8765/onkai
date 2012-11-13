<?php
include_once("config.php");
include_once("function.php");

if(login('guest', 'guest')) {
  session_start();
  if(!isset($_SESSION['user'])) {
    $_SESSION['user'] = get_user('guest');
  }
} else {
  echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
  exit();
}

$big_q_id = $_GET['big_q_id'];
$_SESSION['result']['big_q_id'] = $big_q_id;
$big_question = get_big_question($big_q_id);
$genre_name = get_genre_name($big_question['genre_id']);
if(isset($_GET['qid'])) {
  $qid = $_GET['qid'];
  $c = get_big_question_count($big_question['genre_id']);
  if($c <= $qid) {
    $qid = "result";
  }
} else {
  $qid = 0;
}

if($qid==="result") {
  $_SESSION['result']['last'] = @$_GET['answer'];
  echo "<meta http-equiv='refresh' content='0;URL=result.php'>";
  exit();
}

$question_now = $question_list[$qid];

if($qid > 0) {
  $_SESSION['result'][$qid - 1] = @$_GET['answer'];
}

$id = $big_question['id'];
$title = $big_question['title'];
$about = $big_question['about'];
$num = get_question_count($id);
?>
<!DOCTYPE html>
<html>
  <head>
<?php include_once("head.php");?>
  </head>
  <body>
    <div data-role="page" id="guest_top">
      <div data-role="header">
<?php include_once("header.php");?>
      </div>
      
      <div data-role="content" class="content">
        <h3>問題の選択(<?php echo $genre_name['name'];?>)</h3>
        <ul data-role="listview" data-inset="true">
          <li><a href="start_q.php?big_q_id=<?php echo $id;?>&qid=0">
            <h3><?php echo $title;?></h3>
            <p><?php echo $about;?></p>
            <span class="ui-li-count"><?php echo $num;?></span>
          </a></li>
        </ul>
      </div>
      
      <div data-role="footer">
<?php include_once("footer.php");?>
      </div>
    </div>
  </body>
</html>
