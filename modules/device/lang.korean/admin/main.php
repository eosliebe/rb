<?php 
$R = getDbData($table['s_mobile'],'','*');
?>
<div id="mobilebox">
	<form class="form-horizontal rb-form" name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $module?>" />
		<input type="hidden" name="a" value="mobile" />
		<input type="hidden" name="checkm" value="<?php echo $R['usemobile']?$R['usemobile']:0?>" />

		<div class="page-header">
			<h4>모바일 접속처리</h4>
		</div>
		<div class="form-group">
			<label for="" class="sr-only">모바일 접속처리</span></label>
			<div class="col-md-11">
				<ul class="list-inline">
					<li><i class="fa fa-tablet fa-5x"></i></li>
					<li><i class="fa fa-mobile fa-4x"></i></li>
					<li><h2>모바일 기기로 접속 시</h2></li>
				</ul>
				<div class="btn-group btn-group-lg" data-toggle="buttons">
					<a href="#usemobile-00" class="btn btn-default<?php if(!$R['usemobile']):?> active<?php endif?>" style="height:46px;font-size:18px;" data-toggle="tab">
						<input type="radio" name="usemobile" value="0"<?php if(!$R['usemobile']):?> checked="checked"<?php endif?>> 사이트별 모바일모드 적용
					</a>
					<a href="#usemobile-02" class="btn btn-default<?php if($R['usemobile']==2):?> active<?php endif?>" style="height:46px;font-size:18px;" data-toggle="tab">
						<input type="radio" name="usemobile" value="2"<?php if($R['usemobile']==2):?> checked="checked"<?php endif?>> 특정 도메인 으로 이동
					</a>
					<a href="#usemobile-01" class="btn btn-default<?php if($R['usemobile']==1):?> active<?php endif?>" style="height:46px;font-size:18px;" data-toggle="tab">
						<input type="radio" name="usemobile" value="1"<?php if($R['usemobile']==1):?> checked="checked"<?php endif?>> 특정 사이트로 연결
					</a>
				</div>
				<div class="tab-content">
					<div class="tab-pane well fade<?php if(!$R['usemobile']):?> in active<?php endif?>" id="usemobile-00">
						<p class="form-control-static">
							모바일 기기로 접속 시 사이트별로 모바일 모드를 적용할 수 있습니다.
						</p>
					</div>
					<div class="tab-pane well fade<?php if($R['usemobile']==2):?> in active<?php endif?>" id="usemobile-02">
						<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="fa fa-lg fa-fw kf kf-domain"></i></span>
							<select name="startdomain" class="form-control" style="height:50px;">
								<option value="">모바일 기기로 접속 시 연결할 도메인을 선택 하세요</option>
								<?php $SITES = getDbArray($table['s_domain'],'','*','gid','asc',0,$p)?>
								<?php while($S = db_fetch_array($SITES)):?>
								<option value="http://<?php echo $S['name']?>"<?php if('http://'.$S['name']==$R['startdomain']):?> selected<?php endif?>>ㆍ<?php echo $S['name']?></option>
								<?php endwhile?>
								<?php if(!db_num_rows($SITES)):?>
								<option value="">등록된 도메인이 없습니다.</option>
								<?php endif?>
							</select>
						</div>
						<p class="form-control-static">
							모바일 기기로 접속 시 특정 도메인을 연결할 수 있습니다.
							<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=domain&amp;type=makedomain" class="btn btn-link">도메인 추가</a>
						</p>
					</div>
					<div class="tab-pane well fade<?php if($R['usemobile']==1):?> in active<?php endif?>" id="usemobile-01">
						<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="fa fa-lg fa-fw kf kf-home"></i></span>
							<select name="startsite" class="form-control" style="height:50px;">
								<option value="">모바일 기기로 접속 시 연결할 사이트를 선택하세요.</option>
								<?php $SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p)?>
								<?php while($S = db_fetch_array($SITES)):?>
								<option value="<?php echo $S['uid']?>"<?php if($S['uid']==$R['startsite']):?> selected<?php endif?>>ㆍ<?php echo $S['name']?></option>
								<?php endwhile?>
								<?php if(!db_num_rows($SITES)):?>
								<option value="">등록된 사이트가 없습니다.</option>
								<?php endif?>
							</select>
						</div>
						<p class="form-control-static">
							모바일 기기로 접속 시 특정 사이트로 연결할 수 있습니다. 도메인은 유지 됩니다.
							<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=site&amp;type=makesite" class="btn btn-link">사이트 추가</a>
						</p>
					</div>

				</div>
			</div>
		</div>

		<div class="page-header">
			<h4>디바이스 목록</h4>
		</div>
		
		<div class="form-group">
			<label for="" class="sr-only">디바이스 목록</label>
			<div class="col-md-11">
				<textarea name="agentlist" rows="12" class="form-control"><?php echo trim(implode('',file($g['path_var'].'mobile.agent.txt')))?></textarea>
				<p class="form-control-static hidden">등록 도움말..</p>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-11">
				<button type="submit" class="btn btn-primary btn-block btn-lg">저장하기</button>
			</div>
		</div>
	
</form>
</div>

<script type="text/javascript">
//<![CDATA[
function saveCheck(f)
{
	if (f.checkm.value == '1')
	{
		if (f.startsite.value == '')
		{
			alert('시작사이트를 지정해 주세요.   ');
			f.startsite.focus();
			return false;
		}
	}
	if (f.checkm.value == '2')
	{
		if (f.startdomain.value == '')
		{
			alert('시작도메인을 지정해 주세요.   ');
			f.startdomain.focus();
			return false;
		}
	}
	if (confirm('정말로 실행하시겠습니까?         '))
	{
		getIframeForAction(f);
		$(".btn-primary").addClass("disabled");
		return true;
	}
	return false;
}
//]]>
</script>
