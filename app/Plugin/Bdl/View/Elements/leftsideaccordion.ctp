<?
$this->Combinator->add_libs('css', '../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5');
$this->Combinator->add_libs('css', '../plugins/jscrollPane/style/jquery.jscrollpane.css');
$this->Combinator->add_libs('css', $this->Less->css('bdl_tree', array('plugin' => 'Bdl')));

echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.all', array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/locales/bootstrap-wysihtml5.pl-NEW', array('block' => 'scriptBlock'));
echo $this->Html->script('Bdl.jstree.min', array('block' => 'scriptBlock'));
$this->Combinator->add_libs('js', '../plugins/jscrollPane/script/jquery.mousewheel.js');
$this->Combinator->add_libs('js', '../plugins/jscrollPane/script/jquery.jscrollpane.js');
$this->Combinator->add_libs('js', 'Bdl.bdl_tree');
?>


<div id="leftSideAccordion" class="init hidden-xs hidden-sm">
    <div class="accordion ui-accordion ui-widget ui-helper-reset">
        <h3 class="ui-accordion-header ui-state-default ui-accordion-header-active ui-state-active ui-corner-top ui-accordion-icons">
            <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
            Bank Danych Lokalnych</h3>

        <div class="noOverflow">
            <div class="suggesterBlock searchForm col-xs-12 nopadding">
                <?
                $value = isset($this->request->query['q']) ? addslashes($this->request->query['q']) : '';
                $autocompletion = ($dataBrowser['autocompletion']) ? $dataBrowser['autocompletion'] : false;
                $placeholder = (isset($dataBrowser['searchTitle']) && ($dataBrowser['searchTitle'])) ? addslashes($dataBrowser['searchTitle']) : 'Szukaj...';
                $url = ($dataBrowser['cancel_url']) ? $dataBrowser['cancel_url'] : '';
                ?>

                <?= $this->Element('searcher', array('q' => $value, 'autocompletion' => $autocompletion, 'placeholder' => $placeholder, 'url' => $url)) ?>

            </div>

            <div class="treeBlock jScrollPane col-xs-12">
                <div
                    id="tree" <?= printf('data-structure="%s"', htmlspecialchars(json_encode($tree), ENT_QUOTES, 'UTF-8')) ?>></div>
            </div>
        </div>

        <h3 class="init-bottom ui-accordion-header ui-state-default ui-corner-all ui-accordion-icons"><span
                class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>Wskaźniki Żywej Kultury</h3>

        <div class="init-hide">
            <? if ($BdlTempItems == false) { ?>
                <h4 class="brak_wskz">Nie ma wskaźników do wyświetlenia</h4>
            <? } else { ?>
                <ul class="list-group lista_wskz">
                    <? foreach ($BdlTempItems['BdlTempItems'] as $key => $val) { ?>
                        <li class="list-group-item"><a
                                href="/bdl/bdl_temp_items/<?= $key ?>"><?= $val['tytul'] ?></a>

                            <form class="remove_btn hidden" method="DELETE"
                                  action="/bdl/bdl_temp_items/delete/<?= $key ?>">
                                <button class="btn btn-danger btn-xs pull-right" type="submit"><i
                                        class="icon glyphicon glyphicon-remove"></i></button>
                            </form>
                        </li>
                    <? } ?>
                </ul>
                <ul class="list-group lista_wskz">
                    <? foreach ($BdlTempItems['BdlImportItems'] as $key => $val) { ?>
                        <li class="list-group-item"><a
                                href="/bdl/bdl_temp_items/<?= $key ?>"><?= $val['tytul'] ?></a>

                        </li>
                    <? } ?>
                </ul>
            <? } ?>
            <button class="btn btn-xs btn-primary btn-addnew btn-icon" id="new_temp_item"><i
                    class="icon glyphicon glyphicon-plus"></i>Dodaj</button>

        </div>
    </div>
</div>
<div id="temp_item_opis_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                <h4 class="modal-title">Nowy Wskaźnik</h4>
            </div>
            <form method="post" action="/bdl/bdl_temp_items">
                <div class="modal-body">
                    <div class="col-sm-11">
                        <div class="hidden alert alert-success info"></div>
                        <div class="row "><label class="">Tytuł:</label></div>
                        <div class="row"><input name="tytul" class="form-control nazwa" value="" required>
                        </div>
                        <br>

                        <div class="row"><label>Opis:</label></div>
                    </div>
                    <textarea name="opis" id="editor"></textarea>

                    <div class="row">
                        <div class="col-sm-6">
                            <label class="pull-right"><input class="bdl_input" type="radio" name="type" value="BDL" checked> BDL</label>
                        </div>
                        <div class="col-sm-6">
                            <label class="pull-left"><input class="import_input" type="radio" name="type" value="import"> Importuj</label>
                        </div>
                    </div>
                    <div class="row input_url hidden">
                        <div class="col-sm-11">
                            <label class="">URL skoroszytu:</label><br>
                            <input type="url" name="url" class="form-control nazwa">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-primary btn-icon" id="temp_item_savebtn"><i
                            class="icon glyphicon glyphicon-ok"></i>Dodaj
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>