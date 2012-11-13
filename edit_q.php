<?php
include_once("config.php");
include_once("function.php");

session_start();
if(!isset($_SESSION['user']) && $_SESSION['user']['is_admin']) {
  echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
  exit();
}

if(isset($_POST['edit_big_question'])){
  if(edit_big_question($_POST['id'], $_POST['genre_id'], $_POST['title'], $_POST['about'])) {
    //登録成功
  }
} else if(isset($_POST['edit_question'])){
  //$text = $_POST['text'];
  $text = str_replace(array("\r\n", "\n", "\r"), '<br />', $_POST['text']);
  //print_r($text);
  if(edit_question($_POST['id'], $_POST['big_id'], $text, @$_POST['ans1'], @$_POST['ans2'], @$_POST['ans3'], @$_POST['ans4'], @$_POST['ans5'], @$_POST['ans6'], $_POST['answer'], $_POST['memo'])) {
    //登録成功
  }
} else if(isset($_POST['delete_question'])) {
  if(delete_question($_POST['id'])) {
    //削除成功
  }
} else if(isset($_POST['add_ox'])) {
  if(add_question_ox($_POST['big_id'], $_POST['text'], $_POST['answer'], $_POST['memo'])) {
    //登録成功
  }
} else if(isset($_POST['add_2taku'])) {
  if(add_question_2($_POST['big_id'], $_POST['text'], $_POST['ans1'], $_POST['ans2'], $_POST['answer'])) {
    //登録成功
  }
} else if(isset($_POST['add_3taku'])) {
  if(add_question_3($_POST['big_id'], $_POST['text'], $_POST['ans1'], $_POST['ans2'], $_POST['ans3'], $_POST['answer'], $_POST['memo'])) {
    //登録成功
  }
} else if(isset($_POST['add_4taku'])) {
  if(add_question_4($_POST['big_id'], $_POST['text'], $_POST['ans1'], $_POST['ans2'], $_POST['ans3'], $_POST['ans4'], $_POST['answer'], $_POST['memo'])) {
    //登録成功
  }
} else if(isset($_POST['add_5taku'])) {
  if(add_question_5($_POST['big_id'], $_POST['text'], $_POST['ans1'], $_POST['ans2'], $_POST['ans3'], $_POST['ans4'], $_POST['ans5'], $_POST['answer'], $_POST['memo'])) {
    //登録成功
  }
} else if(isset($_POST['add_6taku'])) {
  if(add_question_6($_POST['big_id'], $_POST['text'], $_POST['ans1'], $_POST['ans2'], $_POST['ans3'], $_POST['ans4'], $_POST['ans5'], $_POST['ans6'], $_POST['answer'], $_POST['memo'])) {
    //登録成功
  }
} else if(isset($_POST['add_zyunban'])) {
  if(add_question_zyunban($_POST['big_id'], $_POST['text'], $_POST['ans1'], $_POST['ans2'], $_POST['ans3'], $_POST['ans4'], $_POST['ans5'], $_POST['ans6'], $_POST['answer'], $_POST['memo'])) {
    //登録成功
  }
} else if(isset($_POST['add_typing'])) {
  if(add_question_typing($_POST['big_id'], $_POST['text'], $_POST['ans1'], $_POST['ans2'], $_POST['ans3'], $_POST['ans4'], $_POST['ans5'], $_POST['ans6'], $_POST['answer'], $_POST['memo'])) {
    //登録成功
  }
} else if(isset($_POST['add_tatou'])) {
  if(add_question_tatou($_POST['big_id'], $_POST['text'], $_POST['ans1'], $_POST['ans2'], $_POST['ans3'], $_POST['ans4'], $_POST['ans5'], $_POST['ans6'], $_POST['answer'], $_POST['memo'])) {
    //登録成功
  }
}

$big_q_id = $_GET['big_q_id'];
$question_list = get_question_list($big_q_id);
$big_question = get_big_question($big_q_id);
?>
<!DOCTYPE html>
<html>
  <head>
