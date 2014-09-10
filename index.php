<?php
header("Content-type:text/html;charset=utf-8");
define('__KIMS__',true);
error_reporting(E_ALL ^ E_NOTICE);
session_save_path('./_tmp/session');
session_start();

if(!get_magic_quotes_gpc())
{
	if (is_array($_GET))
		foreach($_GET as $_tmp['k'] => $_tmp['v'])
			if (is_array($_GET[$_tmp['k']]))
				foreach($_GET[$_tmp['k']] as $_tmp['k1'] => $_tmp['v1']) 
					$_GET[$_tmp['k']][$_tmp['k1']] = ${$_tmp['k']}[$_tmp['k1']] = addslashes($_tmp['v1']); 
			else $_GET[$_tmp['k']] = ${$_tmp['k']} = addslashes($_tmp['v']);
	if (is_array($_POST))
		foreach($_POST as $_tmp['k'] => $_tmp['v'])
			if (is_array($_POST[$_tmp['k']]))
				foreach($_POST[$_tmp['k']] as $_tmp['k1'] => $_tmp['v1']) 
					$_POST[$_tmp['k']][$_tmp['k1']] = ${$_tmp['k']}[$_tmp['k1']] = addslashes($_tmp['v1']);
			else $_POST[$_tmp['k']] = ${$_tmp['k']} = addslashes($_tmp['v']);
}
else {
	if (!ini_get('register_globals'))
	{
		extract($_GET);
		extract($_POST);
	}
}

$d = array();
$g = array(
	'path_root'   => './',
	'path_core'   => './_core/',
	'path_var'    => './_var/',
	'path_tmp'    => './_tmp/',
	'path_layout' => './layouts/',
	'path_module' => './modules/',
	'path_widget' => './widgets/',
	'path_switch' => './switchs/',
	'path_page'   => './pages/',
	'path_file'   => './files/',
	'sys_lang'    => 'korean'
);

$g['time_split'] = explode(' ',microtime());
$g['time_start'] = $g['time_split'][0]+$g['time_split'][1];

if (is_file($g['path_var'].'db.info.php'))
{
	require $g['path_module'].'admin/var/var.system.php';
	$g['url_file'] = str_replace('/index.php','',$_SERVER['SCRIPT_NAME']);
	$g['url_host'] = 'http'.($_SERVER['HTTPS']=='on'?'s':'').'://'.$_SERVER['HTTP_HOST'];
	$g['url_http'] = $g['url_host'].($d['admin']['http_port']&&$d['admin']['http_port']!=80?':'.$d['admin']['http_port']:'');
	$g['url_sslp'] = 'https://'.$_SERVER['HTTP_HOST'].($_SERVER['HTTPS']!='on'&&$d['admin']['ssl_port']?':'.$d['admin']['ssl_port']:'');
	$g['url_root'] = $g['url_http'].$g['url_file'];
	$g['ssl_root'] = $g['url_sslp'].$g['url_file'];
	
	require $g['path_var'].'db.info.php';
	require $g['path_var'].'table.info.php';
	require $g['path_var'].'switch.var.php';
	require $g['path_var'].'plugin.var.php';
	require $g['path_core'].'function/db.mysql.func.php';
	require $g['path_core'].'function/sys.func.php';
	foreach(getSwitchInc('start') as $_switch) include $_switch;
	require $g['path_core'].'engine/main.engine.php';
}
else $m = 'admin';

if ($keyword)
{
	$keyword = trim($keyword);
	$_keyword= stripslashes(htmlspecialchars($keyword));
}
if (!$p) $p = 1;
if (!is_dir($g['path_module'].$m)) $m = $g['sys_module'];
if (!is_dir($g['path_module'].$m.'/lang.'.$_HS['lang'])) $_HS['lang']=$g['sys_lang'];
$g['dir_module'] = $g['path_module'].$m.'/';
$g['url_module'] = $g['s'].'/modules/'.$m;
$g['img_module'] = $g['url_module'].'/images';

if ($a) require $g['path_core'].'engine/action.engine.php';
if ($_HS['open'] > 1) require $g['path_core'].'engine/siteopen.engine.php';
if (!$s && $m != 'admin') getLink($g['s'].'/?m=admin&module='.$g['sys_module'].'&nosite=Y','','','');

if($modal) $g['main'] = $g['path_module'].$modal.'.php';
else include $g['dir_module'].'main.php';

if ($m=='admin' || $iframe=='Y') $d['layout']['php'] = $_HM['layout'] = '_blank/main.php';
else {
	if (!$g['mobile']||$_SESSION['pcmode']=='Y') $d['layout']['php'] = $prelayout ? $prelayout.'.php' : ($_HM['layout'] ? $_HM['layout'] : $_HS['layout']);
	else $d['layout']['php'] = $prelayout ? $prelayout.'.php' : ($_HS['m_layout'] ? $_HS['m_layout'] : ($_HM['layout'] ? $_HM['layout'] : $_HS['layout']));
}

$d['layout']['dir'] = dirname($d['layout']['php']);
$g['dir_layout'] = $g['path_layout'].$d['layout']['dir'];
$g['url_layout'] = $g['s'].'/layouts/'.$d['layout']['dir'];
$g['img_layout'] = $g['url_layout'].'/img';

define('__KIMS_CONTENT__',$g['path_core'].'engine/content.engine.php');

if($my['admin'] && (!$_SERVER['HTTP_REFERER'] || $panel=='Y') && !$iframe)
{
	include $g['path_var'].'language/'.$g['sys_selectlang'].'/_top.lang.php';
	include $g['path_core'].'engine/adminpanel.engine.php';
}
else
{
	foreach($g['switch_1'] as $_switch) include $_switch;

	if ($m!='admin')
	{
		include $g['path_var'].'sitephp/'.$_HS['uid'].'.php';
		if($_HS['buffer'])
		{
			$g['buffer']=true;
			ob_start('ob_gzhandler');
		}
	}

	include './layouts/'.$d['layout']['dir'].'/_includes/_import.control.php';
	include $g['path_layout'].$d['layout']['php'];
	foreach($g['switch_4'] as $_switch) include $_switch;
	if($g['buffer']) ob_end_flush();
}
?>
