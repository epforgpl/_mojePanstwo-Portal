<ul class="dataHighlights col-xs-12 oneline">
    <li class="dataHighlight col-sm-3">
        <p class="_label">Liczba tweetów</p>
        <p class="_value"><?= number_format_h($object->getData('liczba_tweetow')) ?></p>
    </li>
    <li class="dataHighlight col-sm-3">
        <p class="_label">Liczba obserwujących</p>
        <p class="_value"><?= number_format_h($object->getData('liczba_obserwujacych')) ?></p>
    </li>    
</ul>