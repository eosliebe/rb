<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$admin_id = trim($admin_id);
$R = getDbData($table['s_mbrid'],"id='".$admin_id."'",'*');
if (!$R['uid']) getLink('','','존재하지 않는 회원아이디입니다.','');

$M = getDbData($table['s_mbrdata'],'memberuid='.$R['uid'],'*');

if ($M['admin']) getLink('','','이미 관리자로 지정된 회원입니다.','');

getDbUpdate($table['s_mbrdata'],"admin=1,adm_view=''",'memberuid='.$R['uid']);

$fp = fopen($g['dir_module'].'var/users/'.$R['id'].'.widget.php','w');
fwrite($fp,'');
fclose($fp);
@chmod($g['dir_module'].'var/users/'.$R['id'].'.widget.php',0707);

getLink('reload','parent.','','');
?>