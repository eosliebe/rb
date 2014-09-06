<?php
if ($g['device']) getLink($g['s'].'/?r='.$r.'&m='.$m.'&module='.$module.'&front=mobile.shortcut','','','');

function getSwitchList($pos)
{
	$incs = array();
	$dirh = opendir($GLOBALS['g']['path_switch'].$pos);
	while(false !== ($folder = readdir($dirh))) 
	{ 
		$_fins = substr($folder,0,1);
		if(strpos('_.',$_fins) || @in_array($folder,$GLOBALS['d']['switch'][$pos])) continue;
		$incs[] = $folder;
	} 
	closedir($dirh);
	return $incs;
}


$SITES = getDbArray($table['s_site'],'','*','gid','asc',0,1);
$year	= $year		? $year		: substr($date['today'],0,4);
$month	= $month	? $month	: substr($date['today'],4,2);
$day	= $day		? $day		: substr($date['today'],6,2);


include $g['path_core'].'function/rss.func.php';
include $g['path_module'].'market/var/var.php';
$_serverinfo = explode('/',$d['market']['url']);
$_updatelist = getUrlData('http://'.$_serverinfo[2].'/__update/update.txt',10);
$_updatelist = explode("\n",$_updatelist);
$_updatelength = count($_updatelist)-1;
$_lastupdate = explode(',',trim($_updatelist[$_updatelength-1]));
$_isnewversion = is_file($g['path_var'].'update/'.$_lastupdate[1].'.txt') ? true : false;
$_version = explode('.',$d['admin']['version']);
$_gd = gd_info();
$_yesterday = date('Ymd',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-1,substr($date['today'],0,4)));
$accountQue='';
$_D1=getDbData($table['s_numinfo'],$accountQue."date='".$date['today']."'",'*');
$_D2=getDbData($table['s_numinfo'],$accountQue."date='".$_yesterday."'",'*');
$_D3=getDbData($table['bbsday'],$accountQue."date='".$date['today']."'",'*');
$_D4=getDbData($table['bbsday'],$accountQue."date='".$_yesterday."'",'*');
?>



