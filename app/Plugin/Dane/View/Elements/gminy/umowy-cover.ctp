<?

$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);

?>


<div class="col-sm-2 col-xs-12 dataAggsContainer">

    <? if(isset($_submenu) && isset($_submenu['items'])) {

        if (!isset($_submenu['base']))
            $_submenu['base'] = $object->getUrl();

        echo $this->Element('Dane.DataBrowser/browser-menu', array(
            'menu' => $_submenu,
        ));

    } ?>

</div>
<div class="col-sm-10">
    <div class="row">
        <div class="col-sm-12">

            <div class="blocks">

                <? if (@$dataBrowser['aggs']['umowy']['dni']['buckets']) { ?>
                    <div class="block block-simple block-size-sm col-xs-12">
                        <header>Wartość brutto podpisywanych umów:</header>
                        <section>
                            <?= $this->element('Dane.highstock_browser', array(
                                'histogram' => $dataBrowser['aggs']['umowy']['dni']['buckets'],
                                'preset' => 'krakow_umowy',
                                'options' => array(
                                    'more' => array(
                                        'url' => '/dane/gminy/903,krakow/umowy',
                                        'convert' => true,
                                    ),
                                    'aggs' => array(
                                        'umowy' => array(
                                            'size' => 5,
                                        ),
                                        'wykonawcy' => array(),
                                    ),
                                    'mode' => 'medium',
                                ),
                            )); ?>
                        </section>
                    </div>
                <? } ?>

            </div>

        </div>
    </div>
</div>
