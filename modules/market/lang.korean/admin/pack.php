<?php
$g['arr_module_dir'] = array();
$dirs = opendir($g['path_module']);
while(false !== ($mdir = readdir($dirs)))
{
	if (strstr($mdir,'.')) continue;
	$TR = getDbData($table['s_module'],"id='".$mdir."'",'*');
	if(!$TR['id']) $g['arr_module_dir'][] = $mdir;
}
closedir($dirs);

$type = $type ? $type : 'package';
?>





<div id="modulebox">
	<div class="m_menu">
	<ul>
	<li<?php if($type=='package'):?> class="lside selected"<?php else:?> class="lside"<?php endif?>><a href="<?php echo $g['adm_href']?>&amp;type=package">패키지</a></li>
	<li<?php if($type=='layout'):?> class="selected"<?php endif?>><a href="<?php echo $g['adm_href']?>&amp;type=layout">레이아웃</a></li>
	<li<?php if($type=='module'):?> class="selected"<?php endif?>><a href="<?php echo $g['adm_href']?>&amp;type=module">모듈 <?php if(count($g['arr_module_dir'])):?><span class="num">(<?php echo count($g['arr_module_dir'])?>)</span><?php endif?></a></li>
	<li<?php if($type=='widget'):?> class="selected"<?php endif?>><a href="<?php echo $g['adm_href']?>&amp;type=widget">위젯</a></li>
	<li<?php if($type=='switch'):?> class="selected"<?php endif?>><a href="<?php echo $g['adm_href']?>&amp;type=switch">스위치</a></li>
	<li<?php if($type=='theme'):?> class="selected"<?php endif?>><a href="<?php echo $g['adm_href']?>&amp;type=theme">게시판테마</a></li>
	<li<?php if($type=='etc'):?> class="selected"<?php endif?>><a href="<?php echo $g['adm_href']?>&amp;type=etc">기타자료</a></li>
	</ul>
	<div class="clear"></div>
	</div>


<!-- 패키지 -->
<?php if($type == 'package'):?>
	<div class="m_pack">
