<?php
#-----------------------------#
# PHP���åץ����� Ver 1.6.0 #
# ���𤹤�����			      #
# http://www.k-php.com/	      #
#-----------------------------#

require_once 'basics.php';

### ���饹���
class CF_class {
	## �������

	# �����ѥѥ����
	# �����ե������DELkey��DLkey�Ȥ��ƻȤ��ޤ���
	var $master = "snow_admin";

	# �����ȥ�
	var $title = "���ץ��";

	# ���ڡ����������ɽ�����
	var $onep = "20";

	# ������¸���
	var $maxlog = "50000";

	# ���Υ�����ץ�̾
	var $script = "./index.php";

	# �ե��������
	var $alllog = "./alllog.cgi";

	# ��Ƭ���file10010.gif,file10011.mp3�Ȥ��ˤ������"file"�Ǥ���
	# �ʱ��Ĥ�������ѹ����ʤ��ǲ�������
	var $fnh = "file";

	# ����ե�����Х��ȿ�(KB�ǻ���)
	var $max_file = "1000";

	# ���祳���ȥХ��ȿ�(Byte�ǻ���)
	var $max_com = "80";

	# Ʊ��IP�����Ϣ³��Ƶ�����0�ˤ���ȵ������ޤ����
	# ���äǻ����
	var $wait = "60";

	# �����󥿡���ɽ�������1=yes,0=no��	
	var $counter = "1";

	# �������������ɬ�ܤˤ����1=yes,0=no��	
	var $com_must = "1";

	# �ǽ������¸��
	var $last_log = "./last.cgi";

	# �����󥿡���
	var $count_log = "./count.cgi";

	# �ե�������¸�ե����
	var $src = "./src/";

	# ���åץ��ɤǤ����ĥ��
	var $upok = array("gif","bmp","png","jpg","jpeg","zip","lzh","txt","rar","gca","mpg","mp3","avi","swf","doc","3gp","amc","mld","pdf","ppt");

	# ���ߤΥڡ����������ڡ����ؤΰ�ư���
	var $back = "3";

	# ���ߤΥڡ������鼡�ڡ����ؤΰ�ư���
	var $next = "4";

	## ������ꤪ���

	## �ե��󥯥����
	# �إå���
	function html_head() {
		?>
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
		<title><?php echo h($this->title) ?></title>
		<link href="./style.css" rel="stylesheet" type="text/css">
		</head>
		<body>
		<table width="700px" align="center"><tr><td>

		<table class="wrap" cellspacing="1" cellpadding="1">
		<tr bgcolor="#ffffff"><td>
		<div class="title">���ץ��</div>
		<div class="contents">
		<?php
	}

	# �եå���
	function html_foot() {
		?>
		<div class="copy">&copy;<a href="http://www.k-php.com">���𤹤�����</a></div>
		</div>
		</td></tr>
		</table>
		</td></tr></table>
		</body>
		</html>
		<?php
	}

