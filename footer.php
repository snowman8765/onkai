<?php
if(isset($_SESSION['user'])) {
  $q = '';
  if($_SESSION['user']['is_admin']) {
    $q = '<li><a href="create_genre.php" data-icon="plus">問題作成</a></li>';
  }
  $chara_id = $_SESSION['user']['chara_id'];
  $chara = get_chara($chara_id);
  $chara_path = "img/".$chara['file_name'];
  
  echo <<<HTML
<div data-role="navbar" data-iconpos="left">
  <ul>
    <li><a href="main.php" data-icon="home">トップ</a></li>
    <li><a href="select_genre.php" data-icon="grid">学習</a></li>
    <li><a href="ranking.php" data-icon="star">ランキング</a></li>
    $q
    <li><a href="user_config.php" data-icon="gear">設定</a></li>
  </ul>
</div>
HTML;
} else {
  $chara_path = "";
}
?>

<p>Copyright (C) 2012 だって好きだし, All rights reserved.</p>
<img id="cur" src="<?php echo $chara_path;?>" style="width:30px;position:absolute;display:none;" />
<script type="text/javascript">
var adstir_vars = {
  ver    : "3.0",
  app_id : "MEDIA-69f3d4d1",
  ad_spot: 1,
};
</script>
<script type="text/javascript" src="http://js.ad-stir.com/js/adstir.js?20120726"></script>
