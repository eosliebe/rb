<!-- Lazy Load XT :  http://ressio.github.io/lazy-load-xt -->
<?php getImport('lazy-load-xt','jquery.lazyloadxt.min',false,'js')?>
<?php getImport('lazy-load-xt','jquery.lazyloadxt.bg',false,'js')?>


<?php include  $g['path_layout'].$d['layout']['dir'].'/_includes/header.php' ?>

<div class="container-fluid" id="content">
<?php include __KIMS_CONTENT__ ?>
</div>

<?php include  $g['path_layout'].$d['layout']['dir'].'/_includes/footer.php' ?>

<!-- smooth-scroll : https://github.com/cferdinandi/smooth-scroll -->
<?php getImport('smooth-scroll','smooth-scroll',false,'js')?>

<script>
smoothScroll.init({
	speed: 1000,
	easing: 'easeInOutCubic',
	offset: 0,
	updateURL: false,
	callbackBefore: function ( toggle, anchor ) {},
	callbackAfter: function ( toggle, anchor ) {}
});
</script>
