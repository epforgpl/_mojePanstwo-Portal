<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy-radni_powiazania', array('plugin' => 'Dane')));

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

$powiazania = $object->getLayer('urzednicy_powiazania');
?>

    <div class="col-md-10 col-md-offset-1">
        <div id="powiazania" class="object">

            <? if ($powiazania) { ?>

                <h1>Powiązania urzędników gminy <?= $object->getData('nazwa') ?> z organizacjami w <a href="/krs">Krajowym
                        Rejestrze Sądowym</a></h1>

                <p class="desc">Zobacz także <a href="/dane/gminy/903,krakow/radni_powiazania">powiązania
                        radnych &raquo;</a></p>

                <div class="block-group">

                    <? foreach ($powiazania as $p) { ?>

                        <div class="block">

                            <div class="block-header">
                                <h2 class="label pull-left"><a
                                        href="/dane/gminy/<?= $object->getId() ?>/urzednicy/<?= $p['urzednik']['id'] ?>"><?= $p['urzednik']['nazwa'] ?></a>
                                </h2>

                                <p class="desc pull-right"><?= $p['urzednik']['opis'] ?></p>
                            </div>

                            <div class="content row padding">

                                <div class="col-md-12">

                                    <ul>
                                        <?
                                        foreach ($p['organizacje'] as $o) {

                                            $badges = array();

                                            if ($o['relacja']['reprezentat'] == '1') {
                                                $badges[] = $o['relacja']['reprezentat_funkcja'] ? $o['relacja']['reprezentat_funkcja'] : 'Członek organu reprezentacji';
                                            }

                                            if ($o['relacja']['wspolnik'] == '1') {
                                                $badges[] = 'Wspólnik';
                                            }

                                            if ($o['relacja']['akcjonariusz'] == '1') {
                                                $badges[] = 'Akcjonariusz';
                                            }

                                            if ($o['relacja']['prokurent'] == '1') {
                                                $badges[] = 'Prokurent';
                                            }

                                            if ($o['relacja']['nadzorca'] == '1') {
                                                $badges[] = 'Członek organu nadzoru';
                                            }

                                            if ($o['relacja']['zalozyciel'] == '1') {
                                                $badges[] = 'Członek komitetu założycielskiego';
                                            }
                                            ?>
                                            <li>
                                                <a href="/dane/krs_podmioty/<?= $o['id'] ?>"><?= stripslashes($o['nazwa']) ?></a>
                                                <span
                                                    class="badge"><?= implode('</span> <span class="badge">', $badges) ?></span>
                                            </li>
                                        <? } ?>
                                    </ul>

                                </div>

                            </div>

                        </div>

                    <? } ?>
                </div>
            <? } ?>

        </div>
    </div>

<?
echo $this->Element('dataobject/pageEnd');
?>