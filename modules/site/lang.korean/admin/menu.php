<?php
$SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p);
$SITEN = db_num_rows($SITES);
include $g['path_core'].'function/menu.func.php';
$ISCAT = getDbRows($table['s_menu'],'site='.$_HS['uid']);

if($cat)
{
	$CINFO = getUidData($table['s_menu'],$cat);
	$_SEO = getDbData($table['s_seo'],'rel=1 and parent='.$CINFO['uid'],'*');
	$ctarr = getMenuCodeToPath($table['s_menu'],$cat,0);
	$ctnum = count($ctarr);
	for ($i = 0; $i < $ctnum; $i++) $CXA[] = $ctarr[$i]['uid'];
}

$catcode = '';
$is_fcategory =  $CINFO['uid'] && $vtype != 'sub';
$is_regismode = !$CINFO['uid'] || $vtype == 'sub';
if ($is_regismode)
{
	$CINFO['menutype'] = '3';
	$CINFO['name']	   = '';
	$CINFO['joint']	   = '';
	$CINFO['redirect'] = '';
	$CINFO['hidden']   = '';
	$CINFO['target']   = '';
	$CINFO['imghead']  = '';
	$CINFO['imgfoot']  = '';
}
?>


<div id="catebody" class="row">
	<div id="category" class="col-sm-5 col-md-4 col-lg-4">
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">
				<div class="panel-heading rb-icon">
					<div class="icon">
						<i class="fa fa-sitemap fa-2x"></i>
					</div>
					<h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapmetane">메뉴구조</a></h4>
				</div>
				<div class="panel-collapse collapse in" id="collapmetane">
					<?php if($SITEN>1):?>
					<div class="panel-body rb-panel-form">
						<select class="form-control" onchange="goHref('<?php echo $g['s']?>/?m=<?php echo $m?>&module=<?php echo $module?>&front=<?php echo $front?>&r='+this.value);">
						<?php while($S = db_fetch_array($SITES)):?>
						<option value="<?php echo $S['id']?>"<?php if($r==$S['id']):?> selected<?php endif?>><?php echo $S['name']?> (<?php echo $S['id']?>)</option>
						<?php endwhile?>
						</select>
					</div>
					<?php endif?>
					
					<div class="panel-body">
						<div style="min-height:300px;">
							<link href="<?php echo $g['s']?>/_core/css/tree.css" rel="stylesheet">
							<?php $_treeOptions=array('site'=>$s,'table'=>$table['s_menu'],'dispNum'=>true,'dispHidden'=>false,'dispCheckbox'=>false,'allOpen'=>false,'bookmark'=>'site-menu-info')?>
							<?php $_treeOptions['link'] = $g['adm_href'].'&amp;cat='?>
							<?php echo getTreeMenu($_treeOptions,$cat,$code,0,0,'')?>
						</div>
					</div>
					
					<div class="panel-footer">
						<div class="btn-group dropup btn-block">
							<button type="button" class="btn btn-default dropdown-toggle btn-block btn-lg" data-toggle="dropdown">
								<i class="fa fa-download fa-lg"></i> 구조 내려받기 
							</button>
							<ul class="dropdown-menu pull-right" role="menu">
							<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=dumpmenu&amp;type=xml" target="_blank">XML로 생성/받기</a></li>
							<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=dumpmenu&amp;type=xls" target="_action_frame_<?php echo $m?>">엑셀로 받기</a></li>
							<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=dumpmenu&amp;type=txt" target="_action_frame_<?php echo $m?>">텍스트파일로 받기</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			
			<?php if($g['device']):?><a name="site-menu-info"></a><?php endif?>
			<div class="panel panel-default">
				<div class="panel-heading rb-icon">
					<div class="icon">
						<i class="fa fa-retweet fa-2x"></i>
					</div>
					<h4 class="panel-title">
						<a class="accordion-toggle collapsed" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">순서 조정</a>
					</h4>
				</div>
				
				<div class="panel-collapse collapse" id="collapseTwo">
					<?php if($CINFO['isson']||(!$cat&&$ISCAT)):?>
					<form role="form" action="<?php echo $g['s']?>/" method="post">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="<?php echo $module?>">
					<input type="hidden" name="a" value="modifymenugid">
						<div class="panel-body" style="border-top:1px solid #DEDEDE;">
							<div class="dd" id="nestable-menu">
								<ol class="dd-list">
								<?php $_MENUS=getDbSelect($table['s_menu'],'site='.$s.' and parent='.intval($CINFO['uid']).' and depth='.($CINFO['depth']+1).' order by gid asc','*')?>
								<?php $_i=1;while($_M=db_fetch_array($_MENUS)):?>								
								<li class="dd-item" data-id="<?php echo $_i?>">
								<input type="checkbox" name="menumembers[]" value="<?php echo $_M['uid']?>" checked class="hidden">
								<div class="dd-handle"><i class="fa fa-arrows fa-fw"></i> <?php echo $_M['name']?></div>
								</li>
								<?php $_i++;endwhile?>
								</ol>
							</div>
						</div>
					</form>

					<!-- nestable : https://github.com/dbushell/Nestable -->
					<?php getImport('nestable','jquery.nestable',false,'js') ?>
					<script>
					$('#nestable-menu').nestable();
					$('.dd').on('change', function() {
						var f = document.forms[0];
						getIframeForAction(f);
						f.submit();
					});
					</script>

					<?php else:?>
					<div class="panel-body rb-blank">
						<?php if($cat):?>[<?php echo $CINFO['name']?>] 하위에 <?php endif?>등록된 메뉴가 없습니다.
					</div>
					<?php endif?>
				</div>
			</div>
		</div>
	</div>


	<div id="catinfo" class="col-sm-7 col-md-8 col-lg-8">
		<form class="form-horizontal rb-form" name="procForm" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="regismenu">
		<input type="hidden" name="cat" value="<?php echo $CINFO['uid']?>">
		<input type="hidden" name="code" value="<?php echo $code?>">
		<input type="hidden" name="vtype" value="<?php echo $vtype?>">
		<input type="hidden" name="depth" value="<?php echo intval($CINFO['depth'])?>">
		<input type="hidden" name="parent" value="<?php echo intval($CINFO['uid'])?>">
		<input type="hidden" name="perm_g" value="<?php echo $CINFO['perm_g']?>">
		<input type="hidden" name="seouid" value="<?php echo $_SEO['uid']?>">
		<input type="hidden" name="layout" value="">

		<div class="page-header">
			<h4>
				<?php if($is_regismode):?>
				<?php if($vtype == 'sub'):?>서브메뉴 만들기<?php else:?>최상위 메뉴 만들기<?php endif?>
				<?php else:?>
				메뉴 등록정보
				<a href="<?php echo $g['adm_href']?>" class="pull-right btn btn-link">최상위 메뉴 만들기</a>
				<?php endif?>
			</h4>
		</div>

		<?php if($vtype == 'sub'):?>
		<div class="form-group">
			<label class="col-md-2 control-label">상위메뉴</label>
			<div class="col-md-9">
				<ol class="breadcrumb">
				<?php for ($i = 0; $i < $ctnum; $i++):$subcode=$subcode.($i?'/'.$ctarr[$i]['uid']:$ctarr[$i]['uid']) ?>
				<li><a href="<?php echo $g['adm_href']?>&amp;cat=<?php echo $ctarr[$i]['uid']?>&amp;code=<?php echo $subcode?>"><?php echo $ctarr[$i]['name']?></a></li>
				<?php $catcode .= $ctarr[$i]['id'].'/';endfor?>
				</ol>
			</div>
		</div>
		<?php else:?>
		<?php if($cat):?>
		<div class="form-group">		
			<label class="col-md-2 control-label">상위메뉴</label>
			<div class="col-md-9">
				<ol class="breadcrumb">
				<?php for ($i = 0; $i < $ctnum-1; $i++):$subcode=$subcode.($i?'/'.$ctarr[$i]['uid']:$ctarr[$i]['uid'])?>
				<li><a href="<?php echo $g['adm_href']?>&amp;cat=<?php echo $ctarr[$i]['uid']?>&amp;code=<?php echo $subcode?>"><?php echo $ctarr[$i]['name']?></a></li>
				<?php $delparent=$ctarr[$i]['uid'];$catcode .= $ctarr[$i]['id'].'/';endfor?>
				<?php if(!$delparent):?>최상위메뉴<?php endif?>
				</ol>
			</div>
		</div>
		<?php endif?>
		<?php endif?>

		<div class="form-group rb-outside">
			<label class="col-md-2 control-label">메뉴명</label>
			<div class="col-md-10 col-lg-9">
				<?php if($is_fcategory):?>
				<div class="input-group input-group-lg">
					<input class="form-control col-md-6" placeholder="" type="text" name="name" value="<?php echo $CINFO['name']?>"<?php if(!$cat && !$g['device']):?> autofocus<?php endif?>>
					<span class="input-group-btn">
						<a href="<?php echo $g['adm_href']?>&amp;cat=<?php echo $cat?>&amp;code=<?php echo $code?>&amp;vtype=sub" class="btn btn-default" data-tooltip="tooltip" title="서브메뉴 만들기">
							<i class="fa fa-share fa-rotate-90 fa-lg"></i>
						</a>
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletemenu&amp;cat=<?php echo $cat?>&amp;parent=<?php echo $delparent?>&amp;code=<?php echo substr($catcode,0,strlen($catcode)-1)?>" onclick="return hrefCheck(this,true,'정말로 삭제하시겠습니까?     ');" class="btn btn-default" data-tooltip="tooltip" title="메뉴삭제">
							<i class="fa fa-trash-o fa-lg"></i>
						</a>
					</span>
				</div>
				<div class="help-block">
					메뉴를 삭제하면 소속된 하위메뉴까지 모두 삭제됩니다.					
				</div>
				<?php else:?>
				<div class="input-group input-group-lg">
					<input class="form-control" placeholder="" type="text" name="name" value="<?php echo $CINFO['name']?>"<?php if(!$g['device']):?> autofocus<?php endif?>>
					<span class="input-group-btn">
						<button class="btn btn-default rb-help-btn" type="button" data-toggle="collapse" data-target="#guide_new" data-tooltip="tooltip" title="도움말"><i class="fa fa-question fa-lg text-muted"></i></button>
					</span>
				</div>
				<div id="guide_new" class="collapse help-block">
					<p>
						복수의 메뉴를 한번에 등록하시려면 메뉴명을 콤마(,)로 구분해 주세요. <br>
						보기: <code>회사소개,커뮤니티,고객센터</code>
					</p>
					<p>
						메뉴코드를 같이 등록하시려면 다음과 같은 형식으로 등록해 주세요.<br>
						보기: <code>회사소개=company,커뮤니티=community,고객센터=center</code>
					</p>
				</div>
				<?php endif?>
			</div>
		</div>

		<?php if($CINFO['uid']&&!$vtype):?>
		<div class="form-group rb-outside">
			<label class="col-md-2 control-label">코드</label>
			<div class="col-md-10 col-lg-9">
				<div class="input-group input-group-lg">
					<input class="form-control" placeholder="미등록시 자동생성 됩니다." type="text" name="id" value="<?php echo $CINFO['id']?>" maxlength="20">
					<span class="input-group-addon">
					<?php if($CINFO['uid']):?>
						고유키=<code><?php echo sprintf('%05d',$CINFO['uid'])?></code>
					<?php else:?>
						고유키=자동생성됨
					<?php endif?>
					</span>
				</div>
		
				<span class="help-block">
					<button type="button" class="btn btn-link" data-toggle="collapse" data-target="#guide_menucode">
						<i class="fa fa-question-circle fa-fw"></i>
						메뉴를 잘 표현할 수 있는 단어로 입력해 주세요.
					</button>
				</span>
		
				<div id="guide_menucode" class="collapse rb-guide">
					<ul>
					<li>영문대소문자/숫자/_/- 조합으로 등록할 수 있습니다.</li>
					<li>보기) 메뉴호출주소 : <code><?php echo RW('c=<span class="b">메뉴코드</span>')?></code></li>
					<li>메뉴코드는 중복될 수 없습니다.</li>
					</ul>
				</div>
			</div>
		</div>
		<?php endif?>

		<div class="form-group">
			<label class="col-md-2 col-lg-2 control-label">전시내용</label>
			<div class="col-md-10 col-lg-9">
				<div class="btn-group btn-group-lg btn-group-justified" data-toggle="buttons">
					<a href="#codeBox" class="btn btn-default<?php if(!$CINFO['uid']||$CINFO['menutype']==3):?> active<?php endif?>" data-toggle="tab">
						<input name="menutype" type="radio" value="3"<?php if(!$CINFO['uid']||$CINFO['menutype']==3):?> checked<?php endif?>>
						직접꾸미기 
					</a>
					<a href="#widgetBox" class="btn btn-default<?php if($CINFO['menutype']==2):?> active<?php endif?>" data-toggle="tab">
						<input name="menutype" type="radio" value="2"<?php if($CINFO['menutype']==2):?> checked<?php endif?>>
						위젯전시 
					</a>
					<a href="#jointBox" class="btn btn-default<?php if($CINFO['menutype']==1):?> active<?php endif?>" data-toggle="tab">
						<input name="menutype" type="radio" value="1"<?php if($CINFO['menutype']==1):?> checked<?php endif?>>
						모듈연결 
					</a>
				</div>
			</div>
		</div>


		<div class="form-group tab-content">
			<div class="tab-pane form-group<?php if(!$CINFO['uid']||$CINFO['menutype']==3):?> active<?php endif?>" id="codeBox">
				<div class="col-md-offset-2 col-md-10 col-lg-9">
					<?php if($CINFO['uid']):?>
					<a href="#." class="btn btn-default btn-lg btn-block rb-modal-edit" type="button" data-toggle="modal" data-target="#modal_window"><i class="fa fa-pencil fa-lg"></i> 직접편집</a>
					<?php else:?>
					<span class="help-block well">메뉴 등록 후 편집할 수 있습니다.</span>
					<?php endif?>
				</div>
			</div>
			<div class="tab-pane form-group<?php if($CINFO['menutype']==2):?> active<?php endif?>" id="widgetBox">
				<div class="col-md-offset-2 col-md-10 col-lg-9">
					<?php if($CINFO['uid']):?>
					<a href="#." class="btn btn-default btn-lg btn-block rb-modal-widget" type="button" data-toggle="modal" data-target="#modal_window"><i class="fa fa-puzzle-piece fa-lg"></i> 위젯으로 꾸미기</a>
					<?php else:?>
					<span class="help-block well">메뉴 등록 후 편집할 수 있습니다.</span>
					<?php endif?>
				</div>
			</div>
			<div class="tab-pane form-group<?php if($CINFO['menutype']==1):?> active<?php endif?>" id="jointBox">
				<div class="col-md-offset-2 col-md-10 col-lg-9">
					<div class="input-group input-group-lg">
						<input type="text" name="joint" id="jointf" value="<?php echo $CINFO['joint']?>" class="form-control">
						<span class="input-group-btn">
							<button class="btn btn-default rb-modal-module" type="button" title="모듈연결" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window">
								<i class="fa fa-link fa-lg"></i>
							</button>
							<button class="btn btn-default" type="button" title="미리보기" data-tooltip="tooltip" onclick="getId('jointf').value!=''?window.open(getId('jointf').value):alert('모듈연결 주소를 등록해 주세요.');">
								Go!
							</button>
						</span>
					</div>
					<div class="help-block">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="redirect" id="xredirect" value="1"<?php if($CINFO['redirect']):?> checked<?php endif?>>
								<i></i>입력된 주소로 리다이렉트 시켜줍니다. (외부주소 링크시 사용)
							</label>
						</div>
						<ul class="rb-guide" style="margin-bottom:0;padding-bottom:0;">
							<li>이 메뉴에 연결시킬 모듈이 있을 경우 모듈연결을 클릭한 후 선택해 주세요.</li>
							<li>모듈 연결주소가 지정되면 이 메뉴를 호출시 연결주소의 모듈이 출력됩니다.</li>
							<li>접근권한은 연결된 모듈의 권한설정을 따릅니다.</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<?php if($is_fcategory && $CINFO['isson']):?>
		<div class="form-group">
			<div class="col-md-offset-2 col-lg-9">
				<hr>
				<div class="">
					<label>
						<input type="checkbox" name="subcopy" id="cubcopy" value="1" checked> 이 설정을 서브메뉴에도 일괄적용 <small class="text-muted">(메뉴숨김, 레이아웃, 권한)</small>
					</label> 
				</div>
			</div>
		</div>
		<?php endif?>

		<div class="panel-group" id="menu-settings"><!-- 메타설정-->
			<div class="panel panel-<?php echo $_SESSION['sh_site_menu_1']==1?'primary':'default'?>" id="menu-settings-meta">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#menu-settings" href="#menu-settings-meta-body" onclick="sessionSetting('sh_site_menu_1',getId('menu-settings-meta').className.indexOf('default')==-1?'':'1','','');boxDeco('menu-settings-meta','menu-settings-advance');">
							<i class="fa fa-caret-right fa-fw"></i>메타 설정
						</a>
					</h4>
				</div>
				<div id="menu-settings-meta-body" class="panel-collapse collapse<?php if($_SESSION['sh_site_menu_1']==1):?> in<?php endif?>">
					<div class="panel-body">
						<div class="form-group rb-outside">
							<label class="col-md-2 control-label">타이틀</label>
							<div class="col-md-10 col-lg-9">
								<div class="input-group">
									<input type="text" class="form-control rb-title" name="title" value="<?php echo $_SEO['title']?>" maxlength="60" placeholder="50-60자 내에서 작성해 주세요.">
									<span class="input-group-btn">
										<button class="btn btn-default rb-help-btn" type="button" data-toggle="collapse" data-target="#guide_title" data-tooltip="tooltip" title="도움말"><i class="fa fa-question fa-lg text-muted"></i></button>
									</span>
								</div>
								<div class="help-block collapse" id="guide_title">
									<small>
										<code>&lt;title&gt;  &lt;/title&gt;</code> 내부에 삽입됩니다. 
										<a href="http://moz.com/learn/seo/title-tag" target="_blank">참고</a>
									</small>
								</div>
							</div>
						</div>
						<div class="form-group rb-outside">
							<label class="col-md-2 control-label">설명</label>
							<div class="col-md-10 col-lg-9">
								<textarea name="description" class="form-control rb-description" rows="5" placeholder="150-160자 내에서 작성해 주세요." maxlength="160"><?php echo $_SEO['description']?></textarea>
								<div class="help-text"><small class="text-muted"><a href="#guide_description" data-toggle="collapse" ><i class="fa fa-question-circle fa-fw"></i>도움말</a></small></div>
								<div class="collapse" id="guide_description">
									<small class="help-block">
										<code>&lt;meta name="description" content=""&gt;</code> 내부에 삽입됩니다. <br>
										검색 결과에 표시되는 문자를 지정합니다.
										설명글은 엔터없이 입력해 주세요.
										보기)웹 프레임워크의 혁신 - 킴스큐 Rb 에 대한 다운로드,팁 공유등을 제공합니다. <a href="http://moz.com/learn/seo/meta-description" target="_blank">참고</a>
									</small>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">키워드</label>
							<div class="col-md-10 col-lg-9">
								<textarea name="keywords" class="form-control" rows="2" placeholder="콤마(,)로 구분하여 입력해 주세요."><?php echo $_SEO['keywords']?></textarea>
								<div class="help-text"><small class="text-muted"><a href="#guide_keywords" data-toggle="collapse" ><i class="fa fa-question-circle fa-fw"></i>도움말</a></small></div>
								<div class="help-block collapse" id="guide_keywords">
									<small>
										내부 검색용 태그로 활용됩니다. 
										이 문서의 핵심 키워드를 콤마로 구분하여 지정합니다.
										키워드의 갯수는 20개미만을 권장합니다.
										키워드는 엔터없이 입력해 주세요.
										보기)킴스큐,킴스큐Rb,CMS,웹프레임워크,큐마켓
									</small>
								</div>			
							</div>
						</div>				
					</div>
					<div class="panel-footer">
	  					<small class="text-muted">
	  						<i class="fa fa-info-circle fa-lg fa-fw"></i> meta 정보 설정은 검색엔진최적화, 소셜미디어 최적화와 직접 관련이 있습니다. 
	  					</small>
					</div>
				</div>
			</div>

			<div class="panel panel-<?php echo $_SESSION['sh_site_menu_1']==2?'primary':'default'?>" id="menu-settings-advance"><!--고급설정-->
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#menu-settings" href="#menu-settings-advance-body" onclick="sessionSetting('sh_site_menu_1',getId('menu-settings-advance').className.indexOf('default')==-1?'':'2','','');boxDeco('menu-settings-advance','menu-settings-meta');">
							<i class="fa fa-caret-right fa-fw"></i>고급설정
						</a>
					</h4>
				</div>
				<div id="menu-settings-advance-body" class="panel-collapse collapse<?php if($_SESSION['sh_site_menu_1']==2):?> in<?php endif?>">
					<div class="panel-body">

						<div class="form-group">
							<label class="col-md-2 control-label">레이아웃</label>
							<div class="col-md-10 col-lg-9">

								<div class="xrow">
									<div class="col-sm-6" id="rb-layout-select">
										<select class="form-control" name="layout_1" required onchange="getSubLayout(this,'rb-layout-select2','layout_1_sub','');">
											<option value="0">사이트 레이아웃</option>
											<?php $_layoutExp1=explode('/',$CINFO['layout'])?>
											<?php $dirs = opendir($g['path_layout'])?>
											<?php while(false !== ($tpl = readdir($dirs))):?>
											<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
											<option value="<?php echo $tpl?>"<?php if($_layoutExp1[0]==$tpl):?> selected<?php endif?>><?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo $tpl?>)</option>
											<?php endwhile?>
											<?php closedir($dirs)?>
										</select>
									</div>
									<div class="col-sm-6" id="rb-layout-select2">
										<select class="form-control" name="layout_1_sub"<?php if(!$CINFO['layout']):?> disabled<?php endif?>>
											<?php if(!$R['m_layout']):?><option>서브 레이아웃</option><?php endif?>
											<?php $dirs1 = opendir($g['path_layout'].$_layoutExp1[0])?>
											<?php while(false !== ($tpl1 = readdir($dirs1))):?>
											<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
											<option value="<?php echo $tpl1?>"<?php if($_layoutExp1[1]==$tpl1):?> selected<?php endif?>><?php echo str_replace('.php','',$tpl1)?></option>
											<?php endwhile?>
											<?php closedir($dirs1)?>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">메뉴옵션</label>
							<div class="col-md-10 col-lg-9">
								<div class="btn-group btn-group-justified" data-toggle="buttons">
									<label class="btn btn-default<?php if($CINFO['mobile']):?> active<?php endif?>">
										<input type="checkbox" name="mobile" value="1"<?php if($CINFO['mobile']):?> checked<?php endif?>>
										<span class="glyphicon glyphicon-phone"></span>
										모바일출력 
									</label>
									<label class="btn btn-default<?php if($CINFO['target']):?> active<?php endif?>">
										<input type="checkbox" name="target" value="_blank"<?php if($CINFO['target']):?> checked<?php endif?>>
										<span class="glyphicon glyphicon-new-window"></span>
										새창열기 
									</label>
									<label class="btn btn-default<?php if($CINFO['hidden']):?> active<?php endif?>">
										<input type="checkbox" name="hidden" value="1"<?php if($CINFO['hidden']):?> checked<?php endif?>>
										<span class="glyphicon glyphicon-eye-close"></span>
										메뉴숨김 
									</label>
									<label class="btn btn-default<?php if($CINFO['reject']):?> active<?php endif?>">
										<input type="checkbox" name="reject" value="1"<?php if($CINFO['reject']):?> checked<?php endif?>>
										<span class="glyphicon glyphicon-lock"></span>
										메뉴잠금 
									</label>
								</div>
								<span class="help-block">
									<button type="button" class="btn btn-link" data-toggle="collapse" data-target="#guide_mpro"><i class="fa fa-question-circle fa-fw"></i>도움말</button>
								</span>
								<div id="guide_mpro" class="collapse rb-guide">
									<dl class="dl-horizontal">
									<dt>모바일 출력</dt>
									<dd>모바일 레이아웃 사용시 이 메뉴를 출력합니다.</dd>
									<dt>새창열기</dt>
									<dd>이 메뉴를 클릭시 새창으로 엽니다.</dd>
									<dt>메뉴숨김</dt>
									<dd>메뉴를 출력하지 않습니다.(링크접근가능)</dd>
									<dt>메뉴잠금</dt>
									<dd>메뉴의 접근을 차단합니다.(링크접근불가)</dd>
									</dl>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-2 control-label">허용등급</label>
							<div class="col-md-10 col-lg-9">
								<select class="col-md-12 form-control" name="perm_l">
								<option value="">&nbsp;+ 전체허용</option>
								<?php $_LEVEL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',0,1)?>
								<?php while($_L=db_fetch_array($_LEVEL)):?>
								<option value="<?php echo $_L['uid']?>"<?php if($_L['uid']==$CINFO['perm_l']):?> selected="selected"<?php endif?>>ㆍ<?php echo $_L['name']?>(<?php echo number_format($_L['num'])?>) 이상</option>
								<?php if($_L['gid'])break; endwhile?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-2 control-label">차단그룹</label>
							<div class="col-md-10 col-lg-9">
								<select class="col-md-12 form-control" name="_perm_g" multiple size="5">
								<option value=""<?php if(!$CINFO['perm_g']):?> selected="selected"<?php endif?>>ㆍ차단안함</option>
								<?php $_SOSOK=getDbArray($table['s_mbrgroup'],'','*','gid','asc',0,1)?>
								<?php while($_S=db_fetch_array($_SOSOK)):?>
								<option value="<?php echo $_S['uid']?>"<?php if(strstr($CINFO['perm_g'],'['.$_S['uid'].']')):?> selected="selected"<?php endif?>>ㆍ<?php echo $_S['name']?>(<?php echo number_format($_S['num'])?>)</option>
								<?php endwhile?>
								</select>
								<span class="help-block">
									<button type="button" class="btn btn-link" data-toggle="collapse" data-target="#guide_permg"><i class="fa fa-question-circle fa-fw"></i>도움말</button>
								</span>
								<ul id="guide_permg" class="collapse rb-guide">
								<li>복수의 그룹을 선택하려면 드래그하거나 <kbd>Ctrl</kbd> 를 누른다음 클릭해 주세요.</li>
								</ul>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-2 control-label">캐시적용</label>
							<div class="col-md-10 col-lg-9">
								<?php $cachefile = $g['path_page'].'menu/'.sprintf('%05d',$CINFO['uid']).'.txt'?>
								<?php $cachetime = file_exists($cachefile) ? implode('',file($cachefile)) : 0?>
								<select name="cachetime" class="col-md-12 form-control">
								<option value="">&nbsp;+ 적용안함</option>
								<?php for($i = 1; $i < 61; $i++):?>
								<option value="<?php echo $i?>"<?php if($cachetime==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?>분</option>
								<?php endfor?>
								</select>
								<span class="help-block">
									<button type="button" class="btn btn-link" data-toggle="collapse" data-target="#guide_cache"><i class="fa fa-question-circle fa-fw"></i>도움말</button>
								</span>
								<ul id="guide_cache" class="collapse rb-guide">
								<li>DB접속이 많거나 위젯을 많이 사용하는 메뉴일 경우 캐시를 적용하면 서버부하를 줄 일 수 있으며 속도를 높일 수 있습니다.</li>
								<li class="text-danger">실시간 처리가 요구되는 메뉴일 경우 적용하지 마세요.</li>
								</ul>
							</div>
						</div>
						
						<?php if($CINFO['uid']):?>
						<div class="form-group">
							<label class="col-md-2 control-label">메뉴주소</label>
							<div class="col-md-10 col-lg-9">

								<div class="input-group" style="margin-bottom: 5px">
									<span class="input-group-addon">물리주소</span>
									<input id="_url_m_1_" type="text" class="form-control" value="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;c=<?php echo $vtype?substr($catcode,0,strlen($catcode)-1):$catcode.$CINFO['id']?>" readonly>
									<span class="input-group-btn">
										<a href="#." class="btn btn-default" data-tooltip="tooltip" title="클립보드에 복사"><i class="fa fa-clipboard"></i></a>
										<a href="#." class="btn btn-default" data-tooltip="tooltip" title="접속" onclick="window.open(getId('_url_m_1_').value);">Go!</a>
									</span>
								</div>  

								<div class="input-group">
									<span class="input-group-addon">고유주소</span>
									<input id="_url_m_2_" type="text" class="form-control" value="<?php echo $g['s']?>/<?php echo $r?>/c/<?php echo ($vtype?substr($catcode,0,strlen($catcode)-1):$catcode.$CINFO['id'])?>" readonly>
									<span class="input-group-btn">
										<a href="#." class="btn btn-default" data-tooltip="tooltip" title="클립보드에 복사"><i class="fa fa-clipboard"></i></a>
										<a href="#." class="btn btn-default" target="_blank" data-tooltip="tooltip" title="접속" onclick="window.open(getId('_url_m_2_').value);">Go!</a>
									</span>
								</div>  

								<span class="help-block">
									<button type="button" class="btn btn-link" data-toggle="collapse" data-target="#guide_addr"><i class="fa fa-question-circle fa-fw"></i>도움말</button>
								</span>

								<div id="guide_addr" class="collapse rb-guide">
									<dl class="dl-horizontal">
										<dt>물리주소</dt>
										<dd>이 메뉴의 물리적인 실제 주소입니다.</dd>
										<dt>고유주소</dt>
										<dd>주소줄이기/사이트코드 사용옵션 결과주소 입니다.</dd>
									</dl>
								</div>
							</div>
						</div>
						<?php endif?>	

						<div class="form-group">
							<label class="col-md-2 control-label">코드확장</label>
							<div class="col-md-10 col-lg-9">
								<div class="panel-group" style="margin-bottom:0;">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" href="#menu_header" onclick="sessionSetting('sh_site_menu_3','1','','1');">
													문서헤더 
													<?php if($CINFO['uid']&&($CINFO['imghead']||is_file($g['path_page'].'menu/'.sprintf('%05d',$CINFO['uid']).'.header.php'))):?><i class="fa fa-check-circle" title="내용있음" data-tooltip="tooltip"></i><?php endif?>
												</a>
											</h4>
										</div>
										<div id="menu_header" class="panel-collapse collapse<?php if($_SESSION['sh_site_menu_3']):?> in<?php endif?>">
											<div class="panel-body">
												<div class="form-group">
													<label class="col-md-3 control-label" for="menuheader-InputFile">헤더파일</label>
													<div class="col-md-9 col-lg-9">
														<input type="file" name="imghead" id="menuheader-InputFile">
														<?php if($CINFO['imghead']):?>
														<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=menu_file_delete&amp;cat=<?php echo $CINFO['uid']?>&amp;dtype=head" onclick="return hrefCheck(this,true,'정말로 삭제하시겠습니까?     ');">삭제</a>
														<?php else:?>
														<small class="help-block">(gif/jpg/png/swf 가능)</small>
														<?php endif?>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">헤더코드</label>
													<div class="col-md-9 col-lg-9">
														<p>
															<textarea name="codhead" id="codheadArea" class="form-control" rows="5"><?php if(is_file($g['path_page'].'menu/'.sprintf('%05d',$CINFO['uid']).'.header.php')) echo htmlspecialchars(implode('',file($g['path_page'].'menu/'.sprintf('%05d',$CINFO['uid']).'.header.php')))?></textarea>
														</p>
														<!--button type="button" class="btn btn-default btn-block" data-tooltip="tooltip" title="에디터 열기"><i class="fa fa-pencil fa-lg fa-fw"></i>에디터 열기</button-->
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" href="#menu_footer" onclick="sessionSetting('sh_site_menu_4','1','','1');">
													문서풋터
													<?php if($CINFO['uid']&&($CINFO['imgfoot']||is_file($g['path_page'].'menu/'.sprintf('%05d',$CINFO['uid']).'.footer.php'))):?><i class="fa fa-check-circle" title="내용있음" data-tooltip="tooltip"></i><?php endif?>
												</a>
											</h4>
										</div>
										<div id="menu_footer" class="panel-collapse collapse<?php if($_SESSION['sh_site_menu_4']):?> in<?php endif?>">
											<div class="panel-body">
												<div class="form-group">
													<label class="col-md-3 control-label" for="menuheader-InputFile">풋터파일</label>
													<div class="col-md-9 col-lg-9">
														<input type="file" name="imgfoot" id="menufooter-InputFile">
														<?php if($CINFO['imgfoot']):?>
														<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=menu_file_delete&amp;cat=<?php echo $CINFO['uid']?>&amp;dtype=foot" onclick="return hrefCheck(this,true,'정말로 삭제하시겠습니까?     ');">삭제</a>
														<?php else:?>
														<small class="help-block">(gif/jpg/png/swf 가능)</small>
														<?php endif?>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">풋터코드</label>
													<div class="col-md-9 col-lg-9">
														<p>
															<textarea name="codfoot" id="codfootArea" class="form-control" rows="5"><?php if(is_file($g['path_page'].'menu/'.sprintf('%05d',$CINFO['uid']).'.footer.php')) echo htmlspecialchars(implode('',file($g['path_page'].'menu/'.sprintf('%05d',$CINFO['uid']).'.footer.php')))?></textarea>
														</p>
														<!--button type="button" class="btn btn-default btn-block" data-tooltip="tooltip" title="에디터 열기"><i class="fa fa-pencil fa-lg fa-fw"></i>에디터 열기</button-->
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" href="#menu_addinfo" onclick="sessionSetting('sh_site_menu_5','1','','1');">
													부가필드
													<?php if($CINFO['addinfo']):?><i class="fa fa-check-circle" title="내용있음" data-tooltip="tooltip"></i><?php endif?>
												</a>
											</h4>
										</div>
										<div id="menu_addinfo" class="panel-collapse collapse<?php if($_SESSION['sh_site_menu_5']):?> in<?php endif?>">
											<div class="panel-body">
												<div class="form-group">
													<label class="col-md-3 control-label">부가필드</label>
													<div class="col-md-9 col-lg-9">
														<textarea name="addinfo" class="form-control" rows="3"><?php echo htmlspecialchars($CINFO['addinfo'])?></textarea>
														<span class="help-block">이 메뉴에 대해서 추가적인 정보가 필요할 경우 사용하며 필드명은<code>[addinfo]</code> 입니다.</span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" href="#menu_addattr" onclick="sessionSetting('sh_site_menu_6','1','','1');">
													속성추가
													<?php if($_SEO['subject']):?><i class="fa fa-check-circle" title="내용있음" data-tooltip="tooltip"></i><?php endif?>
												</a>
											</h4>
									</div>
									<div id="menu_addattr" class="panel-collapse collapse<?php if($_SESSION['sh_site_menu_6']):?> in<?php endif?>">
										<div class="panel-body">
											<div class="form-group">
												<label class="col-md-3 control-label">추가 속성</label>
												<div class="col-md-9 col-lg-9">
													<input type="text" name="addattr" class="form-control" placeholder="예: rel=&quot;nofollow&quot; 또는 data-scroll 등" value="<?php echo htmlspecialchars($CINFO['addattr'])?>">
													<span class="help-block"><code>&lt;a href="#"  &gt;</code> 태그 내부에 속성으로 추가 됩니다.</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>					
						
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-12 col-lg-12">
			<button class="btn btn-primary btn-block btn-lg" type="submit"><i class="fa fa-check fa-lg"></i> <?php if($CINFO['uid']):?>속성변경<?php else:?>신규메뉴 등록<?php endif?></button>
		</div>
	</div>

	</form>
</div>
</div>



<!-- bootstrap-maxlength -->
<?php getImport('bootstrap-maxlength','bootstrap-maxlength.min',false,'js')?>
<script>
$('input.rb-title').maxlength({
	alwaysShow: true,
	threshold: 10,
	warningClass: "label label-success",
	limitReachedClass: "label label-danger",
});

$('textarea.rb-description').maxlength({
	alwaysShow: true,
	threshold: 10,
	warningClass: "label label-success",
	limitReachedClass: "label label-danger",
});
</script>

<!-- modal -->
<script>
$(document).ready(function() {
	$('.rb-modal-edit').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;system=edit.menu&amp;_menu='.$CINFO['uid'].'&amp;type=source')?>');
	});
	$('.rb-modal-widget').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;system=edit.menu&amp;_menu='.$CINFO['uid'].'&amp;type=widget')?>');
	});
	$('.rb-modal-module').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.joint&amp;dropfield=jointf')?>');
	});
});
</script>

