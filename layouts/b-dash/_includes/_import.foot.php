<!-- smooth-scroll : https://github.com/cferdinandi/smooth-scroll --><?php getImport('smooth-scroll','smooth-scroll',false,'js')?><!-- global js --><script src="<?php echo $g['url_layout']?>/assets/js/_global.js"></script><!-- local js --><script src="<?php echo $g['url_layout']?>/assets/js/<?php echo str_replace('.php','.js',basename($d['layout']['php']))?>"></script><!-- 사이트 풋터 코드 --><?php echo $_HS['footercode'] ?><!-- 푸터 스위치 --><?php foreach($g['switch_3'] as $_switch) include $_switch ?><div id="_box_layer_"></div><div id="_action_layer_"></div><div id="_hidden_layer_"></div><div id="_overLayer_" class="hide"></div><iframe name="_action_frame_<?php echo $m?>" width="0" height="0" frameborder="0" scrolling="no"></iframe><!-- Google Analytics --><script>    var _gauges = _gauges || [];    (function() {    var t   = document.createElement('script');        t.async = true;        t.id    = 'gauges-tracker';        t.setAttribute('data-site-id', '4f0dc9fef5a1f55508000013');        t.src = '//secure.gaug.es/track.js';        var s = document.getElementsByTagName('script')[0];        s.parentNode.insertBefore(t, s);    })();</script>