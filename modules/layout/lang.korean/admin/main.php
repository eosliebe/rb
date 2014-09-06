<div class="row" id="layout-code">
	<div class="col-sm-4 col-md-4 col-lg-3">
		<div class="panel panel-default">
			<div class="panel-heading rb-icon">
				<div class="icon">
					<i class="fa kf kf-layout fa-2x"></i>
				</div>
				<h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapmetane">레이아웃</a></h4>
			</div>
			<div class="panel-collapse collapse in" id="collapmetane">
				<div class="panel-body">
					<div style="min-height:250px">
						<link href="<?php echo $g['s']?>/_core/css/tree.css" rel="stylesheet">
						<div class="rb-tree">
							<ul id="tree-layout" class="rb-icon">
							<?php $layout = $layout ? $layout : dirname($_HS['layout'])?>
							<?php $sublayout = $sublayout ? $sublayout : 'default.php'?>
							<?php $_sublayout = str_replace('.php','',$sublayout)?>
							<?php $dirs = opendir($g['path_layout'])?>
							<?php $_i=1;while(false !== ($tpl = readdir($dirs))):?>
							<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
							<?php $dirs1 = opendir($g['path_layout'].$tpl)?>
							<li>
								<a data-toggle="collapse" href="#tree-layout-<?php echo $_i?>" class="rb-branch<?php if($tpl!=$layout):?> collapsed<?php endif?>"><span><?php echo getFolderName($g['path_layout'].$tpl)?></span> <small>(<?php echo $tpl?>)</small></a>
								<ul id="tree-layout-<?php echo $_i?>" class="collapse<?php if($tpl==$layout):?> in<?php endif?>">
									<?php $_j=0;while(false !== ($tpl1 = readdir($dirs1))):?>
									<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
									<li<?php if($tpl==$layout&&$tpl1==$sublayout):?> class="rb-active"<?php endif?>><a href="<?php echo $g['adm_href']?>&amp;layout=<?php echo $tpl?>&amp;sublayout=<?php echo $tpl1?>" class="rb-leaf"><span><?php echo str_replace('.php','',$tpl1)?></span></a></li>
									<?php $_j++;endwhile?>
								</ul>
							</li>
							<?php $_i++;endwhile?>
							</ul>
						</div>
					</div>
				</div>

				<div class="panel-footer">
					<a class="btn btn-default btn-block" data-toggle="modal" href="#modal-layout-add">레이아웃 추가</a>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-8 col-md-8 col-lg-9">
		<div class="page-header">
			<h4>
				<?php echo getFolderName($g['path_layout'].$layout)?> <small>( <?php echo $layout?> )</small> <span class="label label-primary"><?php echo $_sublayout?></span>
				<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=layout_delete&amp;numSub=<?php echo $_j?>&amp;layout=<?php echo $layout?>&amp;sublayout=<?php echo $sublayout?>" class="btn btn-link pull-right" onclick="return hrefCheck(this,true,'현재 사용중인 레이아웃을 삭제하면 중대한 오류가 발생합니다.\n사용중인 레이아웃인지 다시한번 확인해 주세요.\n정말로 삭제하시겠습니까?');">삭제</a>	
			</h4>
		</div>
		<ul class="nav nav-tabs" role="tablist">
			<li<?php if(!$etcfile&&($_SESSION['sh_layout_tab']=='tab_layout'||!$_SESSION['sh_layout_tab'])):?> class="active"<?php endif?>><a href="#tab_layout" role="tab" data-toggle="tab" onclick="sessionSetting('sh_layout_tab','tab_layout','','');">Layout</a></li>
			<li<?php if(!$etcfile&&$_SESSION['sh_layout_tab']=='tab_css'):?> class="active"<?php endif?>><a href="#tab_css" role="tab" data-toggle="tab" onclick="sessionSetting('sh_layout_tab','tab_css','','');">CSS</a></li>
			<li<?php if(!$etcfile&&$_SESSION['sh_layout_tab']=='tab_js'):?> class="active"<?php endif?>><a href="#tab_js" role="tab" data-toggle="tab" onclick="sessionSetting('sh_layout_tab','tab_js','','');">Javascript</a></li>
			<li style="border:#ccc solid 1px;padding:5px;">
				<select class="form-control" onchange="location.href='<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&module=<?php echo $module?>&layout=<?php echo $layout?>&sublayout=<?php echo $sublayout?>&etcfile='+this.value;">
				<option value="">ETC</option>
				<?php $dirs = opendir($g['path_layout'].$layout.'/')?>
				<?php while(false !== ($tpl = readdir($dirs))):?>
				<?php if(substr($tpl,0,1) != '_')continue?>
				<?php $dirs1 = opendir($g['path_layout'].$layout.'/'.$tpl)?>
				<optgroup label="<?php echo $tpl?>" style="background:#333;color:#fff;">
				<?php while(false !== ($tpl1 = readdir($dirs1))):?>
				<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
				<option value="<?php echo $tpl?>/<?php echo $tpl1?>"<?php if($etcfile==$tpl.'/'.$tpl1):?> selected<?php endif?> style="background:#fff;color:#000;"><?php echo $tpl1?></option>
				<?php endwhile?>
				<?php closedir($dirs1)?>
				</optgroup>
				<?php endwhile?>
				<?php closedir($dirs)?>
				</select>
			</li>
		</ul>

		<div class="tab-content">
			<?php 
			$tabsArray = array(
				'tab_layout' => $sublayout,
				'tab_css' => $_sublayout.'.css',
				'tab_js' =>  $_sublayout.'.js',
			);
			$_i=0;foreach($tabsArray as $_key => $_val):
			?>
			<div class="tab-pane fade<?php if(!$etcfile&&((!$_SESSION['sh_layout_tab']&&!$_i)||$_SESSION['sh_layout_tab']==$_key)):?> active in<?php endif?>" id="<?php echo $_key?>">
				<form action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
				<input type="hidden" name="r" value="<?php echo $r?>">
				<input type="hidden" name="a" value="layout_update">
				<input type="hidden" name="m" value="<?php echo $module?>">
				<input type="hidden" name="layout" value="<?php echo $layout?>">
				<input type="hidden" name="editfile" value="<?php echo $_val?>">
					<div class="rb-files">
						<div class="rb-codeview">
							<div class="rb-codeview-header">
								<ol class="breadcrumb pull-left">
									<li>파일경로 :</li>
									<li>root</li>
									<li>layouts</li>
									<li><?php echo $layout?></li>
									<li class="active"><?php echo $_val?></li>
								</ol>
								<button type="button" class="btn btn-default btn-xs pull-right" data-tooltip="tooltip" title="전체화면"><i class="fa fa-arrows-alt fa-lg"></i></button>
							</div>
							<div class="rb-codeview-body">			
								<textarea name="code" class="form-control" rows="15"><?php echo is_file($g['path_layout'].$layout.'/'.$_val)?htmlspecialchars(implode('',file($g['path_layout'].$layout.'/'.$_val))):''?></textarea>
							</div>	
							<div class="rb-codeview-footer">
								<ul class="list-inline">
									<li><code><?php echo is_file($g['path_layout'].$layout.'/'.$_val)?count(file($g['path_layout'].$layout.'/'.$_val)):'0'?> lines</code></li>
									<li><code><?php echo is_file($g['path_layout'].$layout.'/'.$_val)?getSizeFormat(@filesize($g['path_layout'].$layout.'/'.$_val),2):'0B'?></code></li>
									<li class="pull-right">파일을 편집한 후 저장 버튼을 클릭하면 실시간으로 사용자 페이지에 적용됩니다</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="rb-submit">
						<button type="submit" class="btn btn-primary">저장하기</button>
					</div>
				</form>
			</div>
			<?php $_i++;endforeach?>
			<?php if($etcfile):?>
			<div class="tab-pane fade active in" id="tab_etc">
				<form action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
				<input type="hidden" name="r" value="<?php echo $r?>">
				<input type="hidden" name="a" value="layout_update">
				<input type="hidden" name="m" value="<?php echo $module?>">
				<input type="hidden" name="layout" value="<?php echo $layout?>">
				<input type="hidden" name="editfile" value="<?php echo $etcfile?>">
					<div class="rb-files">
						<div class="rb-codeview">
							<div class="rb-codeview-header">
								<ol class="breadcrumb pull-left">
									<li>파일경로 :</li>
									<li>root</li>
									<li>layouts</li>
									<li><?php echo $layout?></li>
									<li><?php echo str_replace('/','</li><li class="active">',$etcfile)?></li>
								</ol>
								<button type="button" class="btn btn-default btn-xs pull-right" data-tooltip="tooltip" title="전체화면"><i class="fa fa-arrows-alt fa-lg"></i></button>
							</div>
							<div class="rb-codeview-body">			
								<textarea name="code" class="form-control" rows="15"><?php echo htmlspecialchars(implode('',file($g['path_layout'].$layout.'/'.$etcfile)))?></textarea>
							</div>	
							<div class="rb-codeview-footer">
								<ul class="list-inline">
									<li><code><?php echo count(file($g['path_layout'].$layout.'/'.$etcfile))?> lines</code></li>
									<li><code><?php echo getSizeFormat(@filesize($g['path_layout'].$layout.'/'.$etcfile),2)?></code></li>
									<li class="pull-right">파일을 편집한 후 저장 버튼을 클릭하면 실시간으로 사용자 페이지에 적용됩니다</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="rb-submit">
						<button type="submit" class="btn btn-primary">저장하기</button>
					</div>
				</form>
			</div>
			<?php endif?>

		</div>
	</div>
