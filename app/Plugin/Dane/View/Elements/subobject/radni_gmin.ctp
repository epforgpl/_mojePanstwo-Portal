<?php $this->Combinator->add_libs('css', $this->Less->css('radny_details', array('plugin' => 'PrzejrzystyKrakow'))) ?>

<?php
if ($metaDesc = $object->getMetaDescription()) { ?>
    <p class="meta meta-desc"><?= $metaDesc ?></p>
<? }
if ($object->getDescription()) { ?>
    <div class="description">
        <?= $object->getDescription() ?>
    </div>
<? } ?>

<div class="krakowRadnyDetail">
    <div class="row col-xs-12">
        <? if (($tel = $object->getData('tel')) && ($tel !== 'nie')) { ?>
            <div class="option pull-left">
                <a href="skype:<?= $tel; ?>">
                    <i class="fa fa-phone"></i>
                </a>
            </div>
        <? } ?>
        <? if ($fb = $object->getData('fb')) { ?>
            <div class="option pull-left">
                <a href="<?= $fb; ?>" target="_blank">
                    <i class="fa fa-facebook"></i>
                </a>
            </div>
        <? } ?>
        <? if ($blog = $object->getData('blog')) { ?>
            <div class="option pull-left">
                <a href="<?= $blog; ?>" target="_blank">
                    <i class="fa fa-pencil"></i>
                </a>
            </div>
        <? } ?>
        <? if ($www = $object->getData('www')) { ?>
            <div class="option pull-left">
                <a href="<?= $www; ?>" target="_blank">
                    <i class="fa fa-globe"></i>
                </a>
            </div>
        <? } ?>
        <? if ($wiki = $object->getData('wiki')) { ?>
            <div class="option pull-left">
                <a href="<?= $wiki; ?>" target="_blank">
                    <i class="fa fa-wikipedia-w"></i>
                </a>
            </div>
        <? } ?>
    </div>
    <!--<div class="row col-xs-12 col-md-7">
        <table class="table table-condensed">
            <?php /*if (true || isset($detail['rok_urodzenia'])) { */ ?>
                <tr>
                    <td>Data urodzenia</td>
                    <td><? /*= $detail['rok_urodzenia'] */ ?>(potrzeba pełna date)</td>
                </tr>
            <? /* } */ ?>
            <?php /*if (true) { */ ?>
                <tr>
                    <td>Miejsce urodzenia</td>
                    <td>(potrzeba danych)</td>
                </tr>
            <? /* } */ ?>
            <?php /*if (true) { */ ?>
                <tr>
                    <td>Miejsce pracy</td>
                    <td>(potrzeba danych)</td>
                </tr>
            <? /* } */ ?>
            <?php /*if (true) { */ ?>
                <tr>
                    <td>Adres email</td>
                    <td>(potrzeba danych)</td>
                </tr>
            <? /* } */ ?>
            <?php /*if (true) { */ ?>
                <tr>
                    <td>Telefon</td>
                    <td>(potrzeba danych)</td>
                </tr>
            <? /* } */ ?>
            <?php /*if (isset($detail['radni_gmin.data_wybrania'])) { */ ?>
                <tr>
                    <td>Data wybrania</td>
                    <td><? /*= $detail['radni_gmin.data_wybrania'] */ ?></td>
                </tr>
            <? /* } */ ?>
            <?php /*if (isset($detail['liczba_glosow'])) { */ ?>
                <tr>
                    <td>Liczba otrzymanych głosów</td>
                    <td><? /*= $detail['liczba_glosow'] */ ?><?php /*if (isset($detail['procent_glosow_w_okregu'])) {
                            echo ' (' . $detail['procent_glosow_w_okregu'] . '%)';
                        } */ ?></td>
                </tr>
            <? /* } */ ?>
            <?php /*if (isset($detail['liczba_interpelacji'])) { */ ?>
                <tr>
                    <td>Liczba interpelacji</td>
                    <td><? /*= $detail['liczba_interpelacji'] */ ?></td>
                </tr>
            <? /* } */ ?>
            <?php /*if (true || isset($detail['kadencja_id'])) { */ ?>
                <tr>
                    <td>Kadencje</td>
                    <td><? /*= implode(", ", $detail['kadencja_id']) */ ?>(zaznaczyć pogrubieniem info w którym był radnym)
                    </td>
                </tr>
            <? /* } */ ?>
        </table>
    </div>
    <div class="col-xs-12 col-md-5">
        <h3><? /*= $detail['okreg_nr'] */ ?></h3>
        (mapa okręgu)
    </div>-->
</div>