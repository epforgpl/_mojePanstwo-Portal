<?
$this->Combinator->add_libs('css', $this->Less->css('zamowienia_publiczne', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.zamowienia_publiczne');

$output = array();
foreach ($histogram as $b) {

    if (
        isset($b['wykonawcy']['waluty']) &&
        isset($b['wykonawcy']['waluty']['buckets']) &&
        !empty($b['wykonawcy']['waluty']['buckets'])
    ) {

        $waluty = array();
        foreach (@$b['wykonawcy']['waluty']['buckets'] as $w)
            $waluty[$w['key']] = $w['suma']['value'];

        if (isset($waluty['PLN']))
            $output[] = array(
                $b['key'], $waluty['PLN'],
            );

    }

}

if (!isset($mode))
    $mode = false;

?>
<div
    class="mp-zamowienia_publiczne" <?= printf('data-histogram="%s"', htmlspecialchars(json_encode($output), ENT_QUOTES, 'UTF-8')) ?> <?= printf('data-request="%s"', htmlspecialchars(json_encode($request), ENT_QUOTES, 'UTF-8')) ?>>

    <div class="highstock"></div>
    <div class="dataAggs margin-sides-10 smaller">
        <?
        switch ($mode) {
            case 'medium': {
                ?>
                <div class="row">
                    <div class="col-md-12">

                        <div class="agg" data-agg_id="stats"></div>

                    </div>
                    <div class="col-md-8">

                        <div class="block block-size-sm block-simple col-xs-12 margin-top-15">
                            <header>Największe zamówienia:</header>
                            <section class="margin-sides-10">
                                <div class="agg"
                                     data-agg_id="dokumenty" <?= printf('data-agg_params="%s"', htmlspecialchars(json_encode($aggs['dokumenty']), ENT_QUOTES, 'UTF-8')) ?>></div>
                                
                            </section>
                            <div class="buttons" style="display: none;">
                                <a <?= printf('data-more="%s"', htmlspecialchars(json_encode($more), ENT_QUOTES, 'UTF-8')) ?>
                                    href="#" class="btn btn-default btn-xs btn-more">Zobacz więcej</a>
                            </div>


                        </div>


                    </div>
                    <div class="col-md-4 margin-top-15">

                        <div class="block block-size-sm block-simple col-xs-12">
                            <header>Największe zamówienia otrzymali:</header>
                            <section>
                                <div class="agg"
                                     data-choose-request="/zamowienia_publiczne?conditions[zamowienia_publiczne.wykonawca_id]="
                                     data-agg_id="wykonawcy" <?= printf('data-agg_params="%s"', htmlspecialchars(json_encode($aggs['wykonawcy']), ENT_QUOTES, 'UTF-8')) ?>></div>
                            </section>
                        </div>

                    </div>
                </div>
                <?
                break;
            }
            default: {
                foreach ($aggs as $agg_id => $agg_params) {
                    ?>
                    <div class="agg"
                         data-agg_id="<?= $agg_id ?>" <?= printf('data-agg_params="%s"', htmlspecialchars(json_encode($agg_params), ENT_QUOTES, 'UTF-8')) ?>></div>
                    <?
                }
                ?>
                <div class="buttons margin-sides--10" style="display: none;">
                    <a data-href="<?= $more ?>" href="<?= $more ?>" class="btn btn-default btn-xs btn-more">Zobacz
                        więcej &raquo;</a>
                </div>
                <?
            }
        }
        ?>

    </div>

</div>
