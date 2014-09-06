<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if (!$layout) exit;

if ($imgfile)
{
	unlink($g['path_layout'].$layout.'/image/'.$imgfile);
	getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=main&layout='.$layout.'&type=image','parent.','','');
}


if($numSub)
{
	if ($numSub == 1)
	{
		include $g['path_core'].'function/dir.func.php';
		DirDelete($g['path_layout'].$layout);
		getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m,'parent.','','');
	}
	else
	{
		unlink($g['path_layout'].$layout.'/'.$sublayout);
		@unlink($g['path_layout'].$layout.'/widget/'.$sublayout);
		getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&layout='.$layout,'parent.','','');
	}
}
exit;
?>