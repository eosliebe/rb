<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
if ($my['uid'] != 1) getLink('','','권한이 없습니다.','');

getDbUpdate($table['s_mbrdata'],"adm_view='".$perm."'",'memberuid='.$memberuid);

getLink('reload','parent.','처리되었습니다.','');
?>