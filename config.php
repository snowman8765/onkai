<?php
include_once("../lib/adodb5/adodb.inc.php");

include_once("../lib/log4php/Logger.php");
Logger::configure('log4php.xml');
$log = Logger::getLogger('default');

define('DB_DRIVER', 'pdo');
define('DB_TYPE', 'sqlite');
define('USER_DB', 'data.db');

//define('SERVER_NAME', 'reimu');
define('SERVER_NAME', 'snowman8765.sakura.ne.jp');

define('ANSWER_TYPE_OX', 0);
define('ANSWER_TYPE_2', 1);
define('ANSWER_TYPE_3', 2);
define('ANSWER_TYPE_4', 3);
define('ANSWER_TYPE_5', 4);
define('ANSWER_TYPE_6', 5);
define('ANSWER_TYPE_ZYUNBAN', 6);
define('ANSWER_TYPE_TYPING', 7);
define('ANSWER_TYPE_TATOU', 8);

$ANSWER_TYPE = array('OX',
                       '2択',
                       '3択',
                       '4択',
                       '5択',
                       '6択',
                       '順番当て',
                       'タイピング',
                       '一問多答');
?>