</div>




<script>
function getFiles()
{
	var f = document._upload_form_;
	getIframeForAction(f);
	f.submit();
}
function saveCheck(f)
{
	getIframeForAction(f);
	return true;
}
</script>


<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="modal-layout-add" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content kimsq">
			<form name="_upload_form_" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="market">
			<input type="hidden" name="a" value="add_layout">
                <div class="modal-header">
                    <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle fa-lg"></i>  레이아웃 추가</h4>
                </div>
                <div class="modal-body">
					<div class="well" style="padding-bottom:0;">
						<div class="form-group row">
							<label class="col-md-3" style="padding:10px 0 0 30px;">업로드 위치</label>
							<p class="col-md-9">
								<code><?php echo $g['s']?>/layouts/</code>
								<button type="button" class="btn btn-default" onclick="getId('filefiled').click();">파일선택</button>
								<input name="upfile" type="file" id="filefiled" class="hidden">						
							</p>
						</div>
					</div>
					<ul>
						<li> 킴스큐에서 제공하는 공식 레이아웃만 업로드할 수 있습니다.</li>
						<li> 레이아웃을 직접 추가하시려면 매뉴얼에 따라 추가해 주세요.</li>
						<li> 이미 같은이름으로 레이아웃이 존재할 경우 덧씌워집니다.</li>
					</ul>
				</div>
                <div class="modal-footer">
                    <button class="btn btn-default pull-left" data-dismiss="modal" type="button">취소</button>
                    <button class="btn btn-primary" type="button" onclick="getFiles();">추가하기</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
