<?php
$this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start')));
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Start.letters.js');
?>
<?
echo $this->Html->css($this->Less->css('app'));

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>
<?
/* tinymce */
echo $this->Html->script('../plugins/tinymce/js/tinymce/tinymce.min', array('block' => 'scriptBlock'));
?>
<? if (!$this->Session->read('Auth.User.id')) { ?>
    <div class="col-xs-12 nopadding">
        <div class="alert-identity alert alert-dismissable alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4>Uwaga!</h4>

            <p>Nie jesteś zalogowany. Twoje pisma będą przechowywane na tym urządzeniu przez 24 godziny. <a
                    class="_specialCaseLoginButton" href="/login">Zaloguj się</a>, aby trwale przechowywać pisma na
                swoim koncie.</p>
        </div>
    </div>
<? } ?>


<div class="app-content-wrap">
    <div class="objectsPage">

        <?= $this->element('letters/header') ?>

        <?= $this->element('letters/menu', array(
            'plugin' => 'Start',
            'active' => 'edit',
        )); ?>

        <div class="container">

            <div class="row">
                <div class="col-md-9 margin-top-15">

                    <? if (@$pismo['_template'][0]['opis']) { ?>
                        <div class="alert alert-info margin-top-15 margin-sides-20">

                            <?= $pismo['_template'][0]['opis'] ?>

                        </div>
                    <? } ?>

                    <? if (@$pismo['_template'][0]['podstawa_prawna']) { ?>
                        <div class="margin-sides-20">
                            <div class="block block-simple nobg margin-top-0">
                                <header>Do Twojego pisma zostanie dołączona następująca podstawa prawna:</header>
                                <section class="content">
                                    <div><?= $pismo['_template'][0]['podstawa_prawna'] ?></div>
                                </section>
                            </div>
                        </div>
                    <? } ?>

                    <div class="bs-component mp-form nobg mp-form-letter">
                        <form action="/moje-pisma/<?= $pismo['id'] ?>,<?= $pismo['slug'] ?>" method="post"
                              class="form-horizontal">
                            <input type="hidden" name="edit_from_inputs" value="1"/>
                            <fieldset>
                                <?
                                if ($pismo['_inputs']) {
                                    if ($inputs = $pismo['_inputs']) {
                                        foreach ($inputs as $input) {

                                            $full = true;
                                            $v = '';
                                            if ($input['value'])
                                                $v = $input['value'];
                                            elseif ($input['default_value']) {

                                                $v = $input['default_value'];

                                                if (
                                                    $v &&
                                                    ($v[0] == '$') &&
                                                    preg_match('/^\$session\[(.*?)\]$/i', $v, $match)
                                                )
                                                    $v = $this->Session->read($match[1]);

                                            }

                                            if ($input['type'] == 'richtext') {
                                                ?>
                                                <div class="form-group form-row">
                                                    <? if ($input['label']) { ?><label for="inp<?= $input['id'] ?>"
                                                                                       class="col-lg-12 control-label control-label-full"><?= $input['label'] ?></label><? } ?>
                                                    <div class="col-lg-12">
					                        <textarea class="form-control tinymceField" rows="20"
                                                      id="inp<?= $input['id'] ?>"
                                                      name="inp<?= $input['id'] ?>"><?= $v ?></textarea>
                                                        <? if (@$input['desc']) { ?><span
                                                            class="help-block"><?= $input['desc'] ?></span><? } ?>
                                                    </div>
                                                </div>
                                                <?
                                            } elseif ($input['type'] == 'text') {
                                                ?>
                                                <div class="form-group form-row">
                                                    <? if ($input['label']) { ?><label for="inp<?= $input['id'] ?>"
                                                                                       class="<? if ($full) { ?>col-lg-12 control-label-full<? } else { ?>col-lg-2 control-label<? } ?>"><?= $input['label'] ?></label><? } ?>
                                                    <div
                                                        class="<? if ($full) { ?>col-lg-12<? } else { ?>col-lg-10<? } ?>">
                                                        <input value="<?= $v ?>" type="text" class="form-control"
                                                               id="inp<?= $input['id'] ?>"
                                                               name="inp<?= $input['id'] ?>"<? if (@$input['placeholder']) { ?> placeholder="<?= $input['placeholder'] ?>"<? } ?>>
                                                        <? if (@$input['desc']) { ?><span
                                                            class="help-block"><?= $input['desc'] ?></span><? } ?>
                                                    </div>
                                                </div>
                                                <?
                                            } elseif ($input['type'] == 'date') {
                                                ?>
                                                <div class="form-group form-row">
                                                    <label for="inp<?= $input['id'] ?>"
                                                           class="<? if ($full) { ?>col-lg-12 control-label-full<? } else { ?>col-lg-2 control-label<? } ?>"><?= $input['label'] ?></label>
                                                    <div
                                                        class="<? if ($full) { ?>col-lg-12<? } else { ?>col-lg-10<? } ?>">
                                                        <input value="<?= $v ?>" style="max-width: 130px;"
                                                               maxlength="10" type="text" class="form-control"
                                                               id="inp<?= $input['id'] ?>"
                                                               name="inp<?= $input['id'] ?>"<? if (@$input['placeholder']) { ?> placeholder="<?= $input['placeholder'] ?>"<? } ?>>
                                                        <? if (@$input['desc']) { ?><span
                                                            class="help-block"><?= $input['desc'] ?></span><? } ?>
                                                    </div>
                                                </div>
                                                <?
                                            } elseif ($input['type'] == 'email') {
                                                ?>
                                                <div class="form-group form-row">
                                                    <label for="inp<?= $input['id'] ?>"
                                                           class="<? if ($full) { ?>col-lg-12 control-label-full<?
                                                           } else { ?>col-lg-2 control-label<?
                                                           } ?>"><?= $input['label'] ?></label>
                                                    <div class="<? if ($full) { ?>col-lg-12<?
                                                    } else { ?>col-lg-10<?
                                                    } ?>">
                                                        <input value="<?= $v ?>" type="text" class="form-control"
                                                               id="inp<?= $input['id'] ?>"
                                                               name="inp<?= $input['id'] ?>"<? if (@$input['placeholder']) { ?> placeholder="<?= $input['placeholder'] ?>"<? } ?>>
                                                        <? if (@$input['desc']) { ?><span
                                                            class="help-block"><?= $input['desc'] ?></span><? } ?>
                                                    </div>
                                                </div>
                                                <?
                                            }

                                        }
                                    }
                                } else {

                                    $full = true;
                                    $v = '';

                                    ?>

                                    <div class="form-group form-row">
                                        <label for="inp0" class="<? if ($full) { ?>col-lg-12 control-label-full<?
                                        } else { ?>col-lg-2 control-label<?
                                        } ?>">Treść pisma</label>
                                        <div class="<? if ($full) { ?>col-lg-12<?
                                        } else { ?>col-lg-10<?
                                        } ?>">
                                            <textarea class="form-control tinymceField" rows="10" id="inp0"
                                                      name="inp0"><?= $v ?></textarea>
                                        </div>
                                    </div>

                                    <?
                                }
                                ?>

                                <div class="form-group form-row">
                                    <div class="col-lg-12 text-center">
                                        <? if ($pismo['saved']) { ?>
                                            <a href="/moje-pisma/<?= $pismo['id'] ?>,<?= $pismo['slug'] ?>"
                                               class="btn btn-md btn-default">Anuluj</a>
                                            <button type="submit" class="createBtn btn btn-md btn-primary btn-icon"><i
                                                    class="icon icon-applications-pisma"></i>Zapisz
                                            </button>
                                        <? } else { ?>
                                            <button type="submit" class="createBtn btn btn-md btn-success btn-icon"><i
                                                    class="icon icon-applications-pisma"></i>Zapisz i zobacz podgląd
                                                pisma
                                            </button>
                                        <? } ?>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>


                </div>
                <div class="col-md-3">


                    <?= $this->element('letters/side', array('plugin' => 'Start',)); ?>


                </div>
            </div>


        </div>
    </div>
</div>
