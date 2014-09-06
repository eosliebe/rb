<?php
$d['magent']= file($g['path_var'].'mobile.agent.txt');
$g['mobile'] = isMobileConnect($_SERVER['HTTP_USER_AGENT']);
?>


<?php if ($g['mobile']):?>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,target-densitydpi=medium-dpi" />
<div class="_mobile">
<?php else:?>
<div>
<?php endif?>
<div id="lang">
<div class="box">
<form action="./" method="post">
Language : 
<select name="sitelang" onchange="this.form.submit();">
<?php $sitelang = $sitelang ? $sitelang : $g['sys_lang']?>
<?php include_once $g['path_var'].'language/'.$sitelang.'/_install.lang.php'?>
<?php $dirs = opendir($g['path_var'].'language/')?>
<?php while(false !== ($tpl = readdir($dirs))):?>
<?php if($tpl=='.'||$tpl=='..')continue?>
<option value="<?php echo $tpl?>"<?php if($sitelang==$tpl):?> selected="selected"<?php endif?> title="<?php echo $tpl?>">ㆍ<?php echo implode('',file($g['path_var'].'language/'.$tpl.'/name.txt'))?></option>
<?php endwhile?>
<?php closedir($dirs)?>
</select>
</form>
</div>
</div>
<div id="header">

	<h1>kimsQ-Rb Install</h1>

</div>
<div id="container">
<div class="snb">

	<ul>
	<li id="li1" class="lix_now"><?php echo $lang['install']['licence']?></li>
	<li id="li2" class="lix"><?php echo $lang['install']['db']?></li>
	<li id="li3" class="lix"><?php echo $lang['install']['user']?></li>
	<li id="li4" class="lix"><?php echo $lang['install']['site']?></li>
	</ul>

