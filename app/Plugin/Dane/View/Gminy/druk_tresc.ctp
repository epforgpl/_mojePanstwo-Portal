<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
    $this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
    $this->Combinator->add_libs('js', '../plugins/highstock/locals');
    $this->Combinator->add_libs('js', array('Dane.view-gminy-krakow-vote'));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => isset($_submenu) ? $_submenu : false,
    'object' => $druk,
    'objectOptions' => array(
        'bigTitle' => true,
        'truncate' => 1024,
    ),
    'addBreadcrumbs' => array(
        array(
            'label' => 'Treść druku',
        ),
    ),
));
?>

    <h2 class="light">Treść druku</h2>
    <div class="row">
	    <div class="col-md-9 col-xs-12">

        <? echo $this->Document->place($druk->getData('dokument_id')); ?>

        </div><div class="col-md-3 col-xs-12">

            <? if ($object->getId() == '903') { ?>
		    <div class="user_options_votes">
		        <div class="pollBlock hidden">
		            <h3>Jak głosowali inni użytkownicy</h3>
		            <div class="poll"></div>
		        </div>

                <h3>Jak byś Ty zagłosował?</h3>

                <div class="options<? if (empty(AuthComponent::user('id'))) {
		            echo ' _specialCaseLoginButton';
		        } ?>">
		            <button class="btn btn-link vote za" data-vote="1"><i data-icon="&#xe606;"></i>Za</button>
		            <button class="btn btn-link vote wstrzymuje" data-vote="3"><i data-icon="&#xe624;"></i>Wstrzymuje się
		            </button>
		            <button class="btn btn-link vote przeciw" data-vote="2"><i data-icon="&#xe605;"></i>Przeciw</button>
		        </div>
		        <? if (@$user_similar_radni) { ?>
		            <h3>Radni, którzy zagłosowali tak jak Ty</h3>
		            <div class="radniList objectPage">
		                <div gid="12513508" oid="39252" class="objectRender readed objclass radni_gmin">
		                    <div class="row">
		                        <div class="data col-xs-12">
		                            <div>
		                                <div class="attachment col-md-4 nopadding text-center">
		                                    <a href="/dane/gminy/903/radni/39252" class="thumb_cont">
		                                        <img onerror="imgFixer(this)" alt="Dominik Jaśkowiec"
		                                             src="http://resources.sejmometr.pl/avatars/5/10.jpg"
		                                             class="thumb pull-right">
		                                    </a>
		                                </div>
		                                <div style="margin-left: -10px;" class="content col-md-8">
		                                    <p class="title">
		                                        <a title="Dominik Jaśkowiec" href="/dane/gminy/903/radni/39252">
		                                            Dominik Jaśkowiec </a></p>

                                            <p class="meta meta-desc">KW Platforma Obywatelska RP</p>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        <? } ?>
		    </div>
			<? } ?>

        </div>
    </div>

<? echo $this->Element('dataobject/pageEnd');
