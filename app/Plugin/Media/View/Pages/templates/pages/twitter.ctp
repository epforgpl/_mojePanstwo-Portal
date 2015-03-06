<div id="twitter" class="chapter">

    <div id="twitter" class="container innerContent">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="desc main_desc">
                    <p class="text-center" style="margin-bottom: 0;"><b>Wybierz zakres analizy:</b></p>
                </div>
            </div>
        </div>

        <div class="range text-center">
            <ul class="pagination">
                <li<? if ($range == '24h') { ?> class="active" <? } ?>><a href="?range=24h">24 godziny</a></li>
                <li<? if ($range == '3d') { ?> class="active" <? } ?>><a href="?range=3d">3 dni</a></li>
                <li<? if ($range == '7d') { ?> class="active" <? } ?>><a href="?range=7d">7 dni</a></li>
                <li<? if ($range == '1m') { ?> class="active" <? } ?>><a href="?range=1m">1 miesiąc</a></li>
                <!--</<li<? if ($range == '1y') { ?> class="active" <? } ?>><a href="?range=1y">1 rok</a></li>-->
            </ul>
        </div>


        <div class="ranks block">
            <? foreach ($ranks as $rank) { ?>
                <div id="twitter-<?= $rank['name'] ?>" class="rank-row-block">
                    <h3 class="block-header"><?= $rank['title'] ?></h3>
                    <? foreach ($rank['groups'] as $group) { ?>
                        <? if (isset($group['desc'])) { ?>
                            <p class="desc"><?= $group['desc'] ?></p>
                        <? } ?>
                        <? include('twitter/row.ctp'); ?>
                    <? } ?>
                </div>
            <? } ?>
        </div>
    </div>
</div>