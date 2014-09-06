<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$id = trim($id);
$name = trim($name);
$title = trim($title);
$headercode = trim($headercode);
$footercode = trim($footercode);

if ($modal == 'Y')
{
		if (!$id)
		{
			$id = 's'.date('His');
		}

		$ISID = getDbData($Table['s_site'],"id='".$id."'",'*');
		if ($ISID['uid']) getLink('','','이미 동일한 코드의 사이트가 존재합니다.','-1');

		$MAXC = getDbCnt($table['s_site'],'max(gid)','');
		$gid = $MAXC + 1;
		
		$QKEY = "gid,id,name,title,titlefix,icon,layout,startpage,m_layout,m_startpage,lang,open,dtd,nametype,timecal,rewrite,buffer,usescode,headercode,footercode";
		$QVAL = "'$gid','$id','$name','$name','0','glyphicon glyphicon-home','$layout','1','','','korean','1','','nic','0','0','0','1','',''";
		getDbInsert($table['s_site'],$QKEY,$QVAL);
		$LASTUID = getDbCnt($table['s_site'],'max(uid)','');
		db_query("OPTIMIZE TABLE ".$table['s_site'],$DB_CONNECT); 


		$vfile = $g['path_var'].'sitephp/'.$LASTUID.'.php';
		$fp = fopen($vfile,'w');
		fwrite($fp, trim(stripslashes($sitephpcode)));
		fclose($fp);
		@chmod($vfile,0707);

		getLink($g['s'].'/?r='.$id.'&panel=Y','parent.parent.','','');
}
else {

	if ($site_uid)
	{
		$ISID = getDbData($Table['s_site'],"uid<>".$site_uid." and id='".$id."'",'*');
		if ($ISID['uid']) getLink('','','이미 동일한 명칭의 계정아이디가 존재합니다.','');

		if ($iconaction)
		{
			getDbUpdate($table['s_site'],"icon='$icon'",'uid='.$site_uid);
			exit;
		}

		$QVAL = "id='$id',name='$name',title='$title',titlefix='$titlefix',icon='$icon',layout='$layout',startpage='$startpage',m_layout='$m_layout',m_startpage='$m_startpage',lang='$sitelang',open='$open',dtd='$dtd',nametype='$nametype',timecal='$timecal',rewrite='$rewrite',buffer='$buffer',usescode='$usescode',headercode='$headercode',footercode='$footercode'";
		getDbUpdate($table['s_site'],$QVAL,'uid='.$site_uid);

		$vfile = $g['path_var'].'sitephp/'.$site_uid.'.php';
		$fp = fopen($vfile,'w');
		fwrite($fp, trim(stripslashes($sitephpcode)));
		fclose($fp);
		@chmod($vfile,0707);

		if ($r != $id)
		{
			if ($backgo == 'admin')
			{
				getLink($g['s'].'/?r='.$id.'&m='.$backgo.'&module='.$m,'parent.','','');
			}
			else {
				getLink($g['s'].'/?r='.$id.'&system=edit.all&type=site','parent.','','');
			}
		}
		else {
			if ($iframe=='Y') getLink('reload','parent.parent.','','');
			else getLink('reload','parent.','','');
		}
	}
	else {
		
		if (!$id)
		{
			$id = 's'.date('His');
		}
		if (!$title)
		{
			$title = $name;
		}

		$ISID = getDbData($Table['s_site'],"id='".$id."'",'*');
		if ($ISID['uid']) getLink('','','이미 동일한 명칭의 계정아이디가 존재합니다.','');

		$MAXC = getDbCnt($table['s_site'],'max(gid)','');
		$gid = $MAXC + 1;
		
		$QKEY = "gid,id,name,title,titlefix,icon,layout,startpage,m_layout,m_startpage,lang,open,dtd,nametype,timecal,rewrite,buffer,usescode,headercode,footercode";
		$QVAL = "'$gid','$id','$name','$title','$titlefix','$icon','$layout','$startpage','$m_layout','$m_startpage','$sitelang','$open','$dtd','$nametype','$timecal','$rewrite','$buffer','$usescode','$headercode','$footercode'";
		getDbInsert($table['s_site'],$QKEY,$QVAL);
		$LASTUID = getDbCnt($table['s_site'],'max(uid)','');
		db_query("OPTIMIZE TABLE ".$table['s_site'],$DB_CONNECT); 


		$vfile = $g['path_var'].'sitephp/'.$LASTUID.'.php';
		$fp = fopen($vfile,'w');
		fwrite($fp, trim(stripslashes($sitephpcode)));
		fclose($fp);
		@chmod($vfile,0707);

		
		if ($nosite=='Y')
		{
			getLink($g['s'].'/?r='.$id.'&m=admin&pickmodule='.$m.'&panel=Y','parent.','','');
		}
		else {
			getLink('reload','parent.','','');
		}
	}
}
?>