<?php
$rulefile = './_package/package.rule.php';
if (is_file($rulefile)):
include $rulefile;
$SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p);
?>

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return packageAply(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="package_upload" />
	<input type="hidden" name="act" value="package_aply" />

	<div class="tx">
	패키지를 적용할 준비가 되었습니다.
	<?php if(is_file('./_package/readme.txt')):?>
	<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" /> <span class="u hand" onclick="layerShowHide('guide_package','block','none');">안내문서 보기</span>
	<div id="guide_package" class="readme hide">
	<textarea><?php readfile('./_package/readme.txt')?></textarea>
	</div>
	<?php endif?>
	</div>

	<div class="m_ready">
		
		<div class="tbox">
		<table>
		<tr>
		<td class="td1">패키지명 : </td>
		<td class="td2"><?php echo $d['package']['name']?></td>
		</tr>
		<tr>
		<td class="td1">설치/적용요소 : </td>
		<td class="td2 shift">
			<ul>
			<?php $_i=0;$_j=0;foreach($d['package']['elements'] as $key => $val):?>
			<li>
				<input type="checkbox" checked="checked" disabled="disabled" /><?php echo $key?>
				<?php if($val[0]):$_i++;$_INSTALLMD=getDbData($table['s_module'],"id='".$val[0]."'",'*')?>
				<?php if($_INSTALLMD['id']):?>
				<span class="u ins">설치완료</span>
				<?php else:$_j++?>
				<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=package_setting&amp;module=<?php echo $val[0]?>" target="_action_frame_<?php echo $m?>" class="u">모듈설치</a>
				<?php endif?>
				<?php endif?>
			</li>
			<?php endforeach?>
			</ul>
		</td>
		</tr>
		<tr>
		<td class="td1">적용사이트 : </td>
		<td class="td2">
			<select name="site">
			<?php while($S = db_fetch_array($SITES)):?>
			<option value="<?php echo $S['uid']?>"<?php if($r==$S['id']):?> selected="selected"<?php endif?>>ㆍ<?php echo $S['name']?>(<?php echo $S['id']?>)</option>
			<?php endwhile?>
			</select>		
		</td>
		</tr>
		<tr>
		<td class="td1"></td>
		<td class="td2 shift"><label><input type="checkbox" name="aply_site" value="1" checked="checked" />사이트 설정값을 패키지 기본설정값으로 적용합니다.</label></td>
		</tr>
		<tr>
		<td class="td1"></td>
		<td class="td2 shift"><label><input type="checkbox" name="aply_menu" value="1" checked="checked" />패키지에 포함된 메뉴를 생성합니다.(적용사이트의 기존 메뉴는 삭제)</label></td>
		</tr>
		<tr>
		<td class="td1"></td>
		<td class="td2 shift"><label><input type="checkbox" name="aply_page" value="1" checked="checked" />패키지에 포함된 페이지를 생성합니다.(기존 페이지는 유지)</label></td>
		</tr>
		<tr>
		<td class="td1"></td>
		<td class="td2 shift"><label><input type="checkbox" name="aply_bbs" value="1" checked="checked" />패키지에 포함된 게시판을 생성합니다.(기존 게시판은 유지)</label></td>
		</tr>
		<?php if($_i):?>
		<tr>
		<td class="td1"></td>
		<td class="td2 ic">신규 설치가 필요한 모듈이 있을 경우 먼저 설치해 주세요.</td>
		</tr>
		<?php endif?>
		</table>
		</div>
		
		<br />
		<br />
		<input type="button" value="적용취소" class="btngray" onclick="packageCancel();" />
		<input type="submit" value="패키지 적용하기" class="btnblue" />
		<input type="hidden" name="notInstallModule" value="<?php echo $_j?>" />


	</div>

	</form>
<?php else:?>

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="package_upload" />
	<input type="hidden" name="act" value="package_upload" />

	
	<div class="msg">
		패키지파일을 선택하신 후 등록버튼을 클릭해 주세요.<br />
		패키지는 최상위폴더 이하에 압축폴더 경로에 맞춰서 등록됩니다.<br />
		동일명칭의 폴더나 파일이 존재할 경우 덧씌워지므로 주의하세요.<br />
		패키지의 형식은 <span class="b">rb_package_자료코드.zip</span> 이어야 합니다.<br />
		<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=package_dump" target="_action_frame_<?php echo $m?>" onclick="return confirm('패키지용 샘플파일이 생성됩니다.\n자세한 패키지구성 방법은 매뉴얼을 참조하세요.  \n이 작업은 다소 시간이 걸릴 수 있습니다.\n완료될때까지 기다려주세요.');" class="ub">이 사이트를 패키지로 만들기</a>
		<?php if(is_file('./_package/dump.xml')):?>
		<br />
		<span class="ic">패키지가 생성되었습니다.</span>
		<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=package_dump&amp;del=Y" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 삭제하시겠습니까?');" class="u">삭제</a><br />	
		<?php endif?>
	</div>
	
	<div class="btnbox">
	<input type="file" name="upfile" class="upfile" />
	<input type="submit" value="등록하기" class="btnblue" />
	</div>
	</form>

<?php endif?>

	</div>

<?php endif?>
<!-- //패키지 -->


<!-- 모듈 -->
<?php if($type == 'module'):?>

	<div class="m_pack">
	<form name="procForm" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="module_pack_upload" />

	
	<div class="msg">
		패키지파일을 선택하신 후 등록버튼을 클릭해 주세요.<br />
		등록된 패키지는 아래의 대기리스트에서 확인하실 수 있으며 설치버튼을 클릭하셔야 사용가능한 정식모듈로 등록됩니다.<br />
		모듈 패키지의 형식은 <span class="b">rb_module_압축폴더명.zip</span> 이어야 합니다.
	</div>
	
	<div class="btnbox">
	<input type="file" name="upfile" class="upfile" />
	<input type="submit" value="등록하기" class="btnblue" />
	</div>
	

	</form>
	</div>

	<div class="m_ready">

	<div class="rbox">
	<?php foreach($g['arr_module_dir'] as $val):?>
	
	<div class="rmodule">
	<div class="icon" style="background:url('<?php echo getThumbImg($g['path_module'].$val.'/icon')?>') center center no-repeat;"></div>
	<div class="name"><span class="b"><?php echo getFolderName($g['path_module'].$val)?></span>(<?php echo $val?>)</div>
	<div class="tool">
	<span class="btn01"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=module_setting&amp;module=<?php echo $val?>" target="_action_frame_<?php echo $m?>" onclick="return mInstallCheck('<?php echo $val?>');">설치</a></span>
	<span class="btn01"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=pack_delete&amp;type=module&amp;pack=<?php echo $val?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 삭제하시겠습니까?');">삭제</a></span>
	</div>
	</div>
	
	<?php endforeach?>
	</div>

	<?php if(!count($g['arr_module_dir'])):?>
	<div class="none">
	<img src="<?php echo $g['img_core']?>/_public/ico_notice.gif" alt="" />
	설치 대기중인 모듈패키지가 없습니다.
	</div>
	<?php endif?>

	<div class="clear"></div>
	</div>



<?php endif?>
<!-- //모듈 -->


<!-- 레이아웃 -->
<?php if($type == 'layout'):?>

	<div class="m_pack">
	<form name="procForm" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="pack_upload" />
	<input type="hidden" name="type" value="layout" />
	<input type="hidden" name="folder" value="<?php echo $g['path_layout']?>" />

	
	<div class="msg">
		패키지파일을 선택하신 후 등록버튼을 클릭해 주세요.<br />
		패키지는 /layouts/ 에 등록됩니다.<br />
		레이아웃 패키지의 형식은 <span class="b">rb_layout_압축폴더명.zip</span> 이어야 합니다.
	</div>
	
	<div class="btnbox">
	<input type="file" name="upfile" class="upfile" />
	<input type="submit" value="등록하기" class="btnblue" />
	</div>
	</form>

	<div class="themelist">
		<div class="title">
			등록된 레이아웃들
		</div>
		<?php if($insfolder && is_file($g['path_layout'].$insfolder.'/main.php')):?>
		<div class="guide">
			마켓에서 <span class="b"><?php echo $mobile?'모바일웹용':'PC웹용'?> <?php echo getFolderName($g['path_layout'].$insfolder)?><span>(<?php echo $insfolder?>)</span></span> 레이아웃을 내려받으셨습니다.<br />
			이 레이아웃을 현재사이트(<?php echo $_HS['name']?>)의 <?php echo $mobile?'모바일웹':'PC웹'?> 대표레이아웃으로 지정하시겠습니까?<br />

			<?php if($mobile):?>
			모바일웹 미리보기를 하신 후에는 반드시 PC모드전환 버튼을 클릭해 주세요.<br />
			미리보기는 480*800(세로모드) 800*480(가로모드)로 확인할 수 있으며 실제 모바일기기 접속화면과 다를 수 있습니다.<br /><br />
			<input type="button" value="480*800px" class="btngray" onclick="getSizeWin('<?php echo $g['s']?>/?r=<?php echo $r?>&prelayout=<?php echo $insfolder?>/main',480,800);" />
			<input type="button" value="800*480px" class="btngray" onclick="getSizeWin('<?php echo $g['s']?>/?r=<?php echo $r?>&prelayout=<?php echo $insfolder?>/main',800,480);" />
			<input type="button" value="모바일웹 대표레이아웃 지정" class="btnblue" onclick="siteLayoutAply('<?php echo $insfolder?>','mobile');" />
			<input type="button" id="btnpcmodechange" class="btngray" value="PC모드전환" onclick="pcmodeChange();" />
			<?php else:?>
			미리보기는 메인화면에 대해서만 가능합니다.<br />
			<br />
			<input type="button" value="미리보기" class="btngray" onclick="window.open('<?php echo $g['s']?>/?r=<?php echo $r?>&prelayout=<?php echo $insfolder?>/main');" />
			<input type="button" value="PC모드 대표레이아웃 지정" class="btnblue" onclick="siteLayoutAply('<?php echo $insfolder?>','pc');" />
			<?php endif?>

		</div>
		<?php endif?>
		<ul>
		<?php $i=0?>
		<?php $tdir = $g['path_layout']?>
		<?php $dirs = opendir($tdir)?>
		<?php while(false !== ($skin = readdir($dirs))):?>
		<?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
		<?php $i++?>
		<li<?php if($insfolder==$skin):?> class="insfolder"<?php endif?>>
			<img src="<?php echo $g['img_core']?>/_public/ico_folder_01.gif" alt="" />
			<?php echo getFolderName($tdir.$skin)?><span>(<?php echo $skin?>)</span>
			<?php if($skin != '_blank'):?>
			<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=pack_delete&amp;type=layout&amp;pack=<?php echo $skin?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 삭제하시겠습니까?    ');"><img src="<?php echo $g['img_core']?>/_public/btn_del_s01.gif" alt="" title="레이아웃삭제" /></a>
			<?php endif?>
		</li>
		<?php endwhile?>
		<?php closedir($dirs)?>
		<?php if(!$i):?>
		<li class="none">
			<img src="<?php echo $g['img_core']?>/_public/ico_folder_01.gif" alt="" />
			등록된 레이아웃이 없습니다.
		</li>
		<?php endif?>
		</ul>
	</div>

	</div>

<?php endif?>
<!-- //레이아웃 -->



<!-- 위젯 -->
<?php if($type == 'widget'):?>
<?php 

$step_start = 1;
$pwd_start = $g['path_widget'];

if ($option)
{
	$wdgvar=array();
	$swval=explode(',',getKRtoUTF(urldecode(str_replace('[!]','&',$option))));
	$swidget=$swval[0];
	$pwd = $pwd_start.$swidget.'/';

	foreach($swval as $_cval)
	{
		$_xval=explode('^',$_cval);
		$wdgvar[$_xval[0]]=$_xval[1];
	}
}
else {
	$pwd = $pwd ? urldecode($pwd) : $pwd_start;
	$swidget = is_file($pwd.'main.php') ? str_replace($g['path_widget'],'',$pwd) : '';
	if ($swidget) $swidget = substr($swidget,0,strlen($swidget)-1);
}


if (strstr($pwd,'..'))
{
    getLink('','','정상적인 접근이 아닙니다.','close');
}
if(!is_dir($pwd))
{
	getLink('','','존재하지 않는 폴더입니다.','close');
}

function getDirexists($dir)
{
    $opendir = opendir($dir);
    while(false !== ($file = readdir($opendir)))
	{
        if(is_dir($dir.'/'.$file) && !strstr('[.][..][images][data]',$file)){$fex = 1; break;}
    }
    closedir($opendir);
    return $fex;
}
function getPrintdir( $nTab, $filepath, $files, $state ,$dir_ex)
{
    global $g,$pwd,$file,$step_start,$type,$m,$module,$r;
    
    if($step_start) { $nTab = $nTab - $step_start; }
	$css = strstr($pwd,$filepath) ? 'nowdir' : 'alldir';
	$fname1 = getKRtoUTF($files);
	$fname2 = getFolderName($filepath);

	if (is_file($filepath.'main.php'))
	{
		$img_cdir = $g['img_module_admin'].'/ico_widget.gif';
		$img_odir = $g['img_core'].'/_public/ico_f1.png';
	}
	else {
		$img_cdir = $g['img_module_admin'].'/close_dir.gif';
		$img_odir = $g['img_module_admin'].'/open_dir.gif';
	}

    echo '<div class="dir01">';
    echo '<img src="'.$g['img_module_admin'].'/blank.gif" width="'.(($nTab*17)+3).'" height="1" alt="" /> ';
    
	if (!is_file($filepath.'main.php')) echo '<a href="'.$g['adm_href'].'&amp;type='.$type.'&amp;pwd='.urlencode($filepath).'" title="'.$fname1.'">';

    if($state && $dir_ex) {
        echo '<img src="'.$g['img_module_admin'].'/dir_closef.gif" align="absmiddle" alt="" />';
        echo ' <img src="'.$img_cdir.'" alt="" /> <span class="'.$css.'">'.$fname2;
    }
    else if (!$state && $dir_ex) {
        echo '<img src="'.$g['img_module_admin'].'/dir_openf.gif" align="absmiddle" alt="" />';
        echo ' <img src="'.$img_odir.'" alt="" /> <span class="'.$css.'">'.$fname2;
    }
    else {
        echo '<img src="'.$g['img_module_admin'].'/blank.gif" width="11" height="18" align="absmiddle" alt="" />';
        echo ' <img src="'.$img_cdir.'" alt="" /> <span class="'.$css.'">'.$fname2;
    }

	if (!is_file($filepath.'main.php')) echo '</span></a>';
    else echo '</span>';

	echo '<a class="del" href="'.$g['s'].'/?r='.$r.'&m='.$module.'&amp;a=pack_delete&amp;type=widget&amp;pack='.str_replace($g['r'].'/widgets/','',$filepath).'" target="_action_frame_'.$m.'" onclick="return confirm(\'정말로 삭제하시겠습니까?    \');"><img src="'.$g['img_core'].'/_public/btn_del_s01.gif" alt="" title="테마삭제" /></a>';

	echo '</div>';
}
function getDirlist($dirpath,$nStep)
{
    global $pwd;
    $arrPath = explode('/', $pwd );

    if( $dir_handle = opendir($dirpath) )
    {
        while( false !== ($files = readdir($dir_handle)) )
        {
            $subDir = $dirpath.$files.'/';
            if(is_dir($subDir) && !strstr('[.][..][images][data]',$files))
            {
                getPrintdir( $nStep, $subDir, $files, !strstr($pwd,$subDir) , getDirexists($subDir) );
                if( $arrPath[$nStep+1] == $files ) {
                    getDirlist( $subDir, $nStep+1);
                }
            }
        }
    }
    closedir( $dir_handle );
}
?>

	<div class="m_pack">
	<form name="procForm" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="pack_upload" />
	<input type="hidden" name="type" value="widget" />
	<input type="hidden" name="folder" value="<?php echo $g['path_widget']?>" />
	<input type="hidden" name="subfolder" value="<?php echo str_replace($g['path_widget'],'',$pwd)?>" />

	
	<div class="msg">
		패키지파일을 선택하신 후 등록버튼을 클릭해 주세요.<br />
		패키지는 /widgets/ 이하 선택된 폴더 밑에 등록됩니다.<br />
		등록된 위젯들에서 등록할 폴더를 선택해 주세요.<br />
		폴더를 선택하지 않으면 위젯 최상위폴더에 등록됩니다.
		<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=widget&amp;front=main&amp;widgetAdd=Y" class="u">새분류 등록</a><br />
		위젯 패키지의 형식은 <span class="b">rb_widget_압축폴더명.zip</span> 이어야 합니다.
	</div>
	
	<div class="btnbox">
	등록위치 :<?php echo $pwd?>
	<input type="file" name="upfile" class="upfile" />
	<input type="submit" value="등록하기" class="btnblue" />
	</div>
	</form>

	<div class="themelist">
		<div class="title">
			등록된 위젯들
		</div>

		<div class="tree">
		<?php getDirlist($pwd_start,$step_start)?>
		</div>

	</div>

	</div>

<?php endif?>
<!-- //위젯 -->




<!-- 테마 -->
<?php if($type == 'theme'):?>

	<div class="m_pack">
	<form name="procForm" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="pack_upload" />
	<input type="hidden" name="type" value="bbstheme" />
	<input type="hidden" name="folder" value="<?php echo $g['path_module']?>bbs/theme/" />

	
	<div class="msg">
		패키지파일을 선택하신 후 등록버튼을 클릭해 주세요.<br />
		패키지는 /modules/bbs/theme/(_pc/_mobile)/ 에 등록됩니다.<br />
		게시판테마 패키지의 형식은 <span class="b">rb_bbstheme_압축폴더명.zip</span> 이어야 합니다.
	</div>
	
	<div class="btnbox">
	<input type="file" name="upfile" class="upfile" />
	<input type="submit" value="등록하기" class="btnblue" />
	</div>
	</form>


	<div class="themelist">
		<div class="title">
			등록된 테마들
		</div>
		<ul>
		<?php $i=0?>
		<?php $tdir = $g['path_module'].'bbs/theme/'?>
		<?php $dirs = opendir($tdir)?>
		<?php while(false !== ($skin = readdir($dirs))):?>
		<?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
		<?php $i++?>
		<li<?php if($insfolder==$skin):?> class="insfolder"<?php endif?>>
			<img src="<?php echo $g['img_core']?>/_public/ico_folder_01.gif" alt="" />
			<?php echo getFolderName($tdir.$skin)?><span>(<?php echo $skin?>)</span>
			<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=pack_delete&amp;type=bbstheme&amp;pack=<?php echo $subfolder?>/<?php echo $skin?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 삭제하시겠습니까?    ');"><img src="<?php echo $g['img_core']?>/_public/btn_del_s01.gif" alt="" title="테마삭제" /></a>
		</li>
		<?php endwhile?>
		<?php closedir($dirs)?>
		<?php if(!$i):?>
		<li class="none">
			<img src="<?php echo $g['img_core']?>/_public/ico_folder_01.gif" alt="" />
			등록된 테마가 없습니다.
		</li>
		<?php endif?>
		</ul>
	</div>



	</div>

<?php endif?>
<!-- //테마 -->


<!-- 스위치 -->
<?php if($type == 'switch'):?>
<?php
$_switchset = array(
	'start'=>'스타트 스위치',
	'top'=>'탑 스위치',
	'head'=>'헤더 스위치',
	'foot'=>'풋터 스위치',
	'end'=>'엔드 스위치'
);
?>
	<div class="m_pack">
	<form name="procForm" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="pack_upload" />
	<input type="hidden" name="type" value="switch" />
	<input type="hidden" name="folder" value="<?php echo $g['path_switch']?>" />

	
	<div class="msg">
		패키지파일을 선택하신 후 등록버튼을 클릭해 주세요.<br />
		패키지는 /switchs/ 폴더이하 지정된 스위치폴더에 등록됩니다.<br />
		스위치의 형식은 <span class="b">rb_switch_압축폴더명.zip</span> 이어야 합니다.
	</div>
	
	<div class="btnbox">
	<select name="subfolder">
	<?php foreach($_switchset as $_key => $_val):?>
	<option value="<?php echo $_key?>/"><?php echo $_val?></option>
	<?php endforeach?>
	</select>
	<input type="file" name="upfile" class="upfile" />
	<input type="submit" value="등록하기" class="btnblue" />
	</div>
	</form>

	<div class="themelist">
		<div class="title">
			등록된 스위치들
		</div>
		<ul>
		<?php foreach($_switchset as $_key => $_val):?>
		<li class="b" style="margin-top:15px;"><?php echo $_val?></li>
		<?php $i=0?>
		<?php $tdir = $g['path_switch'].$_key.'/'?>
		<?php $dirs = opendir($tdir)?>
		<?php while(false !== ($skin = readdir($dirs))):?>
		<?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
		<?php $i++?>
		<li<?php if($insfolder==$skin):?> class="insfolder"<?php endif?>>
			<img src="<?php echo $g['img_core']?>/_public/ico_folder_01.gif" alt="" />
			<?php echo getFolderName($tdir.$skin)?><span>(<?php echo str_replace('@','',$skin)?>)</span>
			<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=pack_delete&amp;type=switch&amp;pack=<?php echo $_key?>/<?php echo $skin?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 삭제하시겠습니까?    ');"><img src="<?php echo $g['img_core']?>/_public/btn_del_s01.gif" alt="" title="스위치삭제" /></a>
		</li>
		<?php endwhile?>
		<?php closedir($dirs)?>
		<?php if(!$i):?>
		<li class="none">
			<img src="<?php echo $g['img_core']?>/_public/ico_folder_01.gif" alt="" />
			등록된 스위치가 없습니다.
		</li>
		<?php endif?>
		<?php endforeach?>
		</ul>
	</div>

	</div>

<?php endif?>
<!-- //스위치 -->


<!-- 기타자료 -->
<?php if($type == 'etc'):?>

	<div class="m_pack">
	<form name="procForm" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="etc_pack_upload" />

	
	<div class="msg">
		패키지파일을 선택하신 후 등록버튼을 클릭해 주세요.<br />
		패키지는 최상위폴더 이하에 압축폴더 경로에 맞춰서 등록됩니다.<br />
		동일명칭의 폴더나 파일이 존재할 경우 덧씌워지므로(업데이트) 주의하세요.<br />
		기타자료 패키지의 형식은 <span class="b">rb_etc_자료코드.zip</span> 이어야 합니다.
	</div>
	
	<div class="btnbox">
	<input type="file" name="upfile" class="upfile" />
	<input type="submit" value="등록하기" class="btnblue" />
	</div>
	</form>


	</div>

<?php endif?>
<!-- //기타자료 -->



</div>


<script type="text/javascript">
//<![CDATA[
var submitFlag = false;
var minstall = '';
function mInstallCheck(m)
{
	if (minstall.indexOf('['+m+']') != -1)
	{
		alert('설치중입니다. 잠시만 기다려 주세요.');
		return false;
	}
	if(confirm('정말로 설치하시겠습니까?'))
	{
		minstall += '['+m+']';
		return true;
	}
	else {
		return false;
	}
}
function saveCheck(f)
{
	if (submitFlag == true)
	{
		alert('등록중입니다. 잠시만 기다려 주세요.');
		return false;
	}
	if (f.upfile.value == '')
	{
		alert('패키지 파일을 선택해 주세요.');
		f.upfile.focus();
		return false;
	}
	var extarr = f.upfile.value.split('.');
	var filext = extarr[extarr.length-1].toLowerCase();

	if (filext != 'zip')
	{
		alert('패키지는 반드시 zip압축 포맷이어야 합니다.    ');
		f.upfile.focus();
		return false;
	}

	if(confirm('정말로 등록하시겠습니까?       '))
	{
		submitFlag = true;
		return true;
	}
	else {
		return false;
	}
}
function packageCancel()
{
	if (confirm('정말로 이 패키지를 적용하지 않겠습니까?\n패키지관련 파일은 파일메니져 또는 FTP로 직접 삭제해야 합니다.'))
	{
		frames._action_frame_<?php echo $m?>.location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $module?>&a=package_upload&act=package_cancel';		
	}
}
function packageAply(f)
{
	if (f.notInstallModule.value != '0')
	{
		alert('이 패키지에 필요한 신규모듈이 있습니다.   \n먼저 설치해 주세요.');
		return false;
	}
	return confirm('정말로 적용하시겠습니까?       ');
}
function siteLayoutAply(layout,type)
{
	if (confirm('정말로 실행하시겠습니까?   '))
	{
		frames._action_frame_<?php echo $m?>.location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $module?>&a=layout_aply&layout=' + layout + '&type=' + type;
	}
}
function pcmodeChange()
{
	frames._action_frame_<?php echo $m?>.location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&m=mobile&a=mobilemode&value=X';
	getId('btnpcmodechange').className = 'btngray';
}
function getSizeWin(url,x,y)
{
	frames._action_frame_<?php echo $m?>.location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&m=mobile&a=mobilemode&value=E';
	window.open(url,'','left=0,top=0,width='+x+'px,height='+y+'px,resizable=no,scrollbars=yes,status=yes');
	getId('btnpcmodechange').className = 'btnblue';
}
//]]>
</script>



