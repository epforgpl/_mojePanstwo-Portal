<? echo $this->Element('dataobject/pageBegin'); ?>

<div class="row">
	<div class="col-sm-9">
		<?= $this->Document->place( $object->getData('prawo.dokument_id') ) ?>
	</div>
    <div class="col-md-3">

        <ul class="dataHighlights rightColumn margin-top-15">

            <?
            $data_wydania = $object->getData('prawo.data_wydania');
            if (isset($data_wydania) && !empty($data_wydania) && ($data_wydania != '0000-00-00')) { ?>
                <li class="dataHighlight col-xs-12">
                    <p class="_label">Data wydania</p>

                    <p class="_value"><?= $this->Czas->dataSlownie($data_wydania); ?></p>
                </li>
            <? } ?>

            <?
            $data_publikacji = $object->getData('prawo.data_publikacji');
            if (isset($data_publikacji) && !empty($data_publikacji) && ($data_publikacji != '0000-00-00')) { ?>
                <li class="dataHighlight col-xs-12">
                    <p class="_label">Data publikacji</p>

                    <p class="_value"><?= $this->Czas->dataSlownie($data_publikacji); ?></p>
                </li>
            <? } ?>


            <?
            $data_wejscia_w_zycie = $object->getData('prawo.data_wejscia_w_zycie');
            if (isset($data_wejscia_w_zycie) && !empty($data_wejscia_w_zycie) && ($data_wejscia_w_zycie != '0000-00-00')) { ?>
                <li class="dataHighlight col-xs-12">
                    <p class="_label">Data wejścia w życie</p>

                    <p class="_value"><?= $this->Czas->dataSlownie($data_wejscia_w_zycie); ?></p>
                </li>
            <? } ?>

            <?
            if ($sygnatura = $object->getData('prawo.sygnatura')) { ?>
                <li class="dataHighlight col-xs-12">
                    <p class="_label">Sygnatura</p>

                    <p class="_value"><?= $sygnatura ?></p>
                </li>
            <? } ?>
        </ul>

    </div>
</div>

<? echo $this->Element('dataobject/pageEnd'); ?>
