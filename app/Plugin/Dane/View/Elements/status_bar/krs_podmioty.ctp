<ul class="dataHighlights oneline col-xs-12">
	
	<li class="dataHighlight col-xs-12">
        <p class="_value desc"><?= $object->getMetaDescription() ?></p>
    </li>
	
    <? if($page = $object->getPage()) { ?>

        <div class="krakowRadnyDetail">
            <div class="row col-xs-12">

                <? if (($tel = $object->getPage('phone')) && ($tel !== '')) { ?>
                    <div class="option pull-left" data-toggle="modal" data-target="#krakowRadnyDetailPhone">
                        <a data-toggle="tooltip" data-placement="bottom" title="Telefon kontaktowy" href="#"
                           onclick="return false;">
                            <i class="fa fa-phone"></i>
                        </a>
                    </div>
                    <div class="modal fade" id="krakowRadnyDetailPhone">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Telefon kontaktowy</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Numer telefonu:
                                        <strong><?= $tel ?></strong>
                                    </p>
                                    <a class="btn btn-primary btn-social btn-skype" href="skype:<?= $tel; ?>">
                                        <i class="fa fa-skype"></i> Zadzwoń przez Skype
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } else { ?>
                    <div class="option pull-left inactive">
                        <a data-toggle="tooltip" data-placement="bottom" title="Telefon kontaktowy" href="#"
                           onclick="return false;">
                            <i class="fa fa-phone"></i>
                        </a>
                    </div>
                <? } ?>

                <? if ($fb = $object->getPage('facebook')) { ?>
                    <div class="option pull-left">
                        <a data-toggle="tooltip" data-placement="bottom" title="Facebook" href="<?= $fb; ?>" target="_blank">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </div>
                <? } else { ?>
                    <div class="option pull-left inactive">
                        <a data-toggle="tooltip" data-placement="bottom" title="Facebook" href="#" onclick="return false;">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </div>
                <? } ?>

                <? if ($twitter = $object->getPage('twitter')) { ?>
                    <div class="option pull-left">
                        <a data-toggle="tooltip" data-placement="bottom" title="Twitter" href="<?= $twitter; ?>"
                           target="_blank">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </div>
                <? } else { ?>
                    <div class="option pull-left inactive">
                        <a data-toggle="tooltip" data-placement="bottom" title="Twitter" href="#" onclick="return false;">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </div>
                <? } ?>
                <? if ($www = $object->getPage('www')) { ?>
                    <div class="option pull-left">
                        <a data-toggle="tooltip" data-placement="bottom" title="WWW" href="<?= $www; ?>" target="_blank">
                            <i class="glyphicon glyphicon-link"></i>
                        </a>
                    </div>
                <? } else { ?>
                    <div class="option pull-left inactive">
                        <a data-toggle="tooltip" data-placement="bottom" title="WWW" href="#" onclick="return false;">
                            <i class="glyphicon glyphicon-link"></i>
                        </a>
                    </div>
                <? } ?>

                <? if ($email = $object->getPage('email')) { ?>
                    <div class="option pull-left">
                        <a data-toggle="tooltip" data-placement="bottom" title="Adres e-mail" href="mailto:<?= $email; ?>" target="_blank">
                            <i class="glyphicon glyphicon-envelope"></i>
                        </a>
                    </div>
                <? } else { ?>
                    <div class="option pull-left inactive">
                        <a data-toggle="tooltip" data-placement="bottom" title="Adres e-mail" href="#" onclick="return false;">
                            <i class="glyphicon glyphicon-envelope"></i>
                        </a>
                    </div>
                <? } ?>


            </div>
        </div>

    <? } ?>

    <? /*
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
	*/ ?>


</ul>
