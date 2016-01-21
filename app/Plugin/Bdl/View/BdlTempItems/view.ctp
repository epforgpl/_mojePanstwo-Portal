<?php $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane'))); ?>
<?php $this->Combinator->add_libs('js', 'Bdl.BdlTempItems/view'); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('BdlTempItems/view', array('plugin' => 'Bdl'))); ?>
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

				<h1 class="text-center"><?= $BdlTempItem['tytul'] ?></h1>
				
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						
						<div class="temp_items">
						    <div class="hidden alert alert-success info"></div>
						    <form method="post" action="">
						        <input type="hidden" name="_method" value="PUT"/>
						        <input class="hidden wskz_id" name="id" value="<?= $id ?>">
						
						        <div class="row ">
						            <label class="">Tytuł:</label>
						        </div>
						        <div class="row">
						            <input name="tytul" class="form-control nazwa" value="<?= $BdlTempItem['tytul'] ?>">
						        </div>
						        <div class="row">
						            <label>Opis:</label>
						        </div>
						        <div class="row">
						        <textarea name="opis" id="editor" rows="3">
						                    <?= $BdlTempItem['opis'] ?>
						        </textarea>
						        </div>
						    </form>
						    <div class="row">
						        <label class="">Składniki:</label>
						    </div>
						    <div class="row">
						        <div class="col-sm-6">
						            <h4 class="text-center">Licznik</h4>
						            <ul class="licznik_list skladniki_list list-group">
						
						            </ul>
						
						        </div>
						        <div class="col-sm-6">
						            <h4 class="text-center">Mianownik</h4>
						            <ul class="mianownik_list skladniki_list list-group">
						
						            </ul>
						
						        </div>
						    </div>
						    <div class="row margin-top-30 margin-bottom-20">
						        <div class="text-center">
						            <a href="/bdl/admin" class="btn btn-md btn-primary btn-icon temp-btn"><i
						                    class="icon glyphicon glyphicon-chevron-left"></i>Powrót
						            </a> 
						            <button class="btn btn-md btn-success btn-icon temp-btn" id="bdl_temp_save_all_btn"><i
						                    class="icon glyphicon glyphicon-ok"></i>Zapisz
						            </button> 
						            <? /*
						            <button class="btn btn-md btn-success btn-icon temp-btn" id="bdl_temp_save_all_btn"><i
						                    class="icon glyphicon glyphicon-upload"></i>Zapisz i Opublikuj
						            </button>
						            */ ?>
						            <form class="remove_btn" method="POST" action="/bdl/admin/<?= $id ?>/delete">
						                <button class="btn btn-md btn-danger btn-icon temp-btn" id="bdl_temp_save_all_btn"><i
						                        class="icon glyphicon glyphicon-remove"></i>Usuń
						                </button>
						            </form>
						        </div>
						    </div>
						</div>
						
					</div>
				</div>
				

		    </div>
		</div>

	</div>
</div>