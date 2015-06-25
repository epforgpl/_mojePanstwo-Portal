<ul class="dataHighlights oneline col-xs-12">
    <? if ($object->getData('wykreslony')) { ?>
        <li class="dataHighlight col-sm-3">
            <span class="label label-danger">Podmiot wykreślony z KRS</span>
        </li>
    <? } ?>


    <?
    $krs = $object->getData('krs');
    if (isset($krs) && !empty($krs)) { ?>
        <li class="dataHighlight col-sm-3">
            <p class="_label">Numer KRS</p>

            <p class="_value"><?= $krs ?></p>
        </li>
    <? } ?>

    <?
    $nip = $object->getData('nip');
    if (isset($nip) && !empty($nip)) { ?>
        <li class="dataHighlight col-sm-3">
            <p class="_label">Numer NIP</p>

            <p itemprop="taxID" class="_value"><?= $nip ?></p>
        </li>
    <? } ?>

    <?
    $regon = $object->getData('regon');
    if (isset($regon) && !empty($regon)) { ?>
        <li class="dataHighlight col-sm-3">
            <p class="_label">Numer REGON</p>

            <p class="_value"><?= $regon ?></p>
        </li>
    <? } ?>

    <?
    $wartosc_kapital_zakladowy = $object->getData('wartosc_kapital_zakladowy');
    if (isset($wartosc_kapital_zakladowy) && !empty($wartosc_kapital_zakladowy)) { ?>
        <li class="dataHighlight col-sm-3">
            <p class="_label">Kapitał zakładowy</p>

            <p class="_value"><?= number_format_h($wartosc_kapital_zakladowy); ?> PLN</p>
        </li>
    <? } ?>

    <?
    $data_rejestracji = $object->getData('data_rejestracji');
    if (isset($data_rejestracji) && !empty($data_rejestracji)) { ?>
        <li class="dataHighlight col-sm-3">
            <p class="_label">Data rejestracji</p>

            <p class="_value"><?= $this->Czas->dataSlownie($data_rejestracji, array(
                    'itemprop' => 'foundingDate',
                )); ?></p>
        </li>
    <? } ?>

    <?
    $www = $www = $object->getData('www');
    if (isset($www) && !empty($www)) {
        $url = (stripos($www, 'http') === false) ? 'http://' . $www : $www;
        ?>
        <li class="dataHighlight col-sm-6">
            <p class="_label">Strona WWW</p>

            <p class="_value"><a target="_blank" title="<?= addslashes($object->getTitle()) ?>"
                                 href="<?= $url ?>"><?= $www; ?></a></p>
        </li>
    <? } ?>

    <?
    $email = $object->getData('email');
    if (isset($email) && !empty($email)) { ?>
        <li class="dataHighlight col-sm-6">
            <p class="_label">Adres e-mail</p>

            <p itemprop="email" class="_value"><a target="_blank" href="mailto:<?= $email ?>"><?= $email; ?></a></p>
        </li>
    <? } ?>
    
    <?
    $sygnatura_akt = $object->getData('sygnatura_akt');
    if (isset($sygnatura_akt) && !empty($sygnatura_akt)) { ?>
        <li class="dataHighlight col-sm-6">
            <p class="_label">Sygnatura akt</p>

            <p itemprop="email" class="_value"><?= $sygnatura_akt ?></p>
        </li>
    <? } ?>
    
    
    
</ul>