<div class="searcher-app">
	<div class="container">
	    
	    <a href="/"><img id="mp-logo" src="/img/mp-logo.svg" /></a>
	    
	    <? /*$this->element('Dane.DataBrowser/browser-searcher', array(
	    	'size' => 'md',
	    ));*/ ?>
	</div>
</div>
		
<? if( @isset($app_menu) ) {?>
<div class="apps-menu">
	<div class="container">
	    <ul>
		    <? foreach($app_menu[0] as $a) { ?>
		    <li>
		    	<a<? if( isset($a['tooltip']) ) {?> data-toggle="tooltip" data-placement="bottom" title="<?= htmlspecialchars( $a['tooltip'] ) ?>"<? } ?> <? if( isset($a['active']) && $a['active'] ){?> class="active"<? } ?> href="<?= $a['href'] ?>"><? if( isset($a['glyphicon']) ) {?><span class="glyphicon glyphicon-<?= $a['glyphicon'] ?>"></span> <? } ?><?= $a['title'] ?></a>
		    </li>
		    <? } ?>
	    </ul>
	</div>
</div>
<? } ?>