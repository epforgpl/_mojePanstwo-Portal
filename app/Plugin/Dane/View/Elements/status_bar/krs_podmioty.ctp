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

                <? if ($youtube = $object->getPage('youtube')) { ?>
                    <div class="option pull-left">
                        <a data-toggle="tooltip" data-placement="bottom" title="Kanał YouTube" href="<?= $youtube; ?>" target="_blank">
                            <i class="fa fa-youtube"></i>
                        </a>
                    </div>
                <? } else { ?>
                    <div class="option pull-left inactive">
                        <a data-toggle="tooltip" data-placement="bottom" title="Kanał YouTube" href="#" onclick="return false;">
                            <i class="fa fa-youtube"></i>
                        </a>
                    </div>
                <? } ?>


            </div>
        </div>

    <? } ?>
</ul>
