<?php
include_once("config.php");
include_once("function.php");

session_start();
if(!isset($_SESSION['user'])) {
  echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
  exit();
}

$big_q_id = $_GET['big_q_id'];
$question_list = get_question_list($big_q_id);

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
    <div data-role="page" id="result_memo">
      <div data-role="header">
<?php include_once("header.php");?>
      </div>
      
      <div data-role="content" class="content">
<?php
$memo_list = "";
for($i=0; $i<count($question_list); $i++) {
  $memo_list .= "<li>問題".($i+1).":".$question_list[$i]['memo']."</li>";
}
echo <<<HTML
        <table>
          <tr>
            <td>
              <blockquote id="one">
                <h3>問題の解説です</h3>
                <p>
                  <ul>
                    $memo_list
                  </ul>
                </p>
                <span class="arrow" />
              </blockquote>
            </td>
            <td style="vertical-align:middle;padding-left:20px;">
              <img src="$chara_path" />
            </td>
          </tr>
        </table>
        <a href="main.php">終了する</a>
HTML;
?>
      </div>
      
      <div data-role="footer">
<?php include_once("footer.php");?>
      </div>
    </div>
  </body>
</html>
