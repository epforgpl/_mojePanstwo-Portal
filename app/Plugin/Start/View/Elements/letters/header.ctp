<div class="container">
        

	<header class="collection-header objectRender pisma">
	
	    <div class="overflow-auto">
	
	        <div class="content pull-left">
	            <span class="object-icon icon-datasets-pisma"></span>
	
	            <div class="object-icon-side">
	                <h1 data-url="<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>">
	                    <? if ($pismo['is_owner']) { ?>
	                        <div contenteditable="true" data-url="/start/letters/setDocumentName/<?= $pismo['alphaid'] ?>"
	                             class="form-control h1-editable"><?= $pismo['nazwa'] ?></div>
	                    <? } else { ?>
	                        <?= $pismo['nazwa'] ?>
	                    <? } ?>
	                </h1>
	            </div>
	        </div>
			
			<? /*
	        <ul class="buttons pull-right nopadding">
	            <li>
	                <form action="" method="post">
	                    <input type="hidden" name="delete"/>
	                    <button
	                        data-tooltip="true"
	                        data-original-title="Usuń pismo"
	                        data-placement="bottom"
	                        class="btn btn-default btnRemove btn"
	                        type="submit">
	                        <i class="glyphicon glyphicon-trash" title="Usuń pismo" aria-hidden="true"></i>
	                    </button>
	                </form>
	            </li>
	            <? if ($pismo['version'] == '2') { ?>
	                <li>
	                    <a
	                        data-tooltip="true"
	                        data-original-title="Edytuj pismo"
	                        data-placement="bottom"
	                        class="btn btn-default btnEdit btn"
	                        type="button"
	                        href="<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>/edit">
	                        <i class="glyphicon glyphicon-edit" title="Edytuj pismo" aria-hidden="true"></i>
	                    </a>
	                </li>
	            <? } ?>
	            <li>
	                <input type="hidden" name="visibility"/>
	                <button
	                    data-tooltip="true"
	                    data-original-title="Widoczność pisma"
	                    data-placement="bottom"
	                    class="btn btn-default btn"
	                    data-toggle="modal"
	                    data-target="#accessOptions">
	                    <i data-icon="&#xe902;" title="Ustawienia widoczności pisma" aria-hidden="true"></i>
	                </button>
	            </li>
	        </ul>
	        */ ?>
	
	    </div>
	</header>
		
	<ul class="collection-meta">
	    <li>Pismo <? if ($pismo['is_public']) { ?>publiczne<? } else { ?>prywatne<? } ?></li>
	    <? if ($pismo['sent']) { ?>
	        <li>Wysłano <?= dataSlownie($pismo['sent_at']) ?></li>
	    <? } ?>
	</ul>
	
	<? if (!$this->Session->read('Auth.User.id')) { ?>
    <div class="col-xs-12 nopadding">
        <div class="alert-identity alert alert-dismissable alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4>Uwaga!</h4>

            <p>Nie jesteś zalogowany. Twoje pisma będą przechowywane na tym urządzeniu przez 24 godziny. <a
                    class="_specialCaseLoginButton" href="/login">Zaloguj się</a>, aby trwale przechowywać pisma na
                swoim koncie.</p>
        </div>
    </div>
<? } ?>
	
</div>