	# �ȥå�ɽ��
	function file_list($mo) {
		if($this->counter) {
			$fp = @fopen("$this->count_log","r+");
			@flock($fp,LOCK_EX);
			$l = @fgets($fp);
			$l++;
			@rewind($fp);
			@fputs($fp,$l);
			@fclose($fp);
			$disp_counter = "count:"."$l";
		}
	
		$file_list .= "<table align=\"center\" width=\"60%\" cellpadding=\"4\" cellspacing=\"1\" bgcolor=\"#D0D0D0\">\n";
		$file_list .= "<tr><td bgcolor=\"#eeeeee\">\n";
		$file_list .= "<form action=\"$this->script?m=up\" method=\"post\" ENCTYPE=\"MULTIPART/FORM-DATA\">\n";
		$file_list .= "<table width=\"100%\" border=0>\n";
		$file_list .= "<tr><td width=\"50px\">�ե�����</td><td colspan=\"3\"><input type=\"file\" name=\"file\" size=\"20\"></td></tr>\n";
		$file_list .= "<tr><td>������</td><td colspan=\"3\"><input type=\"text\" name=\"com\" size=\"50\"></td></tr>\n";
		$file_list .= "<tr><td>DLkey</td><td><input type=\"password\" name=\"dlkey\" size=\"8\" maxlength=\"10\"></td><td width=\"50px\">Delkey</td><td width=\"180px\"><input type=\"password\" name=\"delkey\" size=\"8\"> <input type=\"submit\" value=\"SUBMIT\"></td></tr>\n";
		$file_list .= "</table>\n";
		$file_list .= "<div style=\"font-size:12px;padding:5px;color:#666666;\">\n";
		$file_list .= "��������$this->max_file"."KB�ޤ�\n<br />";
		$file_list .= "up�ġ�\n";
		for($i=0;$this->upok[$i];$i++) {
			$file_list .= $this->upok[$i]." ";
		}
		$file_list .= "<span style=\"float:right;\">$disp_counter <a href=\"$this->script\">[reload]</a></span>\n";
		$file_list .= "</div>\n";
		$file_list .= "</form>\n";
		$file_list .= "</td></tr>\n";
		$file_list .= "</table>\n";

		$lines = @file($this->alllog);
		# ���
		$all_row = count($lines);
		# ���ڡ�����
		$pages = $all_row / $this->onep;
		if(preg_match("/\./","$pages")) {
			$pages = floor(($pages + 1));
		}
		# ���ߤΥڡ���
		$page = ($mo + $this->onep) / $this->onep;
		if($lines[0]) {
			$file_list .= "<span style=\"line-height:200%;\">�ե��������$all_row"."�� ��$page"."/$pages"."��</span><br />\n";
		} else {
			$file_list .= "<br />\n";
		}
		$file_list .= "<table width=\"100%\" cellpadding=\"4\" cellspacing=\"1\" bgcolor=\"#D0D0D0\">\n";
		if(!$lines[0]) {
			$file_list .= "<tr bgcolor=\"#ffffff\"><td>�ե����뤬�����ʤ��Ǥ�..</td></tr>\n";			
		} else {
			$file_list .= "<tr bgcolor=\"#eeeeee\"><td>DL</td><td>������</td><td>������</td><td>����</td><td>���ե�����̾</td><td>���</td></tr>\n";
			if(!$mo) {$mo = 0;}
			for($i=0;$i!=$this->onep;$i++,$mo++) {
				if($lines[$mo]) {
					list($num,$kac,$com,$size,$date,$orig,$dlkey,$delkey,$id,$ip,$times) = explode("<>",$lines[$mo]);
					if($dlkey != "") {
						$com = "<font color=\"red\">[DLkey]</font> ".h($com);
						$dname = "<a href=\"{$this->script}?m=dp&n={$this->fnh}{$num}\" target=_blank>[{$this->fnh}{$num}".".$kac"."]</a>";
					} else {
						$dname = "<a href=\"{$this->src}{$this->fnh}{$num}.{$kac}\" target=_blank>[{$this->fnh}{$num}".".$kac"."]</a>";
					}
					$file_list .= "<tr bgcolor=\"#ffffff\"><td>".$dname."</td><td>".$com."</td><td>".$this->format($size)."</td><td>".h($date)."</td><td>".h($orig)."</td><td><a href=\"{$this->script}?m=del&n={$this->fnh}{$num}\">[DEL]</a></td></tr>\n";
				}
			}
		}

		$file_list .= "</table>\n";
		if($this->onep < $all_row) {
			$file_list .= $this->move_link($page,$pages,$all_row,$mo);
		}
		$file_list .= "\n";
		return $file_list;
	}

	# ��ư�ѥ��
	function move_link($page,$pages,$all_row,$mo) {

		## ��ư�ѥ��
		$move_link .= "<div style=\"padding:10px;\">";
		# ��Ƭ�ڡ���
		if(($page - $this->back) > 1) {
			$move_link .= "<a href=\"".$this->script."?mo=0\" class=\"disp_link\">|<<</a> ";
		}
		# ���ڡ���ɽ��
		if(($mo - $this->onep) > 0) {
			$xpage = $page;
			$fp = $xpage - $this->back - 1;
			for($i=0;$i<$this->back;$fp++) {
				if($fp > -1) {
					$nmo = $fp * $this->onep;
					$dfp = $fp + 1;
					$move_link .= "<a href=\"".$this->script."?mo=".h($nmo)."\" class=\"disp_link\">$dfp</a> ";
				}
			$i++;
			}
		}
		# ���ߤΥڡ���ɽ��
		$move_link .= "<b style=\"color:red\" class=\"disp_ltex\">$page</b> ";
		# ���ڡ���ɽ��
		if($mo < $all_row) {
			$xpage = $page;
			$nmo = $mo;
			for($i=0;$i<$this->next;$i++){
				$xpage++;
				if($pages < $xpage) {break;}
				$move_link .= "<a href=\"".$this->script."?mo=".h($nmo)."\" class=\"disp_link\">{$xpage}</a> ";
				$nmo = $nmo + $this->onep;
			}
		}
		# ���ڡ���
		if(($mo + $this->onep * $this->next) < $all_row) {
			$nmo = ($pages * $this->onep) - $this->onep;
			$move_link .= "<a href=\"".$this->script."?mo=".h($nmo)."\" class=\"disp_link\">>>|</a>";
		}
		$move_link .= "</div>";
		return $move_link;
	}

