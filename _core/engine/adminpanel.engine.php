<?php
if (!$my['admin']) exit;

$_MODULES = array();
$_MODULES_ALL = getDbArray($table['s_module'],'','*','gid','asc',0,1);
while($_R = db_fetch_array($_MODULES_ALL))
{
	$_MODULES['display'][] = $_R;
	$_MODULES['disp'.$_R['hidden']][] = $_R;
}

$_SITES = array();
$_SITES['list'] = array();
$_SITES_ALL = getDbArray($table['s_site'],'','*','gid','asc',0,1);
while($_R = db_fetch_array($_SITES_ALL))
{
	$_SITES['list'][] = $_R;
	$_SITES['count'.$_R['open']]++;
}
$d['layout']['dom'] = array();
$_nowlayuotdir = dirname($_SESSION['setLayoutKind']?$_HS['m_layout']:$_HS['layout']);
@include $g['path_layout'].$_nowlayuotdir.'/_var/_var.config.php';
@include $g['path_layout'].$_nowlayuotdir.'/_var/_var.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang['sys']['lang']?>">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $g['browtitle']?></title>

<!-- Bootstrap -->
<?php getImport('bootstrap','css/bootstrap.min',false,'css')?>
<?php getImport('bootstrap','css/bootstrap-theme.min',false,'css')?>

<!-- Favicon -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $g['s']?>/_core/images/ico/apple-touch-icon-144-precomposed.png">
<link rel="shortcut icon" href="<?php echo $g['s']?>/_core/images/ico/favicon.ico">

<!-- Font -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
<?php getImport('font-awesome','css/font-awesome',false,'css')?> 
<?php getImport('font-kimsq','css/font-kimsq',false,'css')?> 

<!-- Styles -->
<link href="<?php echo $g['s']?>/_core/engine/adminpanel/main.css" rel="stylesheet">
<link href="<?php echo $g['s']?>/_core/engine/adminpanel/theme/<?php echo $d['admin']['pannellink']?>" rel="stylesheet">

<?php include $g['path_core'].'engine/cssjs.engine.php' ?>
</head>

<body>

