<?php
function getOpenSrcList()
{
	global $g;
	$incs = array();
	$dirh = opendir($g['path_core'].'plugins/');
	while(false !== ($folder = readdir($dirh))) 
	{ 
		if($folder == '.' || $folder == '..') continue;
		$incs[] = $folder;
	} 
	closedir($dirh);
	return $incs;
}
$_openSrcs = getOpenSrcList();
$_openSrcn = count($_openSrcs);
include $g['path_core'].'function/dir.func.php';
?>

<div id="plugins">
	<div class="page-header">
		<h4>플러그인 <span>(총 <?php echo $_openSrcn?>개 / <span id="_sum_size_"></span>)</span></h4>
	</div>

	<form name="pluginForm" action="<?php echo $g['s']?>/" method="post" class="rb-form" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="plugin_config">
		<input type="hidden" name="isdelete" value="">

		<div class="rb-files table-responsive">
			<table class="table table-condensed">
				<thead>
					<tr>
						<th class="rb-check"></th>
						<th class="rb-name">플러그인명</th>
						<th class="rb-size">용량(파일수)</th>
						<th class="rb-update">등록일</th>
						<th class="rb-version">적용버전</th>
					</tr>
				</thead>
				<tbody>
				
					<?php $_sumPluginsSize=0?>
					<?php foreach($_openSrcs as $_key_):?>
					<?php $plCtime = filectime($g['path_core'].'plugins/'.$_key_)?>
					<?php $plugins = DirSizeNum($g['path_core'].'plugins/'.$_key_)?>
					<?php $_sumPluginsSize+=$plugins['size']?>
					<tr>
						<td class="rb-check"><div class="checkbox"><label><input type="checkbox" name="pluginmembers[]" value="<?php echo $_key_?>"><i></i></label></div></td>
						<td class="rb-name"><i class="fa fa-folder fa-lg"></i> &nbsp;<a><?php echo $_key_?></a></td>
						<td class="rb-size"><?php echo getSizeFormat($plugins['size'],1)?> (<?php echo $plugins['num']?>)</td>
						<td class="rb-update">
							<time class="timeago" data-toggle="tooltip" datetime="<?php echo date('c',$plCtime)?>" data-tooltip="tooltip" title="<?php echo date('Y.m.d H:i',$plCtime)?>"></time>	
						</td>
						<td class="rb-version">
							<select name="ov[<?php echo $_key_?>]" class="form-control input-sm">
								<?php $incs = array()?>
								<?php $dirh = opendir($g['path_core'].'plugins/'.$_key_)?>
								<?php while(false !== ($version = readdir($dirh))):?>
								<?php if($version=='.'||$version=='..')continue?>
								<?php if(!strstr($version,'.') || !is_dir($g['path_core'].'plugins/'.$_key_.'/'.$version)) continue?>
								<option value="<?php echo $version?>"<?php if($version==$d['ov'][$_key_]):?> selected="selected"<?php endif?>><?php echo $version?></option>
								<?php endwhile?>
								<?php closedir($dirh)?>
							</select>
						</td>
					</tr>
					<?php endforeach?>

				</tbody>
			</table>
		</div>

		<div class="bottom-action clearfix">
			<div class="btn-toolbar" role="toolbar">
				<div class="btn-group hidden-xs">
					<button type="button" class="btn btn-danger" onclick="deletePlugin('<?php echo $_key_?>','1');"><i class="fa fa-trash-o fa-lg"></i> 전체삭제</button>
				</div>
				<div class="btn-group hidden-xs">
					<button type="button" class="btn btn-danger" onclick="deletePlugin('<?php echo $_key_?>','2');"><i class="fa fa-trash-o fa-lg"></i> 버젼삭제</button>
				</div>
				<div class="btn-group hidden-xs">
					<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-file-upload"><i class="fa fa-upload fa-lg"></i> 플러그인 추가</button>
				</div>
				<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check fa-fw"></i> 버젼변경</button>
			</div>
		</div>

	</form>

	<div class="well">
		킴스큐에서는 오픈소스로 제공되는 다양한 외부 플러그인들이 사용되고 있습니다.<br>
		현재 사용되고 있는 플러그인들의 최신버젼이나 최적화된 버젼을 동적으로 설정할 수 있습니다. <br>
		삽입코드 예시  <code> &lt;?php  getImport('bootstrap-validator','dist/css/bootstrapValidator.min',false,'css') ?&gt;</code>
	</div>
</div>


<!-- timeago -->
<?php getImport('jquery-timeago','jquery.timeago',false,'js')?>
<?php getImport('jquery-timeago','locales/jquery.timeago.ko',false,'js')?>
<script>
jQuery(document).ready(function() {
 $(".rb-update time").timeago();
});
</script>   

<script>
function deletePlugin(plugin,type)
{
	var f  = document.pluginForm;
    var l = document.getElementsByName('pluginmembers[]');
    var n = l.length;
    var i;
	var j=0;

	for (i=0; i < n; i++)
	{
		if (l[i].checked == true)
		{
			j++;
		}
	}
	if (j == 0)
	{
		alert('삭제할 플러그인을 선택해 주세요.   ');
		return false;
	}
	if (confirm('사용중인 플러그인을 삭제하면 사이트에 오류가 발생할 수 있습니다.\n그래도 삭제하시겠습니까?   '))
	{
		getIframeForAction(f);
		f.isdelete.value = type;
		f.submit();
	}
	return false;
}
function saveCheck(f)
{
	if(confirm('정말로 실행하시겠습니까?         '))
	{
		getIframeForAction(f);
		return true;
	}
	return false;
}
function getFiles()
{
	var f = document._upload_form_;
	getIframeForAction(f);
	f.submit();
}
getId('_sum_size_').innerHTML = '<?php echo getSizeFormat($_sumPluginsSize,2)?>';
</script>







<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="modal-file-upload" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content kimsq">
			<form name="_upload_form_" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="market">
			<input type="hidden" name="a" value="add_plugin">
	            <div class="modal-header">
	                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
	                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-upload fa-lg"></i>  플러그인 추가</h4>
	            </div>
	            <div class="modal-body">
					<div class="well" style="padding-bottom:0;">
						<div class="form-group row">
							<label class="col-md-3" style="padding:10px 0 0 30px;">업로드 위치</label>
							<p class="col-md-9">
								<code><?php echo $g['path_core']?>plugins/</code>
								<button type="button" class="btn btn-default" onclick="getId('filefiled').click();">파일선택</button>
								<input name="upfile" type="file" id="filefiled" class="hidden">						
							</p>
						</div>
					</div>
					<ul>
						<li> 킴스큐에서 제공하는 공식 플러그인만 업로드할 수 있습니다.</li>
						<li> 외부 플러그인을 직접 추가하시려면 매뉴얼에 따라 추가해 주세요.</li>
						<li> 이미 같은이름으로 플러그인이 존재할 경우 덧씌워집니다.</li>
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


