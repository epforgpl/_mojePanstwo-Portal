<?php $this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start'))) ?>
<?php $this->Combinator->add_libs('js', 'Start.rangy/rangy-core.js') ?>
<?php $this->Combinator->add_libs('js', 'Start.rangy/rangy-classapplier.js') ?>
<?php $this->Combinator->add_libs('js', 'Start.rangy/rangy-textrange.js') ?>
<?php $this->Combinator->add_libs('js', 'Start.rangy/rangy-highlighter.js') ?>
<?php $this->Combinator->add_libs('js', 'Start.letters.js') ?>
<?php $this->Combinator->add_libs('js', 'Start.letters-share.js') ?>

<?= $this->element('Start.pageBegin'); ?>

<? echo $this->element('Start.letters-pismo-header', array(
    'pismo' => $pismo,
    'alert' => true,
)); ?>
<div class="row">
    <div id="stepper">
        <div class="content clearfix">
            <div class="col-xs-12 view">
                <? echo $this->element('Start.letters-render'); ?>
            </div>
            <div class="col-xs-12 nopadding">
                <div class="editor-tooltip">

                    <? $href_base = '/moje-pisma/' . $pismo['alphaid'] . ',' . $pismo['slug']; ?>

                    <ul class="form-buttons">
                        <li class="inner-addon">
                            <button class="btn btn-info" type="button" ontouchstart="highlightSelectedText();"
                                    onclick="highlightSelectedText();">Ukryj tekst
                            </button>
                            <p class="desc">Zaznacz tekst aby go ukryć.</p>
                        </li>
                        <li class="inner-addon">
                            <button class="btn btn-info" type="button"
                                    ontouchstart="removeHighlightFromSelectedText();"
                                    onclick="removeHighlightFromSelectedText();">Odkryj tekst
                            </button>
                            <p class="desc">Zaznacz ukryty tekst aby od odkryć.</p>
                        </li>

                    </ul>

                    <div class="more-buttons-switcher-cont">
                        <ul class="form-buttons more-buttons-target" style="display: none;">
                            <li class="inner-addon left-addon">
                                <form onsubmit="return confirm('Czy na pewno chcesz usunąć to pismo?');"
                                      method="post"
                                      action="/moje-pisma/<?= $pismo['alphaid'] ?>,<?= $pismo['slug'] ?>">
                                    <button name="delete" type="submit" class="btn btn-danger btn-icon"><i
                                            class="icon glyphicon glyphicon-trash"></i>Skasuj
                                    </button>
                                </form>
                            </li>
                        </ul>
                        <a class="more-buttons-switcher" data-mode="more" href="#more">
                            <span class="glyphicon glyphicon-chevron-down"></span>
                            <span class="text">Więcej</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->element('Start.pageEnd'); ?>
