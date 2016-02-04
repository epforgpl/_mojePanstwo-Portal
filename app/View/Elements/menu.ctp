<?
	
	if(isset($header_vote) && is_array($header_vote)) {
	    echo $this->element('Dane.header_vote');
	} 
	
	$empty = !( isset($_menu) && isset($_menu['items']) );
	
?>
<div class="appMenu<? if($empty) echo " empty"; ?>">
    <? if (!$empty) {?>
	    <div class="container">
            <ul>
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

                    if ($m['id'] && ($m['id'] != 'view')) {
                        $href .= '/' . $m['id'];
                    }

                    if (isset($m['label']) && (!empty($m['label']))) {
                        ?>
                        <li class="<?= implode(' ', $classes) ?>">
                            <a <? if ($dropdown) {
                                echo 'class="dropdown-toggle" data-toggle="dropdown"';
                            } ?>href="<?= $href ?>">
                                <? if (isset($m['icon'])) {
                                    if ($m['icon']['src'] == 'glyphicon') {
                                        ?><span class="glyphicon glyphicon-<?= $m['icon']['id'] ?>"
                                                aria-hidden="true" title="<?= $m['label'] ?>"></span> <?
                                    } else {
                                        ?><span
                                        class="icon icon-<?= $m['icon']['src'] ?>-<?= $m['icon']['id'] ?>"
                                        aria-hidden="true"></span> <?
                                    }
                                }
                                if (@$m['icon']['src'] != 'glyphicon') {
                                    echo $m['label'];
                                }
                                if (isset($m['count']) && $m['count']) { ?> <span
                                    class="counter"><?= $m['count'] ?></span><? } ?>
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
                                                        <span class="counter"><?= $n['count'] ?></span><? } ?>
                                                </a>
                                            </li>
                                        <? }
                                    } ?>
                                </ul>
                            <? } ?>
                        </li>
                    <? }
                } ?>
            </ul>
	    </div>
    <? } ?>
</div>
