<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$vfile = $g['dir_module'].'var/users/'.$my['id'].'.widget.php';
$fp = fopen($vfile,'w');

fwrite($fp, "<?php\r\n");
fwrite($fp, "\$d['page']['mainheight'] = \"".$mainheight."\";\r\n");
fwrite($fp, stripslashes($escapevar)."\r\n");
fwrite($fp, "?>");

fclose($fp);
@chmod($vfile,0707);

getLink('reload','parent.','','');
?>