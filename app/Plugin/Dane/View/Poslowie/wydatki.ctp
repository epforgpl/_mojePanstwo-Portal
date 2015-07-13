<?
$this->Combinator->add_libs('css', $this->Less->css('view-poslowie', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin');

if (
    ($wydatki = $object->getLayer('wydatki')) &&
    ($liczba_pol = $wydatki['liczba_pol']) &&
    ($liczba_rocznikow = $wydatki['liczba_rocznikow'])
) {
    ?>

    <div id="wydatki" class="block">
        <div class="block-header">
            <h2 class="label">Wydatki biura poselskiego</h2>
        </div>

        <div class="content">

            <table class="table table-wydatki table-striped ">
                <thead>
                <tr>
                    <th></th>
                    <? for ($r = 0; $r < $liczba_rocznikow; $r++) { ?>
                        <th><?= $wydatki['roczniki'][$r]['rok'] ?> <a
                                data-dokument_id="<?= $wydatki['roczniki'][$r]['dokument_id'] ?>"
                                href="/dane/poslowie/<?= $object->getId() ?>/wydatki/<?= $wydatki['roczniki'][$r]['rok'] ?>"
                                class="glyphicon glyphicon-file"></a></th>
                    <? } ?>
                </tr>
                </thead>
                <tbody>
                <? for ($p = 0; $p < $liczba_pol; $p++) { ?>
                    <tr>
                        <td class="label_td" style="max-width: 50%;"><?= $wydatki['punkty'][$p]['tytul'] ?></td>
                        <?
                        for ($r = 0; $r < $liczba_rocznikow; $r++) {
                            $v = (float)$wydatki['roczniki'][$r]['pola'][$p];
                            ?>
                            <td<? if (!$v) { ?> class="zero"<? } ?>><?= _currency($v) ?></td>
                        <? } ?>
                    </tr>
                <? } ?>
                </tbody>
            </table>

        </div>
    </div>

<?
}

echo $this->Element('dataobject/pageEnd');
?>