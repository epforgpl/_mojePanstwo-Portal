<?
$this->Combinator->add_libs('css', $this->Less->css('view-msig', array('plugin' => 'Dane')));
echo $this->Element('dataobject/pageBegin');
?>


    <div class="mpanel msig toc col-md-12">

        <? if ($toc = $object->getLayer('toc')) { ?>

            <ul class="dzialy">

                <? foreach ($toc as $_id => $dzial) { ?>

                    <li>

                        <h2>
                            <a href="/dane/msig/<?= $object->getId() ?>/dzialy/<?= $dzial['id'] ?>"><?= $dzial['nazwa'] ?></a>
                        </h2>

                        <? if (!empty($dzial['rozdzialy'])) { ?>

                            <ul class="rozdzialy">

                                <? foreach ($dzial['rozdzialy'] as $_id => $rozdzial) { ?>

                                    <li>

                                        <h3><?= $rozdzial['nazwa'] ?></h3>

                                        <? if (!empty($rozdzial['pozycje'])) { ?>

                                            <ul class="pozycje">

                                                <? foreach ($rozdzial['pozycje'] as $_id => $pozycja) { ?>

                                                    <li>

                                                        <p><?= $pozycja['nazwa'] ?></p>

                                                    </li>

                                                <? } ?>

                                            </ul>

                                        <? } ?>

                                    </li>

                                <? } ?>

                            </ul>

                        <? } ?>

                    </li>

                <? } ?>

            </ul>

        <? } ?>

    </div>


<?= $this->Element('dataobject/pageEnd'); ?>