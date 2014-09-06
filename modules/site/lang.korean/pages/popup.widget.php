<?php 

$step_start = 1;
$pwd_start = $g['path_widget'];
$g['adm_href'] = $g['s']."/?r=".$r."&amp;system=".$system."&amp;iframe=".$iframe.($dropfield?"&amp;dropfield=".$dropfield:'').($option?"&amp;option=".$option:'').($isWcode?"&amp;isWcode=".$isWcode:'');


if ($option)
{
	$wdgvar=array();
	//$swval=explode(',',getKRtoUTF(urldecode(str_replace('[!]','&',$option))));
	$swval=explode(',',urldecode(str_replace('[!]','&',$option)));
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
    global $g,$pwd,$file,$step_start;
    
    if($step_start) { $nTab = $nTab - $step_start; }
	$css = strstr($pwd,$filepath) ? 'nowdir' : 'alldir';
	$fname1 = getKRtoUTF($files);
	$fname2 = getFolderName($filepath);

	if (is_file($filepath.'main.php'))
	{
		$img_cdir = $g['img_module_skin'].'/widget/ico_widget.gif';
		$img_odir = $g['img_core'].'/_public/ico_f1.png';
	}
	else {
		$img_cdir = $g['img_module_skin'].'/widget/close_dir.gif';
		$img_odir = $g['img_module_skin'].'/widget/open_dir.gif';
	}

    echo '<div class="dir01">';
    echo '<img src="'.$g['img_module_skin'].'/widget/blank.gif" width="'.(($nTab*17)+3).'" height="1" alt="" /> ';
    echo '<a href="'.$g['adm_href'].'&amp;pwd='.urlencode($filepath).'" title="'.$fname1.'">';
    if($state && $dir_ex) {
        echo '<img src="'.$g['img_module_skin'].'/widget/dir_closef.gif" align="absmiddle" alt="" />';
        echo ' <img src="'.$img_cdir.'" alt="" /> <span class="'.$css.'">'.$fname2;
    }
    else if (!$state && $dir_ex) {
        echo '<img src="'.$g['img_module_skin'].'/widget/dir_openf.gif" align="absmiddle" alt="" />';
        echo ' <img src="'.$img_odir.'" alt="" /> <span class="'.$css.'">'.$fname2;
    }
    else {
        echo '<img src="'.$g['img_module_skin'].'/widget/blank.gif" width="11" height="18" align="absmiddle" alt="" />';
        echo ' <img src="'.$img_cdir.'" alt="" /> <span class="'.$css.'">'.$fname2;
    }
    echo '</span></a></div>';
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


<div id="widgetbox">
	<div class="category">
		<div class="tree">
		<?php getDirlist($pwd_start,$step_start)?>
		</div>
	</div>

	<div class="content">
		
		<?php if($swidget):?>
			<?php if($option):?>
			<input type="hidden" id="s_w" value="" />
			<input type="hidden" id="s_h" value="" />
			<input type="hidden" id="s_t" value="" />
			<input type="hidden" id="s_l" value="" />
			<?php endif?>
			<?php include_once $g['path_widget'].$swidget.'/admin.php'?>
		<?php else:?>
			<div class="none">
			<img src="<?php echo $g['img_core']?>/_public/ico_notice.gif" alt="" />
			추가할 위젯을 선택하세요.
			</div>
		<?php endif?>

	</div>
</div>




<!----------------------------------------------------------------------------
@부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴
----------------------------------------------------------------------------->

<div id="_modal_header" class="hidden">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><i class="fa fa-picture-o fa-lg"></i> 위젯<?php if($isWcode=='Y'):?>코드 추출<?php else:?>추가<?php endif?></h4>
</div>

<div id="_modal_footer" class="hidden">
	<button type="button" class="btn btn-default pull-left" data-dismiss="modal" aria-hidden="true" id="_modalclosebtn_">닫기</button>

	<button type="button" class="btn btn-primary" onclick="modalSetting('.rb-modal-x','<?php echo getModalLink('upload/lang.korean/_modals/upload.tmp')?>');" data-toggle="modal" data-target=".rb-modal-x">위젯코드 추출하기</a>
	<?php if($isWcode!='Y'):?><button type="button" class="btn btn-primary" onclick="">위젯삽입</button><?php endif?>
</div>
	



<script type="text/javascript">
//<![CDATA[
function dropJoint(m)
{
	var f = opener.getId('<?php echo $dropfield?>');
	f.value = m;
	f.focus();
	top.close();
}

<?php if($swidget && $option):?>
var dp = <?php echo $dropfield?>;
var sz = opener.moveObject[dp];
getId('s_w').value = parseInt(sz.style.width);
getId('s_h').value = parseInt(sz.style.height);
getId('s_t').value = parseInt(sz.style.top);
getId('s_l').value = parseInt(sz.style.left);
<?php endif?>






function modalSetting()
{
	parent.getId('modal_window_dialog_modal_window').style.width = '700px'; //모달창 가로폭
	parent.getId('_modal_iframe_modal_window').style.height = '550px'; //높이(px)

/*
	parent.getId('modal_window_dialog_modal_window').style.position = 'absolute';
	parent.getId('modal_window_dialog_modal_window').style.display = 'block';
	parent.getId('modal_window_dialog_modal_window').style.width = '97%';
	parent.getId('modal_window_dialog_modal_window').style.top = '0';
	parent.getId('modal_window_dialog_modal_window').style.left = '0';
	parent.getId('modal_window_dialog_modal_window').style.right = '0';
	parent.getId('modal_window_dialog_modal_window').style.bottom = '0';
	parent.getId('modal_window_dialog_modal_window').children[0].style.height = '100%';
*/
	parent.getId('_modal_header_modal_window').innerHTML = getId('_modal_header').innerHTML;
	parent.getId('_modal_header_modal_window').className = 'modal-header';
	parent.getId('_modal_header_modal_window').style.background = '#3F424B';
	parent.getId('_modal_header_modal_window').style.color = '#fff';
	parent.getId('_modal_body_modal_window').style.padding = '0';
	parent.getId('_modal_body_modal_window').style.margin = '0';

/*
	parent.getId('_modal_body_modal_window').style.position = 'absolute';
	parent.getId('_modal_body_modal_window').style.display = 'block';
	parent.getId('_modal_body_modal_window').style.paddingRight = '2px';
	parent.getId('_modal_body_modal_window').style.top = '50px';
	parent.getId('_modal_body_modal_window').style.left = '0';
	parent.getId('_modal_body_modal_window').style.right = '0';
	parent.getId('_modal_body_modal_window').style.bottom = '15px';
*/
	parent.getId('_modal_footer_modal_window').innerHTML = getId('_modal_footer').innerHTML;
	parent.getId('_modal_footer_modal_window').className = 'modal-footer';
/*
	parent.getId('_modal_footer_modal_window').style.position = 'absolute';
	parent.getId('_modal_footer_modal_window').style.background = '#fff';
	parent.getId('_modal_footer_modal_window').style.width = '100%';
	parent.getId('_modal_footer_modal_window').style.bottom = '0';

	parent.getId('_modal_iframe_modal_window').style.overflow = 'hidden';
	parent.getId('_modal_iframe_modal_window').scrolling = 'no';
*/
}
modalSetting();
//]]>
</script>