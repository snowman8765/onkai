<?php
include_once("config.php");
include_once("function.php");

session_start();
if(!isset($_SERVER['HTTP_REFERER']) || !strstr($_SERVER['HTTP_REFERER'], SERVER_NAME) || !isset($_SESSION['user'])) {
  include_once('guest_top.php');
  exit();
}

$big_q_id = $_GET['big_q_id'];
$_SESSION['result']['big_q_id'] = $big_q_id;
$question_list = get_question_list($big_q_id);
if(isset($_GET['qid'])) {
  $qid = $_GET['qid'];
  if(count($question_list) <= $qid) {
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
?>
<!DOCTYPE html>
<html>
  <head>
<?php include_once("head.php");?>
  <script>
    $(function(){
      $("input:checkbox").click(function(){
        var val = $(this).val();
        var old_val = $("#answer_fld").val();
        if(old_val.indexOf(val) == -1) {
          $("#answer_fld").val(old_val+""+val);
        } else {
          val = old_val.replace(val, "");
          $("#answer_fld").val(val);
        }
      });
    });
  </script>
  </head>
  <body>
    <div data-role="page" id="start_q">
      <div data-role="header">
<?php include_once("header.php");?>
      </div>
      
      <div data-role="content" class="content">
        <div data-role="collapsible" data-collapsed="false">
          <h3>問題<?php echo $qid+1;?></h3>
          <div id="question"><?php echo $question_now['text'];?></div>
        </div>
        
        <h3>解答(<?php echo $ANSWER_TYPE[$question_now['ans_type']];?>)</h3>
        <form action="start_q.php" method="get">
          <input type="hidden" name="big_q_id" value="<?php echo $big_q_id;?>" />
          <input type="hidden" name="qid" value="<?php echo $qid+1;?>" />
          <?php show_html($question_now);?>
          <input type="submit" name="submit" value="次へ" />
        </form>
      </div>
      
      <div data-role="footer">
<?php include_once("footer.php");?>
      </div>
    </div>
  </body>
</html>
<?php
function show_html($q) {
  $ans_type = $q['ans_type'];
  switch($ans_type) {
    case ANSWER_TYPE_OX: show_html_ox($q);break;
    case ANSWER_TYPE_2:  show_html_N($q, 2);break;
    case ANSWER_TYPE_3:  show_html_N($q, 3);break;
    case ANSWER_TYPE_4:  show_html_N($q, 4);break;
    case ANSWER_TYPE_5:  show_html_N($q, 5);break;
    case ANSWER_TYPE_6:  show_html_N($q, 6);break;
    case ANSWER_TYPE_ZYUNBAN: show_html_zyunban($q);break;
    case ANSWER_TYPE_TYPING: show_html_typing($q);break;
    case ANSWER_TYPE_TATOU: show_html_tatou($q);break;
  }
}

function show_html_ox($q) {
  echo <<<HTML
          <fieldset data-role="controlgroup">
            <input type="radio" id="ans1" name="answer" value="o" />
            <label for="ans1">O</label>
            <input type="radio" id="ans2" name="answer" value="x" />
            <label for="ans2">X</label>
          </fieldset>
HTML;
}

function show_html_N($q, $n) {
  echo '<fieldset data-role="controlgroup">';
  for($i=1; $i<=$n; $i++) {
    $answer = $q['ans'.$i];
    echo <<<HTML
            <input type="radio" id="ans$i" name="answer" value="$i" />
            <label for="ans$i">$answer</label>
HTML;
  }
  echo '</fieldset>';
}

function show_html_zyunban($q) {
  echo '<fieldset data-role="controlgroup">';
  for($i=1; $i<=6; $i++) {
    if(!isset($q['ans'.$i]) || $q['ans'.$i]==="") {
      break;
    }
    $answer = $q['ans'.$i];
    echo <<<HTML
            <input type="checkbox" id="ans$i" name="ans[]" value="$i" />
            <label for="ans$i">$answer</label>
HTML;
  }
  echo '<input type="text" id="answer_fld" name="answer" value="" readonly="readonly" />';
  echo '</fieldset>';
}

function show_html_tatou($q) {
  echo '<fieldset data-role="controlgroup">';
  for($i=1; $i<=6; $i++) {
    if(!isset($q['ans'.$i]) || $q['ans'.$i]==="") {
      break;
    }
    $answer = $q['ans'.$i];
    echo <<<HTML
            <input type="checkbox" id="ans$i" name="ans[]" value="$i" />
            <label for="ans$i">$answer</label>
HTML;
  }
  echo '<input type="hidden" id="answer_fld" name="answer" value="" readonly="readonly" />';
  echo '</fieldset>';
}

function show_html_typing($q) {
  echo <<<HTML
          <fieldset data-role="controlgroup">
            <label for="ans">解答：</label>
            <input type="text" id="ans" name="answer" />
          </fieldset>
HTML;
}
?>
