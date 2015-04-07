<div class="objectSideInner">

    <ul class="dataHighlights side">


        <li class="dataHighlight big">
            <p class="_label">Liczba ludności</p>

            <div>
                <p class="_value"><?= number_format_h($object->getData('liczba_ludnosci')); ?></p>
            </div>
        </li>

        <li class="dataHighlight big">
            <p class="_label">Powierzchnia</p>

            <div>
                <p class="_value"><?= number_format($object->getData('powierzchnia'), 0); ?> km<sup>2</sup></p>
            </div>
        </li>


        <li class="dataHighlight topborder">
            <p class="_label">Dochody roczne gminy</p>

            <div>
                <p class="_value"><?= number_format_h($object->getData('dochody_roczne')); ?> PLN</p>
            </div>
        </li>

        <li class="dataHighlight">
            <p class="_label">Wydatki roczne gminy</p>

            <div>
                <p class="_value"><?= number_format_h($object->getData('wydatki_roczne')); ?> PLN</p>
            </div>
        </li>

        <li class="dataHighlight">
            <p class="_label">Deficyt roczny gminy</p>

            <div>
                <p class="_value"><?= number_format_h($object->getData('zadluzenie_roczne')); ?> PLN</p>
            </div>
        </li>


    </ul>

    <ul class="dataHighlights side hide">

        <li class="dataHighlight">
            <p class="_label">Kod TERYT</p>

            <div>
                <p class="_value"><?= $object->getData('teryt'); ?></p>
            </div>
        </li>

        <li class="dataHighlight">
            <p class="_label">Kod NTS</p>

            <div>
                <p class="_value"><?= $object->getData('nts'); ?></p>
            </div>
        </li>

        <li class="dataHighlight topborder">
            <p class="_label">Biuletyn Informacji Publicznej</p>

            <div>
                <p class="_value"><?= $object->getData('bip_www'); ?></p>
            </div>
        </li>

    </ul>

    <p style="display: none;" class="text-center showHideSide">
        <a class="a-more">Więcej &darr;</a>
        <a class="a-less hide">Mniej &uarr;</a>
    </p>

</div>