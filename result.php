<?php
include_once("config.php");
include_once("function.php");

session_start();
if(!isset($_SESSION['user'])) {
  echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
  exit();
}

if(!isset($_SESSION['result'])) {
  echo "<meta http-equiv='refresh' content='0;URL=main.php'>";
  exit();
} else {
  $result = $_SESSION['result'];
  $_SESSION['result'] = NULL;
}

$big_q_id = $result['big_q_id'];
$question_list = get_question_list($big_q_id);
$all = count($question_list);
$hit = 0;
for($i=0; $i<$all; $i++) {
  $q = $question_list[$i];
  if($i===$all - 1) {
    $r = $result['last'];
  } else {
    $r = $result[$i];
  }
  
  if($q['ans_type']==ANSWER_TYPE_ZYUNBAN) {
    $array = str_split($r);
    $r = implode(',', $array);
  
  } else if($q['ans_type']==ANSWER_TYPE_TATOU) {
    $array = str_split($r);
    sort($array);
    $r = implode(',', $array);
  }
  
  if($q['answer'] === $r) {
    $hit++;
  }
}
$score = ceil($hit/$all*100.0);
if($score >= 100) {
  $result_msg = "合格（完璧だね）";
} else if($score >= 80) {
  $result_msg = "合格（やったね）";
} else if($score >= 60) {
  $result_msg = "合格（もう少し頑張ろう）";
} else {
  $result_msg = "不合格（もっとがんばろう）";
}
add_score($_SESSION['user']['id'], $big_q_id, $hit);
$point = get_point($_SESSION['user']['id']);
update_user_point($_SESSION['user']['id'], $hit+$point);

$chara_id = $_SESSION['user']['chara_id'];
$chara = get_chara($chara_id);
$chara_path = "img/".$chara['file_name'];
?>
<!DOCTYPE html>
<html>
  <head>
<?php include_once("head.php");?>
  </head>
  <body>
    <div data-role="page" id="result">
      <div data-role="header">
<?php include_once("header.php");?>
      </div>
      
      <div data-role="content" class="content">
<?php
echo <<<HTML
        <table>
          <tr>
            <td>
              <blockquote id="one">
                <h3>お疲れ様でした</h3>
                <p>$all 問中、$hit 問正解です。</p>
                <p>採点：$score 点</p>
                <p>得点：$hit 点</p>
                <p>判定：$result_msg</p>
                <span class="arrow" />
              </blockquote>
            </td>
            <td style="vertical-align:middle;padding-left:20px;">
              <img src="$chara_path" />
            </td>
          </tr>
        </table>
        <a href="result_memo.php?big_q_id=$big_q_id">解説を見る</a>
HTML;
?>
      </div>
      
      <div data-role="footer">
<?php include_once("footer.php");?>
      </div>
    </div>
  </body>
</html>
