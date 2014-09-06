<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if(!$layout) exit;

$codeFile = $g['path_layout'].$layout.'/'.$editfile;
$fp = fopen($codeFile,'w');
fwrite($fp,trim(stripslashes($code)));
fclose($fp);
@chmod($codeFile,0707);

getLink('reload','parent.','['.$codeFile.'] 파일이 수정되었습니다.','');

/*
if ($cplayout)
{
	if (!is_file($g['path_layout'].$cplayout.'/main.php'))
	{
		mkdir($g['path_layout'].$cplayout,0707);
		@chmod($g['path_layout'].$cplayout,0707);
		include_once $g['path_core'].'function/dir.func.php';
		DirCopy($g['path_layout'].$layout , $g['path_layout'].$cplayout);
		$layout = $cplayout;
	}
}

if ($type == 'layout')
{
	$nameFile = $g['path_layout'].$layout.'/name.txt';
	$fp = fopen($nameFile,'w');
	fwrite($fp,trim(stripslashes($name)));
	fclose($fp);
	@chmod($nameFile,0707);
}

if ($type != 'image')
{
	if ($type == 'layout')
	{
		$codeName = basename($sublayout,'.php') == $subname ? $sublayout : basename($subname,'.php').'.php';
	}
	else {
		$codeName = '_main.'.$type;
	}

	$codeFile = $g['path_layout'].$layout.'/'.$codeName;
	$fp = fopen($codeFile,'w');
	fwrite($fp,trim(stripslashes($code)));
	fclose($fp);
	@chmod($codeFile,0707);
}
*/
?>