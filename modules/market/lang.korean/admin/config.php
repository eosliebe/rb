<?php include_once $g['path_module'].$module.'/var/var.php'?>

<div id="configbox">

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="config" />

	<div class="title">
		큐마켓 기본정보
	</div>

	<table>
		<tr>
			<td class="td1">큐마켓 URL</td>
			<td class="td2">
				<input type="text" name="url" value="<?php echo $d['market']['url']?>" size="50" class="input" />
			</td>
		</tr>
	</table>



	<div class="title">
		킴스큐 회원정보
	</div>


	<table>
		<tr>
			<td class="td1">아이디 or 이메일</td>
			<td class="td2">
				<input type="text" name="id" value="<?php echo $d['market']['id']?>" size="30" class="input" />
			</td>
		</tr>
		<tr>
			<td class="td1">비밀번호</td>
			<td class="td2">
				<input type="password" name="pw" value="<?php echo $d['market']['pw']?>" size="30" class="input" />

				<div class="guide">
					킴스큐 공식사이트(www.kimsq.com)의 회원정보를 입력해 주세요.<br />
					회원정보를 등록하지 않으실 경우 자료구매,구매내역 열람이 제한됩니다.<br />
				</div>
			</td>
		</tr>
	</table>


	<div class="submitbox">
		<input type="submit" class="btnblue" value=" 확인 " />
	</div>

	</form>

</div>




<script type="text/javascript">
//<![CDATA[
function saveCheck(f)
{
	if (f.theme.value == '')
	{
		alert('테마를 선택해 주세요.       ');
		f.theme.focus();
		return false;
	}
	return confirm('정말로 실행하시겠습니까?         ');
}
//]]>
</script>

