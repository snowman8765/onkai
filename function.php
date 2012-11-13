<?php

function h($html) {
  return htmlspecialchars($html);
}

function get_connection($path) {
  $conn = ADONewConnection(DB_DRIVER);
  //$conn->debug=true;
  $conn->PConnect(DB_TYPE.':'.$path);
  return $conn;
}

function login($id, $pass) {
  $returnValue = false;
  $password = md5($pass);
  $conn = get_connection(USER_DB);
  $sql = "select id, password from user where id='$id' and password='$password'";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = false;
  } else if(isset($rs->fields['id'])){
    $returnValue = true;
  } else {
    $returnValue = false;
  }
  $conn->Close();
  return $returnValue;
}

function has_user($id) {
  $returnValue = false;
  $conn = get_connection(USER_DB);
  $sql = "select id, password from user where id='$id'";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = false;
  } else if(isset($rs->fields['id'])){
    $returnValue = true;
  } else {
    $returnValue = false;
  }
  $conn->Close();
  return $returnValue;
}

function add_user($id, $pass, $name) {
  $returnValue = false;
  $password = md5($pass);
  $conn = get_connection(USER_DB);
  $conn->StartTrans();
  $sql = "insert into user(id, password, name) values('$id', '$password', '$name')";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = false;
  } else {
    $returnValue = true;
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function add_admin($id, $pass, $name) {
  $returnValue = false;
  $password = md5($pass);
  $conn = get_connection(USER_DB);
  $conn->StartTrans();
  $is_admin = TRUE;
  $sql = "insert into user(id, password, name, is_admin) values('$id', '$password', '$name', $is_admin)";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = false;
  } else {
    $returnValue = true;
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function get_user($id) {
  $returnValue = NULL;
  $conn = get_connection(USER_DB);
  $sql = "select id, password, name, chara_id, point, is_admin, add_date from user where id='$id'";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = NULL;
  } else if(!$rs->EOF) {
    $returnValue = array(
      "id"=>$rs->fields['id'],
      "password"=>$rs->fields['password'],
      "name"=>$rs->fields['name'],
      "chara_id"=>$rs->fields['chara_id'],
      "point"=>$rs->fields['point'],
      "is_admin"=>$rs->fields['is_admin'],
      "add_date"=>$rs->fields['add_date']
    );
  }
  $conn->Close();
  return $returnValue;
}

function get_all_user_id() {
  $returnValue = array();
  $conn = get_connection(USER_DB);
  $sql = "select id from user order by id";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = NULL;
  } else if(!$rs->EOF) {
    while(!$rs->EOF) {
      $returnValue[] = $rs->fields['id'];
      $rs->MoveNext();
    }
  }
  $conn->Close();
  return $returnValue;
}

function get_user_count() {
  $returnValue = 0;
  $conn = get_connection(USER_DB);
  $sql = "select count(*) from user";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = NULL;
  } else if(!$rs->EOF) {
    $returnValue = $rs->fields['count(*)'];
  }
  $conn->Close();
  return $returnValue;
}