	# �ե�����UP
	function file_up() {
		$keys = array_keys($_POST);
		for($k=0;$keys[$k];$k++) {
			$_POST[$keys[$k]] = str_replace("<","&lt;",$_POST[$keys[$k]]);
		}

		$img_tmp = $_FILES["file"]["tmp_name"];
		$img_name = $_FILES["file"]["name"];
		$img_size = $_FILES["file"]["size"];

		$f = strrev($img_name);
		$ext = substr($f,0,strpos($f,"."));
		$ext = strrev($ext);

		# ��ĥ�Ҥ���ʸ����
		$ext_big = strtoupper($ext);
		# ��ĥ�Ҥ�ʸ����
		$ext_small = strtolower($ext);
		if(!$img_tmp) {
			echo $this->error("�ե���������Ϥ��Ƥ�������");
			echo $this->html_foot();
			exit;
		} elseif(($img_size/1024) > $this->max_file) {
			echo $this->error("�ե����륵�������礭�����ޤ�");
			echo $this->html_foot();
			exit;
		} elseif(strlen($_POST[com]) > $this->max_com) {
			echo $this->error("�����Ȥ�Ĺ�����ޤ�");
			echo $this->html_foot();
			exit;
		} elseif(!in_array($ext_small, $this->upok) and !in_array($ext_big, $this->upok)) {
			echo $this->error("�����ʥե�����Ǥ�");
			echo $this->html_foot();
			exit;
		} elseif($this->com_must and $_POST[com] == "") {
			echo $this->error("�����Ȥ����Ϥ��Ƥ�������");
			echo $this->html_foot();
			exit;
		}

		$nip = $_SERVER['REMOTE_ADDR'];
		if($this->wait) {
		    $now = time();
		    $last = @fopen($this->last_log, "r+") or die("�ǽ������¸����������Ƥ�������");
			$line = fgets($last);
			list($lbt, $lip) = explode("<>", $line);
			if($nip == $lip && $lbt > $now - $this->wait){
				echo $this->error("Ϣ³��Ƥ������Ƥ��ޤ����⤦�����ֳ֤򤢤��Ƥ������������");
				echo $this->html_foot();
				exit;
			}
			rewind($last);
			fputs($last, "$now<>$nip<>");
			fclose($last);
		}

		$ndate = date("y/m/d-H:i");

		if($_POST[delkey] != "") {
			$ndelkey = crypt($_POST[delkey],vi);
		}

		$fp = @fopen($this->alllog,"r+") or die("�ե���������ѥ���������Ƥ�������");
		stream_set_write_buffer($fp,0);
		flock($fp,LOCK_EX);

		$FSTline = fgets($fp);
		list($num,$kac,$com,$size,$date,$orig,$dlkey,$delkey,$id,$ip,$times) = explode("<>",$FSTline);
		$nnum = $num + 1;
		if($_POST[dlkey] != "") {
			$ndlkey = crypt($_POST[dlkey],vi);
			$chars = "0123456789abcdefghijklmnopqrstuvwxyz";
			$maxrange = strlen($chars);
			$nid = "";
			for($s=0;$s!=20;$s++) {$nid .= $chars[rand(0,$maxrange)];}
			$to_path = $this->src.$nid.".{$ext}";
		} else {
			$to_path = $this->src.$this->fnh.$nnum.".{$ext}";
		}

		$Plines = "$nnum<>$ext<>$_POST[com]<>$img_size<>$ndate<>$img_name<>$ndlkey<>$ndelkey<>$nid<>$nip<>0<>\n";
		$i = 0;
		rewind($fp);
		while (!feof($fp)) {
			$i++;
			$Eline = fgets($fp);
			if($i > $this->maxlog - 1) {
				list($num,$kac,$com,$size,$date,$orig,$dlkey,$delkey,$id,$ip,$times) = explode("<>",$Eline);
				if($id != "") {
					@unlink("{$this->src}{$id}.{$kac}");
				} else {
					@unlink("{$this->src}{$this->fnh}{$num}.{$kac}");
				}
			} else {$Plines .= $Eline;}
		}
		ftruncate($fp, 0);
		rewind($fp);
		fputs($fp,$Plines);
		flock($fp,LOCK_UN);
		fclose($fp);

		move_uploaded_file($img_tmp,$to_path);
	}

