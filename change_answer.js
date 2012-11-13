$(function(){
  $("button").click(function(){
    var id = $(this).attr("id");
    var data = id.split("_");
    
    switch(data[0]) {
      case "ox": html_ox(data[1]);break;
      case "2taku": html_Nselect(data[1]);break;
      case "3taku": html_Nselect(data[1]);break;
      case "4taku": html_Nselect(data[1]);break;
      case "5taku": html_Nselect(data[1]);break;
      case "6taku": html_6select(data[1]);break;
      case "zyunban": html_ox(data[1]);break;
      case "typing": html_ox(data[1]);break;
      case "tatou": html_ox(data[1]);break;
      default: html_ox(data[1]);
    }
  });
})

function fn_answer_list(i, j, val) {
  var html = '<div data-role="fieldcontain" class="answer_list_'+i+'">';
  html += '<label for="ans'+j+'_'+i+'">解答'+j+':</label>';
  html += '<input type="text" id="ans'+j+'_'+i+'" name="ans'+i+'" value="'+val+'" />';
  html += '</div>';
  return html;
}

function fn_answer_number(j, opt) {
  var html = '<option value="'+j+'" '+opt+'>'+j+'</option>';
  return html;
}

function html_ox(num) {
  var old_answer_list = $(".answer_list_"+num).html();
  var answer_list = "";
  $(".answer_list_"+num).html(answer_list);
  
  var old_answer_number = $(".answer_number_"+num).html();
  var answer_number = "";
  $(".answer_number_"+num).html(answer_number);
}

function html_Nselect(num) {
  var old_answer_list = $(".answer_list_"+num).html();
  var answer_list = "";
  $(".answer_list_"+num).html(answer_list);
  
  var old_answer_number = $(".answer_number_"+num).html();
  var answer_number = "";
  $(".answer_number_"+num).html(answer_number);
}

function html_6select(num) {
  var answer = new Array(6);
  answer[0] = $("#ans1_"+num).val();
  answer[1] = $("#ans2_"+num).val();
  answer[2] = $("#ans3_"+num).val();
  answer[3] = $("#ans4_"+num).val();
  answer[4] = $("#ans5_"+num).val();
  answer[5] = $("#ans6_"+num).val();
  var list_html = new Array(6);
  for(var j=1; j<=6; j++) {
    list_html[j-1] = fn_answer_list(num, j, answer[j-1]);
  }
  
  var answer_opt = new Array(6);
  answer_opt[0] = $("#answer"+num+" option:eq(0)").attr("selected");
  answer_opt[1] = $("#answer"+num+" option:eq(1)").attr("selected");
  answer_opt[2] = $("#answer"+num+" option:eq(2)").attr("selected");
  answer_opt[3] = $("#answer"+num+" option:eq(3)").attr("selected");
  answer_opt[4] = $("#answer"+num+" option:eq(4)").attr("selected");
  answer_opt[5] = $("#answer"+num+" option:eq(5)").attr("selected");
  var number_html = new Array(6);
  for(var j=1; j<=6; j++) {
    number_html[j-1] = fn_answer_number(j, answer_opt[j-1]);
  }
  
  var answer_list = "";
  for(var i=0; i<6; i++) {
    answer_list += list_html[i];
  }
  $(".answer_list_"+num).html(answer_list);
  
  var answer_number = '<div data-role="fieldcontain" class="answer_number_'+num+'">';
  answer_number += '<label for="answer'+num+'">正解番号:</label>';
  answer_number += '<select id="answer'+num+'" name="answer">';
  for(var i=0; i<6; i++) {
    answer_number += number_html[i];
  }
  answer_number += '</select>';
  answer_number += '</div>';
  $(".answer_number_"+num).html(answer_number);
}