function update_user($id, $name, $chara_id) {
  $returnValue = FALSE;
  $conn = get_connection(USER_DB);
  $sql = "update user set name='$name', chara_id='$chara_id' where id='$id'";
  $conn->StartTrans();
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = FALSE;
  } else {
    $returnValue = TRUE;
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function update_user_admin($id, $is_admin) {
  $returnValue = FALSE;
  $conn = get_connection(USER_DB);
  $sql = "update user set is_admin='$is_admin' where id='$id'";
  $conn->StartTrans();
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = FALSE;
  } else {
    $returnValue = TRUE;
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function update_user_point($id, $point) {
  $returnValue = FALSE;
  $conn = get_connection(USER_DB);
  $sql = "update user set point='$point' where id='$id'";
  $conn->StartTrans();
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = FALSE;
  } else {
    $returnValue = TRUE;
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function get_all_genre() {
  $returnValue = NULL;
  $conn = get_connection(USER_DB);
  $conn->StartTrans();
  $sql = "select id, name from genre";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = false;
  } else if(!$rs->EOF) {
    while(!$rs->EOF) {
      $returnValue[] = array(
        "id"=>$rs->fields['id'],
        "name"=>$rs->fields['name']
      );
      $rs->MoveNext();
    }
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function get_genre_name($id) {
  $returnValue = NULL;
  $conn = get_connection(USER_DB);
  $conn->StartTrans();
  $sql = "select name from genre where id = '$id'";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = false;
  } else if(!$rs->EOF) {
    $returnValue = array(
      "name"=>$rs->fields['name']
    );
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function get_big_question_count($genre_id) {
  $returnValue = 0;
  $conn = get_connection(USER_DB);
  $conn->StartTrans();
  $sql = "select count(*) from big_question where genre_id = '$genre_id'";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
  } else if(!$rs->EOF) {
    $returnValue = $rs->fields['count(*)'];
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function get_big_question_list($genre_id) {
  $returnValue = NULL;
  $conn = get_connection(USER_DB);
  $conn->StartTrans();
  $sql = "select id, genre_id, title, about from big_question where genre_id = '$genre_id'";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = false;
  } else if(!$rs->EOF) {
    $returnValue = array();
    while(!$rs->EOF) {
      $returnValue[] = array(
        "id"=>$rs->fields['id'],
        "genre_id"=>$rs->fields['genre_id'],
        "title"=>$rs->fields['title'],
        "about"=>$rs->fields['about']
      );
      $rs->MoveNext();
    }
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function get_big_question($id) {
  $returnValue = NULL;
  $conn = get_connection(USER_DB);
  //$conn->debug = true;
  $conn->StartTrans();
  $sql = "select id, genre_id, title, about from big_question where id = '$id'";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = false;
  } else if(!$rs->EOF) {
    $returnValue = array(
      "id"=>$rs->fields['id'],
      "genre_id"=>$rs->fields['genre_id'],
      "title"=>$rs->fields['title'],
      "about"=>$rs->fields['about']
    );
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function edit_big_question($id, $genre_id, $title, $about) {
  $returnValue = NULL;
  $conn = get_connection(USER_DB);
  $conn->debug = true;
  $conn->StartTrans();
  $sql = "update big_question set genre_id='$genre_id', title='$title', about='$about' where id='$id'";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = FALSE;
  } else if(!$rs->EOF) {
    $returnValue = TRUE;
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function get_all_question_count() {
  $returnValue = 0;
  $conn = get_connection(USER_DB);
  $conn->StartTrans();
  $sql = "select count(*) from question";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
  } else if(!$rs->EOF) {
    $returnValue = $rs->fields['count(*)'];
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function get_question_count($big_id) {
  $returnValue = 0;
  $conn = get_connection(USER_DB);
  $conn->StartTrans();
  $sql = "select count(*) from question where big_id = '$big_id'";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
  } else if(!$rs->EOF) {
    $returnValue = $rs->fields['count(*)'];
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function add_genre($genre) {
  $returnValue = false;
  $conn = get_connection(USER_DB);
  $conn->StartTrans();
  $sql = "insert into genre(name) values('$genre')";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = false;
  } else {
    $returnValue = true;
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function add_big_q($genre_id, $title, $about) {
  $returnValue = false;
  $conn = get_connection(USER_DB);
  $conn->StartTrans();
  $sql = "insert into big_question(genre_id, title, about) values('$genre_id', '$title', '$about')";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = false;
  } else {
    $returnValue = true;
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function get_question_list($big_q_id) {
  $returnValue = NULL;
  $conn = get_connection(USER_DB);
  //$conn->debug = true;
  $conn->StartTrans();
  $sql = "select id, big_id, text, ans1, ans2, ans3, ans4, ans5, ans6, answer, ans_type, add_date, memo from question where big_id = '$big_q_id'";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = false;
  } else if(!$rs->EOF) {
    while(!$rs->EOF) {
      $returnValue[] = array(
        "id"=>$rs->fields['id'],
        "big_id"=>$rs->fields['big_id'],
        "text"=>$rs->fields['text'],
        "ans1"=>$rs->fields['ans1'],
        "ans2"=>$rs->fields['ans2'],
        "ans3"=>$rs->fields['ans3'],
        "ans4"=>$rs->fields['ans4'],
        "ans5"=>$rs->fields['ans5'],
        "ans6"=>$rs->fields['ans6'],
        "answer"=>$rs->fields['answer'],
        "ans_type"=>$rs->fields['ans_type'],
        "add_date"=>$rs->fields['add_date'],
        "memo"=>$rs->fields['memo']
      );
      $rs->MoveNext();
    }
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function edit_question($id, $big_id, $text, $ans1, $ans2, $ans3, $ans4, $ans5, $ans6, $answer, $memo) {
  $returnValue = NULL;
  $conn = get_connection(USER_DB);
  //$conn->debug = true;
  $conn->StartTrans();
  $sql = "update question set big_id='$big_id', text='$text', ans1='$ans1', ans2='$ans2', ans3='$ans3', ans4='$ans4', ans5='$ans5', ans6='$ans6', answer='$answer', memo='$memo' where id='$id'";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = false;
  } else if(!$rs->EOF) {
    $returnValue = TRUE;
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function delete_question($id) {
  $returnValue = NULL;
  $conn = get_connection(USER_DB);
  //$conn->debug = true;
  $conn->StartTrans();
  $sql = "delete from question where id='$id'";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = false;
  } else if(!$rs->EOF) {
    $returnValue = TRUE;
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function add_question($big_id, $text, $ans1, $ans2, $ans3, $ans4, $ans5, $ans6, $ans_type, $answer, $memo) {
  $returnValue = NULL;
  $conn = get_connection(USER_DB);
  //$conn->debug = true;
  $conn->StartTrans();
  $sql = "insert into question(big_id, text, ans1, ans2, ans3, ans4, ans5, ans6, ans_type, answer, memo) values('$big_id', '$text', '$ans1', '$ans2', '$ans3', '$ans4', '$ans5', '$ans6', '$ans_type', '$answer', '$memo')";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = false;
  } else if(!$rs->EOF) {
    $returnValue = TRUE;
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function add_question_ox($big_id, $text, $answer, $memo) {
  return add_question($big_id, $text, "O", "X", NULL, NULL, NULL, NULL, 0, $answer, $memo);
}

function add_question_2($big_id, $text, $ans1, $ans2, $answer, $memo) {
  return add_question($big_id, $text, $ans1, $ans2, NULL, NULL, NULL, NULL, 1, $answer, $memo);
}

function add_question_3($big_id, $text, $ans1, $ans2, $ans3, $answer, $memo) {
  return add_question($big_id, $text, $ans1, $ans2, $ans3, NULL, NULL, NULL, 2, $answer, $memo);
}

function add_question_4($big_id, $text, $ans1, $ans2, $ans3, $ans4, $answer, $memo) {
  return add_question($big_id, $text, $ans1, $ans2, $ans3, $ans4, NULL, NULL, 3, $answer, $memo);
}

function add_question_5($big_id, $text, $ans1, $ans2, $ans3, $ans4, $ans5, $answer, $memo) {
  return add_question($big_id, $text, $ans1, $ans2, $ans3, $ans4, $ans5, NULL, 4, $answer, $memo);
}

function add_question_6($big_id, $text, $ans1, $ans2, $ans3, $ans4, $ans5, $ans6, $answer, $memo) {
  return add_question($big_id, $text, $ans1, $ans2, $ans3, $ans4, $ans5, $ans6, 5, $answer, $memo);
}

function add_question_zyunban($big_id, $text, $ans1, $ans2, $ans3, $ans4, $ans5, $ans6, $answer, $memo) {
  return add_question($big_id, $text, $ans1, $ans2, $ans3, $ans4, $ans5, $ans6, 6, $answer, $memo);
}

function add_question_typing($big_id, $text, $answer, $memo) {
  return add_question($big_id, $text, NULL, NULL, NULL, NULL, NULL, NULL, 7, $answer, $memo);
}

function add_question_tatou($big_id, $text, $ans1, $ans2, $ans3, $ans4, $ans5, $ans6, $answer, $memo) {
  return add_question($big_id, $text, $ans1, $ans2, $ans3, $ans4, $ans5, $ans6, 8, $answer, $memo);
}

function get_chara($id) {
  $returnValue = NULL;
  $conn = get_connection(USER_DB);
  //$conn->debug = true;
  $conn->StartTrans();
  $sql = "select id, name, file_name from chara where id='$id'";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $errMsg = $conn->ErrorMsg();
    $returnValue = false;
  } else if(!$rs->EOF) {
    $returnValue = array(
      "id"=>$rs->fields['id'],
      "name"=>$rs->fields['name'],
      "file_name"=>$rs->fields['file_name']
    );
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function answer_html_ox($big_q_id, $q, $i) {
  $id = $q['id'];
  $big_id = $q['big_id'];
  $text = $q['text'];
  $ans1 = $q['ans1'];
  $ans2 = $q['ans2'];
  $answer = $q['answer'];
  $ans_type = $q['ans_type'];
  $memo = $q['memo'];
  $opt1 = $opt2 = "";
  switch($answer) {
    case 1: $opt1 = "selected";break;
    case 2: $opt2 = "selected";break;
    default: $opt1 = "selected";
  }
  $html =<<<HTML
          <div data-role="collapsible">
            <h3>問題 $i の修正</h3>
            <form action="edit_q.php?big_q_id=$big_q_id" method="post">
              <input type="hidden" name="id" value="$id" />
              <input type="hidden" name="big_id" value="$big_id" />
              <div data-role="fieldcontain">
                <label for="text_$i">問題文:</label>
                <textarea id="text_$i" name="text" style="width: 600px;">$text</textarea>
              </div>
              <div data-role="fieldcontain">
                <label for="answer$i">正解番号:</label>
                <select id="answer$i" name="answer">
                  <option value="O" $opt1>O</option>
                  <option value="X" $opt2>X</option>
                </select>
              </div>
              <div data-role="fieldcontain">
                <label for="memo_$i">解説文:</label>
                <textarea id="memo_$i" name="memo" style="width: 600px;">$memo</textarea>
              </div>
              <div data-role="controlgroup" data-type="horizontal">
                <input type="submit" name="edit_question" value="修正" data-icon="forward" />
                <input type="reset" name="reset" value="リセット" data-icon="back" />
                <input type="submit" name="delete_question" value="削除" data-icon="delete" />
              </div>
            </form>
          </div>
HTML;
  return $html;
}

function answer_html_Nselect($big_q_id, $q, $i, $n) {
  $id = $q['id'];
  $big_id = $q['big_id'];
  $text = $q['text'];
  $ans[] = $q['ans1'];
  $ans[] = $q['ans2'];
  $ans[] = $q['ans3'];
  $ans[] = $q['ans4'];
  $ans[] = $q['ans5'];
  $ans[] = $q['ans6'];
  $answer = $q['answer'];
  $ans_type = $q['ans_type'];
  $memo = $q['memo'];
  $opt = array();
  $opt[0] = $opt[1] = $opt[2] = $opt[3] = $opt[4] = $opt[5] = "";
  switch($answer) {
    case 1: $opt[0] = "selected";break;
    case 2: $opt[1] = "selected";break;
    case 3: $opt[2] = "selected";break;
    case 4: $opt[3] = "selected";break;
    case 5: $opt[4] = "selected";break;
    case 6: $opt[5] = "selected";break;
    default: $opt[0] = "selected";
  }
  $html = <<<HTML
          <div data-role="collapsible">
            <h3>問題 $i の修正</h3>
            <form action="edit_q.php?big_q_id=$big_q_id" method="post">
              <input type="hidden" name="id" value="$id" />
              <input type="hidden" name="big_id" value="$big_id" />
              <div data-role="fieldcontain">
                <label for="text_$i">問題文:</label>
                <textarea id="text_$i" name="text" style="width: 600px;">$text</textarea>
              </div>
HTML;
  for($j=1; $j<=$n; $j++) {
    $array_num = $j-1;
    $html .= <<<HTML
              <div data-role="fieldcontain" class="answer_list_$i">
                <label for="ans${j}_$i">解答$j:</label>
                <input type="text" id="ans${j}_$i" name="ans$j" value="$ans[$array_num]" />
              </div>
HTML;
  }
  $html .= <<<HTML
              <div data-role="fieldcontain" class="answer_number_$i">
                <label for="answer$i">正解番号:</label>
                <select id="answer$i" name="answer">
HTML;
  for($j=1; $j<=$n; $j++) {
    $array_num = $j-1;
    $html .= <<<HTML
                  <option value="$j" $opt[$array_num]>$j</option>
HTML;
  }
  $html .= <<<HTML
                </select>
              </div>
              <div data-role="fieldcontain">
                <label for="memo_$i">解説文:</label>
                <textarea id="memo_$i" name="memo" style="width: 600px;">$memo</textarea>
              </div>
              <div data-role="controlgroup" data-type="horizontal">
                <input type="submit" name="edit_question" value="修正" data-icon="forward" />
                <input type="reset" name="reset" value="リセット" data-icon="back" />
                <input type="submit" name="delete_question" value="削除" data-icon="delete" />
              </div>
            </form>
          </div>
HTML;
  return $html;
}

function answer_html_zyunban($big_q_id, $q, $i) {
  $id = $q['id'];
  $big_id = $q['big_id'];
  $text = $q['text'];
  $ans1 = $q['ans1'];
  $ans2 = $q['ans2'];
  $ans3 = $q['ans3'];
  $ans4 = $q['ans4'];
  $ans5 = $q['ans5'];
  $ans6 = $q['ans6'];
  $answer = $q['answer'];
  $ans_type = $q['ans_type'];
  $memo = $q['memo'];
  $html =<<<HTML
          <div data-role="collapsible">
            <h3>問題 $i の修正</h3>
            <form action="edit_q.php?big_q_id=$big_q_id" method="post">
              <input type="hidden" name="id" value="$id" />
              <input type="hidden" name="big_id" value="$big_id" />
              <div data-role="fieldcontain">
                <label for="text_$i">問題文:</label>
                <textarea id="text_$i" name="text" style="width: 600px;">$text</textarea>
              </div>
              <div data-role="fieldcontain">
                <label for="ans1_$i">解答1:</label>
                <input type="text" id="ans1_$i" name="ans1" value="$ans1" />
              </div>
              <div data-role="fieldcontain">
                <label for="ans2_$i">解答2:</label>
                <input type="text" id="ans2_$i" name="ans2" value="$ans2" />
              </div>
              <div data-role="fieldcontain">
                <label for="ans3_$i">解答3:</label>
                <input type="text" id="ans3_$i" name="ans3" value="$ans3" />
              </div>
              <div data-role="fieldcontain">
                <label for="ans4_$i">解答4:</label>
                <input type="text" id="ans4_$i" name="ans4" value="$ans4" />
              </div>
              <div data-role="fieldcontain">
                <label for="ans5_$i">解答5:</label>
                <input type="text" id="ans5_$i" name="ans5" value="$ans5" />
              </div>
              <div data-role="fieldcontain">
                <label for="ans6_$i">解答6:</label>
                <input type="text" id="ans6_$i" name="ans6" value="$ans6" />
              </div>
              <div data-role="fieldcontain">
                <label for="answer$i">正解番号:</label>
                <input type="text" id="answer$i" name="answer" value="$answer" />
              </div>
              <div data-role="fieldcontain">
                <label for="memo_$i">解説文:</label>
                <textarea id="memo_$i" name="memo" style="width: 600px;">$memo</textarea>
              </div>
              <div data-role="controlgroup" data-type="horizontal">
                <input type="submit" name="edit_question" value="修正" data-icon="forward" />
                <input type="reset" name="reset" value="リセット" data-icon="back" />
                <input type="submit" name="delete_question" value="削除" data-icon="delete" />
              </div>
            </form>
          </div>
HTML;
  return $html;
}
function answer_html_tatou($big_q_id, $q, $i) {
  return answer_html_zyunban($big_q_id, $q, $i);
}

function answer_html_typing($big_q_id, $q, $i) {
  $id = $q['id'];
  $big_id = $q['big_id'];
  $text = $q['text'];
  $answer = $q['answer'];
  $ans_type = $q['ans_type'];
  $memo = $q['memo'];
  $html =<<<HTML
          <div data-role="collapsible">
            <h3>問題 $i の修正</h3>
            <form action="edit_q.php?big_q_id=$big_q_id" method="post">
              <input type="hidden" name="id" value="$id" />
              <input type="hidden" name="big_id" value="$big_id" />
              <div data-role="fieldcontain">
                <label for="text_$i">問題文:</label>
                <textarea id="text_$i" name="text" style="width: 600px;">$text</textarea>
              </div>
              <div data-role="fieldcontain">
                <label for="answer$i">正解文字列:</label>
                <input type="text" id="answer$i" name="answer" value="$answer" />
              </div>
              <div data-role="fieldcontain">
                <label for="memo_$i">解説文:</label>
                <textarea id="memo_$i" name="memo" style="width: 600px;">$memo</textarea>
              </div>
              <div data-role="controlgroup" data-type="horizontal">
                <input type="submit" name="edit_question" value="修正" data-icon="forward" />
                <input type="reset" name="reset" value="リセット" data-icon="back" />
                <input type="submit" name="delete_question" value="削除" data-icon="delete" />
              </div>
            </form>
          </div>
HTML;
  return $html;
}

function add_score($user_id, $q_id, $value) {
  $returnValue = false;
  $conn = get_connection(USER_DB);
  $conn->StartTrans();
  $sql = "insert into score(user_id, q_id, value, add_date) values('$user_id', '$q_id', '$value', datetime(CURRENT_TIMESTAMP,'localtime'))";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $returnValue = false;
  } else {
    $returnValue = true;
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function get_point($user_id) {
  $returnValue = false;
  $conn = get_connection(USER_DB);
  $conn->StartTrans();
  $sql = "select point from user where id='$user_id'";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $returnValue = 0;
  } else if(!$rs->EOF) {
    $returnValue = $rs->fields['point'];
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}

function get_ranking($user_id) {
  $returnValue = false;
  $conn = get_connection(USER_DB);
  $conn->StartTrans();
  $sql = "select rank from ranking where id='$user_id'";
  $rs = $conn->Execute($sql);
  if(!$rs) {
    $returnValue = 0;
  } else if(!$rs->EOF) {
    $returnValue = $rs->fields['rank'];
  }
  $conn->CompleteTrans();
  $conn->Close();
  return $returnValue;
}
?>