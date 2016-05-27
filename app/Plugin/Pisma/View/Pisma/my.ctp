<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('pisma-moje', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma-my.js') ?>

<? echo $this->Element('menu'); ?>

<? if (!$this->Session->read('Auth.User.id')) { ?>
    <div class="container">
        <div class="col-md-10 col-sm-offset-1">
            <div class="alert-identity alert alert-dismissable alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>

                <p>Nie jesteś zalogowany. Twoje pisma będą przechowywane na tym urządzeniu przez 24 godziny. <a
                        class="_specialCaseLoginButton" href="/login">Zaloguj się</a>, aby trwale przechowywać pisma na
                    swoim koncie.</p>
            </div>
        </div>
    </div>
<? } ?>

<? if ($pagination['total']) { ?>
    <div class="search-container">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="suggesterBlock searchForm">
                        <form class="form-horizontal suggesterBlock" method="get" action="/pisma">
                            <div class="searcher form-group has-feedback">
                                <div class="input-group">
                                    <input class="form-control hasclear input-lg" name="q" type="text"
                                           value="<?= htmlentities(stripcslashes($q), ENT_QUOTES | ENT_IGNORE, "UTF-8") ?>"
                                           placeholder="Szukaj w moich pismach...">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-primary input-lg">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<? } ?>

<div class="container" id="myPismaBrowser" data-query='<?= json_encode($query); ?>'>
    <div class="col-md-10 col-sm-offset-1">

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
                            <form action="/pisma/moje" method="post">
                                <input name="action" value="delete" type="hidden"/>

                                <div class="inputs">
                                </div>
                                <button class="btn btn-default deleteButton" type="submit">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </button>
                            </form>
                        </div>
                        <div class="optionsUnChecked">

                            <? if (isset($aggs['template'])) echo $this->element('Pisma.aggs', array(
                                'data' => $aggs['template'],
                                'label' => 'Szablon',
                                'allLabel' => 'Wszystkie szablony',
                                'var' => 'template',
                                'selected' => isset($filters_selected['template']),
                            )); ?>

                            <? if (isset($aggs['to'])) echo $this->element('Pisma.aggs', array(
                                'data' => $aggs['to'],
                                'label' => 'Adresat',
                                'allLabel' => 'Wszyscy adresaci',
                                'var' => 'to',
                                'selected' => isset($filters_selected['to']),
                            )); ?>

                            <? if (isset($aggs['sent'])) echo $this->element('Pisma.aggs', array(
                                'data' => $aggs['sent'],
                                'label' => 'Status',
                                'allLabel' => 'Wszystkie statusy',
                                'var' => 'sent',
                                'selected' => isset($filters_selected['sent']),
                            )); ?>

                            <? if (isset($aggs['access'])) echo $this->element('Pisma.aggs', array(
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
                            <p class="remove-filters"><a href="/pisma/moje"><span
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
                                    <a href="/pisma/<?= $item['alphaid'] ?>,<?= $item['slug'] ?>">
                                        <img src="http://pisma.sds.tiktalik.com/thumbs/<?= $item['hash'] ?>.png"
                                             onerror="imgFixer(this)"/>
                                    </a>
                                </div>
                                <div class="cont">

                                    <p class="title">
                                        <a href="/pisma/<?= $item['alphaid'] ?>,<?= $item['slug'] ?>"><?= (isset($item['name']) && $item['name']) ? $item['name'] : 'Pismo' ?></a>
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
                                <a href="/pisma/moje?page=<?php echo $x + 1; ?>" type="button"
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
                            <br/><br/>
                            <a target="_self" href="/pisma/nowe" class="btn btn-info">Nowe pismo</a>
                        </div>
                    </div>
                    <?
                }
            } ?>

        </div>
    </div>
</div>
