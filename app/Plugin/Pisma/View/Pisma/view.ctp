<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma.js') ?>

<div class="appHeader">
    <div class="container innerContent">

        <div class="col-xs-12">
            <? echo $this->Element('Pisma.menu', array(// 'selected' => 'moje'
            )); ?>
        </div>

    </div>
</div>

<div class="container">

    <? echo $this->element('Pisma.pismo-header', array(
        'pismo' => $pismo,
        'alert' => true,
    )); ?>

    <div id="stepper">
        <div class="content clearfix">
            <div class="col-md-10 view">
                <? echo $this->Element('Pisma.render'); ?>
            </div>
            <div class="col-md-2 nopadding">
                <div class="editor-tooltip">

                    <? $href_base = '/pisma/' . $pismo['alphaid'] . ',' . $pismo['slug']; ?>
					
                    <ul class="form-buttons">
                        <li class="inner-addon">
                            <i class="glyphicon glyphicon-send"></i>
                            <a href="<?= $href_base . '/send' ?>" target="_self" class="btn btn-primary sendPismo">Wyślij...</a>

                            <p class="desc">Możesz wysłać pismo do adresata poprzez e-mail.</p>

                            <div id="sendPismoModal" class="modal fade" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Wysyłanie pisma</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Twoje pismo zostanie wysłane z adresu <span class="email">pisma@mojepanstwo.pl</span> na adres:</p>
                                            
                                            <p class="email email-big text-center"><?= $pismo['to_email'] ?></p>
                                            
                                            <div class="additional-desc">
	                                            <p>W polu <b>CC</b> wiadomości zostanie podany Twój adres e-mail - otrzymasz więc kopię wysłanego pisma.</p>
	                                            <p>W polu <b>Reply-to</b> wiadomości również zostanie podany Twój adres email, aby adresat przesłał odpowiedź bezpośrednio na Twój adres.</p>
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <form action="<?= $href_base ?>" method="POST">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    Zamknij
                                                </button>
                                                <button type="submit" value="send" class="btn btn-primary">Wyślij
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <? /*
                        <li class="inner-addon">
                            <i class="glyphicon glyphicon-share"></i>
                            <a href="<?= $href_base . '/share' ?>" target="_self"
                               class="btn btn-primary">Udostępnij...</a>

                            <p class="desc">Twoje pismo jest obecnie prywatne. Możesz je zanonimizować i udostępnić
                                publicznie.</p>
                        </li>
                        */ ?>
                        <li class="inner-addon">
                            <i class="glyphicon glyphicon-edit"></i>
                            <a href="<?= $href_base . '/edit' ?>" target="_self" class="btn btn-primary">Edytuj
                                treść</a>
                        </li>
                    </ul>

                    <ul class="form-buttons more-buttons-target" style="display: none;">
                        <li class="inner-addon left-addon">
                            <form onsubmit="return confirm('Czy na pewno chcesz usunąć to pismo?');" method="post"
                                  action="/pisma/<?= $pismo['alphaid'] ?>,<?= $pismo['slug'] ?>">
                                <i class="glyphicon glyphicon-trash"></i>
                                <input name="delete" type="submit" class="form-control btn btn-danger" value="Skasuj"/>
                            </form>
                        </li>
                    </ul>

                    <p class="more-buttons-switcher-cont">
                        <a class="more-buttons-switcher" data-mode="more" href="#more"><span
                                class="glyphicon glyphicon-chevron-down"></span> <span class="text">Więcej</span></a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>