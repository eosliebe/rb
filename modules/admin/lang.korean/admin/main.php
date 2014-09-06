<div id="configbox">
	<form class="form-horizontal rb-form" role="form" name="sendForm" action="<?php echo $g['s']?>/" method="post">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="email_check">
		<input type="hidden" name="type" value="">

		<div class="page-header">
			<h4>시스템 환경</h4>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">웹서버</label>
			<div class="col-md-9">
				<p class="form-control-static"><?php echo $_SERVER['SERVER_SOFTWARE']?></p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">PHP</label>
			<div class="col-md-9">
				<p class="form-control-static"><?php echo phpversion()?></p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">MySQL</label>
			<div class="col-md-9">
				<p class="form-control-static"><?php echo db_info()?> (<?php echo $DB['type']?>)</p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Core</label>
			<div class="col-md-9">
				<p class="form-control-static">kimsQ Rb <?php echo $d['admin']['version']?></p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">시스템 메일</label>
			<div class="col-md-9">
				<div class="input-group">
				<input type="email" name="email" value="<?php echo $my['email']?>" class="form-control">
				<span class="input-group-btn">
				<button class="btn btn-default" type="button" id="sendmailbtn" onclick="sendCheck(this.id);"><?php if($d['admin']['email']):?><i class="fa fa-info-circle fa-lg fa-fw"></i>정상<?php else:?>이메일 전송확인<?php endif?></button>
				</span>
				</div>
				<p class="form-control-static"><small class="text-muted">입력한 이메일주소로 전송이 되면 메일서버가 정상작동되는 상태입니다.</small></p>
			</div>
		</div>
	</form>	



	<form class="form-horizontal rb-form" role="form" name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="config">
		<input type="hidden" name="act" value="config">
		<input type="hidden" name="version" value="<?php echo $d['admin']['version']?>">
		<input type="hidden" name="autosave" value="">
		<input type="hidden" name="email" value="<?php echo $d['admin']['email']?>">
		<input type="hidden" name="smtp" value="<?php echo $d['admin']['email']?>">
		<input type="hidden" name="ftp" value="<?php echo $d['admin']['ftp']?>">


		<div class="page-header">
			<h4>시스템 테마</h4>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">관리자 테마</label>
			<div class="col-md-9">
				<select name="themepc" class="form-control">
					<?php $dirs = opendir($g['dir_module'].'lang.'.$_HS['lang'].'/theme')?>
					<?php while(false !== ($tpl = readdir($dirs))):?>
					<?php if($tpl=='.' || $tpl == '..')continue?>
					<option value="<?php echo $tpl?>"<?php if($d['admin']['themepc']==$tpl):?> selected<?php endif?>><?php echo $tpl?></option>
					<?php endwhile?>
					<?php closedir($dirs)?>
				</select>
				<p class="form-control-static"></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">관리패널 테마</label>
			<div class="col-md-9">
				<select name="pannellink" class="form-control">
					<?php $dirs = opendir($g['path_core'].'engine/adminpanel/theme')?>
					<?php while(false !== ($tpl = readdir($dirs))):?>
					<?php if($tpl=='.' || $tpl == '..')continue?>
					<option value="<?php echo $tpl?>"<?php if($d['admin']['pannellink']==$tpl):?> selected<?php endif?>><?php echo str_replace('.css','',$tpl)?></option>
					<?php endwhile?>
					<?php closedir($dirs)?>
				</select>
				<p class="form-control-static"></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">CSS/JS 캐시</label>
			<div class="col-md-9">
				<select name="cache_flag" class="form-control">
					<option value=""<?php if($d['admin']['cache_flag']==''):?> selected<?php endif?>>브라우져 설정을 따름</option>
					<option value="totime"<?php if($d['admin']['cache_flag']=='totime'):?> selected<?php endif?>>접속시마다 갱신</option>
					<option value="nhour"<?php if($d['admin']['cache_flag']=='nhour'):?> selected<?php endif?>>한시간 단위로 갱신</option>
					<option value="today"<?php if($d['admin']['cache_flag']=='today'):?> selected<?php endif?>>하루 단위로 갱신</option>
					<option value="month"<?php if($d['admin']['cache_flag']=='month'):?> selected<?php endif?>>한달 단위로 갱신</option>
					<option value="year"<?php if($d['admin']['cache_flag']=='year'):?> selected<?php endif?>>일년 단위로 갱신</option>
				</select>
				<p class="form-control-static"><small class="text-muted">CSS 나 자바스크립트 파일을 수정했을 경우에는 일정기간 접속시마다 갱신되도록 설정해 주세요.</small></p>
			</div>
		</div>

		<div class="page-header">
			<h4>이메일</h4>
		</div>

		<div class="form-group">
			<label for="" class="col-sm-2 control-label">Mail Type</label>
			<div class="col-sm-9">
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-default<?php if(!$d['admin']['smtp_use']):?> active<?php endif?>" data-toggle="tab" data-target="#mail-sendmail">
						<input type="radio" name="smtp_use" value=""<?php if(!$d['admin']['smtp_use']):?> checked<?php endif?>> Sendmail
					</label>
					<label class="btn btn-default<?php if($d['admin']['smtp_use']=='1'):?> active<?php endif?>" data-toggle="tab" data-target="#mail-smtp" data-tooltip="tooltip" title="SMTP 계정이 필요합니다.">
						<input type="radio" name="smtp_use" value="1"<?php if($d['admin']['smtp_use']=='1'):?> checked<?php endif?>> SMTP
					</label>
				</div>
			</div>
		</div>

		<div class="tab-content" style="border:none;padding:0">
			<div id="mail-sendmail" class="tab-pane clearfix<?php if(!$d['admin']['smtp_use']):?> active<?php endif?>">
				<div class="col-md-offset-2 col-md-9">
					<p class="form-control-static">
						<small class="text-muted">호스팅 서버환경에서는 발송메일이 스펨으로 분류되어 차단될 수 있습니다.</small>
					</p>
				</div>
			</div>
			<div id="mail-smtp" class="tab-pane clearfix<?php if($d['admin']['smtp_use']=='1'):?> active<?php endif?>">
				<div class="form-group">
					<label class="col-sm-2 control-label">SMTP Server</label>
					<div class="col-sm-9">
					<input class="form-control" type="text" name="smtp_host" value="<?php echo $d['admin']['smtp_host']?>" placeholder="예) smtp.mail.com">
						<p class="form-control-static"><small class="text-muted"></small></p>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">SMTP Port</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="smtp_port" value="<?php echo $d['admin']['smtp_port']?>" placeholder="" style="width:100px">
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-9">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="smtp_auth" value="1"<?php if($d['admin']['smtp_auth']):?> checked<?php endif?>> <i></i>SMTP 인증 필요
							</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">인증 아이디</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="smtp_user" value="<?php echo $d['admin']['smtp_user']?>" placeholder="인증 아이디">
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">인증 암호</label>
					<div class="col-sm-9">
						<input type="password" class="form-control" name="smtp_pass" value="<?php echo $d['admin']['smtp_pass']?>" placeholder="인증 암호">
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					<button type="button" class="btn btn-default" id="smtpbtn" onclick="sendCheck(this.id);"><?php if($d['admin']['smtp']):?><i class="fa fa-info-circle fa-lg fa-fw"></i>정상<?php else:?>SMTP 연결확인<?php endif?></button>
					<p class="form-control-static"><small class="text-muted">시스템 대표메일로 전송이 되면 메일서버가 정상 작동되는 상태입니다.</small></p>
					</div>
				</div>

	    	</div>
    	</div>
 
		<div class="page-header">
			<h4>FTP </h4>
		</div>

		<div class="form-group">
			<label for="" class="col-sm-2 control-label">FTP 계정</label>
			<div class="col-sm-9">

				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-default<?php if(!$d['admin']['ftp_use']):?> active<?php endif?>" data-toggle="tab" data-target="#ftp-nobody">
						<input type="radio" name="ftp_use" value=""<?php if(!$d['admin']['ftp_use']):?> checked<?php endif?>> Nobody 
					</label>
					<label class="btn btn-default<?php if($d['admin']['ftp_use']=='1'):?> active<?php endif?>" data-toggle="tab" data-target="#ftp-user">
						<input type="radio" name="ftp_use" value="1"<?php if($d['admin']['ftp_use']=='1'):?> checked<?php endif?>> User
					</label>
				</div>


			</div>
		</div>

		<div class="tab-content" style="border:none;padding:0">
			<div id="ftp-nobody" class="tab-pane clearfix<?php if(!$d['admin']['ftp_use']):?> active<?php endif?>">
				<div class="col-md-offset-2 col-md-9">
					<p class="form-control-static">
						<small class="text-muted">일부기능에 제한이 있거나 보안에 취약할 수 있습니다.</small>
					</p>
				</div>
			</div>	
			<div id="ftp-user" class="tab-pane clearfix<?php if($d['admin']['ftp_use']=='1'):?> active<?php endif?>">

				<div class="form-group">
					<label class="col-sm-2 control-label">FTP Type</label>
					<div class="col-sm-9">
						<select name="ftp_type" class="form-control" onchange="ftp_select(this);">
						<option value=""<?php if(!$d['admin']['ftp_type']):?> selected<?php endif?>>FTP</option>
						<option value="sftp"<?php if($d['admin']['ftp_type']=='sftp'):?> selected<?php endif?>>SFTP</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">FTP Server</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="ftp_host" value="<?php echo $d['admin']['ftp_host']?>" placeholder="예) example.kimsq.com  또는 IP adress 입력">
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">FTP Port</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="ftp_port" value="<?php echo $d['admin']['ftp_port']?$d['admin']['ftp_port']:'21'?>" placeholder="" style="width:100px;">
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-9">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="ftp_pasv" value="1"<?php if($d['admin']['ftp_pasv']):?> checked<?php endif?>> <i></i>Passive Mode
							</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">FTP ID</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="ftp_user" value="<?php echo $d['admin']['ftp_user']?>" placeholder="FTP ID">
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">Password</label>
					<div class="col-sm-9">
						<input type="password" class="form-control" name="ftp_pass" value="<?php echo $d['admin']['ftp_pass']?>" placeholder="Password">
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">킴스큐 경로</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="ftp_rb" value="<?php echo $d['admin']['ftp_rb']?>" placeholder="">
						<p class="form-control-static">
							<small class="text-muted">
								FTP로 접속했을때 처음 접속된 경로부터 킴스큐Rb가 설치된 경로를 입력해 주세요.<br>
								경로의 처음과 마지막은 반드시 슬래쉬(/)로 끝나야 합니다.<br>
								보기)<code>/rb/</code> 또는 <code>/www/rb/</code> 또는 <code>/public_html/rb/</code> <a href="#.">자세히 알아보기</a><br>
							</small>
						</p>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="button" class="btn btn-default" id="ftpbtn" onclick="sendCheck(this.id);"><?php if($d['admin']['ftp']):?><i class="fa fa-info-circle fa-lg fa-fw"></i>정상<?php else:?>FTP 연결확인<?php endif?></button>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-md-offset-2 col-md-9">
				<button class="btn btn-primary btn-lg btn-block" type="submit">저장하기</button>
			</div>
		</div>
	</form>