<div class="container-fluid rb-fixed-sidebar<?php if($_COOKIE['_tabShow1']):?> rb-minified-sidebar<?php endif?><?php if($_COOKIE['_tabShow2']):?> rb-hidden-system-admin<?php endif?><?php if($_COOKIE['_tabShow3']):?> rb-hidden-system-site<?php endif?>">

	<div class="rb-system-sidebar rb-system-admin rb-inverse" role="navigation">
		<div class="rb-icons">
			<span class="rb-icon-hide" title="숨기기" data-tooltip="tooltip"> 
				<i class="fa rb-icon"></i> 
			</span>	

			<span class="rb-icon-minify" title="" data-tooltip="tooltip"> 
				<i class="fa rb-icon"></i> 
			</span>
		</div>
		<div class="login-info">
			<span class="dropdown">
				<a href="#" class="rb-username" data-toggle="dropdown">
					<img src="<?php echo $g['s']?>/_var/avatar/<?php echo $my['avatar']?$my['avatar']:'0.gif'?>" alt="" class="img-circle"> 
					<span>
						<?php echo $my[$_HS['nametype']]?>  
					</span>
					 <span class="caret"></span>
				</a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
					<li><a href="#."><i class="fa fa-user"></i> 프로필관리</a></li>
					<li><a href="#."><i class="fa fa-clock-o"></i> 접속기록</a></li>
					<li class="divider"></li>
					<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;a=logout"><i class="fa fa-sign-out"></i> 로그아웃</a></li>
				</ul>
			</span>
		</div>
		<div class="tabs-below">
			<div class="rb-buttons rb-content-padded">
				<div class="btn-toolbar" role="toolbar">
					<div class="btn-group" title="만들기" data-tooltip="tooltip">
						<button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-plus fa-2x"></i>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-addsite">새 사이트</a></li>
							<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-addmenu">새 메뉴</a></li>
							<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-addpage">새 페이지</a></li>
						</ul>
					</div>
					<div class="btn-group" title="미디어셋" data-tooltip="tooltip">
						<button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-photo fa-2x"></i>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-photo">포토셋</a></li>
							<li><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-video">비디오셋</a></li>
						</ul>
					</div>

					<div class="btn-group">
						<button type="button" data-toggle="modal" data-target="#modal_window" class="btn btn-link rb-modal-widget hidden" title="위젯코드 추출" data-tooltip="tooltip">
							<i class="fa fa-code fa-2x"></i>
						</button>
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=dashboard" target="_ADMPNL_" class="btn btn-link" title="대시보드" data-tooltip="tooltip">
							<i class="fa fa-dashboard fa-2x"></i>
						</a>
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>" target="_ADMPNL_" class="btn btn-link" title="홈페이지" data-tooltip="tooltip">
							<i class="fa fa-home fa-2x"></i>
						</a>
					</div>
				</div>
			</div>

			<div class="rb-buttons rb-content-padded">
				<div class="btn-group">
					<a data-toggle="modal" data-target="#modal_window" class="btn btn-default rb-modal-addpackage" style="width:170px"><i class="fa fa-plus-circle fa-lg"></i> 패키지 설치</a>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu pull-right" role="menu">
						<li role="presentation" class="dropdown-header">확장요소 추가하기</li>
						<li><a href="#" data-toggle="modal" data-target="#modal-module-add">모듈</a></li>
						<li><a href="#" data-toggle="modal" data-target="#modal-layout-add">레이아웃</a></li>
						<li><a href="#" data-toggle="modal" data-target="#modal-widget-add">위젯</a></li>
						<li><a href="#" data-toggle="modal" data-target="#modal-switch-add">스위치</a></li>
						<li><a href="#" data-toggle="modal" data-target="#modal-switch-add">테마</a></li>
						<li><a href="#" data-toggle="modal" data-target="#modal-etc-add">기타자료</a></li>
					</ul>
				</div>
			</div>

			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane<?php if(!$_COOKIE['sideBottomTab']||$_COOKIE['sideBottomTab']=='quick'):?> active<?php endif?>" id="sidebar-quick">

					<nav>
						<ul class="list-group" id="sidebar-quick-tree">
							<?php $_i=0;$d['amenu']=array()?>
							<?php foreach($_MODULES['disp0'] as $_SM1):?>
							<?php if(strpos('_'.$my['adm_view'],'['.$_SM1['id'].']')) continue?>
							<?php $d['afile']=$g['path_module'].$_SM1['id'].'/lang.'.$_HS['lang'].'/admin/var/var.menu.php'?>
							<?php if(is_file($d['afile'])) include $d['afile']?>
							<li id="sidebar-quick-<?php echo $_SM1['id']?>" class="list-group-item panel">
								<a<?php if(!is_file($d['afile'])):?> href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=<?php echo $_SM1['id']?>" target="_ADMPNL_"<?php else:?> data-toggle="collapse" data-parent="#sidebar-quick-tree" href="#sidebar-quick-tree-<?php echo $_SM1['id']?>"<?php endif?> class="collapsed" onclick="_quickSelect('<?php echo $_SM1['id']?>');">
									<i class="fa fa-lg fa-fw kf <?php echo $_SM1['icon']?$_SM1['icon']:'fa-th-large'?>"><!--em>N</em--></i> 
									<span class="menu-item-parent"><?php echo $_SM1['name']//ucfirst($_SM1['id'])?></span><!--span class="badge pull-right inbox-badge">14</span-->
									<?php if(is_file($d['afile'])):?><b class="collapse-sign"><em class="fa rb-icon"></em></b><?php endif?>
								</a>

								<?php if(count($d['amenu'])):?>
								<ul id="sidebar-quick-tree-<?php echo $_SM1['id']?>" class="collapse">
								<?php foreach($d['amenu'] as $_k => $_v):?>
									<li id="sidebar-quick-tree-<?php echo $_SM1['id']?>-<?php echo $_k?>">
										<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&module=<?php echo $_SM1['id']?>&amp;front=<?php echo $_k?>" target="_ADMPNL_" onclick="_quickSelect1('<?php echo $_SM1['id']?>','<?php echo $_k?>');"><?php echo $_v?> <!--span class="badge pull-right inbox-badge bg-color-yellow">new</span--></a>
									</li>
								<?php endforeach?>
								</ul>
								<?php endif;$d['amenu']=array()?>
							</li>
							<?php endforeach?>
						</ul>
					</nav>

				</div>
				<div class="tab-pane<?php if($_COOKIE['sideBottomTab']=='sites'):?> active<?php endif?>" id="sidebar-sites">

					<nav>
						<ul class="list-group">
							<?php foreach($_SITES['list'] as $S):?>
							<li id="sidebar-sites-<?php echo $S['id']?>" class="list-group-item<?php if($r==$S['id']):?> active<?php endif?>">
								<a href="<?php echo $g['s']?>/?r=<?php echo $S['id']?>&amp;panel=Y" onclick="//_siteSelect('<?php echo $S['id']?>');">
									<i class="<?php echo $S['icon']?$S['icon']:'glyphicon glyphicon-home'?>"></i> 
									<span class="menu-item-parent"><?php echo $S['name']?></span>
									<?php if($S['open']==2):?><span class="badge pull-right inbox-badge"><i class="fa fa-lock"></i></span><?php endif?>
									<?php if($S['open']==3):?><span class="badge pull-right inbox-badge"><i class="fa fa-lock"></i></span><?php endif?>
								</a>
							</li>
							<?php endforeach?>
						</ul>	
					</nav>
					
				</div>
				<div class="tab-pane<?php if($_COOKIE['sideBottomTab']=='modules'):?> active<?php endif?>" id="sidebar-modules">

					<nav>
						<ul class="list-group">
							<?php $_i=0?>
							<?php foreach($_MODULES['display'] as $_SM1):?>
							<?php if(strpos('_'.$my['adm_view'],'['.$_SM1['id'].']')) continue?>
							<li id="sidebar-modules-<?php echo $_SM1['id']?>" class="list-group-item panel">
								<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=<?php echo $_SM1['id']?>" target="_ADMPNL_" class="collapsed" onclick="_moduleSelect('<?php echo $_SM1['id']?>');">
									<i class="fa fa-lg fa-fw kf <?php echo $_SM1['icon']?$_SM1['icon']:'fa-th-large'?>"><!--em>N</em--></i> 
									<span class="menu-item-parent"><?php echo $_SM1['name']?></span><!--span class="badge pull-right inbox-badge">14</span-->
								</a>
							</li>
							<?php endforeach?>
						</ul>
					</nav>

				</div>
			</div>


			<!-- Nav tabs -->
			<ul class="nav nav-tabs nav-justified" role="tablist">
				<li<?php if(!$_COOKIE['sideBottomTab']||$_COOKIE['sideBottomTab']=='quick'):?> class="active"<?php endif?>><a href="#sidebar-quick" role="tab" data-toggle="tab" title="퀵 패널" data-tooltip="tooltip" onclick="_cookieSetting('sideBottomTab','quick');"><i class="kf kf-bi-05 fa-2x"></i></a></li>
				<li<?php if($_COOKIE['sideBottomTab']=='sites'):?> class="active"<?php endif?>><a href="#sidebar-sites" role="tab" data-toggle="tab" title="사이트 패널" data-tooltip="tooltip" onclick="_cookieSetting('sideBottomTab','sites');"><i class="kf kf-domain fa-2x"></i></a></li>
				<li<?php if($_COOKIE['sideBottomTab']=='modules'):?> class="active"<?php endif?>><a href="#sidebar-modules" role="tab" data-toggle="tab" title="모듈 패널"><i class="kf kf-module fa-2x" onclick="_cookieSetting('sideBottomTab','modules');"></i></a></li>
			</ul>
		</div>
	</div>
	<div class="rb-system-main" role="main">
		<div class="rb-full-overlay">
			<div id="site-preview" class="rb-full-overlay-main">
				<div class="rb-table">
					<div class="rb-table-cell">
						<iframe id="_ADMPNL_" name="_ADMPNL_" src="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m.($pickmodule?'&amp;module='.$pickmodule:'')?>"></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="rb-system-sidebar rb-system-site rb-default" role="application">
		<div class="rb-opener"><i class="fa fa-caret-left fa-lg"></i></div>
		<div class="rb-panel-top">
			<span class="rb-icon-hide" title="숨기기" data-tooltip="tooltip"> 
				<i class="fa rb-icon"></i> 
			</span>
		</div>
		<div class="rb-content-padded">
			<ul class="nav nav-tabs" role="tablist">
				<li<?php if($_COOKIE['rightAdmTab']=='site'||!$_COOKIE['rightAdmTab']):?> class="active"<?php endif?>><a href="#site-settings" role="tab" data-toggle="tab" onclick="_cookieSetting('rightAdmTab','site');">Site</a></li>
				<li<?php if($_COOKIE['rightAdmTab']=='layout'):?> class="active"<?php endif?>><a href="#layout-settings" role="tab" data-toggle="tab" onclick="_cookieSetting('rightAdmTab','layout');">Layout</a></li>
				<li<?php if($_COOKIE['rightAdmTab']=='emulator'):?> class="active"<?php endif?>><a href="#device-emulator" role="tab" data-toggle="tab" onclick="_cookieSetting('rightAdmTab','emulator');">Emulator</a></li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content" style="padding-top: 15px">
				<div class="tab-pane<?php if($_COOKIE['rightAdmTab']=='site'||!$_COOKIE['rightAdmTab']):?> active<?php endif?><?php if(!$_HS['uid']):?> hidden<?php endif?>" id="site-settings">
					<form action="<?php echo $g['s']?>/" method="post" target="_ACTION_" onsubmit="return _siteInfoSaveCheck(this);">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="site">
					<input type="hidden" name="a" value="regissitepanel" />
					<input type="hidden" name="site_uid" value="<?php echo $_HS['uid']?>">
					<input type="hidden" name="layout" value="">
					<input type="hidden" name="m_layout" value="">

					<div class="panel-group rb-scrollbar" id="site-settings-panels">
						<div class="panel panel-primary" id="site-settings-01">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#site-settings-panels" href="#site-settings-01-body">
										<i></i>기본정보
									</a>
								</h4>
							</div>
							<div id="site-settings-01-body" class="panel-collapse collapse in">
								<div class="panel-body">
									<div class="form-group">
										<label>사이트 라벨</label>
										<input type="text" class="form-control" name="name" value="<?php echo $_HS['name']?>">
									</div>
									
									<div class="form-group">
										<label>타이틀 구성</label>
										<input type="text" class="form-control" name="title" value="<?php echo $_HS['title']?>">
										<span class="help-block"><small>입력된 내용은 브라우저의 타이틀로 사용됩니다.<br>치환코드는 매뉴얼을 참고하세요.</small></span>
									</div>

									<div class="form-group">
										<label>사이트 코드</label>
										<input type="text" class="form-control" name="id" value="<?php echo $_HS['id']?>">
									</div>
									<button type="submit" class="btn btn-primary btn-block">저장하기</button>
								</div>
							</div>
						</div>

						<div class="panel panel-default" id="site-settings-02">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#site-settings-panels" href="#site-settings-02-body">
										<i></i>레이아웃
									</a>
								</h4>
							</div>
							<div id="site-settings-02-body" class="panel-collapse collapse">
								<div class="panel-body">
									<div class="form-group">
										<label>기본</label>
										<div id="rb-layout-select">
											<select class="form-control" name="layout_1" required onchange="getSubLayout(this,'rb-layout-select2','layout_1_sub','');">
												<?php $_layoutExp1=explode('/',$_HS['layout'])?>
												<?php $dirs = opendir($g['path_layout'])?>
												<?php $_i=0;while(false !== ($tpl = readdir($dirs))):?>
												<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
												<?php if(!$_i&&!$_HS['layout']) $_layoutExp1[0] = $tpl?>
												<option value="<?php echo $tpl?>"<?php if($_layoutExp1[0]==$tpl):?> selected<?php endif?>><?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo $tpl?>)</option>

												<?php $_i++;endwhile?>
												<?php closedir($dirs)?>
											</select>
										</div>
										<div id="rb-layout-select2" style="margin-top:5px;">
											<select class="form-control" name="layout_1_sub"<?php if(!$_layoutExp1[0]):?> disabled<?php endif?>>
												<?php $dirs1 = opendir($g['path_layout'].$_layoutExp1[0])?>
												<?php while(false !== ($tpl1 = readdir($dirs1))):?>
												<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
												<option value="<?php echo $tpl1?>"<?php if($_layoutExp1[1]==$tpl1):?> selected<?php endif?>><?php echo str_replace('.php','',$tpl1)?></option>
												<?php endwhile?>
												<?php closedir($dirs1)?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label>모바일 전용</label>
										<div id="rb-mlayout-select">
											<select class="form-control" name="m_layout_1" required onchange="getSubLayout(this,'rb-mlayout-select2','m_layout_1_sub','');">
												<option value="0">사용안함</option>
												<?php $_layoutExp2=explode('/',$_HS['m_layout'])?>
												<?php $dirs = opendir($g['path_layout'])?>
												<?php while(false !== ($tpl = readdir($dirs))):?>
												<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
												<option value="<?php echo $tpl?>"<?php if($_layoutExp2[0]==$tpl):?> selected<?php endif?>><?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo $tpl?>)</option>
												<?php endwhile?>
												<?php closedir($dirs)?>
											</select>
										</div>
										<div id="rb-mlayout-select2" style="margin-top:5px;">
											<select class="form-control" name="m_layout_1_sub"<?php if(!$_HS['m_layout']):?> disabled<?php endif?>>
												<?php if(!$_HS['m_layout']):?><option>서브 레이아웃</option><?php endif?>
												<?php $dirs1 = opendir($g['path_layout'].$_layoutExp2[0])?>
												<?php while(false !== ($tpl1 = readdir($dirs1))):?>
												<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
												<option value="<?php echo $tpl1?>"<?php if($_layoutExp2[1]==$tpl1):?> selected<?php endif?>><?php echo str_replace('.php','',$tpl1)?></option>
												<?php endwhile?>
												<?php closedir($dirs1)?>
											</select>
										</div>
									</div>
									<button type="submit" class="btn btn-primary btn-block">저장하기</button>
								</div>
							</div>
						</div>

						<div class="panel panel-default" id="site-settings-03">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#site-settings-panels" href="#site-settings-03-body">
										<i></i>메인페이지 
									</a>
								</h4>
							</div>
							<div id="site-settings-03-body" class="panel-collapse collapse">
								<div class="panel-body">
									<div class="form-group">
										<label>기본</label>
										<select name="startpage" class="form-control">
										<option>레이아웃용 메인페이지</option>
										<?php $PAGES1 = getDbArray($table['s_page'],'ismain=1','*','uid','asc',0,1)?>
										<?php while($S = db_fetch_array($PAGES1)):?>
										<option value="<?php echo $S['uid']?>"<?php if($_HS['startpage']==$S['uid']):?> selected<?php endif?>><?php echo $S['name']?>(<?php echo $S['id']?>)</option>
										<?php endwhile?>
										</select>
									</div>
									<div class="form-group">
										<label>모바일 전용</label>
										<select name="m_startpage" class="form-control">
										<option>레이아웃용 메인페이지</option>
										<?php $PAGES2 = getDbArray($table['s_page'],'mobile=1','*','uid','asc',0,1)?>
										<?php while($S = db_fetch_array($PAGES2)):?>
										<option value="<?php echo $S['uid']?>"<?php if($_HS['m_startpage']==$S['uid']):?> selected<?php endif?>><?php echo $S['name']?>(<?php echo $S['id']?>)</option>
										<?php endwhile?>
										</select>
									</div>
									<button type="submit" class="btn btn-primary btn-block">저장하기</button>
								</div>
							</div>
						</div>

						<div class="panel panel-default" id="site-settings-04">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#site-settings-panels" href="#site-settings-04-body">
										<i></i>고급설정 
									</a>
								</h4>
							</div>
							<div id="site-settings-04-body" class="panel-collapse collapse">
								<div class="panel-body">
									<div class="form-group">
										<label>도메인</label>
										<ul>
											<?php $DOMAINS = getDbArray($table['s_domain'],'site='.$_HS['uid'],'*','gid','asc',0,1)?>
											<?php $DOMAINN = db_num_rows($DOMAINS)?>
											<?php if($DOMAINN):?>
											<?php while($D=db_fetch_array($DOMAINS)):?>
											<li><a href="http://<?php echo $D['name']?>" target="_blank"><?php echo $D['name']?></a></li>
											<?php endwhile?>
											<?php else:?>
											<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=domain&amp;selsite=<?php echo $_HS['uid']?>&amp;type=makedomain" target="_ADMPNL_">연결된 도메인이 없습니다.</a></li>
											<?php endif?>
										</ul>
									</div>	
									<div class="form-group">
										<label>서비스 상태</label>
										<select name="open" class="form-control">
										<option value="1"<?php if($_HS['open']=='1'):?> selected="selected"<?php endif?>>정상서비스</option>
										<option value="2"<?php if($_HS['open']=='2'):?> selected="selected"<?php endif?>>관리자오픈</option>
										<option value="3"<?php if($_HS['open']=='3'):?> selected="selected"<?php endif?>>정지</option>
										</select>
									</div>		
									<button type="submit" class="btn btn-primary btn-block">저장하기</button>
								</div>
							</div>
						</div>
					</div>
					</form>

					<div class="well rb-tab-pane-bottom">
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=site" target="_ADMPNL_" class="btn btn-default btn-block">자세히</a>
					</div>
				</div>
				<div class="tab-pane<?php if($_COOKIE['rightAdmTab']=='layout'):?> active<?php endif?><?php if(!$_HS['uid']):?> hidden<?php endif?>" id="layout-settings">
					<form action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" target="_ACTION_" onsubmit="return _layoutInfoSaveCheck(this);">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="site">
					<input type="hidden" name="a" value="regislayoutpanel" />
					<input type="hidden" name="site_uid" value="<?php echo $_HS['uid']?>">
					<input type="hidden" name="layout" value="<?php echo $_nowlayuotdir?>">

					<div class="panel-group rb-scrollbar" id="layout-settings-panels">
						<?php $_i=1;foreach($d['layout']['dom'] as $_key => $_val):$__i=sprintf('%02d',$_i)?>
						<div class="panel panel-<?php echo $_i==1?'primary':'default'?>" id="layout-settings-<?php echo $__i?>">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#layout-settings-panels" href="#layout-settings-<?php echo $__i?>-body">
										<i></i><?php echo $_val[0]?>
									</a>
								</h4>
							</div>
							<div id="layout-settings-<?php echo $__i?>-body" class="panel-collapse collapse<?php echo $_i==1?' in':''?>">
								<div class="panel-body">
									<p><?php echo $_val[1]?></p>
									
									<?php if(count($_val[2])):?>
									<?php foreach($_val[2] as $_v):?>
									<div class="form-group">
										<?php if($_v[1]!='hidden'):?>
										<label><?php echo $_v[2]?></label>
										<?php endif?>

										<?php if($_v[1]=='hidden'):?>
										<input type="hidden" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" value="<?php echo $d['layout'][$_key.'_'.$_v[0]]?>">
										<?php endif?>
										
										<?php if($_v[1]=='input'):?>
										<input type="text" class="form-control" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" value="<?php echo $d['layout'][$_key.'_'.$_v[0]]?>">
										<?php endif?>

										<?php if($_v[1]=='file'):?>
										<input type="file" class="form-control" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" value="">
										<?php endif?>
										
										<?php if($_v[1]=='textarea'):?>
										<textarea type="text" rows="<?php echo $_v[3]?>" class="form-control" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>"><?php echo $d['layout'][$_key.'_'.$_v[0]]?></textarea>
										<?php endif?>

										<?php if($_v[1]=='select'):?>
										<select name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" class="form-control">
											<?php $_sk=explode(',',$_v[3])?>
											<?php foreach($_sk as $_sa):?>
											<option value="<?php echo $_sa?>"<?php if($d['layout'][$_key.'_'.$_v[0]] == $_sa):?> selected<?php endif?>><?php echo $_sa?></option>
											<?php endforeach?>
										</select>
										<?php endif?>

										<?php if($_v[1]=='radio'):?>
										<?php $_sk=explode(',',$_v[3])?>
										<?php foreach($_sk as $_sa):?>
										<div><input type="radio" class="" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" value="<?php echo $_sa?>"<?php if($d['layout'][$_key.'_'.$_v[0]] == $_sa):?> checked<?php endif?>> <?php echo $_sa?></div>
										<?php endforeach?>
										<?php endif?>

										<?php if($_v[1]=='checkbox'):?>
										<?php $_sk=explode(',',$_v[3])?>
										<?php foreach($_sk as $_sa):?>
										<div><input type="checkbox" class="" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>_chk[]" value="<?php echo $_sa?>"<?php if(strstr($d['layout'][$_key.'_'.$_v[0]],$_sa)):?> checked<?php endif?>> <?php echo $_sa?></div>
										<?php endforeach?>
										<?php endif?>

									</div>
									<?php endforeach?>

									<button type="submit" class="btn btn-primary btn-block">저장하기</button>
									<?php endif?>

								</div>
							</div>
						</div>
						<?php $_i++;endforeach?>
						<?php if($_i==1):?>
						<div class="panel panel-primary" id="layout-settings-01">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#layout-settings-panels" href="#layout-settings-01-body">
										<i></i>레이아웃 설정 안내
									</a>
								</h4>
							</div>
							<div id="layout-settings-01-body" class="panel-collapse collapse in">
								<div class="panel-body">
									<p>현재 사이트(<?php echo $_HS['name']?>)에 <strong><small><?php echo $_SESSION['setLayoutKind']?'모바일 전용':'기본'?>레이아웃</strong></small>으로 지정된 <strong><small><?php echo getFolderName($g['path_layout'].$_nowlayuotdir)?> (<?php echo $_nowlayuotdir?>)</small></strong> 레이아웃은 별도의 설정을 지원하지 않습니다.</p>
								</div>
							</div>
						</div>
						<div class="panel panel-default" id="layout-settings-02">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#layout-settings-panels" href="#layout-settings-02-body">
										<i></i>레이아웃 분기설정
									</a>
								</h4>
							</div>
							<div id="layout-settings-02-body" class="panel-collapse collapse">
								<div class="panel-body">
									<p>현재 사이트에 기본 레이아웃과 모바일 전용레이아웃을 지정했을 경우 두 레이아웃을 구분하여 설정할 수 있습니다.</p>
								</div>
							</div>
						</div>
						<?php endif?>
					</div>

					<div class="well rb-tab-pane-bottom">
						<div class="form-group">
							<label class="sr-only"><small>레이아웃 선택</small></label>
							<select class="form-control" onchange="layoutChange(this);">
								<option value="">기본 레이아웃 설정</option>
								<?php if($_HS['m_layout']):?><option value="1"<?php if($_SESSION['setLayoutKind']):?> selected<?php endif?>>모바일 전용 레이아웃 설정</option><?php endif?>
							</select>
						</div>
					</div>
					</form>
				</div>

				<div class="tab-pane<?php if($_COOKIE['rightAdmTab']=='emulator'):?> active<?php endif?>" id="device-emulator">
					<div class="btn-group rb-device-buttons clearfix" data-toggle="buttons">
						<label class="btn btn-default rb-btn-desktop<?php if($_COOKIE['rightemulTab']=='desktop'||!$_COOKIE['rightemulTab']):?> active<?php endif?>" title="Desktop" data-toggle="tooltip">
							<input type="radio" name="options" id="rightemulTab_desktop" checked> <i class="fa fa-desktop fa-3x"></i><br>Desktop
						</label>
						<label class="btn btn-default rb-btn-tablet<?php if($_COOKIE['rightemulTab']=='tablet'):?> active<?php endif?>" title="Tablet" data-toggle="tooltip">
							<input type="radio" name="options" id="rightemulTab_tablet"> <i class="fa fa-tablet fa-3x"></i><br>Tablet
						</label>
						<label class="btn btn-default rb-btn-mobile<?php if($_COOKIE['rightemulTab']=='mobile'):?> active<?php endif?>" title="Mobile" data-toggle="tooltip">
							<input type="radio" name="options" id="rightemulTab_mobile"> <i class="fa fa-mobile fa-3x"></i><br>phone
						</label>
					</div>

					<fieldset id="deviceshape"<?php if(!$_COOKIE['rightemulTab'] || $_COOKIE['rightemulTab'] == 'desktop'):?> disabled<?php endif?>>
						<div class="btn-group clearfix btn-group-justified" data-toggle="buttons">
							<label id="deviceshape_1" class="btn btn-default<?php if(!$_COOKIE['rightemulDir'] || $_COOKIE['rightemulDir'] == '1'):?> active<?php endif?>" title="Potrait" onclick="_deviceshape(1);">
								<input type="radio" name="deviceshape"><i class="fa fa-rotate-left fa-lg"></i> 세로방향
							</label>
							<label id="deviceshape_2" class="btn btn-default<?php if($_COOKIE['rightemulDir'] == '2'):?> active<?php endif?>" title="Landscape" onclick="_deviceshape(2);">
								<input type="radio" name="deviceshape"> <i class="fa fa-rotate-right fa-lg"></i> 가로방향
							</label>
						</div>
					</fieldset>

					<div class="rb-scrollbar" id="emuldevices">
					    <table class="table table-striped table-hover">
					        <thead>
					            <tr>
					                <th class="rb-name">기기명</th>
					                <th class="rb-brand">제조사</th>
					                <th class="rb-viewport">화면크기</th>
					            </tr>
					        </thead>

					        <tbody>
								<?php $d['magent']= file($g['path_var'].'mobile.agent.txt')?>
								<?php $_i=0;foreach($d['magent'] as $_line):if($_i):if(!trim($_line))continue;$_val=explode(',',trim($_line));$_scSize=explode('*',$_val[2])?>
								<?php if(!$_firstPhone[0]&&$_val[3]=='phone'){$_firstPhone[0]=$_i;$_firstPhone[1]=$_scSize[0];$_firstPhone[2]=$_scSize[1];}?>
								<?php if(!$_firstTablet[0]&&$_val[3]=='tablet'){$_firstTablet[0]=$_i;$_firstTablet[1]=$_scSize[1];$_firstTablet[2]=$_scSize[0];}?>
					            <tr id="emdevice_<?php echo $_i?>" onclick="_emuldevice(this,'<?php echo $_val[2]?>','<?php echo $_val[3]?>');">
					                <td class="rb-name"><?php echo $_val[0]?></td>
					                <td class="rb-brand"><?php echo $_val[1]?></td>
					                <td class="rb-viewport"><?php echo $_scSize[0]?><var>x</var><?php echo $_scSize[1]?></td>
					            </tr>
								<?php endif;$_i++;endforeach?>
					        </tbody>
					    </table>
					</div>

					<div class="well rb-tab-pane-bottom rb-form">

						<ul class="list-group">
							<li class="list-group-item">
								<fieldset>
									<div class="checkbox">
										<label>
											<input type="checkbox"<?php if($g['mobile']):?> checked<?php endif?> onclick="viewbyMobileDevice(this);"> <i></i><small>모바일 디바이스 접속</small>
											<span class="fa fa-question-circle" style="position:relative;" data-popover="popover" title="[도움말] 모바일 디바이스 접속이란?" data-content="<small>모바일 기기로 접속한 것으로 가정하여 사이트를 보여줍니다. 사이트 설정에서 모바일 분기설정을 적용하면 모바일 전용 레이아웃, 시작페이지, 메뉴가 적용 됩니다.</small>"></span>
										</label>
									</div>
								</fieldset>
							</li>
							<li class="list-group-item">
								<div class="input-group input-group-sm">
									<input id="outlink_url" type="text" class="form-control" placeholder="URL 입력" onkeypress="getOuturl(0);">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button" data-tooltip="tooltip" title="불러오기" onclick="getOuturl(1);">Go!</button>
									</span>
								</div>
							</li>
							<li class="list-group-item">
								<small><i class="fa fa-info-circle fa-4x pull-left"></i>기기별 기본 브라우저의 실제크기 화면을 제공합니다. 기기 또는 운영체제별 특성은 실제 기기를 통해 확인하세요.</small>
							</li>
						</ul>

					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<nav class="navbar navbar-default navbar-fixed-bottom visible-xs" role="navigation">
	<!-- 본영역은 미 작업중 입니다. -->
	<div class="container">
		<div class="navbar-header">
			
			<button type="button" class="navbar-toggle rb-icon-hide" data-toggle="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			<a class="navbar-brand" href="#">kimsQ</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-3">
			<button type="button" class="btn btn-default navbar-btn">Sign in</button>
		</div>
	</div>
