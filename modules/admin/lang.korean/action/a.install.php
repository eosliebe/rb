<?php
if(!defined('__KIMS__')) exit;

$iswpiinstall = false;
$wpivfile  = './wpi.var.php';
if (file_exists($wpivfile))
{
	$iswpiinstall = true;
	include_once $wpivfile;
}
$moduledir = array();
$_oldtable = array();
$_tmptable = array();
$_tmpdfile = $g['path_var'].'db.info.php';
$_tmptfile = $g['path_var'].'table.info.php';
include_once $g['path_core'].'function/sys.func.php';
include_once $g['path_core'].'function/db.mysql.func.php';
$date = getVDate(0);

if (is_file($_tmpdfile)) getLink('./','','','');

$DB_CONNECT = @mysql_connect($dbhost.':'.$dbport,$dbuser,$dbpass);
if (!$DB_CONNECT)
{
	echo '<script type="text/javascript">parent.isSubmit=false;parent.goStep(2);</script>';
	getLink('','','DB접속 유저네임이나 패스워드 혹은 포트가 정확하지 않습니다.','');
}
$DB_SELECT = @mysql_select_db($dbname,$DB_CONNECT);
if (!$DB_SELECT)
{
	echo '<script type="text/javascript">parent.isSubmit=false;parent.goStep(2);parent.procForm.dbname.focus();</script>';
	getLink('','','DB네임이 정확하지 않습니다.','');
}

$ISRBDB = db_fetch_array(db_query('select count(*) from '.$dbhead.'_s_module',$DB_CONNECT));
if ($ISRBDB[0])
{
	echo '<script type="text/javascript">parent.isSubmit=false;parent.goStep(2);parent.procForm.dbhead.focus();</script>';
	getLink('','','이미 동일한 테이블식별자로 킴스큐Rb용 DB가 생성되어 있습니다.    \n다른 테이블식별자를 사용해 주세요.','');
}

$fp = fopen($_tmpdfile,'w');
fwrite($fp, "<?php\n");
fwrite($fp, "\$DB['host'] = \"".$dbhost."\";\n");
fwrite($fp, "\$DB['name'] = \"".$dbname."\";\n");
fwrite($fp, "\$DB['user'] = \"".$dbuser."\";\n");
fwrite($fp, "\$DB['pass'] = \"".$dbpass."\";\n");
fwrite($fp, "\$DB['head'] = \"".$dbhead."\";\n");
fwrite($fp, "\$DB['port'] = \"".$dbport."\";\n");
fwrite($fp, "\$DB['type'] = \"".$dbtype."\";\n");
fwrite($fp, "?>");
fclose($fp);
@chmod($_tmpdfile,0707);
$DB['type'] = $dbtype;
$DB['head'] = $dbhead;

if (is_file($_tmptfile)) 
{
	include_once $_tmptfile;
	$_oldtable = $table;
}

$dirh = opendir($g['path_module']); 
while(false !== ($_file = readdir($dirh))) 
{ 
	if($_file == '.' || $_file == '..') continue;

	if(is_file($g['path_module'].$_file.'/_setting/db.table.php')) 
	{	
		$table = array();
		$module= $_file;
		include_once $g['path_module'].$_file.'/_setting/db.table.php';
		include_once $g['path_module'].$_file.'/_setting/db.schema.php';

		foreach($table as $key => $val) $_tmptable[$key] = $val;
		//rename($g['path_module'].$_file.'/_setting/db.table.php',$g['path_module'].$_file.'/_setting/db.table.php.done');

		$moduledir[$_file] = array($_file,count($table));
	}
	else {
		$moduledir[$_file] = array($_file,0);
	}
} 
closedir($dirh);

$fp = fopen($_tmptfile,'w');
fwrite($fp, "<?php\n");
foreach($_oldtable as $key => $val)
{
	if (!$_tmptable[$key])
	{
		fwrite($fp, "\$table['$key'] = \"$val\";\n");
	}
}
foreach($_tmptable as $key => $val)
{
	fwrite($fp, "\$table['$key'] = \"$val\";\n");
}
fwrite($fp, "?>");
fclose($fp);
@chmod($_tmptfile,0707);

include $_tmptfile;

$gid = 0;

$mdlarray = array('dashboard','market','admin','module','site','layout','domain','device');
foreach($mdlarray as $_val)
{
	$QUE = "insert into ".$table['s_module']." 
	(gid,system,hidden,mobile,name,id,tblnum,icon,d_regis) 
	values 
	('".$gid."','1','".(strstr('[market][admin][site][layout]','['.$_val.']')?0:1)."','1','".getFolderName($g['path_module'].$moduledir[$_val][0])."','".$moduledir[$_val][0]."','".$moduledir[$_val][1]."','kf-".($_val=='site'?'home':$_val)."','".$date['totime']."')";
	db_query($QUE,$DB_CONNECT);
	$gid++;
}