	# DL�ڡ���
	function dl_page() {
		$lines = @file($this->alllog);
		for($i=0;$lines[$i];$i++) {
			list($num,$kac,$com,$size,$date,$orig,$dlkey,$delkey,$id,$ip,$times) = explode("<>",$lines[$i]);
			if("{$this->fnh}{$num}" == $_GET[n]) {
				$flag = 1;
				break;
			}
		}
		if(!$flag) {
				echo $this->error("�ե����뤬���Ĥ���ޤ���");
				echo $this->html_foot();
				exit;
		}

		$dl_page .= "<table align=\"center\" width=\"60%\" cellpadding=\"4\" cellspacing=\"1\" bgcolor=\"#D0D0D0\">\n";
		$dl_page .= "<tr><td bgcolor=\"#eeeeee\" align=\"center\">\n";
		$dl_page .= "<font color=\"red\">$this->fnh$num.$kac"."��DL����ˤ�DLkey��ɬ�פʤ�Ǥ���</font>\n<br /><br />";
		$dl_page .= "<form action=\"{$this->script}?m=dp&n=".h($_GET[n])."\" method=\"post\">\n";
		$dl_page .= "<table align=\"center\" cellpadding=\"2\">\n";
		$dl_page .= "<tr><td>�ե�����</td><td>{$this->fnh}{$num}.{$kac}</td></tr>\n";
		$dl_page .= "<tr><td>����</td><td>{$date}</td></tr>\n";
		$dl_page .= "<tr><td>������</td><td>".$this->format($size)."</td></tr>\n";
		$dl_page .= "<tr><td>������</td><td>".h($com)."</td></tr>\n";
		$dl_page .= "<tr><td>DL��</td><td>".h($times)."</td></tr>\n";
		$dl_page .= "<tr><td>DLkey</td><td><input type=\"text\" size=\"12\" name=\"dlkey\"></td></tr>\n";
		$dl_page .= "\n";
		$dl_page .= "</table>\n";
		$dl_page .= "<input type=\"hidden\" name=\"dlroot\" value=\"1\">\n";
		$dl_page .= "<input type=\"submit\" value=\"���������\"><br /><br />\n";
		$dl_page .= "</form>\n";
		$dl_page .= "<a href=\"{$this->script}\">[�ȥåפ�]</a>\n";
		$dl_page .= "</td></tr>\n";
		$dl_page .= "</table>\n";

		$dl_page .= "\n";
		return $dl_page;
	}

	# DL�¹�
	function dl_do() {
		$fp = @fopen($this->alllog,"r+") or die("�ե���������ѥ���������Ƥ�������");
		stream_set_write_buffer($fp,0);
		flock($fp,LOCK_EX);

		while (!feof($fp)) {
			$Eline = fgets($fp);
			list($num,$kac,$com,$size,$date,$orig,$dlkey,$delkey,$id,$ip,$times) = explode("<>",$Eline);
			if("$this->fnh$num" == $_GET[n]) {break;}
		}

		$dlnum = $num;
		$dlid = $id;
		$dlkac = $kac;

		if($_POST[dlkey] != $this->master or strlen($_POST[dlkey]) != strlen($this->master)) {
			if($_POST[dlkey] == "" or $dlkey != crypt($_POST[dlkey],vi)) {
				flock($fp,LOCK_UN);
				fclose($fp);
				echo $this->html_head();
				echo $this->error("DLkey�������Ǥ�");
				echo $this->html_foot();
				exit;
			}
		}

		$Plines = "";
		rewind($fp);
		while (!feof($fp)) {
			$Eline = fgets($fp);
			list($num,$kac,$com,$size,$date,$orig,$dlkey,$delkey,$id,$ip,$times) = explode("<>",$Eline);
			if("{$this->fnh}{$num}" == $_GET[n]) {
				$times++;
				$Plines .= "$num<>$kac<>$com<>$size<>$date<>$orig<>$dlkey<>$delkey<>$id<>$ip<>$times<>\n";
			} else {
				$Plines .= $Eline;
			}
		}

		ftruncate($fp, 0);
		rewind($fp);
		fputs($fp,$Plines);

		flock($fp,LOCK_UN);
		fclose($fp);

		$npath = "{$this->src}{$dlid}.{$dlkac}";
		header("Content-Disposition: attachment; filename={$this->fnh}{$dlnum}.{$dlkac}");
		header("Content-type: application/x-csv");
		readfile ($npath);
		exit;
	}

