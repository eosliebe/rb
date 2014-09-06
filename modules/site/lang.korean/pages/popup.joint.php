
<div id="jointbox">

	<div class="category">
		<ul>
		<?php $MODULES = getDbArray($table['s_module'],'','*','gid','asc',0,1)?>
		<?php while($R=db_fetch_array($MODULES)):?>
		
		<?php $_jfile0 = $g['path_module'].$R['id'].'/lang.'.$_HS['lang'].'/admin/var/var.joint.php'?>
		<?php $_jfile1 = $g['path_module'].$R['id'].'/lang.'.$g['sys_lang'].'/admin/var/var.joint.php'?>
		<?php $_jfile2 = $g['path_module'].$R['id'].'/admin/_pc/var/var.joint.php'?>
		<?php if((!is_file($_jfile0)&&!is_file($_jfile1)&&!is_file($_jfile2))||strstr($cmodule,'['.$R['id'].']'))continue?>
		<?php if($smodule==$R['id']) $g['var_joint_file'] = is_file($_jfile0)?$_jfile0:(is_file($_jfile1)?$_jfile1:$_jfile2)?>

		<li<?php if($smodule==$R['id']):?> class="selected"<?php endif?>><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;system=<?php echo $system?>&amp;iframe=<?php echo $iframe?>&amp;dropfield=<?php echo $dropfield?>&amp;smodule=<?php echo $R['id']?>&amp;cmodule=<?php echo $cmodule?>"><?php echo $R['name']?><span>(<?php echo $R['id']?>)</span></a></li>
		<?php endwhile?>
		</ul>
	</div>

	<div class="content">
		
		<?php if($smodule):?>
		<?php include_once $g['var_joint_file']?>
		<?php else:?>
		<div class="none">
		<img src="<?php echo $g['img_core']?>/_public/ico_notice.gif" alt="" />
		연결할 모듈을 선택하세요.
		</div>
		<?php endif?>

	</div>
</div>



<!----------------------------------------------------------------------------
@부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴
----------------------------------------------------------------------------->

<div id="_modal_header" class="hidden">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><i class="fa fa-picture-o fa-lg"></i> 모듈 연결하기</h4>
</div>

<div id="_modal_footer" class="hidden">
	<?php if($dropButtonUrl):?>
	<button type="button" class="btn btn-default pull-left" data-dismiss="modal" aria-hidden="true" id="_modalclosebtn_">닫기</button>
	<button type="button" class="btn btn-primary" onclick="frames._modal_iframe_modal_window.dropJoint('<?php echo $dropButtonUrl?>');">모듈연결하기</button>
	<?php else:?>
	<button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true" id="_modalclosebtn_">닫기</button>
	<?php endif?>
</div>
	



<script type="text/javascript">
//<![CDATA[
function dropJoint(m)
{
	var f = parent.getId('<?php echo $dropfield?>');
	f.value = m;
	parent.$('#modal_window').modal('hide');
}
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