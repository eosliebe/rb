<?php
$R=array();
$recnum= $recnum ? $recnum : 15;
$sendsql = 'gid';
if ($keyw)
{
	$sendsql .= " and (id like '%".$keyw."%' or name like '%".$keyw."%')";
}
$RCD = getDbArray($table['s_module'],$sendsql,'*','gid','asc',$recnum,$p);
$NUM = getDbRows($table['s_module'],$sendsql);
$TPG = getTotalPage($NUM,$recnum);
if (!$id)$id='site';
?>

<div class="row">
	<div class="col-md-5 col-lg-4" id="tab-content-list">
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">
				<div class="panel-heading rb-icon">
					<div class="icon">
						<i class="fa kf kf-module fa-2x"></i>
					</div>
					<h4 class="dropdown panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapmetane">전체모듈</a>
						<span class="pull-right" style="position:relative;left:-15px;top:3px;">
							<button type="button" class="btn btn-default btn-xs<?php if(!$_SESSION['sh_site_page_search']):?> collapsed<?php endif?>" data-toggle="collapse" data-target="#panel-search" data-tooltip="tooltip" title="검색필터" onclick="sessionSetting('sh_module_search','1','','1');getSearchFocus();"><i class="glyphicon glyphicon-search"></i></button>
						</span>
					</h4>
				</div>
				<div id="panel-search" class="collapse<?php if($_SESSION['sh_module_search']):?> in<?php endif?>">
					<form role="form" action="<?php echo $g['s']?>/" method="get">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="<?php echo $m?>">
					<input type="hidden" name="module" value="<?php echo $module?>">
					<input type="hidden" name="front" value="<?php echo $front?>">
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
							<input type="text" name="keyw" class="form-control" value="<?php echo $keyw?>" placeholder="모듈명,아이디 검색">
						</div>
					</form>
				</div>

				<div class="panel-collapse collapse in" id="collapmetane">
					<table id="module-list" class="table">
						<thead>
							<tr>
								<td class="rb-name"><span>모듈명</span></td>
								<td class="rb-id"><span>아이디</span></td>
								<td class="rb-time"><span>등록일</span></td>
							</tr>
						</thead>
						<tbody>
							<?php while($_R = db_fetch_array($RCD)):?>
							<tr<?php if($id==$_R['id']):$R=$_R?> class="active1"<?php endif?> onclick="goHref('<?php echo $g['adm_href']?>&amp;recnum=<?php echo $recnum?>&amp;p=<?php echo $p?>&amp;id=<?php echo $_R['id']?>&amp;keyw=<?php echo urlencode($keyw)?>#page-info');">
								<td class="rb-name">
									<i class="kf <?php echo $R['icon']?$_R['icon']:'kf-'.$_R['id']?>"></i> 
									<?php echo $_R['name']?>
									<?php if(!$_R['hidden']):?><small><small class="glyphicon glyphicon-eye-open"></small></small><?php endif?>
								</td>
								<td class="rb-id"><?php echo $_R['id']?></td>
								<td class="rb-time">
									<time class="timeago" data-toggle="tooltip" datetime="<?php echo getDateFormat($_R['d_regis'],'c')?>" data-tooltip="tooltip" title="<?php echo getDateFormat($_R['d_regis'],'Y.m.d H:i')?>"></time>
								</td>
							</tr>
							<?php endwhile?>
						</tbody>
					</table>
				
					<?php if($TPG>1):?>
					<div class="panel-footer rb-panel-footer">
						<ul class="pagination">
						<script type="text/javascript">getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
						<?php //echo getPageLink(5,$p,$TPG,'')?>
						</ul>
					</div>
					<?php endif?>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading rb-icon">
					<div class="icon">
						<i class="fa fa-retweet fa-2x"></i>
					</div>
					<h4 class="panel-title">
						<a class="accordion-toggle collapsed" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">
							순서 조정
						</a>
					</h4>
				</div>
				<div class="panel-collapse collapse" id="collapseTwo">
					<form role="form" action="<?php echo $g['s']?>/" method="post">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="<?php echo $module?>">
					<input type="hidden" name="a" value="moduleorder_update">
						<div class="panel-body" style="border-top:#ccc solid 1px;">
							<div class="dd" id="nestable-menu">
								<ol class="dd-list">
									<?php $RCD = getDbArray($table['s_module'],'','*','gid','asc',0,1)?>
									<?php while($_R=db_fetch_array($RCD)):?>
									<li class="dd-item" data-id="1">
										<div class="dd-handle">
											<input type="checkbox" name="modulemembers[]" value="<?php echo $_R['id']?>" checked class="hidden">
											<i class="fa fa-arrows fa-fw"></i>
											<i class="kf <?php echo $R['icon']?$_R['icon']:'kf-'.$_R['id']?>"></i>
											<?php echo $_R['name']?> (<?php echo $_R['id']?>)
										</div>
									</li>
									<?php endwhile?>
								</ol>
							</div>
						</div>
					</form>
					<div class="panel-footer">
						<a href="#." class="btn btn-default btn-block">모듈추가</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if(!$R['id']) $R=getDbData($table['s_module'],"id='site'",'*')?>
	<?php if($g['device']):?><a name="page-info"></a><?php endif?>
	<div class="col-md-7 col-lg-8" id="tab-content-view">
		<div class="page-header">
			<h4>모듈 등록정보</h4>
		</div>

		<div class="row">
			<div class="col-md-2 col-sm-2 text-center">
				<div class="rb-box">
					<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $_R['id']?>">
						<i class="rb-icon kf <?php echo $R['icon']?$R['icon']:'kf-'.$R['id']?>"></i><br>
						<i class="rb-name"><?php echo $R['id']?></i>
					</a>
				</div>
			</div>
			
			<div class="col-md-10 col-sm-10">
				<h4 class="media-heading">
					<strong><?php echo $R['name']?></strong>
				</h4>

				<div class="btn-group" style="margin:10px 0">
					<button type="button" class="btn btn-default">개발자 정보</button>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
				<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&amp;module=<?php echo $R['id']?>">모듈 관리자 페이지</a></li>
				<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $R['id']?>" target="_blank">모듈 사용자 페이지</a></li>
				<li class="divider"></li>
				<?php if(!$R['system']):?>
				<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=module_delete&amp;moduleid=<?php echo $R['id']?>" onclick="return hrefCheck(this,true,'관련파일/DB데이터가 모두 삭제됩니다.\n정말로 삭제하시겠습니까?');">모듈삭제</a></li>
				<?php else:?>
				<li class="disabled"><a>모듈삭제</a></li>
				<?php endif?>
				</ul>

			</div>
			<p class="text-muted"><small>선택된 모듈에 대한 등록정보입니다. 시스템 기본모듈은 삭제할 수 없습니다.</small></p>
		</div>
	</div>
	<hr>

	<form class="form-horizontal rb-form" role="form" name="procForm" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>">
	<input type="hidden" name="m" value="<?php echo $module?>">
	<input type="hidden" name="moduleid" value="<?php echo $R['id']?>">
	<input type="hidden" name="a" value="moduleinfo_update">
	<input type="hidden" name="iconaction" value="">

		<div class="form-group">
			<label class="col-md-2 control-label">아이디</label>
			<div class="col-md-10">
				<p class="form-control-static"><?php echo $R['id']?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">모듈명</label>
			<div class="col-md-9">
				<input class="form-control col-md-6" placeholder="" type="text" name="name" value="<?php echo $R['name']?>">
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">아이콘</label>
			<div class="col-md-9">
				 <div class="input-group">
					  <input type="text" name="icon" class="form-control" value="<?php echo $R['icon']?>">
					  <span class="input-group-btn">
						<button type="button" class="btn btn-default rb-modal-iconset" data-toggle="modal" data-target="#modal_window">아이콘찾기</button>
					  </span>
				</div>
				<p class="form-control-static">
					<ul class="list-unstyled">
						<li>전용 아이콘 폰트를 사용하려면 모듈내부에 아이폰 폰트 파일을 내장 하고 있어야 합니다.</li>
						<li>아이콘 폰트 제작 방법은 <a href="http://docs.kimsq.com/kr/" target="_blank">도움말</a>을 참고해 주세요</li>
						<li>입력된 코드는 <code>&lt;i class=""&gt;</code>에 속성으로 반영 됩니다.</li>
					</ul>
				</p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label"></label>
			<div class="col-md-9">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="hidden" value="1"<?php if($R['hidden']):?> checked="checked"<?php endif?>>
						<i></i>퀵패널에서 제외
					</label>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">DB</label>
			<div class="col-md-9">
				<p class="form-control-static">
				<?php if($R['tblnum']):?>
				DB테이블 <?php echo $R['tblnum']?>개가 생성되었습니다.
				<?php else:?>
				이 모듈은 DB테이블을 생성하지 않습니다.
				<?php endif?>					
				</p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">등록일</label>
			<div class="col-md-9">
				<p class="form-control-static"><?php echo getDateFormat($R['d_regis'],'Y/m/d')?></p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">언어팩</label>
			<div class="col-md-9">
				<p class="form-control-static">
				<?php $i=0?>
				<?php $dirs = opendir($g['path_module'].$R['id'].'/')?>
				<?php while(false !== ($tpl = readdir($dirs))):?>
				<?php if(substr($tpl,0,5)!='lang.')continue?>
				<?php $reallang = str_replace('lang.','',$tpl)?>
				<span class="b"><?php echo getFolderName($g['path_var'].'language/'.$reallang)?></span>(<?php echo $reallang?>)<br />
				<?php $i++; endwhile?>
				<?php closedir($dirs)?>
				<?php if(!$i):?>
				<span class="b">언어팩이 없는 모듈입니다</span>
				<?php endif?>
				</p>
			</div>
		</div>

		<hr>

		<div class="form-group">
			<div class="col-md-offset-2 col-md-9">
				<button class="btn btn-primary btn-block btn-lg" type="submit"><i class="fa fa-check fa-lg"></i> 속성변경</button>
			</div>
		</div>
	</form>

	</div>