<?php include_once("head.php");?>
  </head>
  <body>
    <div data-role="page" id="edit_q">
      <div data-role="header">
<?php include_once("header.php");?>
      </div>
      
      <div data-role="content" class="content">
        <div data-role="collapsible">
          <h3>大問の修正</h3>
          <form action="edit_q.php?big_q_id=<?php echo $big_q_id;?>" method="post">
            <input type="hidden" name="id" value="<?php echo $big_question['id'];?>" />
            <input type="hidden" name="genre_id" value="<?php echo $big_question['genre_id'];?>" />
            <div data-role="fieldcontain">
              <label for="title">タイトル:</label>
              <input type="text" id="title" name="title" value="<?php echo $big_question['title'];?>" />
            </div>
            <div data-role="fieldcontain">
              <label for="about">概要:</label>
              <textarea id="about" name="about" style="width: 600px;"><?php echo $big_question['about'];?></textarea>
              <button onClick="toggleArea1();">切り替え</button>
            </div>
            <input type="submit" name="edit_big_question" value="修正" />
          </form>
        </div>
        <div data-role="collapsible">
          <h3>問題のテンプレート作成</h3>
          <form action="edit_q.php?big_q_id=<?php echo $big_q_id;?>" method="post">
            <input type="hidden" name="big_id" value="<?php echo $big_question['id'];?>" />
            <input type="hidden" name="text" value="ここに問題文を記述する。" />
            <input type="hidden" name="ans1" value="" />
            <input type="hidden" name="ans2" value="" />
            <input type="hidden" name="ans3" value="" />
            <input type="hidden" name="ans4" value="" />
            <input type="hidden" name="ans5" value="" />
            <input type="hidden" name="ans6" value="" />
            <input type="hidden" name="answer" value="1" />
            <div data-role="controlgroup" data-type="horizontal">
              <input type="submit" name="add_ox" value="OX" />
              <input type="submit" name="add_2taku" value="2択" />
              <input type="submit" name="add_3taku" value="3択" />
              <input type="submit" name="add_4taku" value="4択" />
              <input type="submit" name="add_5taku" value="5択" />
              <input type="submit" name="add_6taku" value="6択" />
              <input type="submit" name="add_zyunban" value="順番当て" />
              <input type="submit" name="add_typing" value="タイピング" />
              <input type="submit" name="add_tatou" value="一問多答" />
            </div>
          </form>
        </div>
        
        <div data-role="collapsible-set">
<?php
for($i=1; $i<=count($question_list); $i++) {
  $q = $question_list[$i-1];
  $ans_type = $q['ans_type'];
  switch($ans_type) {
    case ANSWER_TYPE_OX: $html = answer_html_ox($big_q_id, $q, $i);break;
    case ANSWER_TYPE_2: $html = answer_html_Nselect($big_q_id, $q, $i, 2);break;
    case ANSWER_TYPE_3: $html = answer_html_Nselect($big_q_id, $q, $i, 3);break;
    case ANSWER_TYPE_4: $html = answer_html_Nselect($big_q_id, $q, $i, 4);break;
    case ANSWER_TYPE_5: $html = answer_html_Nselect($big_q_id, $q, $i, 5);break;
    case ANSWER_TYPE_6: $html = answer_html_Nselect($big_q_id, $q, $i, 6);break;
    case ANSWER_TYPE_ZYUNBAN: $html = answer_html_zyunban($big_q_id, $q, $i);break;
    case ANSWER_TYPE_TYPING: $html = answer_html_typing($big_q_id, $q, $i);break;
    case ANSWER_TYPE_TATOU: $html = answer_html_tatou($big_q_id, $q, $i);break;
    default: $html = answer_html_Nselect($big_q_id, $q, $i, 4);
  }
  echo $html;
}
?>
        </div>
      </div>
      
      <div data-role="footer">
<?php include_once("footer.php");?>
      </div>
    </div>
  </body>
</html>