</div>
<div id="content">

	<form name="procForm" action="./" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return installCheck(this);">
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="a" value="install" />
	<input type="hidden" name="sitelang" value="<?php echo $sitelang?>" />


	<div id="step1">

		<h2><?php echo $lang['install']['licence']?></h2>

		<?php if ($g['mobile']):?>
		<div class="langselect">
		Language : 
		<select name="sitelang" onchange="location.href='./?sitelang='+this.value;">
		<?php $sitelang = $sitelang ? $sitelang : $g['sys_lang']?>
		<?php include_once $g['path_var'].'language/'.$sitelang.'/_install.lang.php'?>
		<?php $dirs = opendir($g['path_var'].'language/')?>
		<?php while(false !== ($tpl = readdir($dirs))):?>
		<?php if($tpl=='.'||$tpl=='..')continue?>
		<option value="<?php echo $tpl?>"<?php if($sitelang==$tpl):?> selected="selected"<?php endif?> title="<?php echo $tpl?>">ㆍ<?php echo implode('',file($g['path_var'].'language/'.$tpl.'/name.txt'))?></option>
		<?php endwhile?>
		<?php closedir($dirs)?>
		</select>
		</div>
		<?php endif?>

		<div class="guide">
			<?php echo $lang['install']['msg1_1']?><br />
			<?php echo $lang['install']['msg1_2']?>
		</div>
		
		<div class="stepbody">
		<textarea class="licence" rows="10" cols="50"><?php readfile('LICENSE')?></textarea>
		
		<div class="agreebox shift">
		<input type="checkbox" id="licence_agree" onclick="agreeCheck(this);" /><label for="licence_agree"><?php echo $lang['install']['msg1_3']?></label>
		</div>
		</div>

		<div class="bottom">
			<input type="button" value="<?php echo $lang['install']['prev']?>" disabled="disabled" />
			<input type="button" value="<?php echo $lang['install']['next']?>" id="next_01" disabled="disabled" onclick="goStep(2);" />
		</div>
	</div>

	<div id="step2" class="hide">

		<h2><?php echo $lang['install']['db']?></h2>
		<div class="guide">
			<?php echo $lang['install']['msg2_1']?><br />
			<?php echo $lang['install']['msg2_2']?>
		</div>
		<div class="stepbody">
		<table>
			<tr>
			<td class="td1"><?php echo $lang['install']['db_host']?></td>
			<td class="td2"><input type="text" name="dbhost" value="<?php echo $_SESSION['_live_dbhost']?$_SESSION['_live_dbhost']:'localhost'?>" class="input" /></td>
			</tr>
			<tr>
			<td class="td1"><?php echo $lang['install']['db_name']?></td>
			<td class="td2"><input type="text" name="dbname" value="<?php echo $_SESSION['_live_dbname']?>" class="input" /></td>
			</tr>
			<tr>
			<td class="td1"><?php echo $lang['install']['db_user']?></td>
			<td class="td2"><input type="text" name="dbuser" value="<?php echo $_SESSION['_live_dbuser']?>" class="input" /></td>
			</tr>
			<tr>
			<td class="td1"><?php echo $lang['install']['db_pw']?></td>
			<td class="td2"><input type="password" name="dbpass" value="<?php echo $_SESSION['_live_dbpass']?>" class="input" /></td>
			</tr>
			<tr>
			<td class="td1"><?php echo $lang['install']['db_port']?></td>
			<td class="td2"><input type="text" name="dbport" value="<?php echo $_SESSION['_live_dbport']?$_SESSION['_live_dbport']:'3306'?>" class="input" /></td>
			</tr>
			<tr>
			<td class="td1"><?php echo $lang['install']['db_tbl']?></td>
			<td class="td2"><input type="text" name="dbhead" value="<?php echo $_SESSION['_live_dbhead']?$_SESSION['_live_dbhead']:'rb'?>" class="input" /></td>
			</tr>
			<tr>
			<td class="td1"><?php echo $lang['install']['db_engine']?></td>
			<td class="td2">
				<select name="dbtype" onchange="engineCheck(this);">
				<option value="MyISAM">MyISAM</option>
				<option value="InnoDB">InnoDB</option>
				</select>
				<span>(<?php echo $lang['install']['db_engines']?>)</span>
			</td>
			</tr>
		</table>
		</div>
		<div class="bottom">
			<input type="button" value="<?php echo $lang['install']['prev']?>" onclick="goStep(1);" />
			<input type="button" value="<?php echo $lang['install']['next']?>" onclick="goStep(3);" />
		</div>
	</div>

	<div id="step3" class="hide">
		<h2><?php echo $lang['install']['user']?></h2>
		<div class="guide">
			<?php echo $lang['install']['msg3_1']?><br />
			<?php echo $lang['install']['msg3_2']?><br />
		</div>
		<div class="stepbody">
		<table>
			<tr>
			<td class="td1 _xd1"><?php echo $lang['install']['user_name']?></td>
			<td class="td2 _xd2"><input type="text" name="name" value="<?php echo $_SESSION['_live_name']?>" class="input" /></td>
			</tr>
			<tr>
			<td class="td1 _xd1"><?php echo $lang['install']['user_id']?></td>
			<td class="td2 _xd2"><input type="text" name="id" value="<?php echo $_SESSION['_live_id']?>" class="input" /> <span><?php echo $lang['install']['user_idrule']?></span></td>
			</tr>
			<tr>
			<td class="td1 _xd1"><?php echo $lang['install']['user_pw1']?></td>
			<td class="td2 _xd2"><input type="password" name="pw0" value="<?php echo $_SESSION['_live_pw']?>" class="input" /></td>
			</tr>
			<tr>
			<td class="td1 _xd1"><?php echo $lang['install']['user_pw2']?></td>
			<td class="td2 _xd2"><input type="password" name="pw1" value="<?php echo $_SESSION['_live_pw']?>" class="input" /></td>
			</tr>
			<tr>
			<td class="td1 _xd1"><?php echo $lang['install']['user_email']?></td>
			<td class="td2 _xd2"><input type="text" name="email" value="<?php echo $_SESSION['_live_email']?>" class="input" /></td>
			</tr>
		</table>
		<div class="guide1">
			<img src="<?php echo $g['img_core']?>/_public/ico_notice.gif" alt="" />
			<?php echo $lang['install']['msg4_1']?>
		</div>
				
		</div>
		<div class="bottom">
			<input type="button" value="<?php echo $lang['install']['prev']?>" onclick="goStep(2);" />
			<input type="button" value="<?php echo $lang['install']['next']?>" onclick="goStep(4);" />
		</div>
	</div>

	<div id="step4" class="hide">

		<h2><?php echo $lang['install']['site']?></h2>
		<div class="guide">
			<?php echo $lang['install']['msg4_2']?><br />
			<?php echo $lang['install']['msg4_3']?>
		</div>
		<div class="stepbody">
		<table>

			<tr>
			<td class="td1 _xd1"><?php echo $lang['install']['site_name']?></td>
			<td class="td2 _xd2"><input type="text" name="sitename" value="<?php echo $_SESSION['_live_sitename']?>" class="input" /></td>
			</tr>

			<tr>
			<td class="td1 _xd1"><?php echo $lang['install']['site_package']?></td>
			<td class="td2 shift _xd3">
				<input type="radio" checked="checked" /><?php echo $lang['install']['site_pack1']?><br />
				<i><input type="radio" disabled="disabled" /><?php echo $lang['install']['site_pack2']?></i><br />
				<span><input type="radio" disabled="disabled" /><?php echo $lang['install']['site_pack3']?><br /></span>
				<span><input type="radio" disabled="disabled" /><?php echo $lang['install']['site_pack4']?><br /></span>
				<i><input type="radio" disabled="disabled" /><?php echo $lang['install']['site_pack5']?></i><br />
				<i><input type="radio" disabled="disabled" /><?php echo $lang['install']['site_pack6']?></i><br />
				<div style="padding-top:15px;line-height:150%;"><?php echo $lang['install']['site_packm']?><br />
				</div>
			</td>
			</tr>

		</table>
		</div>

		<div class="bottom">
			<input type="button" value="<?php echo $lang['install']['prev']?>" onclick="goStep(3);" />
			<input type="submit" value="<?php echo $lang['install']['install']?>" />
		</div>
	</div>


	</form>


