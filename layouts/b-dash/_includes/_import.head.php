<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,target-densitydpi=medium-dpi">
<meta name="apple-mobile-web-app-capable" content="no">
<meta name="apple-mobile-web-app-status-bar-style" content="black">

<!-- Seo -->
<meta name="robots" content="ALL">
<meta name="generator" content="kimsQ-Rb <?php echo $d['admin']['version']?>"> 
<meta name="title" content="<?php echo strip_tags($g['meta_tit'])?>"> 
<meta name="keywords" content="<?php echo strip_tags($g['meta_key'])?>"> 
<meta name="description" content="<?php echo strip_tags($g['meta_des'])?>">

<title><?php echo $g['browtitle']?></title>

<!-- Favicons -->
<link href="<?php echo $g['url_layout']?>/assets/ico/apple-touch-icon-144-precomposed.png" rel="apple-touch-icon-precomposed" sizes="144x144" >
<link href="<?php echo $g['url_layout']?>/assets/ico/favicon.ico" rel="shortcut icon">

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
<link href="<?php echo $g['url_layout']?>/_includes/_global.css" rel="stylesheet">

<!-- local css -->
<link href="<?php echo $g['url_layout']?>/assets/css/<?php echo str_replace('.php','.css',basename($d['layout']['php']))?>" rel="stylesheet">

<!-- Lazy Load XT :  http://ressio.github.io/lazy-load-xt -->
<?php getImport('lazy-load-xt','jquery.lazyloadxt.min',false,'js')?>
<?php getImport('lazy-load-xt','jquery.lazyloadxt.bg',false,'js')?>


<!-- 사이트 헤드 코드 -->
<?php echo $_HS['headercode']?>

<!-- 엔진코드:삭제하지마세요 -->
<?php include $g['path_core'].'engine/cssjs.engine.php' ?>
