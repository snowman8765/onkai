<?php
include_once("config.php");
include_once("function.php");
?>
<!DOCTYPE html>
<html>
  <head>
<?php include_once("head.php");?>
  </head>
  <body>
    <div data-role="page" id="about">
      <div data-role="header">
<?php include_once("header.php");?>
      </div>
      
      <div data-role="content" class="content">
        <div data-role="collapsible">
          <h3>お知らせ</h3>
          <p>2012年10月21日：ver.0.9.3：問題に解説文を追加できるように修正</p>
          <p>2012年10月21日：ver.0.9.2：ランキング機能の実装</p>
          <p>2012年10月20日：ver.0.9.1：好きな問題へのブックマーク(リンク作成)が可能</p>
          <p>2012年10月20日：ver.0.9：問題の解答形式を追加(OX,2～6択,順番当て,タイピング,一問多答)</p>
          <p>2012年10月03日：ver.0.8.3：問題の削除を追加、その他いろいろ修正</p>
          <p>2012年10月01日：ver.0.8.2：マニュアル追加、ベータ版として一般公開</p>
          <p>2012年09月29日：ver.0.8.1：結果画面の修正、問題作成の修正</p>
          <p>2012年09月27日：ver.0.8：問題作成機能追加、結果画面の作成、など</p>
          <p>2012年09月12日：ver.0.1：オンライン勉強会の開発開始</p>
        </div>
        <div data-role="collapsible" data-collapsed="false">
          <h3>作ったのは</h3>
          <p>プログラム：snowman8765(<a href="http://snowman8765.sakura.ne.jp/" target="_blank">だって好きだし</a>,<a href="mailto:snowman8765@gmail.com">snowman8765@gmail.com</a>)</p>
          <p>イラスト：<a href="http://www.pixiv.net/member.php?id=598307" target="_blank">灰時</a>様</p>
        </div>
        <div data-role="collapsible">
          <h3>利用したライブラリなど</h3>
          <p><a href="http://jquery.com/" target="_blank">jQuery</a></p>
          <p><a href="http://jquerymobile.com/" target="_blank">jQuery Mobile</a></p>
          <p><a href="http://cmonos.jp/blog/2010010800/1.shtml" target="_blank">nicEdit 日本語版</a></p>
          <p><a href="http://datatables.net/" target="_blank">DataTables</a></p>
        </div>
        <div data-role="collapsible">
          <h3>マニュアル</h3>
          <p><a href="onkai_manual.pdf" target="_blank">PDFのダウンロード</a></p>
        </div>
      </div>
      
      <div data-role="footer">
<?php include_once("footer.php");?>
      </div>
    </div>
  </body>
</html>
