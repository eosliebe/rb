<?php
$package_step = $package_step ? $package_step : 1;
$package_type = $package_type ? $package_type : 1;

?>

<style>

#modal-package-install,
#modal-package-install h4 {
    font-family: 'Open Sans', "돋움", dotum !important;
} {
    font-family: 'Open Sans', "돋움", dotum !important;
}

#modal-package-install .modal-body {
    min-height: 400px;
    max-height: calc(100vh - 175px);
    overflow-y: auto;
    padding: 15px
}

#modal-package-install .tab-content {
    padding: 20px 0
}


/* breadcrumb */

#modal-package-install .breadcrumb {
    margin: -15px -15px 15px;
    border-radius: 0;
    padding: 10px 15px;
}

#modal-package-install .breadcrumb a {
    color: #999;
}

#modal-package-install .breadcrumb a:hover {
    text-decoration: none;
}

#modal-package-install .breadcrumb .active a{
    color: #428bca;
    font-weight: bold;
}

#modal-package-install .breadcrumb .badge {
    background-color: #999;
}

#modal-package-install .breadcrumb .active .badge {
    background-color: #428bca;
}


#modal-package-install h4 {
    line-height: 1.5
}

#modal-package-install .page-header {
    margin-top: 20px;
}

#modal-package-install .list-group {
    margin-bottom: 10px; 
}

#modal-package-install .rb-icon {
    font-size: 70px
}

#modal-package-install .label {
    display: inline;
    padding: .2em .6em .3em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25em;
}

#modal-package-install .pager {
    margin: 0; 
}




/* tab2 */

#tab2 .well {
    margin-bottom: 10px
}

#tab2 .panel-heading a {
    display: inline-block;
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
}

#tab2 .panel-heading a {
    color: #666;
    display: block;
}
#tab2 .panel-heading a:hover {
    text-decoration: none;
}

#tab2 .panel-heading span:before {
    content: " \f078";
}
#tab2 .panel-heading .collapsed span:before {
    content: " \f054";
}


/* responsive */

@media (min-width: 992px) {
    .modal-lg {
        width: 780px;
    }
}

@media (max-width: 768px) {

    #modal-package-install .breadcrumb .badge {
        padding: 5px 15px
    }

    #modal-package-install .breadcrumb .badge {
        font-size: 18px
    }

    #modal-package-install .rb-icon {
        font-size: 40px
    }

    #modal-package-install .tab-content {
        padding: 0
    }

    #tab1 .btn {
        display: block;
        width: 100%
    }
}



/* 김성호 */
#modal-package-install ul {
	padding: 0;
	margin: 0;
	list-style-type: none;
	background: #f5f5f5;
	padding: 10px 0 10px 30px;
	height: 40px;
}
#modal-package-install ul {
	color: #999;
}
#modal-package-install ul .active {
	font-weight:bold;
	color: #428BCA;
}
#modal-package-install ul .active .badge {
	background: #428BCA;
}
#modal-package-install ul li {
	float: left;
	margin-right: 15px;
}

#modal-package-install .modal-body {
	padding: 0;
}
#modal-package-install .tab-content {
	clear: both;
	padding: 40px 20px 0 20px;
}
</style>




