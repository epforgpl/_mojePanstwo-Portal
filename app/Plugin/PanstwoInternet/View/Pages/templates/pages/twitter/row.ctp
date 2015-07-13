<div class="row rank-row">
    <? if ($group['mode'] == 'tags') { ?>
        <ul id="tagsCloud">
            <?
            foreach ($stats['tags'] as $tag) {
                $href = '/dane/twitter/?tags=' . $tag['id'];
                ?>
                <li style="font-size: <?= $tag['size'] ?>px;"><a href="<?= $href ?>"><?= $tag['tag'] ?></a></li>
            <? } ?>
        </ul>
    <? } else { ?>
        <? foreach ($group['types'] as $type) { ?>
            <div class="col-lg-3 rank-col">
                <h4 class="label label-<?= $type['class'] ?>"><?= $type['title'] ?></h4>
                <? include('mode.ctp'); ?>
            </div>
        <? } ?>
    <? } ?>
</div>