<?
$this->Combinator->add_libs('css', '../plugins/jscrollPane/style/jquery.jscrollpane.css');
$this->Combinator->add_libs('js', '../plugins/jscrollPane/script/jquery.mousewheel.js');
$this->Combinator->add_libs('js', '../plugins/jscrollPane/script/jquery.jscrollpane.js');
?>


<?= $this->Element('dataobject/pageBegin', array('renderFile' => 'page-bdl_wskazniki')); ?>
<?= $this->Element('bdl_select', array('expand_dimension' => $expand_dimension, 'dims' => $dims)); ?>

    <div id="leftSideAccordion">
        <header>Bank Danych Lokalnych</header>

        <section>
            <h3>Wskaźniki</h3>

            <div class="treeBlock jScrollPane">
                <?
                $this->Combinator->add_libs('js', 'Bdl.jstree.min');
                $this->Combinator->add_libs('js', 'Bdl.bdl');
                ?>
                <div
                    id="tree" <?= printf('data-structure="%s"', htmlspecialchars(json_encode($tree), ENT_QUOTES, 'UTF-8')) ?>></div>
            </div>

            <h3>Tworzenie wskaźników</h3>

            <div></div>

        </section>
    </div>

    <div id="bdl-wskazniki" class="col-xs-12">
        <? if (in_array('bdl_opis', $object_editable)) {
            echo $this->element('Dane.bdl_opis');
        } ?>

        <div class="object">
            <?
            if (!empty($expanded_dimension)) {
                foreach ($expanded_dimension['options'] as $option) {
                    if (isset($option['data'])) {
                        echo $this->element('Dane.bdl_wskaznik', array(
                            'data' => $option['data'],
                            'url' => $object->getUrl(),
                            'title' => $option['value'],
                        ));
                    }
                }
            }
            ?>
        </div>
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>