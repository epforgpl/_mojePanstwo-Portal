<? echo $this->Element('dataobject/pageBegin'); ?>

    <div class="administracjaPubliczna row">

        <? if ($object->getData('file') != '1') { ?>

            <div class="col-md-9 col-md-offset-1">
                <div class="">

                    <div class="block-group">

                        <? if (isset($info['opis_html']) && $info['opis_html']) { ?>
                            <div class="block">
                                <div class="block-header">
                                    <h2 class="label">Informacje</h2>
                                </div>
                                <div class="content opis">
                                    <?= $info['opis_html'] ?>
                                </div>
                            </div>
                        <? } ?>


                        <? if (
                            ($tree = $object->getLayer('tree')) &&
                            ($items = $tree['items'])
                        ) {
                            ?>
                            <div class="block">
                                <div class="block-header">

                                    <h2 class="label">Podległe instytucje</h2>

                                </div>
                                <div class="content nopadding">

                                    <div class="tree">
                                        <ul>
                                            <li>
                                                <?
                                                echo $this->Element('Dane.objects/instytucje/list', array(
                                                    'items' => $items,
                                                    'i' => 0,
                                                ));
                                                ?>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        <? } ?>

                    </div>

                </div>
            </div>

        <? } ?>

    </div>

<?= $this->Element('dataobject/pageEnd'); ?>