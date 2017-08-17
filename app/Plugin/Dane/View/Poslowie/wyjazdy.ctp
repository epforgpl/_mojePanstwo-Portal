<?
$this->Combinator->add_libs('css', $this->Less->css('view-poslowie', array('plugin' => 'Dane')));
echo $this->Element('dataobject/pageBegin');
?>

    <div class="mpanel" style="padding: 20px; margin: 20px;">

        <? if ($object->getData('liczba_wyjazdow8') && $object->getData('wartosc_wyjazdow8')) { ?>
            <p style="color: green;"
               class="stat text-center"><?= pl_dopelniacz($object->getData('liczba_wyjazdow8'), 'wyjazd', 'wyjazdy', 'wyjazdów') ?>
                na kwotę <?= _currency($object->getData('wartosc_wyjazdow8')) ?></p>
        <? } ?>

        <? if ($object->getLayer('wyjazdy')) { ?>
            <table class="table table-striped table-hover " style="font-size: 13px;">
                <thead>
                <tr>
                    <th>Miejsce</th>
                    <th>Wydarzenie</th>
                    <th>Koszt</th>
                    <th style="min-width: 7em;">Od</th>
                    <th style="min-width: 7em;">Do</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($object->getLayer('wyjazdy') as $ev) { ?>
                    <tr>
                        <td><?= $ev['kraj'] ?></td>
                        <td><a href="/dane/poslowie_wyjazdy_wydarzenia8/<?= $ev['id'] ?>"><?= $ev['delegacja'] ?></a>
                        </td>
                        <td style="text-align: right;"><?= _currency($ev['koszt_suma']) ?></td>
                        <td><?= $this->Czas->dataSlownie($ev['od']) ?></td>
                        <td><?= $this->Czas->dataSlownie($ev['do']) ?></td>
                    </tr>
                <? } ?>
                </tbody>
            </table>
        <? } else { ?>
            <p>Brak udokumentowanych wyjazdów zagranicznych.</p>
        <? } ?>
    </div>

<?
echo $this->Element('dataobject/pageEnd');
?>