<nav class="rb-sidebar hidden-print">

	<?php if($_HMF['uid']):?>
	<nav class="panel panel-default rb-menu">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $_HMF['name']?></h3>
		</div>
		<?php if($_HMF['isson']):?>
		<ul class="list-group">
			<?php $_MENUS2=getDbSelect($table['s_menu'],'site='.$s.' and parent='.$_HMF['uid'].' and hidden=0 and depth=2 order by gid asc','*')?>
			<?php $_MENUSN=db_num_rows($_MENUS2)?>
			<?php while($_M2=db_fetch_array($_MENUS2)):?>
			<a href="<?php echo $_M2['joint']?$_M2['joint']:RW('c='.$_CA[0].'/'.$_M2['id'])?>" target="<?php echo $_M2['target']?>" class="list-group-item<?php if($_M2['id']==$_CA[1]):?> active<?php endif?>">
				<span class="branch"></span>
				<?php echo $_M2['name']?>
			</a>
			<?php if($_M2['isson']&&($_HM['uid']==$_M2['uid']||$_HM['parent']==$_M2['uid'])):?>
			<?php $_MENUS3=getDbSelect($table['s_menu'],'site='.$s.' and parent='.$_M2['uid'].' and hidden=0 and depth=3 order by gid asc','*')?>
			<ul class="nav">
			<?php while($_M3=db_fetch_array($_MENUS3)):?>
			<li<?php if($_M3['uid']==$_HM['uid']):?> class="active"<?php endif?>><a href="<?php echo RW('c='.$_CA[0].'/'.$_CA[1].'/'.$_M3['id'])?>" target="<?php echo $_M3['target']?>"><?php echo $_M3['name']?></a></li>
			<?php endwhile?>
			</ul>
			<?php endif?>
			<?php endwhile?>
		</ul>
		<?php endif?>
	</nav>
	<?php endif?>

	<div class="list-group">
	  <a href="<?php echo $d['layout']['sidelinkurl1']?>" class="list-group-item">
		<div class="rb-side-icon pull-right">
			<i class="fa fa-cloud-upload"></i>
		</div>
		<strong><?php echo $d['layout']['sidelinktext1']?></strong>
	  </a>
	  <a href="tel:<?php echo $d['layout']['sidelinkurl2']?>" class="list-group-item">
		<div class="rb-side-icon pull-right">
			<i class="fa fa-phone"></i>
		</div>
		<strong><?php echo $d['layout']['sidelinktext2']?></strong>
	  </a>
	</div>

</nav>