<div id="modal-package-install">
	<div class="modal-body">

		<ul>
			<li<?php if($package_step==1):?> class="active"<?php endif?>><span class="badge">1단계</span> <span>패키지 업로드</span></li>
			<li<?php if($package_step==2):?> class="active"<?php endif?>><span class="badge">2단계</span> <span>설치하기</span></li>
			<li<?php if($package_step==3):?> class="active"<?php endif?>><span class="badge">3단계</span> <span>완료</span></li>
		</ul>






		<div class="tab-content">
			
			<?php if($package_step==1):?>
			<div id="tab1">

				<div class="row">
					<div class="col-sm-4 text-center rb-icon">
						<i class="fa fa-upload fa-3x"></i>
						<h4 class="text-center text-muted">
							<!--패키지 파일을<br>업로드 해주세요-->
							패키지를 설치할<br>
							준비가 되었습니다.
						</h4>
					</div>           

					<div class="col-sm-8">

						<!--
						<div class="alert alert-warning" role="alert">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<i class="fa fa-exclamation-circle fa-lg"></i> 패키지 형식이 맞지 않습니다.
						</div>
						-->

						<div class="attach well form-horizontal">
							<!--
							<div class="row">
								<div class="col-sm-3">
									<button type="file" class="btn btn-default">파일선택</button>
								</div>
								<div class="col-sm-9" style="padding-top:7px">
									<div class="progress progress-striped active">
										<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
											<span class="sr-only">60% Complete</span>
										</div>
									</div>
								</div>
							</div>
							-->
							<?php if($package_type==1):?>
							<ul class="list-group attach-list">
								<li class="list-group-item">
									<i class="fa fa-file-archive-o"></i> rb_package_bootstrap_starter.zip &nbsp;&nbsp;<span class="label label-default">1211.5kB</span>
								</li>
							</ul>
							<?php endif?>
							<?php if($package_type==2):?>
							<ul class="list-group attach-list">
								<li class="list-group-item">
									<i class="fa fa-file-archive-o"></i> rb_package_bcamp.zip &nbsp;&nbsp;<span class="label label-default">433.5kB</span>
								</li>
							</ul>
							<?php endif?>

						</div>

						<ul>
							<li>패키지는 최상위폴더 이하에 압축폴더 경로에 맞춰서 등록됩니다.</li>
							<li>동일명칭의 폴더나 파일이 존재할 경우 덧씌워지므로 주의하세요.</li>
							<li>패키지의 형식은 <code>rb_package_자료코드.zip</code> 이어야 합니다.</li>
							<li>업로드가 완료되었다면, '다음' 버튼을 클릭해주세요</li>
						</ul>
					</div>
				</div>

			</div>
			<?php endif?>


















			<?php if($package_step==2):?>
			<div id="tab2">

				<div class="row">
					<div class="col-sm-4 text-center rb-icon">
						<i class="fa fa-cube fa-3x"></i>
						<h4 class="text-center text-muted">
							패키지를 적용할 준비가<br>완료 되었습니다.
						</h4>
					</div>           

					<div class="col-sm-8">

						<form class="form-horizontal" role="form">

							<div class="well">
								<div class="form-group">
									<label for="" class="col-sm-3 control-label">패키지명</label>
									<div class="col-sm-9">
										<p class="form-control-static">
										<?php if($package_type==1):?>Bootstrap Starter Pack for kimsQ Rb<?php endif?>
										<?php if($package_type==2):?>Bcamp Pack for kimsQ Rb<?php endif?>										
										</p>
									</div>
								</div>


								<div class="form-group">
									<label for="" class="col-sm-3 control-label">적용사이트</label>
									<div class="col-sm-8">
										<select id="siteid" class="form-control">
											<option value="">신규생성 후 적용</option>
											<option value="">-----------------------</option>
											<?php $_SITES_ALL = getDbArray($table['s_site'],'','*','gid','asc',0,1)?>
											<?php while($_R = db_fetch_array($_SITES_ALL)):?>
											<option value="<?php echo $_R['id']?>"><?php echo $_R['name']?></option>
											<?php endwhile?>
										</select>
										<span class="help-block">운영중인 사이트에는 적용하지 마십시오.</span>
									</div>
								</div>
							</div>


							<div class="panel panel-default">
								<div class="panel-heading">
									<a class="collapsed" data-toggle="collapse" href="#package-options"><i class="fa fa-cog"></i> 세부설정<span class="pull-right"></span></a>
								</div>
								<div class="panel-body collapse" id="package-options">
									<div class="form-group">
										<label for="" class="col-sm-3 control-label">설치요소</label>
										<div class="col-sm-9">
											<div class="checkbox">
												<label>
													<input type="checkbox" value="">
													<span class="label label-default">Layout</span> bootstrap-starter
												</label>
											</div>
											<div class="checkbox disabled">
												<label>
													<input type="checkbox" value="" disabled>
													<span class="label label-default">switch-head</span> bootstrap
												</label>
											</div>
											<div class="checkbox disabled">
												<label>
													<input type="checkbox" value="" disabled>
													<span class="label label-default">switch-head</span> favicon-touch
												</label>
											</div>
											<div class="checkbox disabled">
												<label>
													<input type="checkbox" value="" disabled>
													<span class="label label-default">switch-foot</span> bootstrap
												</label>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label for="" class="col-sm-3 control-label">옵션</label>
										<div class="col-sm-9">
											<div class="checkbox">
												<label>
													<input type="checkbox" value="" checked>
													사이트 설정값을 패키지 기본설정값으로 적용합니다.
												</label>
											</div>
											<div class="checkbox">
												<label>
													<input type="checkbox" value="" checked>
													패키지에 포함된 메뉴를 생성합니다. 
													<span class="help-block">(적용사이트의 기존 메뉴는 삭제 )</span>
												</label>
												
											</div>
											<div class="checkbox">
												<label>
													<input type="checkbox" value="" checked>
													패키지에 포함된 페이지를 생성합니다. 
													<span class="help-block">(기존페이지는 유지)</span>
												</label>
											</div>
											<div class="checkbox">
												<label>
													<input type="checkbox" value="" checked>
													패키지에 포함된 포럼을 생성합니다. 
													<span class="help-block">(기존 포럼은 유지)</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>


						</form>

					</div>
				</div>

			</div>
			<?php endif?>








			<?php if($package_step==3):?>
			<div id="tab3">

				<div class="row">
					<div class="col-sm-4 text-center rb-icon">
						<i class="fa fa-home fa-3x"></i>
						<h4 class="text-center text-muted">
							설치가 완료 되었습니다.
						</h4>
					</div>           

					<div class="col-sm-8">


						<div class="text-center">
							<br><br>
							<a href="<?php echo $g['s']?>/?r=<?php echo $siteid?>&amp;panel=Y" class="btn btn-primary btn-lg" target="_parent"><i class="fa fa-share"></i> 사이트 접속하기</a>
							<br><br>
							<hr>
							<?php echo urldecode($package_name)?> 패키지가<br>
							<strong><?php echo urldecode($site_name)?></strong>에 설치 완료 되었습니다.
						</div>



					</div>
				</div>

			</div>
			<?php endif?>











		</div>
		
	</div>
