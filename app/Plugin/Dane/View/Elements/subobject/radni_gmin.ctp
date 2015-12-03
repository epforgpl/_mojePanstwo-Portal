<?php $this->Combinator->add_libs('css', $this->Less->css('radny_details', array('plugin' => 'PrzejrzystyKrakow'))) ?>

<?php
if ($metaDesc = $object->getMetaDescription()) { ?>
    <p class="meta meta-desc"><?= $metaDesc ?></p>
<? }
if ($object->getDescription()) { ?>
    <div class="description">
        <?= $object->getDescription() ?>
    </div>
<? } ?>

<div class="krakowRadnyDetail">
    <div class="row col-xs-12">
        <? if ($bip = $object->getLayer('bip_url')) { ?>
            <div class="option pull-left">
                <a data-toggle="tooltip" data-placement="bottom" title="Biuletyn Informacji Publicznej"
                   href="<?= @$bip; ?>" target="_blank">
                    <img class="bip" src="/Dane/img/customObject/krakow/logo_bip.png"/>
                </a>
            </div>
        <? } ?>
        <? if (($tel = $object->getData('tel')) && ($tel !== 'nie')) { ?>
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
        <? if ($fb = $object->getData('fb')) { ?>
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
        <? if ($twitter = $object->getData('twitter')) { ?>
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
        <? if ($blog = $object->getData('blog')) { ?>
            <div class="option pull-left">
                <a data-toggle="tooltip" data-placement="bottom" title="Blog" href="<?= $blog; ?>" target="_blank">
                    <i class="glyphicon glyphicon-link"></i>
                </a>
            </div>
        <? } else { ?>
            <div class="option pull-left inactive">
                <a data-toggle="tooltip" data-placement="bottom" title="Blog" href="#" onclick="return false;">
                    <i class="glyphicon glyphicon-link"></i>
                </a>
            </div>
        <? } ?>
        <? if ($www = $object->getData('www')) { ?>
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
        <? if ($wiki = $object->getData('wiki')) { ?>
            <div class="option pull-left">
                <a data-toggle="tooltip" data-placement="bottom" data-placement="bottom" title="Wikipedia"
                   href="<?= $wiki; ?>" target="_blank">
                    <i class="fa fa-wikipedia-w"></i>
                </a>
            </div>
        <? } else { ?>
            <div class="option pull-left inactive">
                <a data-toggle="tooltip" data-placement="bottom" data-placement="bottom" title="Wikipedia" href="#"
                   onclick="return false;">
                    <i class="fa fa-wikipedia-w"></i>
                </a>
            </div>
        <? } ?>

        <? if ($email = $object->getData('email2')) { ?>
            <div class="option pismo pull-left" data-toggle="modal" data-target="#krakowRadnyDetailPismo">
                <a data-toggle="tooltip" data-placement="bottom" data-placement="bottom" title="Wyślij pismo do radnego"
                   href="#" onclick="return false;">
                    <i class="glyphicon glyphicon-envelope"></i>
                </a>
            </div>
            <div class="modal fade" id="krakowRadnyDetailPismo">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Wyślij pismo do radnego</h4>
                        </div>
                        <div class="modal-body">
                            <p>Adres email:
                                <strong><?= $email ?></strong>
                            </p>

                            <div class="col-xs-12 pismoBox" data-dismiss="modal">
                                <?
                                $this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
                                $this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma')));
                                $this->Combinator->add_libs('js', 'Pisma.pisma-button');
                                echo $this->element('tools/pismo', array(
                                    'label' => '<strong>Wyślij pismo</strong> do radnego',
                                    'adresat' => 'radni_gmin:' . $radny->getId() . ':' . $radny->getData('plec')
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <? } else { ?>
            <div class="option inactive pull-left">
                <a data-toggle="tooltip" data-placement="bottom" data-placement="bottom" title="Wyślij pismo do radnego"
                   href="#" onclick="return false;">
                    <i class="glyphicon glyphicon-envelope"></i>
                </a>
            </div>
        <? } ?>
    </div>
</div>
