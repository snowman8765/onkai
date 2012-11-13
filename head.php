<title>ON会</title>
<meta charset="UTF-8">
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="robots" content="index,follow" />
<meta name="author" content="snowman8765" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
<script type="text/javascript">
  $.mobile.ajaxEnabled = false;
</script>
<?php
if(isset($_SESSION['user'])) {
  echo '<script src="mouse.js"></script>';
  echo <<<HTML
<script>
  $(function(){
    $("#cur").css("display", "");
  });
</script>
HTML;
}
?>
<script type="text/javascript" src="change_answer.js"></script>
<script type="text/javascript" src="nicEdit/nicEdit.js"></script>
<script type="text/javascript">
  bkLib.onDomLoaded(function() {
    if (navigator.userAgent.indexOf('iPhone') > 0 || navigator.userAgent.indexOf('iPad') > 0 || navigator.userAgent.indexOf('iPod') > 0 || navigator.userAgent.indexOf('Android') > 0) {
      //スマートフォン時に実行したいjs
    } else {
      nicEditors.allTextAreas();
    }
  });
</script>
<style type="text/css">
  blockquote {
    margin: 0 0 0 0;
    padding: 0;
  }

  blockquote#one {
    width: 250px;
    background: #e3e3e3;
    padding: 25px;
    position: relative;
  }

  blockquote#one .arrow {
    width: 0; 
    height: 0;
    line-height: 0;
    border-top: 30px solid #e3e3e3;
    border-left: none;
    border-right: 30px solid #f8f8f8;
    position: absolute;
    bottom: 40%;
    right: -30px;
  }
</style>