</nav>

<?php getImport('jquery','jquery-'.$d['ov']['jquery'].'.min',false,'js')?>
<?php getImport('bootstrap','js/bootstrap.min',false,'js')?>

<script>
$(document).ready(function(){

	$(".rb-system-admin .rb-icon-minify").click(function(){
		$(".container-fluid").toggleClass("rb-minified-sidebar");
		if ($(".container-fluid").hasClass("rb-minified-sidebar")) {
			$(".rb-system-sidebar .rb-icon-minify").attr("data-original-title", "펼치기");
		} else {
			$(".rb-system-sidebar .rb-icon-minify").attr("data-original-title", "접기");	
		}
		if(getCookie('_tabShow1')=='') setCookie('_tabShow1',1,1);
		else setCookie('_tabShow1','',1);
	});

	$(".rb-system-admin .rb-icon-hide").click(function(){
		$(".container-fluid").toggleClass("rb-hidden-system-admin");
		if ($(".container-fluid").hasClass("rb-hidden-system-admin")) {
			$(".rb-system-sidebar .rb-icon-hide").attr("data-original-title", "고정하기");
		} else {
			$(".rb-system-sidebar .rb-icon-hide").attr("data-original-title", "숨기기");	
		}
		if(getCookie('_tabShow2')=='') setCookie('_tabShow2',1,1);
		else setCookie('_tabShow2','',1);
	});

	$(".rb-system-site .rb-icon-hide").click(function(){
		$(".container-fluid").toggleClass("rb-hidden-system-site");
		
		if(getCookie('_tabShow3')=='') setCookie('_tabShow3',1,1);
		else setCookie('_tabShow3','',1);
	});

	// tooltip
	$('body').tooltip({
		selector: '[data-tooltip=tooltip]',
		placement : 'auto',
		html: 'true',
		container: 'body'
	});

	// popover
	$('body').popover({
		selector: '[data-popover=popover]',
		placement : 'auto',
		html: 'true',
		trigger: 'hover',
		container: 'body',
	});

	// mac OS hack 적용
	if(navigator.userAgent.indexOf("Mac") > 0) {
		$("body").addClass("mac-os");
	}

	$(".rb-btn-desktop").click(function(){
		getId('_ADMPNL_').style.display = '';
		getId('_ADMPNL_').style.width = '';
		getId('_ADMPNL_').style.height = '';
		setCookie('rightemulTab','desktop',1);
		$("#emuldevices tr").removeClass("active");
		$(".rb-full-overlay-main").removeClass( "mobile tablet" ).addClass( "desktop" );
		getId('deviceshape').disabled = true;
		_nowSelectedDevice = '';
	});

	$(".rb-btn-tablet").click(function(){
		setCookie('rightemulTab','tablet',1);
		setCookie('rightemulDir',2,1);
		$("#emuldevices tr").removeClass("active");
		$("#emdevice_<?php echo $_firstTablet[0]?>").addClass("active");
		$("#deviceshape_1").removeClass("active");
		$("#deviceshape_2").addClass("active");
		$(".rb-full-overlay-main").removeClass( "desktop mobile" ).addClass( "tablet" );
		getId('_ADMPNL_').style.display = 'block';
		getId('_ADMPNL_').style.width = '<?php echo $_firstTablet[2]?>px';
		getId('_ADMPNL_').style.height = '<?php echo $_firstTablet[1]?>px';
		getId('deviceshape').disabled = false;
		_nowSelectedDevice = 'emdevice_<?php echo $_firstTablet[0]?>';
	});

	$(".rb-btn-mobile").click(function(){
		setCookie('rightemulTab','mobile',1);
		setCookie('rightemulDir',1,1);
		$("#emuldevices tr").removeClass("active");
		$("#emdevice_<?php echo $_firstPhone[0]?>").addClass("active");
		$("#deviceshape_1").addClass("active");
		$("#deviceshape_2").removeClass("active");
		$(".rb-full-overlay-main").removeClass( "desktop tablet" ).addClass( "mobile" );
		getId('_ADMPNL_').style.display = 'block';
		getId('_ADMPNL_').style.width = '<?php echo $_firstPhone[1]?>px';
		getId('_ADMPNL_').style.height = '<?php echo $_firstPhone[2]?>px';
		getId('deviceshape').disabled = false;
		_nowSelectedDevice = 'emdevice_<?php echo $_firstPhone[0]?>';
	});


	<?php if($_COOKIE['rightemulTab'] && $_COOKIE['rightemulTab'] != 'desktop'):?>
	$(".rb-btn-<?php echo $_COOKIE['rightemulTab']?>").click();
	<?php else:?>
	getId('deviceshape').disabled = true;
	<?php endif?>


	//사이트
	$('.rb-modal-addsite').on('click',function() {
		frames._ADMPNL_.location.href = rooturl + '/?r=' + raccount + '&m=admin&module=site&type=makesite';
	});
	//메뉴
	$('.rb-modal-addmenu').on('click',function() {
		frames._ADMPNL_.location.href = rooturl + '/?r=' + raccount + '&m=admin&module=site&front=menu';
	});
	//페이지
	$('.rb-modal-addpage').on('click',function() {
		frames._ADMPNL_.location.href = rooturl + '/?r=' + raccount + '&m=admin&module=site&front=page';
	});
});
var _nowSelectedDevice = '';
function _emuldevice(obj,size,type)
{
	var s = size.split('*');
	type = type == 'phone' ? 'mobile' : type;
	setCookie('rightemulTab',type,1);
	$(".rb-device-buttons label").removeClass( "active" );
	$(".rb-btn-"+type).addClass( "active" );
	$(".rb-full-overlay-main").removeClass( "desktop" ).removeClass( "tablet" ).removeClass( "mobile" ).addClass( type );
	$("#emuldevices tr").removeClass("active");
	$("#"+obj.id).addClass("active");
	getId('deviceshape').disabled = false;

	getId('_ADMPNL_').style.display = 'block';
	if(getCookie('rightemulDir') == '2')
	{
		if (type == 'mobile')
		{
			getId('_ADMPNL_').style.width = s[1]+'px';
			getId('_ADMPNL_').style.height = s[0]+'px';
		}
		else {
			getId('_ADMPNL_').style.width = s[0]+'px';
			getId('_ADMPNL_').style.height = s[1]+'px';
		}
	}
	else {
		if (type == 'mobile')
		{
			getId('_ADMPNL_').style.width = s[0]+'px';
			getId('_ADMPNL_').style.height = s[1]+'px';
		}
		else {
			getId('_ADMPNL_').style.width = s[1]+'px';
			getId('_ADMPNL_').style.height = s[0]+'px';
		}
	}
	_nowSelectedDevice = obj.id;
}
function _deviceshape(n)
{
	setCookie('rightemulDir',n,1);
	$("#"+_nowSelectedDevice).click();
}
function _quickSelect(id)
{	
	$("#sidebar-quick .list-group-item").removeClass("active");
	$("#sidebar-quick-"+id).addClass("active");
}
function _quickSelect1(id,_k)
{	
	$("#sidebar-quick-tree-"+id+" li").removeClass("active");
	$("#sidebar-quick-tree-"+id+"-"+_k).addClass("active");
}
function _siteSelect(id)
{	
	$("#sidebar-sites .list-group-item").removeClass("active");
	$("#sidebar-sites-"+id).addClass("active");
}
function _moduleSelect(id)
{	
	$("#sidebar-modules .list-group-item").removeClass("active");
	$("#sidebar-modules-"+id).addClass("active");
}
function _cookieSetting(name,tab)
{
	setCookie(name,tab,1);
}
function _siteInfoSaveCheck(f)
{
	f.layout.value = f.layout_1.value + '/' + f.layout_1_sub.value;
	if(f.m_layout_1.value != '0') f.m_layout.value = f.m_layout_1.value + '/' + f.m_layout_1_sub.value;
	else f.m_layout.value = '';

	return confirm('정말로 변경하시겠습니까?    ');
}
function _layoutInfoSaveCheck(f)
{
	return confirm('정말로 변경하시겠습니까?    ');
}
function getOuturl(n)
{
	if (n == 0)
	{
		if(event.keyCode != 13) return false;
	}
	if (getId('outlink_url').value != '')
	{
		var url = 'http://' + getId('outlink_url').value.replace('http://');
		frames._ADMPNL_.location.href = url;
	}
}
function viewbyMobileDevice(obj)
{
	frames._ACTION_.location.href = rooturl + '/?a=sessionsetting&target=parent.frames._ADMPNL_.&name=pcmode&value=' + (obj.checked ? 'E' : '');
}
function layoutChange(obj)
{
	frames._ACTION_.location.href = rooturl + '/?a=sessionsetting&target=parent.&name=setLayoutKind&value=' + obj.value;
}