$siteid = 'home';
$layout = 'b-dash/default.php';
$QKEY = "gid,id,name,title,titlefix,icon,layout,startpage,m_layout,m_startpage,lang,open,dtd,nametype,timecal,rewrite,buffer,usescode,headercode,footercode";
$QVAL = "'0','".$siteid."','$sitename','$sitename','0','','$layout','0','mobile/default.php','0','$sitelang','1','','nic','0','0','0','0','',''";
getDbInsert($table['s_site'],$QKEY,$QVAL);
db_query("OPTIMIZE TABLE ".$table['s_site'],$DB_CONNECT); 
$S = getDbData($table['s_site'],"id='".$siteid."'",'*');
$LASTUID = $S['uid'];

$pagesarray = array
(
	'main'=>array('메인화면','3',''),
);


foreach($pagesarray as $_key => $_val)
{
	$QUE = "insert into ".$table['s_page']." 
	(pagetype,ismain,mobile,id,category,name,perm_g,perm_l,layout,joint,hit,d_regis,d_update)
	values
	('$_val[1]','".($_key=='main'?1:0)."','".($_key=='main'?1:0)."','$_key','기본페이지','$_val[0]','','0','','$_val[2]','0','".$date['totime']."','')";
	db_query($QUE,$DB_CONNECT);

/*
	$mfile = $g['path_page'].$_key.'.php';
	$fp = fopen($mfile,'w');
	fwrite($fp,$_val[0]);
	fclose($fp);
	@chmod($mfile,0707);
	$mfile = $g['path_page'].$_key.'.widget.php';
	$fp = fopen($mfile,'w');
	fwrite($fp,'');
	fclose($fp);
	@chmod($mfile,0707);
*/
}

//임시셋팅
$menus_array = array(
	
	'event-overview' => 'Event Overview',
	'speakers-and-moderators' => 'Speakers & Moderators',
	'event-program' => 'Event Program',
	'previous-events' => 'Previous Events',
	'cover' => 'Cover'
);

$_i = 0;
foreach($menus_array as $_key => $_val)
{
	$qkey = 'gid,site,isson,parent,depth,id,menutype,mobile,hidden,reject,name,target,redirect,joint,layout,imghead,imgfoot,addattr';
	$qval = "'".$_i."','".$LASTUID."','0','0','1','".$_key."','3','1','0','0','".$_val."','','','','','','',''";
	getDbInsert($table['s_menu'],$qkey,$qval);
	$lastmenu = getDbCnt($table['s_menu'],'max(uid)','');

	$mfile = $g['path_page'].'menu/'.sprintf('%05d',$lastmenu);

	$fp = fopen($mfile.'.php','w');
	fwrite($fp,'');
	fclose($fp);
	@chmod($mfile.'.php',0707);

	$fp = fopen($mfile.'.widget.php','w');
	fwrite($fp,'');
	fclose($fp);
	@chmod($mfile.'.widget.php',0707);

	$_i++;
}





db_query("insert into ".$table['s_mbrid']." (site,id,pw)values('1','$id','".md5($pw1)."')",$DB_CONNECT);
$QUE = "insert into ".$table['s_mbrdata']." 
(memberuid,site,auth,sosok,level,comp,admin,adm_view,
email,name,nic,grade,photo,home,sex,birth1,birth2,birthtype,tel1,tel2,zip,
addr0,addr1,addr2,job,marr1,marr2,sms,mailing,smail,point,usepoint,money,cash,num_login,pw_q,pw_a,now_log,last_log,last_pw,is_paper,d_regis,tmpcode,sns,addfield)
values
('1','1','1','1','1','0','1','',
'$email','$name','관리자','','','','0','0','0','0','','','',
'','','','','0','0','1','1','0','0','0','0','0','1','킴스큐 설치시에 입력한 회원비밀번호는?','$pw1','1','".$date['totime']."','".$date['today']."','0','".$date['totime']."','','','')";
db_query($QUE,$DB_CONNECT);

$sosokset = array('A그룹','B그룹','C그룹','D그룹','E그룹','F그룹','G그룹','H그룹');
$i = 0;
foreach ($sosokset as $_val)
{
	getDbInsert($table['s_mbrgroup'],'gid,name,num',"'".$i."','".$_val."','".(!$i?1:0)."'");
	$i++;
}
for ($i = 1; $i < 101; $i++)
{
	getDbInsert($table['s_mbrlevel'],'gid,name,num,login,post,comment',"'".($i==20?1:0)."','레벨".$i."','".($i==1?1:0)."','0','0','0'");
}

setcookie('svshop', $id.'|'.$pw1, time()+60*60*24*30, '/');

$_SESSION['mbr_uid'] = 1;
$_SESSION['mbr_pw']  = md5($pw1);

$fp = fopen($g['path_module'].'admin/var/users/'.$id.'.widget.php','w');
fwrite($fp,'');
fclose($fp);
@chmod($g['path_module'].'admin/var/users/'.$id.'.widget.php',0707);


if ($iswpiinstall)
{
	unlink($wpivfile);
	getLink('./?r='.$id.'&panel=Y','','설치가 완료되었습니다. 홈페이지로 이동합니다.','');
}

getLink('./?r='.$id.'&panel=Y','parent.','설치가 완료되었습니다. 홈페이지로 이동합니다.','');
?>