</div>

<!-- timeago -->
<?php getImport('jquery-timeago','jquery.timeago',false,'js')?>
<?php getImport('jquery-timeago','locales/jquery.timeago.ko',false,'js')?>
<script>
jQuery(document).ready(function() {
 $(".rb-time time").timeago();
});
</script>   


<!-- nestable : https://github.com/dbushell/Nestable -->
<?php getImport('nestable','jquery.nestable',false,'js')?>
<script>
$('#nestable-menu').nestable();
$('.dd').on('change', function() {
	var f = document.forms[1];
	getIframeForAction(f);
	f.submit();
});
</script>

<!-- basic -->
<script>
$(document).ready(function()
{
	$('.rb-modal-iconset').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=module&amp;front=modal.icons')?>');
	});
});
function saveCheck(f)
{
	if (f.name.value == '')
	{
		alert('모듈이름을 입력해 주세요.     ');
		f.name.focus();
		return false;
	}
	getIframeForAction(f);
	return confirm('정말로 실행하시겠습니까?         ');
}
function getSearchFocus()
{
	if(getId('panel-search').className.indexOf('in') == -1) setTimeout("document.forms[0].keyw.focus();",100);
}
function iconDrop(val)
{
	var f = document.procForm;
	f.icon.value = val;
	iconDropAply();
}
function iconDropAply()
{
	var f = document.procForm;
	f.iconaction.value = '1';
	getIframeForAction(f);
	f.submit();
	$('#modal_window').modal('hide');
}
</script>
