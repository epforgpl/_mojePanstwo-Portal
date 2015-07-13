<div id="twitter" class="chapter">
    <div class="col-md-12 header-row">
        <div class="container">
            <h2><?= __d('panstwo_internet', 'LC_PANSTWOINTERNET_TWITTER_HEADLINE') ?></h2>
        </div>
    </div>

    <div id="twitter" class="container innerContent">
        <div class="col-md-12">
            <div class="desc">
                <p><?= __d('panstwo_internet', 'LC_PANSTWOINTERNET_TWITTER_TOPIC') ?></p>
            </div>
        </div>

        <div class="ranks">
            <? foreach ($ranks as $rank) { ?>
                <div id="twitter-<?= $rank['name'] ?>" class="rank-row-block">
                    <h3><?= $rank['title'] ?></h3>
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