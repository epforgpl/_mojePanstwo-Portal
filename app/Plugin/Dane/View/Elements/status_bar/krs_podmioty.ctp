<ul class="dataHighlights col-xs-12">
    <? if ($object->getData('wykreslony')) { ?>
        <li class="dataHighlight col-sm-3">
            <span class="label label-danger">Podmiot wykreślony z KRS</span>
        </li>
    <? } ?>


    <? if ($object->getData('krs')) { ?>
        <li class="dataHighlight col-sm-3">
            <p class="_label">Numer KRS</p>

            <p class="_value"><?= $object->getData('krs'); ?></p>
        </li>
    <? } ?>

    <? if ($object->getData('nip')) { ?>
        <li class="dataHighlight col-sm-3">
            <p class="_label">Numer NIP</p>

            <p itemprop="taxID" class="_value"><?= $object->getData('nip'); ?></p>
        </li>
    <? } ?>

    <? if ($object->getData('regon')) { ?>
        <li class="dataHighlight col-sm-3">
            <p class="_label">Numer REGON</p>

            <p class="_value"><?= $object->getData('regon'); ?></p>
        </li>
    <? } ?>


    <? if ($object->getData('wartosc_kapital_zakladowy')) { ?>
        <li class="dataHighlight col-sm-3">
            <p class="_label">Kapitał zakładowy</p>

            <p class="_value"><?= number_format_h($object->getData('wartosc_kapital_zakladowy')); ?> PLN</p>
        </li>
    <? } ?>



    <? if ($object->getData('data_rejestracji')) { ?>
        <li class="dataHighlight col-sm-3">
            <p class="_label">Data rejestracji</p>

            <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_rejestracji'), array(
                    'itemprop' => 'foundingDate',
                )); ?></p>
        </li>
    <? } ?>

    <? if ($www = $object->getData('www')) {
        $url = (stripos($www, 'http') === false) ? 'http://' . $www : $www;
        ?>
        <li class="dataHighlight col-sm-3">
            <p class="_label">Strona WWW</p>

            <p class="_value"><a target="_blank" title="<?= addslashes($object->getTitle()) ?>"
                                 href="<?= $url ?>"><?= $www; ?></a></p>
        </li>
    <? } ?>

    <? if ($email = $object->getData('email')) { ?>
        <li class="dataHighlight col-sm-3">
            <p class="_label">Adres e-mail</p>

            <p itemprop="email" class="_value"><a target="_blank" href="mailto:<?= $email ?>"><?= $email; ?></a></p>
        </li>
    <? } ?>
</ul>