<div class="searcher-app mp-sticky">
	<div class="container">
	    
	    <a href="/"><img id="mp-logo" src="/img/mp-logo.svg" /></a>
	    
	    <ul class="app-icons left">
		    <li><a href="#" class="_mPAppIcon" data-icon="&#xe600;"></a></li>
		    <li><a href="#" class="_mPAppIcon" data-icon="&#xe61e;"></a></li>
		    <li><a href="#" class="_mPAppIcon" data-icon-applications="&#xe60a;"></a></li>
	    </ul>
	    
	    <? /*
	    <div class="search-main input-group size-sm">
            <input type="text" required="" autocomplete="off" data-searchtag="" data-autocompletion="true" data-url="/dane" data-dataset="*" name="q" placeholder="Szukaj..." class="form-control hasclear input-sm clearer-on ui-autocomplete-input">
                                <a href="/dane" class="clearer">
                    <span aria-hidden="true" class="form-control-feedback" style="display: none;">×</span>
                </a>
                            <div class="input-group-btn">
                <button type="submit" class="btn btn-primary input-sm" style="visibility: hidden;">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </div>
        </div>
        */ ?>
        
        <ul class="app-icons right">
		    <li><a href="#" class="_mPAppIcon" data-icon-applications="&#xe60b;"></a></li>
		    <li><a href="#" class="_mPAppIcon" data-icon-applications="&#xe60a;"></a></li>
		    <li class="login">
		    	<img class="_s0 _2dpc _rw img" src="https://scontent-frt3-1.xx.fbcdn.net/hprofile-frc3/v/t1.0-1/c153.25.545.545/s50x50/601067_10150839264495706_607337381_n.jpg?oh=8af0b20120dce777ed8dc0cc3876863c&amp;oe=56E264DA" alt="" id="profile_pic_header_616010705">
		    	<p>Daniel Macyszyn</p>
		    </li>
	    </ul>
	    
	    <? /*$this->element('Dane.DataBrowser/browser-searcher', array(
	    	'size' => 'md',
	    ));*/ ?>
	</div>
</div>
		
<? if( isset($this->request->query['q']) && @isset($app_menu) ) {?>
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