<!DOCTYPE html>
<html lang="<?php echo $lang['sys']['lang']?>">
	<head>
		<?php include  $g['path_layout'].$d['layout']['dir'].'/_includes/_import.head.php' ?>
	</head>
	<body id="rb-body" data-spy="scroll" data-target=".rb-nav-scrollspy">

		<?php include  $g['path_layout'].$d['layout']['dir'].'/_includes/header.php' ?>

		<div class="container-fluid" id="content">
			<?php include __KIMS_CONTENT__ ?>
		</div>

		<?php include  $g['path_layout'].$d['layout']['dir'].'/_includes/footer.php' ?>

		<?php include  $g['path_layout'].$d['layout']['dir'].'/_includes/_import.foot.php' ?>
		
	</body>
</html>
