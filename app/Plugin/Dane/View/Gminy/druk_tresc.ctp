<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
    $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
    $this->Combinator->add_libs('js', '../plugins/highcharts/locals');
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
    <div class="row col-xs-12 col-md-10">
        <? echo $this->Document->place($druk->getData('dokument_id')); ?>
    </div>

<? if (($object->getId() == '903') && !empty(AuthComponent::user('id'))) { ?>
    <div class="row col-xs-12 col-md-2 user_options_votes">
        <? if (@$all_users_votes || true) { ?>
            <h3>Jak głosowali inni użytkownicy</h3>
            <div class="poll"></div>
        <? } ?>

        <? if (@$user_vote_already) { ?>
            <button class="btn btn-default">Zmień swój głos</button>
        <? } ?>
        <h3>Jak byś ty zagłosował?</h3>

        <div class="options">
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
<? echo $this->Element('dataobject/pageEnd');