<!-- bootstrap Validator -->
<?php getImport('bootstrap-validator','dist/css/bootstrapValidator.min',false,'css')?>
<?php getImport('bootstrap-validator','dist/js/bootstrapValidator.min',false,'js')?>

<script>
$('.form-horizontal').bootstrapValidator({
	message: 'This value is not valid',
	<?php if(!$g['device']):?>
	feedbackIcons: {
		valid: 'glyphicon glyphicon-ok',
		invalid: 'glyphicon glyphicon-remove',
		validating: 'glyphicon glyphicon-refresh'
	},
	<?php endif?>
	fields: {
		name: {
			message: 'The menu is not valid',
			validators: {
				notEmpty: {
					message: '메뉴명 입력해 주세요.'
				}
			}
		},
		id: {
			validators: {
				notEmpty: {
					message: '메뉴코드를 입력해 주세요.'
				},
				regexp: {
					regexp: /^[a-zA-Z0-9_]+$/,
					message: '메뉴코드는 영문대소문자/숫자/_/- 만 사용할 수 있습니다. '
				}
			}
		},
	}
});
</script>

<!-- basic -->
<script>
function saveCheck(f)
{
<?php if(!$SITEN):?>
	alert('사이트가 등록되지 않았습니다.\n먼저 사이트를 만들어주세요.      ');
	return false;
<?php endif?>
    var l1 = f._perm_g;
    var n1 = l1.length;
    var i;
	var s1 = '';

	for	(i = 0; i < n1; i++)
	{
		if (l1[i].selected == true && l1[i].value != '')
		{
			s1 += '['+l1[i].value+']';
		}
	}

	f.perm_g.value = s1;
/*
	if (f.name.value == '')
	{
		alert('메뉴명칭을 입력해 주세요.      ');
		f.name.focus();
		return false;
	}
*/
	if (f.id)
	{
		if (f.id.value == '')
		{
			alert('메뉴코드를 입력해 주세요.      ');
			f.id.focus();
			return false;
		}
		if (!chkFnameValue(f.id.value))
		{
			alert('메뉴코드는 영문대소문자/숫자/_/- 만 사용할 수 있습니다.      ');
			f.id.focus();
			return false;
		}
	}
	if (f.menutype[2].checked == true)
	{
		if (f.joint.value == '')
		{
			alert('모듈을 연결해 주세요.      ');
			f.joint.focus();
			return false;
		}
	}

	if(f.layout_1.value != '0') f.layout.value = f.layout_1.value + '/' + f.layout_1_sub.value;
	else f.layout.value = '';

	getIframeForAction(f);	
	//return confirm('정말로 실행하시겠습니까?         ');
}
function boxDeco(layer1,layer2)
{
	if(getId(layer1).className.indexOf('default') == -1) $("#"+layer1).addClass("panel-default").removeClass("panel-primary");
	else $("#"+layer1).addClass("panel-primary").removeClass("panel-default");
	$("#"+layer2).addClass("panel-default").removeClass("panel-primary");
}
</script>
