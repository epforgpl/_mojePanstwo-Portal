<div id="spis_tresci" class="navbar navbar-default">
    <div class="navbar-collapse collapse navbar-responsive-collapse row">
        <ul class="nav navbar-nav container">
            <? foreach ($toc as $chapter) {
                $subchapters = (isset($chapter['subchapters']) && !(empty($chapter['subchapters'])));
                $active = (isset($chapter['active']) && ($chapter['active']));
                ?>
                <li class="col-md-2<? if ($subchapters) { ?> dropdown<? } ?><? if ($active) { ?> active<? } ?>">
                    <a <? if ($subchapters) { ?>href="#" class="dropdown-toggle" data-toggle="dropdown"
                       <? }else{ ?>href="#<?= $chapter['name'] ?>"<? } ?>><?= $chapter['title'] ?><? if ($subchapters) { ?>
                            <b class="caret"></b><? } ?></a>
                    <? if ($subchapters) { ?>
                        <ul class="dropdown-menu">
                            <? foreach ($chapter['subchapters'] as $subchapter) { ?>
                                <li>
                                    <a href="#<?= $chapter['name'] ?>-<?= $subchapter['name'] ?>"><?= $subchapter['title'] ?></a>
                                </li>
                            <? } ?>
                        </ul>
                    <? } ?>
                </li>
            <? } ?>
        </ul>
    </div>
</div>