</div>
<div class="clear"></div>
</div>

<div id="footer">


</div>

</div>



<script type="text/javascript">
//<![CDATA[
function engineCheck(obj)
{
	if (obj.value == 'innoDB')
	{
		if(confirm('<?php echo $lang['install']['alert_1']?>'))
		{
			obj.value = 'innoDB';
		}
		else {
			obj.value = 'MyISAM';
		}
	}
}
function agreeCheck(obj)
{
	if (obj.checked == true)
	{
		getId('next_01').disabled = false;
	}
	else {
		getId('next_01').disabled = true;
	}
}
function goStep(n)
{
	var f = document.procForm;
	var i;
	

	if (n > 1)
	{
		document.getElementById('lang').style.display = 'none';
	}
	else {
		document.getElementById('lang').style.display = 'block';
	}
	if (n == 2)
	{
		if (getId('licence_agree').checked == false)
		{
			return false;
		}
	}
	if (n == 3)
	{
		if (f.dbhost.value == '')
		{
			alert('<?php echo $lang['install']['alert_2']?>    ');
			f.dbhost.focus();
			return false;
		}
		if (f.dbname.value == '')
		{
			alert('<?php echo $lang['install']['alert_3']?>    ');
			f.dbname.focus();
			return false;
		}
		if (f.dbuser.value == '')
		{
			alert('<?php echo $lang['install']['alert_4']?>    ');
			f.dbuser.focus();
			return false;
		}
		if (f.dbpass.value == '')
		{
			alert('<?php echo $lang['install']['alert_5']?>    ');
			f.dbpass.focus();
			return false;
		}
		if (f.dbport.value == '')
		{
			alert('<?php echo $lang['install']['alert_6']?>    ');
			f.dbport.focus();
			return false;
		}
		if (!chkIdValue(f.dbhead.value))
		{
			alert('<?php echo $lang['install']['alert_7']?>    ');
			f.dbhead.focus();
			return false;
		}
	}

	if (n == 4)
	{
		if (f.name.value == '')
		{
			alert('<?php echo $lang['install']['alert_8']?>    ');
			f.name.focus();
			return false;
		}
		if (f.id.value.length < 4 || f.id.value.length > 12 || !chkIdValue(f.id.value))
		{
			alert('<?php echo $lang['install']['alert_9']?>    ');
			f.id.focus();
			return false;
		}
		if (f.pw0.value == '')
		{
			alert('<?php echo $lang['install']['alert_10']?>    ');
			f.pw0.focus();
			return false;
		}
		if (f.pw1.value == '')
		{
			alert('<?php echo $lang['install']['alert_11']?>    ');
			f.pw1.focus();
			return false;
		}
		if (f.pw0.value != f.pw1.value)
		{
			alert('<?php echo $lang['install']['alert_12']?>    ');
			f.pw0.value = '';
			f.pw1.value = '';
			f.pw0.focus();
			return false;
		}
		if (!chkEmailAddr(f.email.value))
		{
			alert('<?php echo $lang['install']['alert_13']?>    ');
			f.email.focus();
			return false;
		}
	}

	for (i = 1; i < 5; i++)
	{
		getId('step'+i).style.display = 'none';

		getId('li'+i).style.fontWeight = 'normal';
		getId('li'+i).style.color = '#555';
		getId('li'+i).style.background = 'url() top left no-repeat';

	}
	for (i = 1; i < n; i++)
	{
		getId('li'+i).style.fontWeight = 'normal';
		getId('li'+i).style.color = '#7C9B39';
		getId('li'+i).style.background = 'url(<?php echo $g['img_install']?>/chk_01.gif) top left no-repeat';
	}


	getId('step'+n).style.display = 'block';

	getId('li'+n).style.fontWeight = 'bold';
	getId('li'+n).style.color = '#000000';
	getId('li'+n).style.background = 'url(<?php echo $g['img_install']?>/chk_02.gif) top left no-repeat';
}

var isSubmit = false;

function installCheck(f)
{
	if (isSubmit == true)
	{
		alert('<?php echo $lang['install']['alert_14']?>');
		return false;
	}
	if (f.sitename.value == '')
	{
		alert('<?php echo $lang['install']['alert_15']?>    ');
		f.sitename.focus();
		return false;
	}

	if(confirm('<?php echo $lang['install']['alert_16']?>         '))
	{
		isSubmit = true;
		return true;
	}
	return false;
}
//]]>
</script>