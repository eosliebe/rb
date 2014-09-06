

<!--
<?php
$RCD = getDbArray($table['s_mbrdata'],'admin=1','*','memberuid','asc',0,1);
?>


<div id="mbrlist">

	<div class="info">

		<div class="article">
			<?php echo number_format(db_num_rows($RCD))?>명(<?php echo $p?>/<?php echo $TPG?>페이지)
		</div>
		
		<div class="category">

		</div>
		<div class="clear"></div>
	</div>


	<form name="listForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return false;">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $module?>" />
		<input type="hidden" name="a" value="" />
		<input type="hidden" name="perm" value="" />

	<table class="table" summary="관리자리스트 입니다.">
		<caption class="hidden">관리자리스트</caption> 
	<thead>
		<tr>
			<th scope="col" class="side1"><img src="<?php echo $g['img_core']?>/_public/ico_check_01.gif" alt="선택/반전" class="hand" onclick="chkFlag('mbrmembers[]');" /></th>
			<th scope="col">권한</th>
			<th scope="col">접속</th>
			<th scope="col">이름</th>
			<th scope="col">닉네임</th>
			<th scope="col">아이디</th>
			<th scope="col">등급</th>
			<th scope="col">연락처</th>
			<th scope="col">최근접속</th>
			<th class="side2"></th>
		</tr>
	</thead>
	<tbody>
		<?php $_P=array()?>
		<?php while($R=db_fetch_array($RCD)):?>
		<?php $_R=getUidData($table['s_mbrid'],$R['memberuid'])?>
		<?php if($R['memberuid']==$uid)$_P=$R?>
		<tr>
			<?php if($R['memberuid']==1):?>
			<td class="side1"><input type="checkbox" disabled="disabled"></td>
			<td>-</td>
			<?php else:?>
			<td class="side1"><input type="checkbox" name="mbrmembers[]" value="<?php echo $R['memberuid']?>" /></td>
			<td><a href="<?php echo $g['adm_href']?>&amp;uid=<?php echo $R['memberuid']?>" class="u">권한</a></td>
			<?php endif?>
			<td><?php echo $R['now_log']?'Y':'N'?></td>
			<td><a href="javascript:OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=Y&m=member&front=manager&page=main&mbruid=<?php echo $R['memberuid']?>');" title="회원메니져"><?php echo $R['name']?></a></td>
			<td><a href="javascript:OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=Y&m=member&front=manager&page=post&mbruid=<?php echo $R['memberuid']?>');" title="게시정보"><?php echo $R['nic']?></a></td>
			<td><a href="javascript:OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=Y&m=member&front=manager&page=info&mbruid=<?php echo $R['memberuid']?>');" title="회원정보"><?php echo $_R['id']?></a></td>
			<td><?php echo $R['level']?></td>
			<td><?php echo $R['tel2']?$R['tel2']:$R['tel1']?></td>
			<td title="<?php echo getDateFormat($R['last_log'],'Y.m.d')?>"><?php echo -getRemainDate($R['last_log'])?>일</td>
			<td></td>
		</tr>
		<?php endwhile?>
	</tbody>
	</table>
	<div>


		<p>
			<div class="input-group">
				<input type="text" name="admin_id" value="" class="form-control" placeholder="관리자로 추가할 회원의 아이디를 입력해 주세요.">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" onclick="actQue('admin_regis');">관리자 추가</button>
					<button class="btn btn-default" type="button" onclick="actQue('admin_delete');">관리자 제외</button>
				</span>
			</div>
		</p>

		
	</form>

	<?php if($uid&&$_P['memberuid']):?>
	<div id="permdiv">
		<form name="permForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $module?>" />
		<input type="hidden" name="a" value="admin_perm" />
		<input type="hidden" name="memberuid" value="<?php echo $_P['memberuid']?>" />
		<input type="hidden" name="perm" value="" />

		<div class="tt">
			<?php echo $_P['name']?> 관리자에게 <span>접근을 제한할 모듈</span>을 선택해 주세요.
			<input type="submit" class="btnblue" value="권한처리" />
			<input type="button" class="btngray" value="취소" onclick="getId('permdiv').style.display='none';" />
			<input type="button" class="btngray" value="전체선택" onclick="chkFlag('module_members[]');" />
		</div>
		<ul>
		<?php $MODULES = getDbArray($table['s_module'],'','*','gid','asc',0,1)?>
		<?php while($_M=db_fetch_array($MODULES)):?>
		<li>
			<input type="checkbox" name="module_members[]" id="module_<?php echo $_M['id']?>" value="<?php echo $_M['id']?>"<?php if(strpos('_'.$_P['adm_view'],'['.$_M['id'].']')):?> checked="checked"<?php endif?> />
			<img src="<?php echo $g['img_core']?>/_public/ico_<?php echo $_M['hidden']?'hide':'show'?>.gif" alt="" class="eye" />
			<img src="<?php echo $g['img_core']?>/_public/ico_mobile.gif" alt=""<?php if(!$_M['mobile']):?> class="mobilehide"<?php endif?> />
			<label for="module_<?php echo $_M['id']?>"><?php echo $_M['name']?></label>
		</li>
		<?php endwhile?>
		</ul>
		<div class="clear"></div>
		</form>
	</div>
	<?php endif?>

</div>


<script type="text/javascript">
//<![CDATA[
function saveCheck(f)
{
    var l = document.getElementsByName('module_members[]');
    var n = l.length;
    var i;
	var s = '';

	for	(i = 0; i < n; i++)
	{
		if (l[i].checked == true)
		{
			s += '['+l[i].value+']';
		}
	}

	f.perm.value = s;

	return confirm('정말로 실행하시겠습니까?   ');
}
function actQue(flag)
{
	var f = document.listForm;
    var l = document.getElementsByName('mbrmembers[]');
    var n = l.length;
    var i;
	var j=0;
	
	if (flag == 'admin_delete')
	{
		for	(i = 0; i < n; i++)
		{
			if (l[i].checked == true)
			{
				j++;
			}
		}
		if (!j)
		{
			alert('제외시킬 관리자를 선택해 주세요.     ');
			return false;
		}

		if (confirm('정말로 실행하시겠습니까?         '))
		{
			f.a.value = flag;
			f.submit();
		}
	}
	if (flag == 'admin_regis')
	{
		if (f.admin_id.value == '')
		{
			alert('관리자로 추가할 회원아이디를 입력해 주세요.       ');
			f.admin_id.focus();
			return false;
		}
		f.a.value = flag;
		f.submit();
	}

	return false;
}
//]]>
</script>


-->