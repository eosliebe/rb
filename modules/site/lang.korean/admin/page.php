<?php
$R=array();
$recnum= $recnum ? $recnum : 15;
$sendsql= ($cat?"category='".$cat."'":'uid>0');
if ($keyw)
{
	$sendsql .= " and (id like '%".$keyw."%' or name like '%".$keyw."%' or category like '%".$keyw."%')";
}
$PAGES = getDbArray($table['s_page'],$sendsql,'*','d_update','desc',$recnum,$p);
$NUM = getDbRows($table['s_page'],$sendsql);
$TPG = getTotalPage($NUM,$recnum);

if ($uid)
{
	$R = getUidData($table['s_page'],$uid);
	$_SEO = getDbData($table['s_seo'],'rel=2 and parent='.$R['uid'],'*');
}
?>


<div class="row">
	<div class="col-md-5 col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading rb-icon">
				<div class="icon">
					<i class="fa fa-file-text-o fa-2x"></i>
				</div>
				<h4 class="dropdown panel-title">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $cat?$cat:'전체페이지'?> <i class="caret"></i></a>
					<ul class="dropdown-menu">
						<li role="presentation" class="dropdown-header">페이지 분류</li>
						<li<?php if(!$cat):?> class="active"<?php endif?>><a href="<?php echo $g['adm_href']?>">전체페이지</a></li>
						<?php $_cats=array()?>
						<?php $CATS=db_query("select *,count(*) as cnt from ".$table['s_page']." group by category",$DB_CONNECT)?>
						<?php while($C=db_fetch_array($CATS)):$_cats[]=$C['category']?>
						<li<?php if($C['category']==$cat):?> class="active"<?php endif?>><a href="<?php echo $g['adm_href']?>&amp;cat=<?php echo urlencode($C['category'])?>"><?php echo $C['category']?> <small>(<?php echo $C['cnt']?>)</small></a></li>
						<?php endwhile?>
					</ul>
					<span class="pull-right">
						<button type="button" class="btn btn-default btn-xs<?php if(!$_SESSION['sh_site_page_search']):?> collapsed<?php endif?>" data-toggle="collapse" data-target="#panel-search" data-tooltip="tooltip" title="검색필터" onclick="sessionSetting('sh_site_page_search','1','','1');getSearchFocus();"><i class="glyphicon glyphicon-search"></i></button>
					</span>
				</h4>
			</div>
			
			<div id="panel-search" class="collapse<?php if($_SESSION['sh_site_page_search']):?> in<?php endif?>">
				<form role="form" action="<?php echo $g['s']?>/" method="get">
				<input type="hidden" name="r" value="<?php echo $r?>">
				<input type="hidden" name="m" value="<?php echo $m?>">
				<input type="hidden" name="module" value="<?php echo $module?>">
				<input type="hidden" name="front" value="<?php echo $front?>">
				<input type="hidden" name="cat" value="<?php echo $cat?>">
					<div class="panel-heading rb-search-box">
						<div class="input-group">
							<div class="input-group-addon"><small>출력수</small></div>
							<div class="input-group-btn">
								<select class="form-control" name="recnum" onchange="this.form.submit();">
								<option value="15"<?php if($recnum==15):?> selected<?php endif?>>15</option>
								<option value="30"<?php if($recnum==30):?> selected<?php endif?>>30</option>
								<option value="60"<?php if($recnum==60):?> selected<?php endif?>>60</option>
								<option value="100"<?php if($recnum==100):?> selected<?php endif?>>100</option>
								</select>
							</div>
						</div>
					</div>
					<div class="rb-keyword-search">
						<input type="text" name="keyw" class="form-control" value="<?php echo $keyw?>" placeholder="페이지명,코드,분류명 검색">
					</div>
				</form>
			</div>

			<table id="page-list" class="table">
			<thead>
				<tr>
					<td class="rb-pagename"><span>페이지명</span></td>
					<td class="rb-time"><span>최종수정</span></td>
				</tr>
			</thead>
			<tbody>
				<?php $_pagetypeset1=array('','fa-link','fa-puzzle-piece','fa-pencil')?>
				<?php $_pagetypeset2=array('','모듈콘텐츠','위젯꾸미기','직접꾸미기')?>
				<?php while($PR = db_fetch_array($PAGES)):?>
				<tr<?php if($uid==$PR['uid']):?> class="active1"<?php endif?>>
					<td onclick="goHref('<?php echo $g['adm_href']?>&amp;cat=<?php echo urlencode($cat)?>&amp;p=<?php echo $p?>&amp;uid=<?php echo $PR['uid']?>&amp;recnum=<?php echo $recnum?>&amp;p=<?php echo $p?>&amp;keyw=<?php echo urlencode($keyw)?>#page-info');">
						<a href="#.">
							<span class="badge" data-tooltip="tooltip" title="<?php echo $_pagetypeset2[$PR['pagetype']]?>">
								<i class="fa <?php echo $_pagetypeset1[$PR['pagetype']]?> fa-lg"></i>
							</span>
							<?php echo $PR['name']?>
						</a>
						<small><i><?php echo $PR['id']?></i></small>
					</td>
					<td class="rb-time">
						<time class="timeago" data-toggle="tooltip" datetime="<?php echo getDateFormat($PR['d_update'],'c')?>" data-tooltip="tooltip" title="<?php echo getDateFormat($PR['d_update'],'Y.m.d H:i')?>"></time>
					</td>
				</tr>
				<?php endwhile?>
			</tbody>
			</table>

			<div class="panel-footer rb-panel-footer">
				<ul class="pagination">
				<script type="text/javascript">getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
				<?php //echo getPageLink(5,$p,$TPG,'')?>
				</ul>
			</div>
		</div>
	</div>

	<div id="tab-content-view" class="col-md-7 col-lg-8">
		<?php if($g['device']):?><a name="page-info"></a><?php endif?>
		<form name="procForm" class="form-horizontal rb-form" role="form" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="regispage" />
		<input type="hidden" name="uid" value="<?php echo $R['uid']?>">
		<input type="hidden" name="orign_id" value="<?php echo $R['id']?>">
		<input type="hidden" name="perm_g" value="<?php echo $R['perm_g']?>">
		<input type="hidden" name="seouid" value="<?php echo $_SEO['uid']?>">
		<input type="hidden" name="layout" value="">
		
			<div class="page-header">
				<h4>
					<?php if($R['uid']):?>
					페이지 등록정보
					<a href="<?php echo $g['adm_href']?>" class="pull-right btn btn-link">새 페이지 만들기</a>
					<?php else:?>
					새 페이지 만들기
					<?php endif?>
				</h4>
			</div>

			<div class="form-group rb-outside">
				<label class="col-md-2 col-lg-2 control-label">페이지명</label>
				<div class="col-md-10 col-lg-9">
					<div class="input-group input-group-lg">
						<input class="form-control" placeholder="" type="text" name="name" value="<?php echo $R['name']?>"<?php if(!$R['uid'] && !$g['device']):?> autofocus<?php endif?>>
						<span class="input-group-btn">
							<button class="btn btn-default rb-help-btn" type="button" data-toggle="collapse" data-target="#guide_startpage" data-tooltip="tooltip" title="페이지 형식지정"><i class="kf-admin" style="width:10px;"></i></button>
						</span>
						<?php if($R['uid']):?>
						<span class="input-group-btn">
							<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletepage&amp;uid=<?php echo $R['uid']?>" onclick="return hrefCheck(this,true,'정말로 삭제하시겠습니까?     ');" class="btn btn-default" data-tooltip="tooltip" title="페이지삭제">
							<i class="fa fa-trash-o fa-lg"></i>
							</a>
						</span>
						<?php endif?>
					</div>
				</div>
			</div>

			<div id="guide_startpage" class="collapse">
				<div class="col-md-offset-2 col-lg-offset-2">
					<div class="help-block">
						<label class="checkbox-inline">
							<input type="checkbox" name="ismain" value="1"<?php if($R['ismain']):?> checked<?php endif?>><i></i><span class="glyphicon glyphicon-home"></span> 메인 페이지 
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" name="mobile" value="1"<?php if($R['mobile']):?> checked<?php endif?>><i></i><span class="glyphicon glyphicon-phone"></span> 모바일 페이지 
						</label>
						<p>
							보기) 메인화면,로그인,회원가입,마이페이지,통합검색,이용약관,고객센터<br>
							메인 페이지는 사이트 속성중 메인 페이지로 지정할 수 있습니다.<br>
							메인화면으로 사용할 페이지일 경우 메인 페이지에 체크해 주세요.<br><br>
						</p>
					</div>
				</div>

				<div class="form-group rb-outside">
					<label class="col-md-2 control-label">코드</label>
					<div class="col-md-10 col-lg-9">
						<div class="input-group input-group-lg">
							<input class="form-control" type="text" name="id" value="<?php echo $R['id']?$R['id']:'p'.$date['tohour']?>" maxlength="20" placeholder="">
							<span class="input-group-btn">
								<button class="btn btn-default rb-help-btn" type="button" data-toggle="collapse" data-target="#guide_pagecode" data-tooltip="tooltip" title="도움말"><i class="fa fa-question fa-lg"></i></button>
							</span>
						</div>
						<div id="guide_pagecode" class="collapse help-block">
							페이지 호출시에 사용되는 코드이므로 가급적 페이지명을 잘 표현할 수 있는 영어로 입력해주세요.<br>
							영문대소문자/숫자/_/- 조합으로 등록할 수 있습니다. <br>
							보기) 페이지호출주소 : <code>./?mod=페이지코드</code> <br>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 col-lg-2 control-label">전시내용</label>
				<div class="col-md-10 col-lg-9">
					<div class="btn-group btn-group-lg btn-group-justified" data-toggle="buttons">
						<a href="#codeBox" class="btn btn-default<?php if(!$R['uid']||$R['pagetype']==3):?> active<?php endif?>" data-toggle="tab">
							<input id="option1" name="pagetype" type="radio" value="3"<?php if(!$R['uid']||$R['pagetype']==3):?> checked<?php endif?>>
							직접꾸미기 
						</a>
						<a href="#widgetBox" class="btn btn-default<?php if($R['pagetype']==2):?> active<?php endif?>" data-toggle="tab">
							<input id="option2" name="pagetype" type="radio" value="2"<?php if($R['pagetype']==2):?> checked<?php endif?>>
							위젯전시 
						</a>
						<a href="#jointBox" class="btn btn-default<?php if($R['pagetype']==1):?> active<?php endif?>" data-toggle="tab">
							<input id="option3" name="pagetype" type="radio" value="1"<?php if($R['pagetype']==1):?> checked<?php endif?>>
							모듈연결 
						</a>
					</div>
				</div>
			</div>

			<div class="form-group tab-content">
				<div class="tab-pane form-group<?php if(!$R['uid']||$R['pagetype']==3):?> active<?php endif?>" id="codeBox">
					<div class="col-md-offset-2 col-md-10 col-lg-9">
						<?php if($R['uid']):?>
						<a href="#." class="btn btn-default btn-lg btn-block rb-modal-edit" type="button" data-toggle="modal" data-target="#modal_window"><i class="fa fa-pencil fa-lg"></i> 직접편집</a>
						<?php else:?>
						<span class="help-block well">페이지 등록 후 편집할 수 있습니다.</span>
						<?php endif?>
					</div>
				</div>
				<div class="tab-pane form-group<?php if($R['pagetype']==2):?> active<?php endif?>" id="widgetBox">
					<div class="col-md-offset-2 col-md-10 col-lg-9">
						<?php if($R['uid']):?>
						<a href="#." class="btn btn-default btn-lg btn-block rb-modal-widget" type="button" data-toggle="modal" data-target="#modal_window"><i class="fa fa-puzzle-piece fa-lg"></i> 위젯으로 꾸미기</a>				
						<?php else:?>
						<span class="help-block well">페이지 등록 후 편집할 수 있습니다.</span>
						<?php endif?>
					</div>
				</div>
				<div class="tab-pane form-group<?php if($R['pagetype']==1):?> active<?php endif?>" id="jointBox">
					<div class="col-md-offset-2 col-md-10 col-lg-9">
						<div class="input-group input-group-lg">
							<input type="text" name="joint" id="jointf" value="<?php echo $R['joint']?>" class="form-control">
							<span class="input-group-btn">
								<button class="btn btn-default rb-modal-module" type="button" title="모듈연결" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window">
									<i class="fa fa-link fa-lg"></i>
								</button>
								<button class="btn btn-default" type="button" title="미리보기" data-tooltip="tooltip" onclick="getId('jointf').value!=''?window.open(getId('jointf').value):alert('모듈연결 주소를 등록해 주세요.');">
									Go!
								</button>
							</span>
						</div>
						<span class="help-block text-muted">
							<ul class="list-unstyled">
								<li>이 페이지에 연결시킬 모듈이 있을 경우 모듈연결을 클릭한 후 선택해 주세요.</li>
								<li>모듈 연결주소가 지정되면 이 메뉴를 호출시 해당 연결주소의 모듈이 출력됩니다.</li>
								<li>접근권한은 연결된 모듈의 권한설정을 따릅니다.</li>
							</ul>
						</span>
					</div>
				</div>
			</div>

			<div class="panel-group" id="page-settings">
				<div class="panel panel-<?php echo $_SESSION['sh_site_page_1']==1?'primary':'default'?>" id="page-settings-meta">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#page-settings" href="#page-settings-meta-body" onclick="sessionSetting('sh_site_page_1',getId('page-settings-meta').className.indexOf('default')==-1?'':'1','','');boxDeco('page-settings-meta','page-settings-advance');">
								<i class="fa fa-caret-right fa-fw"></i>메타 설정
							</a>
						</h4>
					</div>
					<div id="page-settings-meta-body" class="panel-collapse collapse<?php if($_SESSION['sh_site_page_1']==1):?> in<?php endif?>">
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
			  
				<div class="panel panel-<?php echo $_SESSION['sh_site_page_1']==2?'primary':'default'?>" id="page-settings-advance">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#page-settings" href="#page-settings-advance-body" onclick="sessionSetting('sh_site_page_1',getId('page-settings-advance').className.indexOf('default')==-1?'':'2','','');boxDeco('page-settings-advance','page-settings-meta');">
								<i class="fa fa-caret-right fa-fw"></i>고급설정
							</a>
						</h4>
					</div>
					<div id="page-settings-advance-body" class="panel-collapse collapse<?php if($_SESSION['sh_site_page_1']==2):?> in<?php endif?>">
						<div class="panel-body">
							<div class="form-group">
								<label class="col-md-2 control-label">레이아웃</label>
								<div class="col-md-10 col-lg-9">

									<div class="xrow">
										<div class="col-sm-6" id="rb-layout-select">
											<select class="form-control" name="layout_1" required onchange="getSubLayout(this,'rb-layout-select2','layout_1_sub','');">
												<option value="0">사이트 레이아웃</option>
												<?php $_layoutExp1=explode('/',$R['layout'])?>
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
								<label class="col-md-2 col-lg-2 control-label">분류</label>
								<div class="col-md-10 col-lg-9">
									<div class="input-group">
										<input class="form-control" type="text" name="category" value="<?php echo $R['category']?$R['category']:$_cats[0]?>">
										<div class="input-group-btn">
											<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
												<span class="caret"></span>
											</button>
											<ul class="dropdown-menu pull-right">
												<?php foreach($_cats as $_val):?>
												<li><a href="#." onclick="document.procForm.category.value=this.innerHTML;"><?php echo $_val?></a></li>
												<?php endforeach?>
												<?php if(count($_cats)):?>
												<li class="divider"></li>
												<?php endif?>
												<li><a href="#." onclick="document.procForm.category.value='';document.procForm.category.focus();">직접입력</a></li>
											</ul>
										</div><!-- /btn-group -->
									</div>
									<ul class="rb-guide" style="border-top:0;">
										<li>관리가 편하도록 페이지분류를 적절히 지정하여 등록해 주세요.</li>
										<li>페이지 분류는 직접 입력하거나 이미 등록된 분류를 선택할 수 있습니다.</li>
										<li>분류를 직접입력하면 분류선택기에 자동으로 추가됩니다.</li>
									</ul>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">소속메뉴</label>
								<div class="col-md-10 col-lg-9">
										<select class="col-md-12 form-control" name="sosokmenu">
										<option value="">&nbsp;+ 사용안함</option>
										<?php include $g['path_core'].'function/menu1.func.php'?>
										<?php $cat=$R['sosokmenu']?>
										<?php getMenuShowSelect($s,$table['s_menu'],0,0,0,0,0,'')?>
										</select>

									<span class="help-block">
										<button type="button" class="btn btn-link" data-toggle="collapse" data-target="#guide_sosok"><i class="fa fa-question-circle fa-fw"></i>도움말</button>
									</span>

									<ul id="guide_sosok" class="collapse rb-guide">
									<li>이 페이지의 소속메뉴가 종종 필요할 수 있습니다.</li>
									<li>특정메뉴의 서브페이지로 사용되기를 원할경우 지정해 주세요.</li>
									</ul>

								</div>
							</div>				
							<div class="form-group">
								<label class="col-md-2 col-lg-2 control-label">허용등급</label>
								<div class="col-md-10 col-lg-9">
									<select class="col-md-12 form-control" name="perm_l">
									<option value="">&nbsp;+ 전체허용</option>
									<?php $_LEVEL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',0,1)?>
									<?php while($_L=db_fetch_array($_LEVEL)):?>
									<option value="<?php echo $_L['uid']?>"<?php if($_L['uid']==$R['perm_l']):?> selected="selected"<?php endif?>>ㆍ<?php echo $_L['name']?>(<?php echo number_format($_L['num'])?>) 이상</option>
									<?php if($_L['gid'])break; endwhile?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">차단그룹</label>
								<div class="col-md-10 col-lg-9">
									<select class="col-md-12 form-control" name="_perm_g" multiple size="5">
									<option value=""<?php if(!$R['perm_g']):?> selected="selected"<?php endif?>>ㆍ차단안함</option>
									<?php $_SOSOK=getDbArray($table['s_mbrgroup'],'','*','gid','asc',0,1)?>
									<?php while($_S=db_fetch_array($_SOSOK)):?>
									<option value="<?php echo $_S['uid']?>"<?php if(strstr($R['perm_g'],'['.$_S['uid'].']')):?> selected="selected"<?php endif?>>ㆍ<?php echo $_S['name']?>(<?php echo number_format($_S['num'])?>)</option>
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
									<?php $cachefile = $g['path_page'].$R['id'].'.txt'?>
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
									<li>DB접속이 많거나 위젯을 많이 사용하는 페이지일 경우 캐시를 적용하면 서버부하를 줄 일 수 있으며 속도를 높일 수 있습니다.</li>
									<li class="text-danger">실시간 처리가 요구되는 페이지일 경우 적용하지 마세요.</li>
									</ul>
								</div>
							</div>
							<?php if($R['uid']):?>
							<div class="form-group">
								<label class="col-md-2 col-lg-2 control-label">주소</label>
								<div class="col-md-10 col-lg-9">

									<div class="input-group" style="margin-bottom: 5px">
										<span class="input-group-addon">물리주소</span>
										<input type="text" class="form-control" value="<?php echo $g['s']?>/index.php?r=<?php echo $r?>&amp;mod=<?php echo $R['id']?>">
										<span class="input-group-btn">
											<a href="" class="btn btn-default" data-tooltip="tooltip" title="클립보드에 복사"><i class="fa fa-clipboard"></i></a>
											<a href="<?php echo $g['s']?>/index.php?r=<?php echo $r?>&amp;mod=<?php echo $R['id']?>" class="btn btn-default" target="_blank" data-tooltip="tooltip" title="접속">Go!</a>
										</span>
									</div>  

									<div class="input-group">
										<span class="input-group-addon">고유주소</span>
										<input type="text" class="form-control" value="<?php echo RW('mod='.$R['id'])?>">
										<span class="input-group-btn">
											<a href="" class="btn btn-default" data-tooltip="tooltip" title="클립보드에 복사"><i class="fa fa-clipboard"></i></a>
											<a href="<?php echo RW('mod='.$R['id'])?>" class="btn btn-default" target="_blank" data-tooltip="tooltip" title="접속">Go!</a>
										</span>
									</div>  

								</div>
							</div>
							<?php endif?>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12 col-lg-12">
					<button class="btn btn-primary btn-block btn-lg" type="submit"><i class="fa fa-check fa-lg"></i> <?php if($R['uid']):?>속성변경<?php else:?>신규페이지 등록<?php endif?></button>
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
		modalSetting('modal_window','<?php echo getModalLink('&amp;system=edit.page&amp;_page='.$R['uid'].'&amp;type=source')?>');
	});
	$('.rb-modal-widget').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;system=edit.page&amp;_page='.$R['uid'].'&amp;type=widget')?>');
	});
	$('.rb-modal-module').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.joint&amp;dropfield=jointf')?>');
	});
});
</script>

