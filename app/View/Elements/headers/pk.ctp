<?
$this->Combinator->add_libs('css', $this->Less->css('appheader'));
$this->Combinator->add_libs('js', array('appheader'));
?>
<div class="appHeader extended pk">
        <div class="container">
            <div class="holder">
                <div class="attachment col-xs-12 col-sm-3 text-center">
                    <a href="http://przejrzystykrakow.pl">
                        <img src="/dane/img/customObject/krakow/logo_pkrk.png" alt=""/>
                    </a>
                </div>
                <div class="content col-xs-12 col-sm-9">
                    <h1>
                        <a href="http://przejrzystykrakow.pl">Przejrzysty Kraków</a>
                    </h1>

                    <p class="header">Monitorujemy pracę instytucji publicznych w Krakowie.</p>
                </div>
            </div>
        </div>
        
        <div class="menu">
            <div class="container">
                <ul class="nav nav-tabs">
                    <li class="mobileMenu active visible-xs">
                        <a href="#mobileMenu">
                            <span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>
                        </a>
                    </li>
                    <?php if (isset($pkMenu)) {
	                    
	                    
                        foreach ($pkMenu['items'] as $m) {
	                        
	                        if( !isset($m['id']) )
				            	$m['id'] = 'view';
	                        
                            unset($m['icon']);
                            $classes = array();

                            if (isset($m['class']) && !empty($m['class'])) {
                                $classes[] = $m['class'];
                            }
                            
            

                            if (isset($_menu['selected'])) {
                                if ($m['id'] == $_menu['selected'])
                                    $classes[] = 'active';

                                if (isset($m['dropdown']) && !empty($m['dropdown']['items'])) {
                                    foreach ($m['dropdown']['items'] as &$item) {
                                        if ($item['id'] == $_menu['selected']) {

                                            $classes[] = 'active';
                                            $item['selected'] = true;
                                            break;

                                        }
                                    }
                                }
                            }

                            if (isset($appSettings['menuSelected']) && ($m['id'] == $appSettings['menuSelected'])) {
                                $classes[] = 'active';
                            }

                            if (isset($appSettings['menuSelected']) && isset($m['dropdown']) && !empty($m['dropdown']['items'])) {
                                foreach ($m['dropdown']['items'] as &$item) {
                                    if ($item['id'] == $appSettings['menuSelected']) {
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

                            $href = $pkMenu['base'];
                            if ($m['id'])
                                $href .= '/' . $m['id'];
                            ?>
                            <li class="<?= implode(' ', $classes) ?>">
                                <a<? if ($dropdown) echo ' class="dropdown-toggle" data-toggle="dropdown"'; ?>
                                    href="<?= $href ?>">
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
                                        <? if (!empty($m['dropdown']['items'])) {
                                            foreach ($m['dropdown']['items'] as $n) {
                                                if (isset($n['topborder']) && $n['topborder']) { ?>
                                                    <li class="divider"></li>
                                                <? } ?>
                                                <li<? if (isset($n['selected']) && $n['selected']) { ?> class="active"<? } ?>>
                                                    <a href="<?= isset($n['href']) ? $n['href'] : '#' ?>"><?= $n['label'] ?><? if (isset($n['count']) && $n['count']) { ?>
                                                            <span class="badge"><?= $n['count'] ?></span><? } ?></a>
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
        </div>
    </div>