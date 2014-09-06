<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

getDbUpdate($table['s_module'],'mobile=0',"id='".$module_id."'");

getLink($g['s'].'/?r='.$r.'&m='.$m,'','모바일 관리패널에서 제외되었습니다.','');
?>