<!-- timeago -->
<?php getImport('jquery-timeago','jquery.timeago',false,'js')?>
<?php getImport('jquery-timeago','locales/jquery.timeago.ko',false,'js')?>
<script>
jQuery(document).ready(function() {
 $(".rb-time time").timeago();
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
			message: 'The username is not valid',
			validators: {
				notEmpty: {
					message: '페이지명을 입력해 주세요.'
				}
			}
		},
		id: {
			validators: {
				notEmpty: {
					message: '페이지 코드를 입력해 주세요.'
				},
				regexp: {
					regexp: /^[a-zA-Z0-9\_\-]+$/,
					message: '페이지 코드는 영문대소문자/숫자/_/- 만 사용할 수 있습니다. '
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


	if (f.pagetype[2].checked == true)
	{
		if (f.joint.value == '')
		{
			alert('모듈을 연결해 주세요.      ');
			f.joint.focus();
			return false;
		}
	}
	getIframeForAction(f);	
	//return confirm('정말로 실행하시겠습니까?         ');
}
function boxDeco(layer1,layer2)
{
	if(getId(layer1).className.indexOf('default') == -1) $("#"+layer1).addClass("panel-default").removeClass("panel-primary");
	else $("#"+layer1).addClass("panel-primary").removeClass("panel-default");
	$("#"+layer2).addClass("panel-default").removeClass("panel-primary");
}
function getSearchFocus()
{
	if(getId('panel-search').className.indexOf('in') == -1) setTimeout("document.forms[0].keyw.focus();",100);
}
</script>
