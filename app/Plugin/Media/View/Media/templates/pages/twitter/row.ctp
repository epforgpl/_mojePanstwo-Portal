<div class="row rank-row">
    <? if ($group['mode'] == 'tags') { ?>
        <ul id="tagsCloud">
            <?
            foreach ($stats['from']['*']['tags']['objects'] as $tag) {
                $href = '/dane/twitter/?!bez_retweetow=1&tags[]=' . $tag['id'] . '&_date=LAST_' . $range;
                ?>
                <li style="font-size: <?= $tag['size'] ?>px;"><a href="#"><?= $tag['name'] ?></a></li>
            <? } ?>
        </ul>
    <? } else { ?>
        <? foreach ($group['types'] as $type) { ?>
            <div class="col-md-3 rank-col">
                <h4 class="label label-<?= $type['class'] ?>"><a
                        href="/dane/twitter_accounts/?typ_id[]=<?= $type['id'] ?>"><?= $type['nazwa'] ?></a></h4>
                <? include('mode.ctp'); ?>
            </div>
        <? } ?>
    <? } ?>
</div>