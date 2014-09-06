<?php
include_once $g['path_core'].'function/menu.func.php';
$ISCAT = getDbRows($table['s_domain'],'');


if($cat)
{
	$CINFO = getUidData($table['s_domain'],$cat);
	$ctarr = getMenuCodeToPath($table['s_domain'],$cat,0);
	$ctnum = count($ctarr);
	for ($i = 0; $i < $ctnum; $i++) $CXA[] = $ctarr[$i]['uid'];
}

$is_fcategory =  $CINFO['uid'] && $vtype != 'sub';
$is_regismode = !$CINFO['uid'] || $vtype == 'sub';
if ($is_regismode)
{
	$_fdomain = '.'.str_replace('www.','',$CINFO['name']);
	$CINFO['name'] = '';
	$CINFO['site'] = '';
}
?>


<div class="row">
	<div id="" class="col-sm-5 col-md-5 col-lg-4">

		<div class="panel-group" id="accordion">
			<div class="panel panel-default">
			  <div class="panel-heading rb-icon">
				<div class="icon">
				<i class="fa fa-globe fa-2x"></i>
				</div>
				<h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapmetane">연결 도메인</a></h4>
			  </div>

			  <div class="panel-collapse collapse in" id="collapmetane">

				<div class="panel-body">

					<div style="min-height:300px">
						<?php if($ISCAT):?>
						<link href="<?php echo $g['s']?>/_core/css/tree.css" rel="stylesheet">
						<?php $_treeOptions=array('table'=>$table['s_domain'])?>
						<?php $_treeOptions['link'] = $g['adm_href'].'&amp;cat='?>
						<?php echo getTreeMenu($_treeOptions,$cat,$code,0,0,'')?>
						<?php else:?>
						<div class="rb-none">
							등록된 도메인이 없습니다.
						</div>
						<?php endif?>

					</div>

				</div>
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
				<?php if($CINFO['isson']||(!$cat&&$ISCAT)):?>
				<form role="form" action="<?php echo $g['s']?>/" method="post">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="<?php echo $module?>">
					<input type="hidden" name="a" value="modifygid">
					
					<div class="panel-body" style="border-top:1px solid #DEDEDE;">
				        <div class="dd" id="nestable-menu">
				            <ol class="dd-list">
							<?php $_MENUS=getDbSelect($table['s_domain'],'parent='.intval($CINFO['uid']).' and depth='.($CINFO['depth']+1).' order by gid asc','*')?>
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
					등록된 도메인이 없거나 2차 도메인입니다.
				</div>
				<?php endif?>
			  </div>
			</div>
			
		</div>
	</div>

	<div id="" class="col-sm-7 col-md-7 col-lg-8">

		<form class="form-horizontal rb-form" name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>" />
			<input type="hidden" name="m" value="<?php echo $module?>" />
			<input type="hidden" name="a" value="regisdomain" />
			<input type="hidden" name="cat" value="<?php echo $CINFO['uid']?>" />
			<input type="hidden" name="code" value="<?php echo $code?>" />
			<input type="hidden" name="depth" value="<?php echo intval($CINFO['depth'])?>" />
			<input type="hidden" name="parent" value="<?php echo intval($CINFO['uid'])?>" />
			<input type="hidden" name="vtype" value="<?php echo $vtype?>" />		
			<input type="hidden" name="_fdomain" value="<?php echo $_fdomain?>" />		

			<div class="page-header">
				<h4>
					<?php if($is_regismode):?>
						<?php if($vtype == 'sub'):?>2차 도메인 등록<?php else:?>1차 도메인 등록<?php endif?>
					<?php else:?>
						도메인 등록정보
					<?php endif?>

					<a href="<?php echo $g['adm_href']?>&amp;type=makedomain" class="pull-right btn btn-link">1차 도메인 등록</a>
				</h4>
			</div>

			<?php if($vtype == 'sub'):?>
			<div class="form-group">
				<label class="col-lg-2 control-label">소속 도메인</label>
				<div class="col-lg-9">
					<p class="form-control-static">
						<?php for ($i = 0; $i < $ctnum; $i++):$subcode=$subcode.($i?'/'.$ctarr[$i]['uid']:$ctarr[$i]['uid'])?>
						<a href="<?php echo $g['adm_href']?>&amp;cat=<?php echo $ctarr[$i]['uid']?>&amp;code=<?php echo $subcode?>"><?php echo $ctarr[$i]['name']?></a>
						<?php if($i < $ctnum-1):?> &gt; <?php endif?> 
						<?php endfor?>
					</p>
				</div>
			</div>
			<?php else:?>
			<?php if($cat):?>
			<div class="form-group">
				<label class="col-lg-2 control-label">소속 도메인</label>
				<div class="col-lg-9">
					<p class="form-control-static">
						<?php for ($i = 0; $i < $ctnum-1; $i++):$subcode=$subcode.($i?'/'.$ctarr[$i]['uid']:$ctarr[$i]['uid'])?>
						<a href="<?php echo $g['adm_href']?>&amp;cat=<?php echo $ctarr[$i]['uid']?>&amp;code=<?php echo $subcode?>"><?php echo $ctarr[$i]['name']?></a>
						<?php if($i < $ctnum-2):?> &gt; <?php endif?> 
						<?php $delparent=$ctarr[$i]['uid'];endfor?>
						<?php if(!$delparent):?>최상위도메인<?php endif?>
					</p>
				</div>
			</div>
			<?php endif?>
			<?php endif?>

			<div class="form-group rb-outside">
			  <label class="col-lg-2 control-label">도메인 주소</label>
			  <div class="col-lg-9">

				<?php if($is_fcategory):?>

				<div class="input-group input-group-lg">
				  <input class="form-control col-md-6" placeholder="" type="text" name="name" value="<?php echo $CINFO['name']?>"<?php if(!$cat):?> autofocus<?php endif?>>
				  <span class="input-group-btn">
					<?php if($CINFO['depth']==1):?>
					<a href="<?php echo $g['adm_href']?>&amp;cat=<?php echo $cat?>&amp;code=<?php echo $code?>&amp;vtype=sub" class="btn btn-default" data-tooltip="tooltip" title="2차도메인 등록">
					  <i class="fa fa-share fa-rotate-90 fa-lg"></i>
					</a>
					<?php endif?>
					<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletedomain&amp;cat=<?php echo $cat?>&amp;code=<?php echo $CINFO['depth']==1?$CINFO['uid']:$CINFO['parent']?>&amp;parent=<?php echo $delparent?>" class="btn btn-default" data-tooltip="tooltip" title="삭제" onclick="return hrefCheck(this,true,'정말로 삭제하시겠습니까?');">
					  <i class="fa fa-trash-o fa-lg"></i>
					</a>
				  </span>
				</div>
				<div class="help-block">
						1차 도메인을 삭제하면 소속된 2차 도메인 모두 삭제됩니다.					
				</div>

				<?php else:?>

					<div class="input-group input-group-lg">
						<input class="form-control" placeholder="" type="text" name="name" value="<?php echo $CINFO['name']?>" autofocus>
						<?php if($vtype=='sub'):?><span class="input-group-addon"><?php echo $_fdomain?></span><?php endif?>
						<span class="input-group-btn">
							<button class="btn btn-default rb-help-btn" type="button" data-toggle="collapse" data-target="#guide_new" data-tooltip="tooltip" title="도움말"><i class="fa fa-question fa-lg text-muted"></i></button>
						</span>
					</div>
					<p id="guide_new"  class="form-control-static collapse"><code>http://</code> 또는 <code>https://</code> 를 제외하고 입력해주세요.</p>	

				<?php endif?>

			  </div>
			</div>

			<div class="form-group rb-outside">
				<label class="col-lg-2 control-label">연결 사이트</label>
				<div class="col-lg-9">

					<select name="site" class="form-control input-lg">
					<option value="">선택하세요</option>
					<?php $SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p)?>
					<?php while($S = db_fetch_array($SITES)):?>
					<option value="<?php echo $S['uid']?>"<?php if($CINFO['site']==$S['uid'] || $selsite==$S['uid']):?> selected<?php endif?>>ㆍ<?php echo $S['name']?></option>
					<?php endwhile?>
					<?php if(!db_num_rows($SITES)):?>
					<option value="">등록된 사이트가 없습니다.</option>
					<?php endif?>
					</select>

				</div>
			</div>

			<hr>

			<div class="form-group">
				<div class="col-lg-offset-2 col-lg-9">
					<button type="submit" class="btn btn-primary btn-lg"><?php echo $is_fcategory?'속성 변경':($vtype=='sub'?'등록':'등록')?></button>
					<?php if($vtype=='sub'):?><button type="button" class="btn btn-default btn-lg" onclick="history.back();" />등록취소</button><?php endif?>
					<?php if($cat):?><button type="button" class="btn btn-default btn-lg" onclick="window.open('http://<?php echo $CINFO['name']?>');"><i class="fa fa-share fa-fw fa-lg"></i> 접속하기</button><?php endif?>

					<div class="well rb-help">
						<small>
							<ul>
								<li>도메인 공급업체를 통해 <a href="#.">네임서버 설정</a>과 <a href="#.">웹서버 설정</a>이 필요합니다.</li>
								<li><code>http://</code> 또는 <code>https://</code> 를 제외하고 등록해 주세요</li>
								<li>2차 도메인까지 등록할 수 있으며, 포트지정도 가능합니다.</li>
								<li>도메인 미 등록시 첫번째 사이트에 접속됩니다.</li>
							</ul>
						</small>
					</div>


				</div>
			</div>
		</form>

	</div>
</div>


<!-- bootstrap Validator -->
<?php getImport('bootstrap-validator','dist/css/bootstrapValidator.min',false,'css')?>
<?php getImport('bootstrap-validator','dist/js/bootstrapValidator.min',false,'js')?>

<script>
function saveCheck(f)
{
	getIframeForAction(f);
	return true;	
}
$(document).ready(function() {
    $('.form-horizontal').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                message: 'The domain is not valid',
                validators: {
                    notEmpty: {
                        message: '도메인을 입력해 주세요.'
                    },
                    regexp: {
                        regexp: /^[a-z0-9_\-\.]+$/,
                        message: '도메인은 영문소문자/숫자/_/-/. 만 사용할 수 있습니다. '
                    }
                }
            },
            site: {
                validators: {
                    notEmpty: {
                        message: '연결사이트를 지정해 주세요'
                    }
                }
            },
        }
    });
});
</script>

