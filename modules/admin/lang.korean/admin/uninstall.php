<div id="uninstall">

	<div class="panel panel-danger">
		<div class="panel-heading">Danger Zone</div>
		<div class="panel-body">
			<div class="page-header"><h4>kimsQ Rb Uninstall</h4></div>

			<div class="media">
				<h1 class="pull-left"><span class="fa fa-trash fa-lg"></span></h1>
				<div class="media-body">
				<ul>	
					<li>킴스큐Rb의 모든데이터(폴더/파일/DB)를 제거합니다.</li>
					<li>제거과정에서 쓰기퍼미션이 없는 일부 파일이나 폴더가 남을 수 있습니다.</li>
					<li>남은 폴더/파일은 FTP를 이용해서 삭제해 주세요.</li>
					<li>삭제된 데이터는 복구할 수 없습니다.</li>
				</ul>
				</div>
			</div>


			<div class="page-header"><h4>삭제 정보</h4></div>


			<dl class="dl-horizontal">
				<dt>경로</dt>
				<dd><code><?php echo $g['s']?>/*</code></dd>
				<dt>DB table 정보</dt>
				<dd><code><?php echo $DB['head']?>*</code></dd>
			</dl>

			<hr>

			<?php if($d['admin']['ftp_use']):?>
			<div class="form-group">
				<label for="" class="sr-only">FTP 접속암호</label>
				<div class="input-group input-group-lg">
					<input type="password" class="form-control" id="_ftp_pass_" placeholder="FTP 접속암호 암호를 입력해 주세요">
					<span class="input-group-btn">
						<button type="button" class="btn btn-default" id="ftpbtn_uninstall" onclick="sendCheck(this.id);"><?php if($d['admin']['ftp']):?><i class="fa fa-info-circle fa-lg fa-fw"></i>정상<?php else:?>FTP 연결확인<?php endif?></button>
					</span>
				</div>
			</div>
			<?php else:?>
			<div class="well">
				제거과정에서 쓰기퍼미션이 없는 일부 파일이나 폴더가 남을 수 있습니다. <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>">FTP 계정등록</a>후 제거를 추천 드립니다. 
			</div>
			<?php endif?>

		</div>
		<div class="panel-footer">
			<button type="button" class="btn btn-default btn-lg btn-block rb-danger" data-toggle="modal" data-target="#modal-uninstall" >제거</button>
		</div>
	</div>

</div>



<!-- Modal -->
<div class="modal fade" id="modal-uninstall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">정말 삭제하시겠습니까?</h4>
      </div>
      <div class="modal-body">
			<ul>	
				<li>킴스큐Rb의 모든데이터(폴더/파일/DB)를 제거합니다.</li>
				<li>제거과정에서 쓰기퍼미션이 없는 일부 파일이나 폴더가 남을 수 있습니다.</li>
				<li>남은 폴더/파일은 FTP를 이용해서 삭제해 주세요.</li>
				<li>삭제된 데이터는 복구할 수 없습니다.</li>
			</ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-lg btn-block" onclick="uninstall();">네, 삭제하겠습니다.</button>
      </div>
    </div>
  </div>
</div>

<form name="sendForm" action="<?php echo $g['s']?>/" method="post">
<input type="hidden" name="r" value="<?php echo $r?>">
<input type="hidden" name="m" value="<?php echo $module?>">
<input type="hidden" name="a" value="">
<input type="hidden" name="type" value="">
<input type="hidden" name="pass" value="">
</form>

<script>
function sendCheck(id)
{
	if (getId('_ftp_pass_').value == '')
	{
		alert('FTP 패스워드를 입력해 주세요.   ');
		getId('_ftp_pass_').focus();
		return false;
	}
	var f = document.sendForm;
	f.a.value = 'email_check';
	f.type.value = id;
	f.pass.value = getId('_ftp_pass_').value;
	getId(id).innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
	getIframeForAction(f);
	f.submit();
}
function uninstall()
{
	var f = document.sendForm;
	f.a.value = 'uninstall';
	getIframeForAction(f);
	f.submit();
}
</script>