<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$id = trim($id);
$name = trim($name);
$title = trim($title);

if ($site_uid)
{
	$ISID = getDbData($Table['s_site'],"uid<>".$site_uid." and id='".$id."'",'*');
	if ($ISID['uid']) getLink('','','이미 동일한 명칭의 계정아이디가 존재합니다.','');

	$QVAL = "id='$id',name='$name',title='$title',layout='$layout',startpage='$startpage',m_layout='$m_layout',m_startpage='$m_startpage',open='$open'";
	getDbUpdate($table['s_site'],$QVAL,'uid='.$site_uid);
}

getLink('reload','parent.frames._ADMPNL_.','','');
?>