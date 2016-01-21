<? if (false && ($szef = $object->getLayer('szef'))) { ?>
    <ul class="dataHighlights col-xs-12">
        <?php if (isset($szef['kandydat_nazwa']) && !empty($szef['kandydat_nazwa'])) { ?>
            <li class="dataHighlight col-sm-6 col-sm-3">
                <p class="_label"><?= $szef['stanowisko'] ?></p>

                <p class="_value"><?= $szef['kandydat_nazwa'] ?></p>
            </li>
        <?php } ?>

        <?php if (isset($szef['komitet_nazwa']) && !empty($szef['komitet_nazwa'])) { ?>
            <li class="dataHighlight col-sm-6 col-sm-3">
                <p class="_label">Komitet</p>

                <p class="_value"><?= $szef['komitet_nazwa'] ?></p>
            </li>
        <?php } ?>

        <?php if (isset($szef['liczba_glosow']) && !empty($szef['liczba_glosow'])) { ?>
            <li class="dataHighlight col-sm-6 col-sm-3">
                <p class="_label">Liczba głosów</p>

                <p class="_value"><?= number_format_h($szef['liczba_glosow']); ?></p>
            </li>
        <?php } ?>

        <?php if (isset($szef['procent_glosow']) && !empty($szef['procent_glosow'])) { ?>
            <li class="dataHighlight col-sm-6 col-sm-3">
                <p class="_label">Poparcie</p>

                <p class="_value"><?= round($szef['procent_glosow'], 1) ?>%</p>
            </li>
        <?php } ?>
    </ul>
<? } ?>
<ul class="dataHighlights oneline col-xs-12">

    <? if($page = $object->getPage()) { ?>

        <div class="krakowRadnyDetail">
            <div class="row col-xs-12">

                <? if (($tel = $object->getPage('phone')) && ($tel !== '')) { ?>
                    <div class="option pull-left" data-toggle="modal" data-target="#krakowRadnyDetailPhone">
                        <a data-toggle="tooltip" data-placement="bottom" title="Telefon kontaktowy" href="#"
                           onclick="return false;"><span class="fa fa-phone"></span></a>
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
                                    <a class="btn btn-primary btn-social btn-skype" href="skype:<?= $tel; ?>"><span
                                            class="fa fa-skype"></span> Zadzwoń przez Skype</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } else { ?>
                    <div class="option pull-left inactive">
                        <a data-toggle="tooltip" data-placement="bottom" title="Telefon kontaktowy" href="#"
                           onclick="return false;"><span class="fa fa-phone"></span></a>
                    </div>
                <? } ?>

                <? if ($fb = $object->getPage('facebook')) { ?>
                    <div class="option pull-left">
                        <a data-toggle="tooltip" data-placement="bottom" title="Facebook" href="<?= $fb; ?>"
                           target="_blank"><span class="fa fa-facebook"></span></a>
                    </div>
                <? } else { ?>
                    <div class="option pull-left inactive">
                        <a data-toggle="tooltip" data-placement="bottom" title="Facebook" href="#"
                           onclick="return false;"><span class="fa fa-facebook"></span></a>
                    </div>
                <? } ?>

                <? if ($twitter = $object->getPage('twitter')) { ?>
                    <div class="option pull-left">
                        <a data-toggle="tooltip" data-placement="bottom" title="Twitter" href="<?= $twitter; ?>"
                           target="_blank"><span class="fa fa-twitter"></span></a>
                    </div>
                <? } else { ?>
                    <div class="option pull-left inactive">
                        <a data-toggle="tooltip" data-placement="bottom" title="Twitter" href="#"
                           onclick="return false;"><span class="fa fa-twitter"></span></a>
                    </div>
                <? } ?>
                <? if ($www = $object->getPage('www')) { ?>
                    <div class="option pull-left">
                        <a data-toggle="tooltip" data-placement="bottom" title="WWW" href="<?= $www; ?>"
                           target="_blank"><span class="glyphicon glyphicon-link"></span></a>
                    </div>
                <? } else { ?>
                    <div class="option pull-left inactive">
                        <a data-toggle="tooltip" data-placement="bottom" title="WWW" href="#"
                           onclick="return false;"><span class="glyphicon glyphicon-link"></span></a>
                    </div>
                <? } ?>

                <? if ($email = $object->getPage('email')) { ?>
                    <div class="option pull-left">
                        <a data-toggle="tooltip" data-placement="bottom" title="Adres e-mail"
                           href="mailto:<?= $email; ?>" target="_blank"><span
                                class="glyphicon glyphicon-envelope"></span></a>
                    </div>
                <? } else { ?>
                    <div class="option pull-left inactive">
                        <a data-toggle="tooltip" data-placement="bottom" title="Adres e-mail" href="#"
                           onclick="return false;"><span class="glyphicon glyphicon-envelope"></span></a>
                    </div>
                <? } ?>


            </div>
        </div>

    <? } ?>

    <?php $typ_nazwa = $object->getData('typ_nazwa');
    if (isset($typ_nazwa) && !empty($typ_nazwa)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">

            <p class="_value"><?= $typ_nazwa; ?></p>
        </li>
    <?php } ?>
</ul>
