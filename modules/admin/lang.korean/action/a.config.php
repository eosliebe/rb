<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$fdset = array();
$fdset['config'] = array('version','themepc','pannellink','cache_flag','smtp_use','smtp_host','smtp_port','smtp_auth','smtp_user','smtp_pass',
						 'ftp_use','ftp_type','ftp_host','ftp_port','ftp_pasv','ftp_user','ftp_pass','ftp_rb','email','smtp','ftp');
$fdset['ssl'] = array('http_port','ssl_type','ssl_port','ssl_module','ssl_menu','ssl_page');
$fdset['security'] = array('secu_tags','secu_domain','secu_param');

foreach ($fdset[$act] as $val)
{
	$d['admin'][$val] = str_replace("\n",'<br>',trim(${$val}));
}

$_tmpdfile = $g['dir_module'].'var/var.system.php';
$fp = fopen($_tmpdfile,'w');
fwrite($fp, "<?php\n");
foreach ($d['admin'] as $key => $val)
{
	fwrite($fp, "\$d['admin']['".$key."'] = \"".addslashes(stripslashes($val))."\";\n");
}
fwrite($fp, "?>");
fclose($fp);
@chmod($_tmpdfile,0707);

if($autosave):
?>
<script>
parent.document.procForm.target = '';
parent.document.procForm.autosave.value = '';
</script>
<?php
exit;
endif;
getLink('reload','parent.','','');
?>