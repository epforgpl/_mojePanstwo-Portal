<?php echo $this->Html->css('../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.min', array('block' => 'cssBlock')); ?>

<?php echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.all', array('block' => 'scriptBlock')); ?>
<?php echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/locales/bootstrap-wysihtml5.pl-PL', array('block' => 'scriptBlock')); ?>

<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('js', 'Pisma.jquery.autosize.min.js') ?>
<?php $this->Combinator->add_libs('js', 'Pisma.jquery_steps.js') ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma.js') ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma-button.js') ?>

<?php
if (!empty($pismo['szablon_id'])) $pismo_init['szablon_id'] = $pismo['szablon_id'];
if (!empty($pismo['adresat_id'])) $pismo_init['adresat_id'] = $pismo['adresat_id'];
?>


<div id="stepper"<? if (!empty($pismo_init)) echo ' data-pismo=' . json_encode($pismo_init); ?>>


    <h2>Wybierz szablon i adresata</h2>
    <section>

        <div class="container start">

            <div class="col-xs-12 col-md-10 col-md-offset-1">

                <p class="hint-title">Wybierz szablon, aby ułatwić tworzenie pisma. Na podstawie wybranego szablonu,
                    umieścimy w Twoim piśmie odpowiednie formuły prawne i inne informacje. Jeśli nie chcesz
                    wybierać szablonu - przejdź dalej.</p>

                <form class="letter form-horizontal">
                    <fieldset>
                        <div class="form-group szablony">
                            <label for="szablonSelect" class="col-lg-2 control-label">Szablon</label>

                            <div class="col-lg-10">
                                <div class="radio">
                                    <label><input name="szablon_id" value="option1" checked="" type="radio">Brak
                                        szablonu</label>
								</div>
								<div class="radio">
                                    <label><input name="szablon_id" value="option2" type="radio">Wniosk o udostępnienie
                                        informacji publicznej</label>
								</div>
								<div class="radio">
                                    <label><input name="szablon_id" value="option2" type="radio">Skarga na decyzję
                                        administracyjną</label>
								</div>
                                
                                <div class="templates_browser">
                                    <a href="#" class="pisma-list-button pisma-list-button-no-jump">Zobacz wszystkie
                                        szablony &raquo;</a>
                                </div>
                                
                            </div>
                        </div>
                    </fieldset>
                     
                    <fieldset>
                        <div class="form-group adresaci">
                            <label for="adresatSelect" class="col-lg-2 control-label">Adresat</label>

                            <div class="col-lg-10">
                                <input class="form-control input-lg" id="adresatSelect"
                                       placeholder="Zacznij pisać aby znaleźć adresata..."
                                       type="text" autocomplete="off"/>

                                <input type="hidden" name="adresat_id"/>

                                <div class="list adresaciList content" style="display: none">
                                    <ul class="ul-raw"></ul>
                                </div>
                                <span class="help-block">Na podstawie wybranego adresata, uzupełnimy dane teleadresowe w Twoim piśmie.</span>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="final">
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-1 text-center">
                                <button type="submit" class="btn btn-md btn-primary">Wpisz treść pisma
                                    <span class="glyphicon glyphicon-play"></span>
                                </button>
                            </div>
                        </div>
                    </fieldset>
                </form>

            </div>

        </div>

    </section>

    <? /*
    <h2>Wybierz szablon pisma</h2>
    <section>

        <div class="container szablony">

            <div class="col-xs-12 col-md-10 col-md-offset-1">

                <p class="hint-title">Wybierz szablon, aby ułatwić tworzenie pisma. Na podstawie wybranego szablonu,
                    umieścimy w Twoim piśmie odpowiednie formuły prawne i inne informacje. Jeśli nie chcesz
                    wybierać szablonu - przejdź dalej.</p>

                <div id="chosen-template" class="block" style="display: none;">
                    <div class="block-header">
                        <h2 class="label pull-left">Wybrany szablon</h2>

                        <div class="pull-right">
                            <button class="btn btn-danger btn-xs">Usuń wybór</button>
                        </div>
                    </div>
                    <div class="content">
                        <ul class="ul-raw"></ul>
                    </div>
                </div>

                <? foreach ($templatesGroups as $group) { ?>
                    <div class="block search ">
                        <div class="block-header">
                            <h2 class="label"><?= $group['nazwa'] ?></h2>
                        </div>
                        <div class="list content">
                            <ul class="ul-raw">
                                <?
                                foreach ($group['templates'] as $template) {
                                    ?>
                                    <li data-id="<?= $template['id'] ?>"
                                        data-title="<?= addslashes($template['nazwa']) ?>" class="row">
                                        <div class="pull-left col-md-11">
                                            <p class="title"><a
                                                    href="/dane/pisma_szablony/<?= $template['id'] ?>"><?= $template['nazwa'] ?></a>
                                            </p>

                                            <p style="display: none;" class="desc"><?= $template['opis'] ?></p>
                                        </div>
                                        <div class="pull-right  col-md-1">
                                            <button class="btn btn-success btn-xs">Wybierz</button>
                                        </div>
                                    </li>
                                <? } ?>
                            </ul>
                        </div>
                    </div>
                <? } ?>

            </div>

        </div>

    </section>
	

    <h2>Wybierz adresata</h2>
    <section>

        <div class="container adresaci">

            <div class="col-xs-12 col-md-10 col-md-offset-1">

                <p class="hint-title">Wybierz adresata, do którego chcesz napisać. To pozwoli automatycznie wypełnić
                    dane teleadresowe w Twoim piśmie.</p>

                <div id="chosen-addressee" class="block" style="display: none;">
                    <div class="block-header">
                        <h2 class="label pull-left">Wybrany adresat</h2>

                        <div class="pull-right">
                            <button class="btn btn-danger btn-xs">Usuń wybór</button>
                        </div>
                    </div>
                    <div class="content">
                        <ul class="ul-raw"></ul>
                    </div>
                </div>

                <div class="block">
                    <div class="block-header">
                        <input class="search" type="text" name="adresat" placeholder="Szukaj adresata..."/>
                    </div>
                    <div class="list content" style="display: none"></div>
                </div>

            </div>

        </div>

    </section>
	*/ ?>


    <h2>Wpisz treść</h2>
    <section>
        <div class="container edit">

            <div class="editor-container row">
                <div class="col-xs-12 col-md-10">
                    <? echo $this->Element('Pisma.render'); ?>
                </div>
                <div class="col-xs-12 col-md-2 nopadding">
                    <div class="editor-tooltip">
                        <ul class="form-buttons">
                            <li class="inner-addon">
                                <i class="glyphicon glyphicon-send"></i>
                                <button class="btn btn-primary" name="send">Zapisz i wyślij</button>
                            </li>
                            <li class="inner-addon">
                                <i class="glyphicon glyphicon-saved"></i>
                                <button class="btn btn-primary" name="save">Zapisz</button>
                            </li>
                            <li class="inner-addon">
                                <i class="glyphicon glyphicon-print"></i>
                                <button class="btn btn-default" name="print">Drukuj</button>
                            </li>
                            <li class="inner-addon">
                                <i class="glyphicon glyphicon-ban-circle"></i>
                                <button class="btn btn-default" name="delete">Skasuj</button>
                            </li>
                        </ul>
                    </div>
                    <div class="modal fade" id="pismoConfirm" tabindex="-1" role="dialog"
                         aria-labelledby="pismoConfirmLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Wprowadź nazwę pisma</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="pismoTitle">Podaj nazwę tego pisma:</label>
                                        <input type="text" class="form-control" id="pismoTitle" placeholder="Nowe pismo"
                                               maxlength="255">

                                        <p class="help-block errorMsg hide">Prosze wprowadzić nazwę pisma.</p>
                                    </div>
                                    <p class="help-block">Adresat Twojego pisma nie zobaczy tego pola. Będzie ono
                                        widoczne tylko dla Ciebie
                                        na stronie "Moje Pisma".</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                                    <button type="button" class="btn saveTemplate btn-primary">Zapisz</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <? /*
	
    <h2>Zapisz i wyślij</h2>
    <section>
        <div class="container preview">

            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <p class="hint-title">To jest Twoje gotowe pismo! Możesz je teraz wysłać do adresata lub tylko zapisać.
                    <br/>Twoje pismo jest prywatne - tylko Ty masz do niego dostęp. Po zapisaniu, będziesz mógł je
                    zanonimizować i upublicznić.</p>
            </div>

            <form id="finalForm" action="/pisma/nowe" method="post">
                <input name="miejscowosc" type="hidden" maxlength="127"/>
                <input name="data_pisma" type="hidden" maxlength="10"/>
                <textarea name="nadawca" class="hide" maxlength="511"></textarea>
                <input name="adresat_id" type="hidden"/>
                <input name="adresat" type="hidden" maxlength="511"/>
                <input name="szablon_id" type="hidden"/>
                <input name="tytul" type="hidden" maxlength="511"/>
                <input name="tresc" type="hidden"/>
                <textarea class="hide" name="podpis" maxlength="255"/></textarea>
                <input name="nazwa" type="hidden" value="Nowe pismo"/>

                <? /*
                <div class="row">
                    <div class="col-xs-12 col-md-10">
                        <fieldset>
                            <div class="form-group">
                                <label for="inputTtitle" class="col-lg-2 control-label">Nazwa pisma</label>

                                <div class="col-lg-10">
                                    <input name="nazwa" class="form-control" id="inputTtitle" autocomplete="off"
                                           maxlength="255" required="required"
                                           type="text"<?php if (!empty($pismo['nazwa'])) echo ' value="' . $pismo['nazwa'] . '"' ?>>

                                    <p class="desc">Adresat pisma nie zobaczy powyższego tytułu. Będzie on używany tylko
                                        do organizacji Twoich pism.</p>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                */ /* ?>

                <div class="row previewRender">
                    <div class="col-xs-12 col-md-10">
                        <div id="editor-cont" class="loading"></div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="editor-tooltip">

                            <ul class="form-buttons">
                                <li class="inner-addon">
                                    <i class="glyphicon glyphicon-send"></i>
                                    <input type="submit" name="send" value="Zapisz i wyślij"
                                           class="btn btn-primary"/>
                                </li>
                                <li class="inner-addon">
                                    <i class="glyphicon glyphicon-saved"></i>
                                    <input type="submit" name="save" value="Zapisz" class="btn btn-primary"/>
                                </li>
                                <li class="inner-addon">
                                    <i class="glyphicon glyphicon-print"></i>
                                    <input type="submit" name="print" value="Wydrukuj" class="btn btn-primary"/>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal fade" id="pismoConfirm" tabindex="-1" role="dialog"
                         aria-labelledby="pismoConfirmLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Wprowadź nazwę pisma</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="pismoTitle">Podaj nazwę tego pisma:</label>
                                        <input type="text" class="form-control" id="pismoTitle" placeholder="Nowe pismo"
                                               maxlength="255">

                                        <p class="help-block errorMsg hide">Prosze wprowadzić nazwę pisma.</p>
                                    </div>
                                    <p class="help-block">Adresat Twojego pisma nie zobaczy tego pola. Będzie ono
                                        widoczne tylko dla Ciebie
                                        na stronie "Moje Pisma".</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                                    <button type="button" class="btn saveTemplate btn-primary">Zapisz</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <? */ ?>
</div>
