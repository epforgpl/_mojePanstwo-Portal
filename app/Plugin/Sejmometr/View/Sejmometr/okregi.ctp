<? $this->Combinator->add_libs('js', 'Sejmometr.okregi');
$this->Combinator->add_libs('css', $this->Less->css('okregi', array('plugin' => 'Sejmometr')));

switch (Configure::read('Config.language')) {
    case 'pol':
        $lang = "pl-PL";
        break;
    case 'eng':
        $lang = "en-EN";
        break;
};
echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false&language=' . $lang, array('block' => 'scriptBlock')); ?>

<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <div id="map"></div>
        </div>
        <div class="col-sm-4">
            <h3>Okregi według numerów</h3>
            <div class="row">
                <? foreach($okregi as $i => $okrag) { ?>
                    <button id="okrag<?= $okrag[0]; ?>" data-index="<?= $i; ?>" type="button" class="btn btn-link okrag"><?= $okrag[1]; ?></button>
                <? } ?>
            </div>
        </div>
    </div>
</div>

<div data-name="okregi" data-value='<?= json_encode($okregi) ?>'></div>
