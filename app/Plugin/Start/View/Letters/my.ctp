<?php $this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('letters-moje', array('plugin' => 'Start'))) ?>
<?php $this->Combinator->add_libs('js', 'Start.letters-my.js') ?>

<?
	echo $this->Html->css($this->Less->css('app'));

	echo $this->element('headers/main');
	echo $this->element('app/sidebar');
?>

<div class="overflow-auto">
	<h1 class="pull-left">Moje pisma</h1>
    <a href="/moje-pisma/nowe" class="btn btn-primary btn-icon submit width-auto pull-right margin-top-20">
        <i aria-hidden="true" class="icon glyphicon glyphicon-plus"></i>
        Nowe pismo
    </a>
</div>

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

<div id="myPismaBrowser" data-query='<?= json_encode($query); ?>'>
    <div class="col-xs-12">

        <div class="letters">

            <? if ($pagination['total']) { ?>

                <div class="row actionbar">
                    <div class="col-md-1 text-center">
                        <input type="checkbox" class="checkAll margin-top-10"/>
                    </div>
                    <div class="col-md-4 desc text-muted">
                        <div class="selectedCount margin-top-7"></div>
                        <div class="paginationList margin-top-7">
                            <? echo ($pagination['page'] * $pagination['perPage']) - ($pagination['perPage'] - 1) ?>
                            <span
                                class="small">-</span> <?= $pagination['total'] > ($pagination['page'] * $pagination['perPage']) ? ($pagination['page'] * $pagination['perPage']) : $pagination['total'] ?>
                            <span class="small">z</span> <?= $pagination['total'] ?>
                        </div>
                    </div>
                    <div class="col-md-7 text-right">
                        <div class="optionsChecked">
                            <form action="/moje-pisma/moje" method="post">
                                <input name="action" value="delete" type="hidden"/>

                                <div class="inputs">
                                </div>
                                <button class="btn btn-default deleteButton" type="submit">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </button>
                            </form>
                        </div>
                        <div class="optionsUnChecked">

                            <? if (isset($aggs['template'])) echo $this->element('Start.letters-aggs', array(
                                'data' => $aggs['template'],
                                'label' => 'Szablon',
                                'allLabel' => 'Wszystkie szablony',
                                'var' => 'template',
                                'selected' => isset($filters_selected['template']),
                            )); ?>

                            <? if (isset($aggs['to'])) echo $this->element('Start.letters-aggs', array(
                                'data' => $aggs['to'],
                                'label' => 'Adresat',
                                'allLabel' => 'Wszyscy adresaci',
                                'var' => 'to',
                                'selected' => isset($filters_selected['to']),
                            )); ?>

                            <? if (isset($aggs['sent'])) echo $this->element('Start.letters-aggs', array(
                                'data' => $aggs['sent'],
                                'label' => 'Status',
                                'allLabel' => 'Wszystkie statusy',
                                'var' => 'sent',
                                'selected' => isset($filters_selected['sent']),
                            )); ?>

                            <? if (isset($aggs['access'])) echo $this->element('Start.letters-aggs', array(
                                'data' => $aggs['access'],
                                'label' => 'Dostęp',
                                'allLabel' => 'Wszystko',
                                'var' => 'access',
                                'selected' => isset($filters_selected['access']),
                            )); ?>

                        </div>
                    </div>
                </div>

                <? if (!empty($filters_selected)) { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="remove-filters"><a href="/moje-pisma/moje"><span
                                        class="glyphicon glyphicon-remove"></span> Usuń wszystkie filtry</a></p>
                        </div>
                    </div>
                <? } ?>

                <div class="items">
                    <? foreach ($items as $item) { ?>
                        <div class="row item-list" data-id="<?= $item['alphaid']; ?>">
                            <div class="col-sm-1 text-center haveCheckbox">
                                <input type="checkbox" class="itemCheckbox"/>
                            </div>
                            <div class="col-sm-9">
                                <div class="thumb">
                                    <a href="/moje-pisma/<?= $item['alphaid'] ?>,<?= $item['slug'] ?>">
                                        <img src="http://pisma.sds.tiktalik.com/thumbs/<?= $item['hash'] ?>.png"
                                             onerror="imgFixer(this)"/>
                                    </a>
                                </div>
                                <div class="cont">

                                    <p class="title">
                                        <a href="/moje-pisma/<?= $item['alphaid'] ?>,<?= $item['slug'] ?>"><?= (isset($item['name']) && $item['name']) ? $item['name'] : 'Pismo' ?></a>
                                    </p>

                                    <? if (isset($item['sent']) && $item['sent']) { ?>
                                        <p class="meta">
                                            Wysłano: <?= date('Y-m-d H:i:s', strtotime($item['sent_at'])) ?>
                                        </p>
                                    <? } ?>

                                    <? if (isset($item['to_name'])) { ?>
                                        <p class="fields">
                                            <small>Do:</small>
                                            <span class="val"><?= $item['to_name'] ?></span>
                                        </p>
                                    <? } ?>

                                </div>
                            </div>
                            <div class="col-sm-2 text-right">
                            <span class="date">
                                <?= dataSlownie($item['date']); ?>
                            </span>
                            </div>
                        </div>
                    <? } ?>
                </div>

                <?php if (1 < $pagination['total'] / $pagination['perPage']) { ?>
                    <div class="paginationListNumber">
                        <div class="btn-group" role="group">
                            <?php for ($x = 0; $x < $pagination['total'] / $pagination['perPage']; $x++) { ?>
                                <a href="/moje-pisma/moje?page=<?php echo $x + 1; ?>" type="button"
                                   class="btn btn-default<?php if (($x + 1) == $pagination['page']) echo ' active' ?>"><?php echo $x + 1; ?></a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

            <? } else {
                if ($q) {
                    ?>
                    <p class="letters-msg">Brak pism</p>
                    <?
                } else {
                    ?>
                    <div class="informationBlock missing col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
                        <div class="col-xs-12 information">

                            <h2>Nie stworzyłeś jeszcze żadnych pism</h2>
                        </div>
                    </div>
                    <?
                }
            } ?>

        </div>
    </div>
</div>
