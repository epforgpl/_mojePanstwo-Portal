<?
$this->Combinator->add_libs('css', $this->Less->css('appheader'));
$this->Combinator->add_libs('js', array('appheader'));

$img = false;
if (isset($appSettings['headerImg']))
    $img = ($appSettings['headerImg'][0] == '/') ? $appSettings['headerImg'] : '/' . strtolower($this->request->params['plugin']) . '/img/header_' . $appSettings['headerImg'] . '.png';
if (isset($settings['menuSelected']) && !empty($settings['menuSelected']))
    $appSettings['menuSelected'] = $settings['menuSelected'];
?>
<?php if (($domainMode == 'PK') || (isset($object) && ($object->getId() == '903'))) { ?>
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

                    <p class="header">Program Przejrzysty Kraków, prowadzony przez <a href="/dane/krs_podmioty/325617">Fundację
                            Stańczyka</a>, ma na celu wieloaspektowy monitoring życia publicznego w Krakowie. W ramach
                        programu prowadzony jest obecnie monitoring Rady Miasta i Dzielnic Krakowa.</p>
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
                    <? foreach ($pkMenu['items'] as $m) {
                        unset($m['icon']);
                        $classes = array();

                        if (isset($m['class']) && !empty($m['class'])) {
                            $classes[] = $m['class'];
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
                    <? } ?>
                </ul>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="appHeader">
        <div class="container">
            <div class="holder">

                <? /*
            <ol class="breadcrumb">
			  <li><a href="/aplikacje"><i class="_mPAppIcon" data-icon-new="&#xe800;"></i> Aplikacje</a></li>
			</ol>
			*/ ?>

                <div class="row">
                    <div class="col-md-8">

                        <? if (isset($appSettings['title'])) { ?>
                            <h1><a href="/krs"><img class="svg" alt="Krajowy Rejestr Sądowy" src="/krs/icon/krs-gray.svg"> <?= $appSettings['title'] ?></a></h1>
                        <? } ?>

                    </div>

                    <? if( isset($dataBrowser['chapters']) && !empty($dataBrowser['chapters']) ) {?>
                        <div class="col-md-4">
                            <div class="goto text-right">
                                <select class="selectpicker" data-style="btn-default" title="Przejdź do...">
                                    <? foreach($dataBrowser['chapters']['chapters'] as $chapter_id => $chapter) { ?>
                                        <option <? if( (isset($dataBrowser['chapters']['selected'])) && ($chapter_id == $dataBrowser['chapters']['selected']) ) {?>selected="selected" <? } ?>href="<?= $chapter['href'] ?>"><?= $chapter['label'] ?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                    <? } ?>

                </div>

            </div>
        </div>
        <? /*
    <? if(isset($appSettings['menu'])) { ?>
        <div class="menu">
            <div class="container">
                <ul class="nav nav-tabs">
                    <? foreach($appSettings['menu'] as $menuItem) { ?>
                        <? $isActive = (bool) (isset($appSettings['menuSelected']) && ($menuItem['id'] == $appSettings['menuSelected'])); ?>
                        <? $isDropDown = (bool) (isset($menuItem['dropdown'])); ?>
                        <?
                        if($isDropDown && isset($appSettings['menuSelected'])) {
                            // sprawdzamy czy w submenu jest zaznaczona jakaś opcja, jeżeli
                            // tak - ustawiamy całe drzewo jako active
                            foreach($menuItem['dropdown'] as $_menuItem) {
                                if($_menuItem['id'] == $appSettings['menuSelected']) {
                                    $isActive = true;
                                    break;
                                }
                            }
                        }
                        ?>
                        <li class="<?= $isActive ? 'active' : ''; ?> <?= $isActive ? 'dropdown ' : ''; ?>">
                            <a <?= isset($menuItem['dropdown']) ? 'class="dropdown-toggle" data-toggle="dropdown"' : ''; ?> href="<?= isset($menuItem['href']) ? '/'.$menuItem['href'] : '/'.strtolower($this->request->params['plugin']).'/'.$menuItem['id']; ?>">
                                <?= $menuItem['label'] ?>
                                <? if(isset($menuItem['dropdown'])) { ?>
                                    <span class="caret"></span>
                                <? } ?>
                            </a>
                            <? if(isset($menuItem['dropdown'])) { ?>
                                <ul class="dropdown-menu" role="menu">
                                    <? foreach($menuItem['dropdown'] as $menuItem) { ?>
                                        <li <?= (isset($appSettings['menuSelected']) && ($menuItem['id'] == $appSettings['menuSelected'])) ? 'class="active"' : '' ?>>
                                            <a href="<?= isset($menuItem['href']) ? '/'.$menuItem['href'] : '/'.strtolower($this->request->params['plugin']).'/'.$menuItem['id']; ?>">
                                                <?= $menuItem['label']; ?>
                                            </a>
                                        </li>
                                    <? } ?>
                                </ul>
                            <? } ?>
                        </li>
                    <? } ?>
                </ul>
            </div>
        </div>
    <? } ?> <? */ ?>
    </div>
<?php } ?>