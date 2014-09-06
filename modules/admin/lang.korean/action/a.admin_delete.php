<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

foreach ($mbrmembers as $val)
{
	if ($my['uid'] == $val) continue;
	$M=getDbData($table['s_mbrid'],'uid='.$val,'*');
	getDbUpdate($table['s_mbrdata'],"admin=0,adm_view=''",'memberuid='.$M['uid']);
	unlink($g['dir_module'].'var/users/'.$M['id'].'.widget.php');
}

getLink('reload','parent.','','');
?>