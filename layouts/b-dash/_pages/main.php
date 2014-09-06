<!-- rb-cover  -->
<section class="jumbotron rb-cover" id="page-top">
	<div class="container">
		<h1>B DASH CAMP 2014 </h1>
		<h1>SUMMER IN FUKUOKA</h1>
		<p>July 17th–18th, 2014</p>


		<nav class="hidden-xs rb-nav rb-nav-scrollspy" data-spy="affix" data-offset-top="235" data-scroll-header>		

			<ul class="nav list-inline">
				<?php $_MENUS1=getDbSelect($table['s_menu'],'site='.$s.' and hidden=0 and depth=1 order by gid asc limit 0,5','*')?>
				<?php while($_M1=db_fetch_array($_MENUS1)):?>
				<?php if(!$_M1['isson']):?>
				<li<?php if(in_array($_M1['id'],$_CA)):?> class="active"<?php endif?>><a data-scroll href="#<?php echo $_M1['id']//$_M1['redirect']?$_M1['joint']:RW('c='.$_M1['id'])?>" target="<?php echo $_M1['target']?>"><?php echo $_M1['name']?></a>
				<?php else:?>
				<li class="dropdown"><a data-scroll href="#." class="dropdown-toggle" data-toggle="dropdown"><?php echo $_M1['name']?> <b class="caret"></b></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<li<?php if(!$_CA[1]&&in_array($_M1['id'],$_CA)):?> class="active"<?php endif?>><a data-scroll href="#<?php echo $_M1['id']//$_M1['redirect']?$_M1['joint']:RW('c='.$_M1['id'])?>" target="<?php echo $_M1['target']?>"><?php echo $_M1['name']?></a></li>
				<li role="presentation" class="divider"></li>
				<?php $_MENUS2=getDbSelect($table['s_menu'],'site='.$s.' and parent='.$_M1['uid'].' and hidden=0 and depth=2 order by gid asc','*')?>
				<?php while($_M2=db_fetch_array($_MENUS2)):?>
				<li<?php if(in_array($_M2['id'],$_CA)):?> class="active"<?php endif?>><a data-scroll href="#<?php echo $_M1['id']//RW('c='.$_M1['id'].'/'.$_M2['id'])?>" target="<?php echo $_M2['target']?>"><?php echo $_M2['name']?></a></li>
				<?php endwhile?>
				</ul>
				<?php endif?>
				</li>
				<?php endwhile?>
				<?php $_MENUS1=getDbSelect($table['s_menu'],'site='.$s.' and hidden=0 and depth=1 order by gid asc limit 5,100','*')?>
				<?php if(db_num_rows($_MENUS1)):?>
				<li id="lastNav"><a data-scroll href="#." class="dropdown-toggle" data-toggle="dropdown">더보기 <span class="caret"></span></a>
				<ul class="dropdown-menu dropdown-menu-right" id="collapsed">
				<?php while($_M1=db_fetch_array($_MENUS1)):?>
				<li<?php if(in_array($_M1['id'],$_CA)):?> class="active"<?php endif?>><a data-scroll href="#<?php echo $_M1['id']//$_M1['redirect']?$_M1['joint']:RW('c='.$_M1['id'])?>" target="<?php echo $_M1['target']?>"><?php echo $_M1['name']?></a>
				<?php endwhile?>
				</ul>
				</li>
				<?php endif?>
			</ul>

		</nav>

	</div>
</section>


<!-- Widgets  -->

<?php getWidget('b-dash/overview',array('title'=>'Event Overview','widgetbox'=>'event-overview')) ?>
<?php getWidget('b-dash/speakers',array('title'=>'Speakers & Moderators','widgetbox'=>'speakers-and-moderators')) ?>
<?php getWidget('b-dash/timeline',array('title'=>'Event Program','widgetbox'=>'event-program')) ?>
<?php getWidget('b-dash/gallery',array('limit'=>'5','title'=>'Previous Events','widgetbox'=>'previous-events')) ?>



<!-- animate.css : https://github.com/daneden/animate.css  -->

<link rel="stylesheet" href="<?php echo $g['s']?>/_core/opensrc/animate.css/3.1.1/animate.min.css">
<script>
$('.rb-cover h1').addClass('animated fadeInLeft');
$('.rb-section-speakers .page-header h1').addClass('animated fadeInDown');
</script>
