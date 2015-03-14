<?php $this->Combinator->add_libs('css', $this->Less->css('prawo', array('plugin' => 'Prawo'))) ?>
<?php $this->Combinator->add_libs('js', 'Prawo.prawo.js') ?>

<?= $this->Element('appheader', array('title' => 'Prawo', 'subtitle' => 'Przeglądaj prawo obowiązujące w Polsce', 'appMenu' => $appMenu, 'appMenuSelected' => $appMenuSelected, 'headerUrl' => 'prawo.png')); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="block-group">
                <div class="block acts">
                    <div class="block-header">
                        <h2 class="label">Ustawy, które ostatnio weszły w życie</h2>
                    </div>
                    <div class="content">
                        <ul class="acts">
                            <?
                            $last_date = false;
                            foreach ($ustawy_przeszlosc as $act) {

                                $show_date = ($last_date === false) || ($last_date != $act->getData('data_wejscia_w_zycie'));
                                $this->Dataobject->setObject($act);
                                ?>
                                <li class="row">
                                    <div class="row-inner">
                                        <div class="col-md-2">
                                            <? if ($show_date) { ?><p
                                                class="date"><?= $this->Czas->dataSlownie($act->getData('data_wejscia_w_zycie')) ?></p><? } ?>
                                        </div>
                                        <div class="col-md-10">
                                            <p class="title"><a
                                                    href="<?= $act->getUrl() ?>"><?= $act->getData('typ_nazwa') ?> <?= $act->getShortTitle() ?></a>
                                            </p>
                                            <? if ($opis = $act->getData('opis')) { ?>
                                                <div class="desc"><?= $opis ?></div><? } ?>
                                        </div>
                                    </div>
                                </li>
                                <?
                                $last_date = $act->getData('data_wejscia_w_zycie');
                            }
                            ?>
                        </ul>

                        <div class="btn_cont">
                            <a href="/dane/prawo/?!weszly=1&typ_id[]=1&search=web&order=data_wejscia_w_zycie desc"
                               class="btn btn-sm btn-default">Wszystkie &raquo;</a>
                        </div>
                    </div>
                </div>

                <div class="block acts">
                    <div class="block-header">
                        <h2 class="label">Ustawy, które wejdą w życie w przyszłości</h2>
                    </div>
                    <div class="content">
                        <ul class="acts">
                            <?
                            $last_date = false;
                            foreach ($ustawy_przyszlosc as $act) {

                                $show_date = ($last_date === false) || ($last_date != $act->getData('data_wejscia_w_zycie'));
                                $this->Dataobject->setObject($act);
                                ?>
                                <li class="row">

                                    <div class="row-inner">
                                        <div class="col-md-2">
                                            <? if ($show_date) { ?><p
                                                class="date"><?= $this->Czas->dataSlownie($act->getData('data_wejscia_w_zycie')) ?></p><? } ?>
                                        </div>
                                        <div class="col-md-10">
                                            <p class="title"><a
                                                    href="<?= $act->getUrl() ?>"><?= $act->getData('typ_nazwa') ?> <?= $act->getShortTitle() ?></a>
                                            </p>
                                            <? if ($opis = $act->getData('opis')) { ?>
                                                <div class="desc"><?= $opis ?></div><? } ?>
                                        </div>
                                    </div>

                                </li>
                                <?
                                $last_date = $act->getData('data_wejscia_w_zycie');
                            }
                            ?>
                        </ul>

                        <div class="btn_cont">
                            <a href="/dane/prawo/?!wejda=1&typ_id[]=1&search=web&order=data_wejscia_w_zycie asc"
                               class="btn btn-sm btn-default">Wszystkie &raquo;</a>
                        </div>

                    </div>
                </div>

                <div class="block acts">
                    <div class="block-header">
                        <h2 class="label">Najnowsze projekty ustaw</h2>
                    </div>
                    <div class="content">
                        <ul class="acts">
                            <?
                            $last_date = false;
                            foreach ($projekty as $act) {

                                $show_date = ($last_date === false) || ($last_date != $act->getDate());
                                $this->Dataobject->setObject($act);
                                ?>
                                <li class="row">

                                    <div class="row-inner">
                                        <div class="col-md-2">
                                            <? if ($show_date) { ?><p
                                                class="date"><?= $this->Czas->dataSlownie($act->getDate()) ?></p><? } ?>
                                        </div>
                                        <div class="col-md-10">
                                            <p class="title"><a
                                                    href="<?= $act->getUrl() ?>"><?= $act->getShortTitle() ?></a></p>
                                            <? if ($opis = $act->getData('opis')) { ?>
                                                <div class="desc"><?= $opis ?></div><? } ?>
                                        </div>
                                    </div>

                                </li>
                                <?
                                $last_date = $act->getDate();
                            }
                            ?>
                        </ul>

                        <div class="btn_cont">
                            <a href="/dane/prawo_projekty" class="btn btn-sm btn-default">Wszystkie &raquo;</a>
                        </div>

                    </div>
                </div>


            </div>

        </div>
        <div class="col-md-4">
            <div class="block-group">
                <div class="block nobg">
                    <div class="block-header">
                        <h2 class="label">Ważne</h2>
                    </div>
                    <div class="content">

                        <ul class="popular">
                            <? foreach ($popular as $act) { ?>
                                <li><a href="/dane/prawo/<?= $act['id'] ?>"><?= $act['nazwa'] ?></a></li>
                            <? } ?>
                        </ul>

                    </div>
                </div>

                <div class="block nobg">
                    <div class="block-header">
                        <h2 class="label">Baza aktów prawnych</h2>
                    </div>
                    <div class="content nopadding">


                        <ul class="types">
                            <?
                            foreach ($types as $type) {
                                $href = '/dane/prawo?typ_id[]=' . $type['id'];
                                ?>
                                <li class="row">
                                    <p class="title pull-left"><a href="<?= $href ?>"><?= $type['nazwa'] ?></a> <span
                                            class="badge counter"><?= _number($type['count']) ?></span></p>
                                    <? if ($type['count']) { ?><p class="pending pull-right"><a
                                            href="/dane/prawo/?!wejda=1&typ_id[]=<?= $type['id'] ?>&search=web&order=data_wejscia_w_zycie asc"
                                            class="label label-warning"><?= pl_dopelniacz($type['pending_count'], 'oczekujący', 'oczekujące', 'oczekujących') ?></a>
                                        </p><? } ?>
                                </li>
                            <? } ?>
                        </ul>

                        <div class="btn_cont">
                            <a href="/dane/prawo" class="btn btn-sm btn-default">Wszystkie akty &raquo;</a>
                        </div>

                    </div>
                </div>

                <div class="block nobg">
                    <div class="block-header">
                        <h2 class="label">Najnowsze prawo według tematów</h2>
                    </div>
                    <div class="content nopadding">

                        <ul class="keywords">
                            <? foreach ($keywords as $keyword) { ?>
                                <li><a class="label label-primary"
                                       href="/dane/prawo_hasla/<?= $keyword['id'] ?>"><?= $keyword['q'] ?></a></li>
                            <? } ?>
                        </ul>

                        <div class="btn_cont">
                            <a href="/dane/prawo_hasla" class="btn btn-sm btn-default">Wszystkie tematy &raquo;</a>
                        </div>

                    </div>
                </div>


            </div>

        </div>

    </div>

</div>