<? $this->Combinator->add_libs('css', $this->Less->css('admin', array('plugin' => 'Admin'))); ?>

<? echo $this->Element('headers/main'); ?>

<header>
    <a href="/admin"><h1>Admin</h1></a>
</header>
<div class="container">
    <div class="row">
        <div class="col-md-3 menu">
            <? if(isset($menu)) { ?>
                <ul class="nav nav-pills nav-stacked margin-top-20">
                    <? foreach($menu as $item) { ?>
                        <li<? if(isset($action) && $action == $item['id']) echo ' class="active"'; ?>>
                            <a href="<?= $item['href'] ?>">
                                <?= $item['label'] ?>
                            </a>
                        </li>
                    <? } ?>
                </ul>
            <? } ?>
        </div>
        <div class="col-md-9 content">
