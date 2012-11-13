<?php
include_once("config.php");
include_once("function.php");

  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
   * Easy set variables
   */
  
  /* Array of database columns which should be read and sent back to DataTables. Use a space where
   * you want to insert a non-database field (for example a counter or static image)
   */
  $aColumns = array( 'rank', 'point', 'id', 'name', 'chara_id' );
  
  /* Indexed column (used for fast and accurate table cardinality) */
  $sIndexColumn = "id";
  
  /* DB table to use */
  $sTable = "ranking";
  
  /* Database connection information */
  $gaSql['user']       = "";
  $gaSql['password']   = "";
  $gaSql['db']         = "";
  $gaSql['server']     = "localhost";
  
  /* REMOVE THIS LINE (it just includes my SQL connection user/pass) */
  //include_once( $_SERVER['DOCUMENT_ROOT']."/datatables/mysql.php" );
  
  $conn = ADONewConnection(DB_DRIVER);
  $conn->PConnect(DB_TYPE.':'.USER_DB);
  //$conn->debug=true;
  
  
  /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
   * If you just want to use the basic configuration for DataTables with PHP server-side, there is
   * no need to edit below this line
   */
  
  /* 
   * Local functions
   */
  function fatal_error ( $sErrorMessage = '' )
  {
    header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
    die( $sErrorMessage );
  }

  /* 
   * Paging
   */
  $sLimit = "";
  if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
  {
    $sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".intval( $_GET['iDisplayLength'] );
  }
  
  
  /*
   * Ordering
   */
  $sOrder = "";
  if ( isset( $_GET['iSortCol_0'] ) )
  {
    $sOrder = "ORDER BY  ";
    for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
    {
      if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
      {
        $sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".$_GET['sSortDir_'.$i].", ";
      }
    }
    
    $sOrder = substr_replace( $sOrder, "", -2 );
    if ( $sOrder == "ORDER BY" )
    {
      $sOrder = "";
    }
  }
  
  
  /* 
   * Filtering
   * NOTE this does not match the built-in DataTables filtering which does it
   * word by word on any field. It's possible to do here, but concerned about efficiency
   * on very large tables, and MySQL's regex functionality is very limited
   */
  $sWhere = "";
  if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
  {
    $sWhere = "WHERE (";
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
      if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" )
      {
        $sWhere .= "`".$aColumns[$i]."` LIKE '%".$_GET['sSearch']."%' OR ";
      }
    }
    $sWhere = substr_replace( $sWhere, "", -3 );
    $sWhere .= ')';
  }
  
  /* Individual column filtering */
  for ( $i=0 ; $i<count($aColumns) ; $i++ )
  {
    if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
    {
      if ( $sWhere == "" )
      {
        $sWhere = "WHERE ";
      }
      else
      {
        $sWhere .= " AND ";
      }
      $sWhere .= "`".$aColumns[$i]."` LIKE '%".$_GET['sSearch_'.$i]."%' ";
    }
  }
  
  
  /*
   * SQL queries
   * Get data to display
   */
  $colum = str_replace(" , ", " ", implode(", ", $aColumns));
  $sQuery =<<<SQL
SELECT $colum
FROM   $sTable
$sWhere
$sOrder
$sLimit
SQL;
  $rs = $conn->Execute($sQuery);
  $rResult = array();
  if(!$rs) {
    fatal_error($conn->ErrorMsg());
  } else if(!$rs->EOF) {
    while(!$rs->EOF) {
      $rResult[] = array(
        "id"=>$rs->fields['id'],
        "name"=>$rs->fields['name'],
        "point"=>$rs->fields['point'],
        "chara_id"=>$rs->fields['chara_id'],
        "rank"=>$rs->fields['rank']
      );
      $rs->MoveNext();
    }
  }
  
  /*
   * SQL queries
   * Get data to chara data
   */
  $sQuery =<<<SQL
SELECT id, name, file_name
FROM   chara
SQL;
  $rs = $conn->Execute($sQuery);
  $charaResult = array();
  if(!$rs) {
    fatal_error($conn->ErrorMsg());
  } else if(!$rs->EOF) {
    while(!$rs->EOF) {
      $charaResult[] = array(
        "id"=>$rs->fields['id'],
        "name"=>$rs->fields['name'],
        "file_name"=>$rs->fields['file_name']
      );
      $rs->MoveNext();
    }
  }
  
  /* Data set length after filtering */
  $sQuery =<<<SQL
SELECT count(*) as c
FROM   (select * from $sTable $sWhere $sOrder)
SQL;
  $rs = $conn->Execute($sQuery);
  $iFilteredTotal = 0;
  if(!$rs) {
    fatal_error($conn->ErrorMsg());
  } else if(!$rs->EOF) {
    $iFilteredTotal = $rs->fields['c'];
  }
  
  /* Total data set length */
  $sQuery =<<<SQL
SELECT COUNT(`$sIndexColumn`) as c
FROM   $sTable
SQL;
  $rs = $conn->Execute($sQuery);
  $iTotal = 0;
  if(!$rs) {
    fatal_error($conn->ErrorMsg());
  } else if(!$rs->EOF) {
    $iTotal = $rs->fields['c'];
  }
  
  
  /*
   * Output
   */
  $output = array(
    "sEcho" => intval($_GET['sEcho']),
    "iTotalRecords" => intval($iTotal),
    "iTotalDisplayRecords" => intval($iFilteredTotal),
    "aaData" => array()
  );
  
  foreach( $rResult as $aRow){
    $row = array();
    for ( $i=0 ; $i<count($aColumns) ; $i++ ){
      if($aColumns[$i] == "name") {
        $row[] = '<a href="#">'.$aRow['name'].'</a>';
      } else if($aColumns[$i] == "chara_id") {
        $chara_id = $aRow[$aColumns[$i]];
        $chara_file_path = $charaResult[$chara_id -1]['file_name'];
        $chara_id = "<img src='./img/$chara_file_path' style='width:40px;' />";
        $row[] = $chara_id;
      } else {
        $row[] = $aRow[$aColumns[$i]];
      }
    }
    $output['aaData'][] = $row;
  }
  
  echo json_encode( $output );
?>
