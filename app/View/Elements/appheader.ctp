<?

$this->Combinator->add_libs('css', $this->Less->css('appheader'));

$img = false;
if( isset($appSettings['headerImg']) )
    $img = ( $appSettings['headerImg'][0]=='/' ) ? $appSettings['headerImg'] : '/' . strtolower($this->request->params['plugin']) . '/img/header_' . $appSettings['headerImg'] . '.png';
?>

<div class="appHeader"<? if( $img ) echo ' style="background-image: url(' . $img . ')"'; ?>>
    <div class="container">
        <div class="holder">
            <? if (isset($appSettings['title'])) { ?>
                <h1><?= $appSettings['title'] ?></h1>
            <? } ?>

            <? if (isset($appSettings['subtitle'])) { ?>
                <h2><?= $appSettings['subtitle'] ?></h2>
            <? } ?>
        </div>
    </div>
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
    <? } ?>
</div>