<div class="rb-dashboard">


	<div class="alert alert-danger fade in">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<a href="http://<?php echo $_serverinfo[2]?>/r/update/<?php echo $_lastupdate[2]?>" class="alert-link"  target="_blank">Rb <?php echo $_lastupdate[0]?> - <?php echo getDateFormat($_lastupdate[1],'Y.m.d')?></a> 업데이트가 있습니다. 
		 <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=admin&amp;front=update" class="alert-link">지금 업데이트 하시겠습니까? </a>. 
	</div>




	<div class="row">

		<div class="col-md-12 col-lg-12">

			<div class="panel panel-default rb-traffic">
				<div class="panel-heading">
					<a class="rb-collapse btn btn-link" data-toggle="collapse" data-target="#wedget-01"></a>
					<h3 class="panel-title">접속통계 <small>(<?php echo getDateFormat($date['today'],'Y/m')?>)</small></h3>
				</div>
				<div  class="collapse in" id="wedget-01">
					<div class="panel-body">

						<div class="text-center text-muted" style="height: 200px; line-height: 200px">
							Line chart 삽입
						</div>

					</div>
					<div class="panel-body rb-summary">
						<div class="rb-table-column">
							<span class="rb-num">31</span>
							순방문
						</div>
						<div class="rb-table-column">
							<span class="rb-num">2</span>
							페이지뷰
						</div>
						<div class="rb-table-column">
							<span class="rb-num">2</span>
							평균뷰
						</div>
						<div class="rb-table-column">
							<span class="rb-num">2</span>
							모바일접속
						</div>
					</div>
					<div class="panel-footer rb-more"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=counter">more</a></div>
				</div>
			</div>

		</div>

		<div class="col-md-6 col-lg-6">

			<div class="panel panel-default">
				<div class="panel-heading">
					<a class="rb-collapse btn btn-link" data-toggle="collapse" data-target="#wedget-02"></a>
					<h3 class="panel-title">Referring sites</h3>
				</div>
				<div class="collapse in" id="wedget-02">
					<table id="page-list" class="table table-hover">
					        <thead>
					            <tr>
					                <th>Site</th>
					                <th class="text-center">Views</th>
					                <th class="text-center">Unique visitors</th>
					            </tr>
					        </thead>
					        <tbody>

								<tr>
									<td data-search="<?php echo $PR['name']?> <?php echo $PR['id']?> <?php echo $PR['category']?>">
										<i class="fa fa-facebook-square fa-fw fa-lg"></i>
										<a href="#">facebook.com</a>
									</td>
									<td class="text-center">6</td>
									<td class="text-center">11</td>
								</tr>
								<tr>
									<td data-search="<?php echo $PR['name']?> <?php echo $PR['id']?> <?php echo $PR['category']?>">
										<i class="fa fa-facebook-square fa-fw fa-lg"></i>
										<a href="#">m.facebook.com</a>
									</td>
									<td class="text-center">6</td>
									<td class="text-center">11</td>
								</tr>
								<tr>
									<td data-search="<?php echo $PR['name']?> <?php echo $PR['id']?> <?php echo $PR['category']?>">
										<i class="fa fa-twitter-square fa-fw fa-lg"></i>
										<a href="#">twitter.com</a>
									</td>
									<td class="text-center">6</td>
									<td class="text-center">11</td>
								</tr>
								<tr>
									<td data-search="<?php echo $PR['name']?> <?php echo $PR['id']?> <?php echo $PR['category']?>">
										<i class="fa fa-globe fa-fw fa-lg"></i>
										<a href="#">kimsq.com</a>
									</td>
									<td class="text-center">6</td>
									<td class="text-center">11</td>
								</tr>
					        </tbody>
					</table>
					<div class="panel-footer rb-more"><a href="#">more</a></div>
				</div>
				
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<a class="rb-collapse btn btn-link" data-toggle="collapse" data-target="#wedget-03"></a>
					<h3 class="panel-title">Social 미디어 공유현황 </h3>
				</div>
				<div class="panel-body collapse in" id="wedget-03">
					<div class="well text-center text-muted" style="height: 182px; line-height: 130px">Pie chart 삽입</div>
				</div>
			</div>

		</div>

		<div class="col-md-6 col-lg-6">

			<div class="panel panel-default">
				<div class="panel-heading">
					<a class="rb-collapse btn btn-link" data-toggle="collapse" data-target="#wedget-06"></a>
					<h3 class="panel-title">Popular Page</h3>
				</div>
				<div class="collapse in" id="wedget-06">
					<table id="page-list" class="table table-hover">
					        <thead>
					            <tr>
					                <th>Page</th>
					                <th class="text-center">Views</th>
					                <th class="text-center">Unique visitors</th>
					            </tr>
					        </thead>
					        <tbody>

								<tr>
									<td data-search="<?php echo $PR['name']?> <?php echo $PR['id']?> <?php echo $PR['category']?>">
										<i class="fa fa-file-text-o fa-fw fa-lg"></i>
										<a href="#">codeforseoul/seoul_serenity</a>
									</td>
									<td class="text-center">6</td>
									<td class="text-center">11</td>
								</tr>
								<tr>
									<td data-search="<?php echo $PR['name']?> <?php echo $PR['id']?> <?php echo $PR['category']?>">
										<i class="fa fa-file-text-o fa-fw fa-lg"></i>
										<a href="#">Issues</a>
									</td>
									<td class="text-center">6</td>
									<td class="text-center">11</td>
								</tr>
								<tr>
									<td data-search="<?php echo $PR['name']?> <?php echo $PR['id']?> <?php echo $PR['category']?>">
										<i class="fa fa-file-text-o fa-fw fa-lg"></i>
										<a href="#">Milestones - codeforseoul/seoul_se..</a>
									</td>
									<td class="text-center">6</td>
									<td class="text-center">11</td>
								</tr>
								<tr>
									<td data-search="<?php echo $PR['name']?> <?php echo $PR['id']?> <?php echo $PR['category']?>">
										<i class="fa fa-file-text-o fa-fw fa-lg"></i>
										<a href="#">Branches</a>
									</td>
									<td class="text-center">6</td>
									<td class="text-center">11</td>
								</tr>
					        </tbody>
					</table>
					<div class="panel-footer rb-more"><a href="#">more</a></div>
				</div>
				
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<a class="rb-collapse btn btn-link" data-toggle="collapse" data-target="#wedget-07"></a>
					<h3 class="panel-title">Popular Site</h3>
				</div>
				<div class="collapse in" id="wedget-07">
					<table id="page-list" class="table table-hover">
					        <thead>
					            <tr>
					                <th>Site</th>
					                <th class="text-center">Views</th>
					                <th class="text-center">Unique visitors</th>
					            </tr>
					        </thead>
					        <tbody>

								<tr>
									<td data-search="<?php echo $PR['name']?> <?php echo $PR['id']?> <?php echo $PR['category']?>">
										<i class="fa fa-globe fa-fw fa-lg"></i>
										<a href="#">대한주식회사</a>
									</td>
									<td class="text-center">6</td>
									<td class="text-center">11</td>
								</tr>
								<tr>
									<td data-search="<?php echo $PR['name']?> <?php echo $PR['id']?> <?php echo $PR['category']?>">
										<i class="fa fa-globe fa-fw fa-lg"></i>
										<a href="#">블로그</a>
									</td>
									<td class="text-center">6</td>
									<td class="text-center">11</td>
								</tr>
								<tr>
									<td data-search="<?php echo $PR['name']?> <?php echo $PR['id']?> <?php echo $PR['category']?>">
										<i class="fa fa-globe fa-fw fa-lg"></i>
										<a href="#">B-Dash Camp</a>
									</td>
									<td class="text-center">6</td>
									<td class="text-center">11</td>
								</tr>
								<tr>
									<td data-search="<?php echo $PR['name']?> <?php echo $PR['id']?> <?php echo $PR['category']?>">
										<i class="fa fa-globe fa-fw fa-lg"></i>
										<a href="#">레드블럭 홈페이지</a>
									</td>
									<td class="text-center">6</td>
									<td class="text-center">11</td>
								</tr>
					        </tbody>
					</table>
					<div class="panel-footer rb-more"><a href="#">more</a></div>
				</div>
				
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<a class="rb-collapse btn btn-link" data-toggle="collapse" data-target="#wedget-08"></a>
					<h3 class="panel-title">시스템 환경</h3>
				</div>
				<div class="panel-body collapse in" id="wedget-08">

					<dl class="dl-horizontal">
						<dt>웹서버</dt>
						<dd><?php echo $_SERVER['SERVER_SOFTWARE']?></dd>

						<dt>PHP 버전</dt>
						<dd><?php echo phpversion()?></dd>

						<dt>MySQL 버전</dt>
						<dd><?php echo db_info()?> (<?php echo $DB['type']?>)</dd>

						<dt>GD 버전</dt>
						<dd><?php echo $_gd['GD Version']?></dd>

						<dt>kimsQ Rb 버전</dt>
						<dd><?php echo $d['admin']['version']?></dd>
					</dl>
				</div>
				<div class="panel-footer rb-more"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=admin&amp;front=config">more</a></div>
			</div>


		</div>



	</div>



</div>


