<?
if (isset($tree)) {

    $this->Combinator->add_libs('css', $this->Less->css('bdl', array('plugin' => 'Bdl')));

    $this->Combinator->add_libs('js', 'Bdl.jstree.min');
    $this->Combinator->add_libs('js', 'Bdl.bdl');
    ?>

    <div class="col-xs-12 col-md-8">
        <div class="block col-xs-12">
            <header>Przeglądaj według kategorii</header>
            <section class="aggs-init">
                <div id="tree" <?= printf('data-structure="%s"', htmlspecialchars(json_encode($tree), ENT_QUOTES, 'UTF-8')) ?>></div>
            </section>
        </div>
    </div>
<? } ?>