</div>




<form name="packageAddForm" action="<?php echo $g['s']?>/" method="post" target="_package_iframe_">
<input type="hidden" name="r" value="<?php echo $r?>" />
<input type="hidden" name="m" value="module" />
<input type="hidden" name="a" value="package_aply" />
<input type="hidden" name="siteid" value="" />
<input type="hidden" name="package_type" value="<?php echo $package_type?>" />
<input type="hidden" name="package_name" value="<?php echo $package_type==1?'Bootstrap Starter Pack for kimsQ Rb':'Bcamp Pack for kimsQ Rb'?>" />


</form>
<iframe name="_package_iframe_" width="1" height="1" frameborder="0" scrolling="no"></iframe>




<!----------------------------------------------------------------------------
@부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴
----------------------------------------------------------------------------->

<div id="_modal_header" class="hidden">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><i class="fa fa-plus-circle fa-lg"></i> Site Package Install</h4>
</div>
<div id="_modal_footer" class="hidden">
	<?php if($package_step==3):?>
	<button type="button" class="btn btn-default" disabled>취소</button>
	<button type="button" class="btn btn-primary" disabled>완료</button>
	<?php else:?>
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">취소</button>

	<?php if($package_step==1):?>
	<button type="button" class="btn btn-primary" onclick="frames._modal_iframe_modal_window.nextStep();">다음</button>
	<?php endif?>

	<?php if($package_step==2):?>
	<button type="button" class="btn btn-primary" onclick="frames._modal_iframe_modal_window.install();">다음</button>
	<?php endif?>

	<?php endif?>
</div>

	


<script type="text/javascript">
//<![CDATA[
function nextStep()
{
	location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=Y&m=admin&module=module&front=modal.package&package_type=<?php echo $package_type?>&&package_step=2';
}
function install()
{
	var f = document.packageAddForm;
	f.siteid.value = getId('siteid').value;
	f.submit();
}
function modalSetting()
{
	parent.getId('modal_window_dialog_modal_window').style.width = '800px'; //모달창 가로폭
	parent.getId('_modal_iframe_modal_window').style.height = '390px'; //높이(px)

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
/*
parent.window.onresize = function()
{
	var w = parent.document.body.scrollWidth;
	var h = parent.document.body.scrollHeight;
	if(w < 500)
	{
		parent.getId('modal_window_dialog_modal_window').style.width = '100%';
		parent.getId('_modal_iframe_modal_window').style.height = h + 'px';
	}
	else
	{
		parent.getId('modal_window_dialog_modal_window').style.width = '800px';
		parent.getId('_modal_iframe_modal_window').style.height = '460px'; //높이(px)
	}
}
*/
modalSetting();
//]]>
</script>


