<?= $this->element('Admin.header'); ?>
<? $this->Combinator->add_libs('js','Admin.accept-moderate-request-modal'); ?>

<h2>Żądania uprawnień</h2>

    <ul class="nav nav-tabs">
        <? foreach($statuses as $_status => $label) { ?>
            <li role="presentation" <? if($status == $_status) echo 'class="active"'; ?>>
                <a href="/admin/moderate_requests/index/<?= $_status; ?>">
                    <?= $label; ?>
                </a>
            </li>
        <? } ?>
    </ul>

    <? if(!count($pages_requests)) { ?>
        <p class="margin-top-20">Brak żądań</p>
    <? } else { ?>
        <table class="table table-striped table-hover table-bordered margin-top-10">
            <tr>
                <th>Data utworzenia</th>
                <th>Obiekt</th>
                <th>Użytkownik</th>
                <th>Zgłaszający</th>
                <? if($status == 0) { ?>
                    <th>Opcje</th>
                <? } ?>
            </tr>
            <? foreach($pages_requests as $page_request) { ?>
                <tr>
                    <td><?= $page_request['PageRequest']['cts']; ?></td>
                    <td>
                        <a href="/dane/<?= $page_request['PageRequest']['dataset']; ?>/<?= $page_request['PageRequest']['object_id']; ?>">
                            <?= $page_request['PageRequest']['dataset']; ?>:<?= $page_request['PageRequest']['object_id']; ?>
                        </a>
                    </td>
                    <td>
                        <? if($page_request['User']['id']) { ?>
                            <?= $page_request['User']['username']; ?>
                            (<?= $page_request['User']['id']; ?> )
                        <? } else { ?>
                            Gość
                        <? } ?>
                    </td>
                    <td>
                        <?= $page_request['PageRequest']['email']; ?><br/>
                        <?= $page_request['PageRequest']['phone']; ?><br/>
                        <?= $page_request['PageRequest']['firstname']; ?>
                        <?= $page_request['PageRequest']['lastname']; ?>
                        (<?= $page_request['PageRequest']['position']; ?>)<br/>
                        <b><?= $page_request['PageRequest']['organization']; ?></b>
                    </td>
                    <? if($status == 0) { ?>
                        <td>
                            <? if($page_request['User']['id']) { ?>
                            <div class="btn-group btn-group-sm" role="group">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Akceptuj jako..
                                        &nbsp; <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="accept-moderate-request-modal-open" data-page-request-id="<?= $page_request['PageRequest']['id']; ?>" data-dataset="<?= $page_request['PageRequest']['dataset']; ?>" data-object-id="<?= $page_request['PageRequest']['object_id']; ?>" data-user-id="<?= $page_request['User']['id']; ?>" data-role="1" href="#">Właściciel</a></li>
                                        <li><a class="accept-moderate-request-modal-open" data-page-request-id="<?= $page_request['PageRequest']['id']; ?>" data-dataset="<?= $page_request['PageRequest']['dataset']; ?>" data-object-id="<?= $page_request['PageRequest']['object_id']; ?>" data-user-id="<?= $page_request['User']['id']; ?>" data-role="2" href="#">Administrator</a></li>
                                    </ul>
                                </div>
                                <a href="/admin/moderate_requests/reject/<?= $page_request['PageRequest']['id']; ?>" class="btn btn-danger">Odrzuć</a>
                            </div>
                            <? } else { ?>
                                <p>Dana osoba musi się zarejestrować oraz wysłać ponowne zgłoszenie bezpośrednio z profilu organizacji.</p>
                            <? } ?>
                        </td>
                    <? } ?>
                </tr>
            <? } ?>
        </table>
    <? } ?>

<?= $this->element('Admin.footer'); ?>
