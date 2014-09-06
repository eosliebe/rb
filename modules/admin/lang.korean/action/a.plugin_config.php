<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$deletePlugins = '.';
if ($isdelete)
{
	include $g['path_core'].'function/dir.func.php';
	foreach($pluginmembers as $plg)
	{
		if($isdelete == '1')
		{
			DirDelete($g['path_core'].'plugins/'.$plg);
		}
		if($isdelete == '2')
		{
			DirDelete($g['path_core'].'plugins/'.$plg.'/'.$ov[$plg]);
		}
	}
}
else {
	$_tmpdfile = $g['path_var'].'plugin.var.php';
	$fp = fopen($_tmpdfile,'w');
	fwrite($fp, "<?php\n");
	foreach ($ov as $_key_ => $_val_)
	{
		fwrite($fp, "\$d['ov']['".$_key_."'] = '".trim($_val_)."';\n");
	}
	fwrite($fp, "?>");
	fclose($fp);
	@chmod($_tmpdfile,0707);
}
getLink('reload','parent.','','');
?>