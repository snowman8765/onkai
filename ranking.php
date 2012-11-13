<?php
include_once("config.php");
include_once("function.php");

session_start();
if(!isset($_SESSION['user'])) {
  echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
  exit();
}
?>
<!DOCTYPE html>
<html>
  <head>
<?php include_once("head.php");?>
    <link rel="stylesheet" href="./dataTables/css/jquery.dataTables.css" />
    <script type="text/javascript" src="./dataTables/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
      $(function(){
        $('#table_id').dataTable({
          "iDisplayLength": 10,
          "aaSorting": [[0, "asc"]],
          "aoColumnDefs": [{"bVisible": false, "aTargets": [2]}],
          "bStateSave": false,
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": "server_processing.php"
        });
      });
    </script>
  </head>
  <body>
    <div data-role="page" id="index">
      <div data-role="header">
<?php include_once("header.php");?>
      </div>
      
      <div data-role="content" class="content">
        <table id="table_id">
          <thead>
            <tr><th>順位</th><th>得点</th><th>ID</th><th>名前</th><th>アバター</th></tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      
      <div data-role="footer">
<?php include_once("footer.php");?>
      </div>
    </div>
  </body>
</html>