</div>
<div class="hidden"><iframe name="_autosave_"></iframe></div>



<!-- basic -->
<script>
var submitFlag = false;
function sendCheck(id)
{
	if (submitFlag == true)
	{
		alert('응답을 기다리는 중입니다. 잠시 기다려 주세요.');
		return false;
	}
	var f = document.sendForm;
	var f1 = document.procForm;
	if (id == 'sendmailbtn' || id == 'smtpbtn')
	{
		if (f.email.value == '')
		{
			alert('시스템 이메일 주소를 입력해 주세요.       ');
			f.email.focus();
			return false;
		}
	}
	if (id == 'smtpbtn')
	{
		if (f1.smtp_host.value == '')
		{
			alert('SMTP 서버주소를 입력해 주세요.   ');
			f.smtp_host.focus();
			return false;
		}
		if (f1.smtp_port.value == '')
		{
			alert('SMTP 포트번호를 입력해 주세요.    ');
			f.smtp_port.focus();
			return false;
		}
		if (f1.smtp_user.value == '')
		{
			alert('인증 아이디를 입력해 주세요.     ');
			f.smtp_user.focus();
			return false;
		}
		if (f1.smtp_pass.value == '')
		{
			alert('인증 암호를 입력해 주세요.    ');
			f.smtp_pass.focus();
			return false;
		}
	}
	if (id == 'ftpbtn')
	{
		if (f1.ftp_host.value == '')
		{
			alert('FTP 서버주소를 입력해 주세요.   ');
			f1.ftp_host.focus();
			return false;
		}
		if (f1.ftp_port.value == '')
		{
			alert('FTP 포트번호를 입력해 주세요.    ');
			f.ftp_port.focus();
			return false;
		}
		if (f1.ftp_user.value == '')
		{
			alert('FTP 아이디를 입력해 주세요.     ');
			f.ftp_user.focus();
			return false;
		}
		if (f1.ftp_pass.value == '')
		{
			alert('FTP 암호를 입력해 주세요.    ');
			f.ftp_pass.focus();
			return false;
		}
	}

	f.type.value = id;
	getId(id).innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
	getIframeForAction(f);
	f.submit();
}
function ftp_select(obj)
{
	if (obj.value == '') obj.form.ftp_port.value = '21';
	else obj.form.ftp_port.value = '22';
}
function saveCheck(f)
{
	getIframeForAction(f);
	return confirm('정말로 실행하시겠습니까?         ');
}
</script>

