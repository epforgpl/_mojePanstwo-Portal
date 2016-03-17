<?php
$this->Combinator->add_libs('js', 'Admin.accept-moderate-request-modal');
$this->Combinator->add_libs('js', 'Dane.modal-dataobject-manage');
?>
<div
    data-toggle="modal"
    data-target="#manageModal"
    class="btn optionBtn btn-danger off">
    <i class="glyphicon glyphicon-cog" aria-hidden="true"></i> Zarządzaj
</div>

<div class="modal fade" id="manageModal" tabindex="-1" role="dialog" aria-labelledby="manageModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="manageModalLabel">Zarządzaj tą stroną</h4>
            </div>
            <div class="modal-body">
                <? if(isset($_manageOptionsModals) && count($_manageOptionsModals)) { ?>
                    <ul class="manage-list">
                        <? foreach($_manageOptionsModals as $name) { ?>
                            <li>
                                <a href="#<?= $name ?>" data-name="<?= $name ?>" class="open_<?= $name ?>_modal">
                                    <? switch($name) {
                                        case 'users': echo 'Moderatorzy strony'; break;
                                        case 'cover': echo 'Zmień obrazek tła'; break;
                                        case 'logo': echo 'Zmień logo'; break;
                                        case 'bdl_opis': echo 'Zmiana opisu i nazwy'; break;
                                        case 'bdl_wymiar': echo 'Ustaw wymiar rozwinięcia'; break;
                                        case 'prawo_hasla_merge': echo 'Połącz z instytucją'; break;
                                    } ?>
                                </a>
                            </li>
                        <? } ?>
                    </ul>
                <? } ?>
            </div>
        </div>
    </div>
</div>

<div id="dataObjectManageModals"></div>
