<!DOCTYPE html>
<html lang="<?php echo $lang['sys']['lang']?>">
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,target-densitydpi=medium-dpi">
<meta name="apple-mobile-web-app-capable" content="no">
<meta name="apple-mobile-web-app-status-bar-style" content="black">

<!-- Seo -->
<meta name="robots" content="ALL">
<meta name="generator" content="kimsQ-RB <?php echo $d['admin']['version']?>"> 
<meta name="title" content="<?php echo strip_tags($g['meta_tit'])?>"> 
<meta name="keywords" content="<?php echo strip_tags($g['meta_key'])?>"> 
<meta name="description" content="<?php echo strip_tags($g['meta_des'])?>">

<title><?php echo $g['browtitle']?></title>

<!-- Favicons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $g['url_layout']?>/assets/ico/apple-touch-icon-144-precomposed.png">
<link rel="shortcut icon" href="<?php echo $g['url_layout']?>/assets/ico/favicon.ico">

<!-- bootstrap css -->
<?php getImport('bootstrap','css/bootstrap.min',false,'css')?>

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- jQuery -->
<?php getImport('jquery','jquery-'.$d['ov']['jquery'].'.min',false,'js')?>

<!-- bootstrap js -->
<?php getImport('bootstrap','js/bootstrap.min',false,'js')?>

<!-- 시스템 폰트 -->
<?php getImport('font-awesome','css/font-awesome',false,'css')?> 
<?php getImport('font-kimsq','css/font-kimsq',false,'css')?> 
<link href="//fonts.googleapis.com/earlyaccess/nanumgothic.css" rel="stylesheet">

<!-- global css -->
<link type="text/css" rel="stylesheet" charset="utf-8" href="<?php echo $g['url_layout']?>/_includes/_global.css">

<!-- local css -->
<link type="text/css" rel="stylesheet" charset="utf-8" href="<?php echo $g['url_layout'].'/'.str_replace('.php','.css',basename($d['layout']['php']))?>">

<!-- 사이트 헤드 코드 -->
<?php echo $_HS['headercode']?>

<!-- 엔진코드:삭제하지마세요 -->
<?php include $g['path_core'].'engine/cssjs.engine.php'?>

</head>

<body id="rb-body" data-spy="scroll" data-target=".rb-nav-scrollspy">
