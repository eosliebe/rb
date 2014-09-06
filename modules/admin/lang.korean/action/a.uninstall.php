<?php
if(!defined('__KIMS__')) exit;
checkAdmin(0);

// DB 삭제
//foreach ($table as $key => $val) db_query('drop table '.$val,$DB_CONNECT);

// FTP 삭제
if ($d['admin']['ftp_use']&&$d['admin']['ftp'])
{


}
// NOBODY 삭제
else {
	include $g['path_core'].'function/dir.func.php';
	//DirDelete('./');
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>안내메세지</title>
<script>
top.location.href = 'http://<?php echo $_SERVER['HTTP_HOST']?>/';
</script>
</head>
<body></body>
</html>
