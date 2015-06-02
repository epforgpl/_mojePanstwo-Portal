<div class="appMenu">
    <div class="container">
        <? if (isset($_menu) && isset($_menu['items'])) { ?>
            <ul class="nav nav-tabs">
                <?
                foreach ($_menu['items'] as $m) {

                    if (!isset($m['id']) || !$m['id'])
                        $m['id'] = 'view';

                    $classes = array();

                    if (isset($m['class']) && !empty($m['class'])) {
                        $classes = explode(' ', $m['class']);
                    }
										
                    if (isset($_menu['selected']) && ($m['id'] == $_menu['selected'])) {
                        $classes[] = 'active';
                    }

                    if (isset($m['dropdown']) && !empty($m['dropdown']['items'])) {
                        foreach ($m['dropdown']['items'] as &$item) {
                            if ($item['id'] == $_menu['selected']) {

                                $classes[] = 'active';
                                $item['selected'] = true;
                                break;

                            }
                        }
                    }

                    $dropdown = false;
                    if (isset($m['dropdown']) && $m['dropdown']) {
                        $dropdown = true;
                        $classes[] = 'dropdown';
                    }

                    $href = $_menu['base'];
					
                    if ($m['id'] && ($m['id'] != 'view'))
                        $href .= '/' . $m['id'];
                                        
                    ?>
                    <li class="<?= implode(' ', $classes) ?>">
                        <a <? if ($dropdown) {
                            echo 'class="dropdown-toggle" data-toggle="dropdown"';
                        } ?>href="<?= $href ?>">
                            <? if (isset($m['icon'])) { ?><span class="<?= $m['icon'] ?>"></span> <? } ?>
                            <?= $m['label'] ?><? if (isset($m['count']) && $m['count']) { ?>
                                <span class="badge"><?= $m['count'] ?></span>
                            <? } ?>
                            <? if ($dropdown) { ?>
                                <span class="caret"></span>
                            <? } ?>
                        </a>
                        <? if ($dropdown) { ?>
                            <ul class="dropdown-menu">
                                <?
                                if (!empty($m['dropdown']['items'])) {
                                    foreach ($m['dropdown']['items'] as $n) {
                                        if (isset($n['topborder']) && $n['topborder']) { ?>
                                            <li class="divider"></li>
                                        <? } ?>
                                        <li<? if (isset($n['selected']) && $n['selected']) { ?> class="active"<? } ?>>
                                            <a href="<?= isset($n['href']) ? $n['href'] : '#' ?>">
                                                <?= $n['label'] ?><? if (isset($n['count']) && $n['count']) { ?>
                                                    <span class="badge"><?= $n['count'] ?></span><? } ?>
                                            </a>
                                        </li>
                                    <? }
                                } ?>
                            </ul>
                        <? } ?>
                    </li>
                <? } ?>
            </ul>
        <? } ?>
    </div>
</div>
