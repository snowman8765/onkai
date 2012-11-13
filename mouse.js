$(function(){
  $("div.content").mousemove(function(e){
    var left = e.clientX + 10;
    var top = e.clientY + 10 - $("div.content").height() - 80;
    $("#cur").css({left:left, top:top});
  });
})
