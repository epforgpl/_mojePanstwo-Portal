<?php $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane'))); ?>
<?php $this->Combinator->add_libs('js', 'Bdl.BdlTempItems/index'); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('BdlTempItems/index', array('plugin' => 'Bdl'))); ?>
<?php $this->Combinator->add_libs('css', '../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5'); ?>
<?php echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.all', array('block' => 'scriptBlock')); ?>
<?php echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/locales/bootstrap-wysihtml5.pl-PL', array('block' => 'scriptBlock')); ?>

<div class="objectsPage">
	<div class="dataBrowser margin-top-0<? if (isset($class)) echo " " . $class; ?>">

		<div class="searcher-app">
			<div class="container">
			    <?= $this->element('Dane.DataBrowser/browser-searcher', array(
			    	'size' => 'md',
			    )); ?>
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

		<div class="container">
            <div class="dataBrowserContent">

				<div class="appBanner">
			        <h1 class="appTitle">Wskaźniki Żywej Kultury</h1>			
			    </div>

				<div class="row">
					<div class="col-md-10 col-md-offset-1 bdl-admin-list">
				    <? if ($BdlTempItems == false) { ?>
				       <h4 class="msg">Brak wskaźników do wyświetlenia</h4>
				    <? } else { ?>
				        <ul class="list-group lista_wskz">
				            <? foreach ($BdlTempItems as $key => $val) { ?>
				                <li class="list-group-item"><a href="/bdl/admin/<?= $key ?>"><?= isset($val['tytul']) ? $val['tytul'] : "[Nowy wskaźnik]" ?></a>
				
				                    <form class="remove_btn hidden" method="DELETE" action="/bdl/admin/<?= $key ?>/delete">
				                        <button class="btn btn-danger btn-xs pull-right" type="submit"><i
				                                class="icon glyphicon glyphicon-remove"></i></button>
				                    </form>
				                </li>
				            <? } ?>
				        </ul>
				    <? } ?>
					</div>
				</div>
				
				<div class="row text-center margin-bottom-20">
				    <p><button class="btn btn-primary btn-addnew" id="new_temp_item">Dodaj nowy wskaźnik</button></p>
				    <p><a href="/bdl">Powrót do Banku Danych Lokalnych &raquo;</a></p>
				</div>
				

		    </div>
		</div>

	</div>
</div>



<div id="temp_item_opis_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                <h4 class="modal-title">Nowy Wskaźnik:</h4>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <form method="post" action="">
                        <div class="hidden alert alert-success info"></div>
                        <div class="row "><label class="">Tytuł:</label></div>
                        <div class="row"><input name="tytul" class="form-control nazwa" value="">
                        </div>
                        <br>

                        <div class="row"><label>Opis:</label></div>
                </div>
                <textarea name="opis" id="editor">
                </textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-md btn-primary btn-icon" id="temp_item_savebtn"><i
                        class="icon glyphicon glyphicon-ok"></i>Dodaj
                </button>
                </form>
            </div>
        </div>
    </div>
</div>
