<?php

function h($var) {
	return htmlspecialchars($var, ENT_QUOTES, 'EUC-JP');
}

function v($var) {
	var_dump($var);
}