// collapse UI 개선 권기택 추가 , 코드 최적화 필요성 

$('#site-settings-01-body').on('show.bs.collapse', function () {
  $("#site-settings-01").addClass("panel-primary").removeClass("panel-default");
});

$('#site-settings-01-body').on('hide.bs.collapse', function () {
  $("#site-settings-01").addClass("panel-default").removeClass("panel-primary");
});

$('#site-settings-02-body').on('show.bs.collapse', function () {
  $("#site-settings-02").addClass("panel-primary").removeClass("panel-default");
});

$('#site-settings-02-body').on('hide.bs.collapse', function () {
  $("#site-settings-02").addClass("panel-default").removeClass("panel-primary");
});


$('#site-settings-03-body').on('show.bs.collapse', function () {
  $("#site-settings-03").addClass("panel-primary").removeClass("panel-default");
});

$('#site-settings-03-body').on('hide.bs.collapse', function () {
  $("#site-settings-03").addClass("panel-default").removeClass("panel-primary");
});

$('#site-settings-04-body').on('show.bs.collapse', function () {
  $("#site-settings-04").addClass("panel-primary").removeClass("panel-default");
});

$('#site-settings-04-body').on('hide.bs.collapse', function () {
  $("#site-settings-04").addClass("panel-default").removeClass("panel-primary");
});

