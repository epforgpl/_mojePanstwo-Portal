
<div class="container">
    <h1>Żądania uprawnień</h1>
    <div class="row margin-top-20">
        <? if(!count($pages_requests)) { ?>
            <p>Brak żądań</p>
        <? } else { ?>
            <table class="table table-striped table-hover table-bordered">
                <tr>
                    <th>Dataset</th>
                    <th>Obiekt</th>
                    <th>Użytkownik</th>
                    <th>Organizacja</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Stanowisko</th>
                    <th>E-mail</th>
                    <th>Telefon</th>
                    <th>Data utworzenia</th>
                    <th>Opcje</th>
                </tr>
                <? foreach($pages_requests as $page_request) { ?>
                    <tr>
                        <td><?= $page_request['PageRequest']['dataset']; ?></td>
                        <td>
                            <a href="/dane/<?= $page_request['PageRequest']['dataset']; ?>/<?= $page_request['PageRequest']['object_id']; ?>">
                                <?= $page_request['PageRequest']['object_id']; ?>
                            </a>
                        </td>
                        <td>
                            <?= $page_request['User']['username']; ?>
                            (<?= $page_request['User']['id']; ?> )
                        </td>
                        <td><?= $page_request['PageRequest']['organization']; ?></td>
                        <td><?= $page_request['PageRequest']['firstname']; ?></td>
                        <td><?= $page_request['PageRequest']['lastname']; ?></td>
                        <td><?= $page_request['PageRequest']['position']; ?></td>
                        <td><?= $page_request['PageRequest']['email']; ?></td>
                        <td><?= $page_request['PageRequest']['phone']; ?></td>
                        <td><?= $page_request['PageRequest']['cts']; ?></td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Akceptuj jako..
                                        &nbsp; <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="/admin/moderate_requests/accept/<?= $page_request['PageRequest']['id']; ?>/1">Właściciel</a></li>
                                        <li><a href="/admin/moderate_requests/accept/<?= $page_request['PageRequest']['id']; ?>/2">Administrator</a></li>
                                    </ul>
                                </div>
                                <a href="/admin/moderate_requests/reject/<?= $page_request['PageRequest']['id']; ?>" class="btn btn-danger">Odrzuć</a>
                            </div>
                        </td>
                    </tr>
                <? } ?>
            </table>
        <? } ?>
    </div>
</div>