	# DEL�ڡ���
	function del_page() {
		$lines = @file($this->alllog);
		for($i=0;$lines[$i];$i++) {
			list($num,$kac,$com,$size,$date,$orig,$dlkey,$delkey,$id,$ip,$times) = explode("<>",$lines[$i]);
			if("{$this->fnh}{$num}" == $_GET[n]) {break;}
		}
		$dl_page .= "<table align=\"center\" width=\"60%\" cellpadding=\"4\" cellspacing=\"1\" bgcolor=\"#D0D0D0\">\n";
		$dl_page .= "<tr><td bgcolor=\"#eeeeee\" align=\"center\">\n";
		$dl_page .= "<font color=\"red\">" . $this->fnh . $num . h('.'.$kac) ."�������ޤ���</font>\n<br /><br />";
		$dl_page .= "<form action=\"$this->script?m=deldo&n=$_GET[n]\" method=\"post\">\n";
		$dl_page .= "<table align=\"center\" cellpadding=\"2\">\n";
		$dl_page .= "<tr><td>�ե�����</td><td>$this->fnh$num.$kac</td></tr>\n";
		$dl_page .= "<tr><td>DELkey</td><td><input type=\"text\" size=\"12\" name=\"delkey\"></td></tr>\n";
		$dl_page .= "\n";
		$dl_page .= "</table>\n";
		$dl_page .= "<input type=\"submit\" value=\"DELETE\"><br /><br />\n";
		$dl_page .= "</form>\n";
		$dl_page .= "<a href=\"$this->script\">[�ȥåפ�]</a>\n";
		$dl_page .= "</td></tr>\n";
		$dl_page .= "</table>\n";

		$dl_page .= "\n";
		return $dl_page;
	}

	# DEL�¹�
	function del_do() {
		$fp = @fopen($this->alllog,"r+") or die("�ե���������ѥ���������Ƥ�������");
		stream_set_write_buffer($fp,0);
		flock($fp,LOCK_EX);

		while (!feof($fp)) {
			$Eline = fgets($fp);
			list($num,$kac,$com,$size,$date,$orig,$dlkey,$delkey,$id,$ip,$times) = explode("<>",$Eline);
			if("$this->fnh$num" == $_GET[n]) {break;}
		}

		if($_POST[delkey] != $this->master or strlen($_POST[delkey]) != strlen($this->master)) {
			if($_POST[delkey] == "" or $delkey != crypt($_POST[delkey],vi)) {
				flock($fp,LOCK_UN);
				fclose($fp);
				echo $this->error("DELkey�������Ǥ�");
				echo $this->html_foot();
				exit;
			}
		}

		rewind($fp);
		while (!feof($fp)) {
			$Eline = fgets($fp);
			list($num,$kac,$com,$size,$date,$orig,$dlkey,$delkey,$id,$ip,$times) = explode("<>",$Eline);
			if("$this->fnh$num" != $_GET[n]) {
				$Plines .= $Eline;
			} else {
				if($id != "") {
					@unlink("$this->src$id.$kac");
				} else {
					@unlink("$this->src$this->fnh$num.$kac");
				}
			}
		}

		ftruncate($fp, 0);
		rewind($fp);
		fputs($fp,$Plines);
		flock($fp,LOCK_UN);
		fclose($fp);
	}

	# �ե����륵�����ե����ޥå�
	function format($esize) {
		if($esize > 1023) {
			$esize = floor($esize/1024);
			$esize .= "KB";
		} else {
			$esize .= "bytes";
		}
		return $esize;
	}

	# ���顼
	function error($mes) {
		$error .= "<table align=\"center\" width=\"60%\" cellpadding=\"4\" cellspacing=\"1\" bgcolor=\"#D0D0D0\">\n";
		$error .= "<tr><td bgcolor=\"#eeeeee\" align=\"center\">\n";
		$error .= "<font color=\"red\">ERROR</font>\n<br /><br />";
		$error .= h($mes) . "<br /><br />\n";
		$error .= "<input type=button value=\"���\" onClick=\"javascript:history.go(-1)\">\n";
		$error .= "</td></tr>\n";
		$error .= "</table>\n";

		$error .= "\n";
		return $error;
	}

} ### ���饹�����λ


### ��ư��
# ���֥�����������
$c = new CF_class;

## ʬ��
switch($_GET[m]) {

	case dp://DL�ڡ������¹�
	if($_POST[dlroot]) {
		$c->dl_do();
	} else {
		$c->html_head();
		echo $c->dl_page();
	}
	break;

	case up://UP
	$c->html_head();
	$c->file_up();
	echo $c->file_list(0);
	break;

	case del://DEL�ڡ���
	$c->html_head();
	echo $c->del_page();
	break;

	case deldo://DEL�¹�
	$c->html_head();
	$c->del_do();
	echo $c->file_list(0);
	break;

	default://�ȥå׽���
	$c->html_head();
	echo $c->file_list($_GET[mo]);
	break;
}

# �եå�������
echo $c->html_foot();