$('#layout-settings-01-body').on('show.bs.collapse', function () {
  $("#layout-settings-01").addClass("panel-primary").removeClass("panel-default");
});

$('#layout-settings-01-body').on('hide.bs.collapse', function () {
  $("#layout-settings-01").addClass("panel-default").removeClass("panel-primary");
});

$('#layout-settings-02-body').on('show.bs.collapse', function () {
  $("#layout-settings-02").addClass("panel-primary").removeClass("panel-default");
});

$('#layout-settings-02-body').on('hide.bs.collapse', function () {
  $("#layout-settings-02").addClass("panel-default").removeClass("panel-primary");
});

$('#layout-settings-03-body').on('show.bs.collapse', function () {
  $("#layout-settings-03").addClass("panel-primary").removeClass("panel-default");
});

$('#layout-settings-03-body').on('hide.bs.collapse', function () {
  $("#layout-settings-03").addClass("panel-default").removeClass("panel-primary");
});

$('#layout-settings-04-body').on('show.bs.collapse', function () {
  $("#layout-settings-04").addClass("panel-primary").removeClass("panel-default");
});

$('#layout-settings-04-body').on('hide.bs.collapse', function () {
  $("#layout-settings-04").addClass("panel-default").removeClass("panel-primary");
});

$('#layout-settings-05-body').on('show.bs.collapse', function () {
  $("#layout-settings-05").addClass("panel-primary").removeClass("panel-default");
});

$('#layout-settings-05-body').on('hide.bs.collapse', function () {
  $("#layout-settings-05").addClass("panel-default").removeClass("panel-primary");
});


$('#layout-settings-06-body').on('show.bs.collapse', function () {
  $("#layout-settings-06").addClass("panel-primary").removeClass("panel-default");
});

$('#layout-settings-06-body').on('hide.bs.collapse', function () {
  $("#layout-settings-06").addClass("panel-default").removeClass("panel-primary");
});

$('#layout-settings-07-body').on('show.bs.collapse', function () {
  $("#layout-settings-07").addClass("panel-primary").removeClass("panel-default");
});

$('#layout-settings-07-body').on('hide.bs.collapse', function () {
  $("#layout-settings-07").addClass("panel-default").removeClass("panel-primary");
});

</script>

<div id="_box_layer_"></div>
<div id="_action_layer_"></div>
<div id="_hidden_layer_"></div>
<div id="_overLayer_"></div>
<iframe id="_ACTION_" name="_ACTION_" class="hidden"></iframe>
</body>
</html>
