<ul class="dataHighlights side">
    <li class="dataHighlight big">
        <p class="_label">Liczba obserwujacych</p>

        <p class="_value"><?= _number($object->getData('liczba_obserwujacych')); ?></p>
    </li>
    <li class="dataHighlight inl">
        <p class="_label">Liczba tweetów</p>

        <p class="_value"><?= _number($object->getData('liczba_tweetow')); ?></p>
    </li>
    <li class="dataHighlight inl">
        <p class="_label">Liczba retweetów</p>

        <p class="_value"><?= _number($object->getData('liczba_retweetow_wlasnych')); ?></p>
    </li>
    <li class="dataHighlight inl">
        <p class="_label">Liczba wzmianek</p>

        <p class="_value"><?= _number($object->getData('liczba_wzmianek_rts')); ?></p>
    </li>
    <li class="dataHighlight inl">
        <p class="_label">Liczba odpowiedzi</p>

        <p class="_value"><?= _number($object->getData('liczba_odpowiedzi_rts')); ?></p>
    </li>
</ul>

<p class="text-center showHideSide">
    <a class="a-more">Więcej &darr;</a>
    <a class="a-less hide">Mniej &uarr;</a>
</p>

<ul class="dataHighlights side hide">
    <li class="dataHighlight inl topborder">
        <p class="_label">Liczba tweetów w 2013 r.</p>

        <p class="_value"><?= _number($object->getData('liczba_tweetow_wlasnych_2013')); ?></p>
    </li>
    <li class="dataHighlight inl">
        <p class="_label">Liczba retweetów w 2013 r.</p>

        <p class="_value"><?= _number($object->getData('liczba_retweetow_wlasnych_2013')); ?></p>
    </li>
    <li class="dataHighlight inl">
        <p class="_label">Liczba wzmianek w 2013 r.</p>

        <p class="_value"><?= _number($object->getData('liczba_wzmianek_rts_2013')); ?></p>
    </li>
    <li class="dataHighlight inl">
        <p class="_label">Liczba odpowiedzi w 2013 r.</p>

        <p class="_value"><?= _number($object->getData('liczba_odpowiedzi_rts_2013')); ?></p>
    </li>
</ul>