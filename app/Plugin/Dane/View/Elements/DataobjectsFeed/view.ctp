<?php $this->Combinator->add_libs('js', 'Dane.feed'); ?>

<div class="dataBrowser dataFeed">
    <div class="dataObjects">
        <div class="innerContainer update-objects">

            <?
            if (isset($objects)) {
                if (empty($objects)) {
                    // echo '<p class="noResults">' . __d('dane', 'LC_DANE_BRAK_WYNIKOW') . '</p>';
                } else {
                    ?>
                    <ul class="dataFeed-ul list-group list-dataobjects">
                        <?= $this->element('Dane.DataobjectsFeed/loop', array(
                            'objects' => $objects,
                            'preset' => $preset,
                        )) ?>
                    </ul>

                    <? if ($pagination['total'] > $perPage) { ?>

                        <div data-nextPage="2" data-perPage="<?= $perPage ?>" data-direction="<?= $direction ?>"
                             class="loadMoreContent">

                            <div class="button">
                                <button class="btn btn-sm btn-default">
                                    <span class="glyphicon glyphicon-chevron-down"></span> Załaduj więcej
                                </button>
                            </div>

                            <div class="spinner" style="display: none;">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                        </div>

                    <? } ?>

                <?
                }
            }
            ?>

        </div>
    </div>
</div>