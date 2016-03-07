<?= $this->element('Admin.header'); ?>

<h2>Transakcje</h2>

<form class="form-inline" action="/admin/transactions" method="get">
    <div class="form-group">
        <input type="text" value="<?= isset($q) ? $q : '' ?>" class="form-control" name="q" placeholder="id (numer z opisu)">
    </div>
    <button type="submit" class="btn btn-default">Szukaj</button>
</form>

<? if(isset($rows) && count($rows)) { ?>
    <table class="table table-striped table-hover table-bordered margin-top-10">
        <tr>
            <th>Informacje</th>
            <th>Opcje</th>
        </tr>
        <? foreach($rows as $row) { $row = $row['AdminTransaction']; ?>
            <tr>
                <td>
                    <? if($row['user_id'] == '0') { ?>
                        Gość
                    <? } else { ?>
                        <a href="/dane/uzytkownicy/<?= $row['user_id'] ?>">
                            Użytkownik
                        </a>
                    <? } ?>,
                    <a href="/dane/krs_podmioty/<?= $row['krs_pozycje_id'] ?>">
                        Podmiot
                    </a> (<a href="/admin/bank_accounts?q=<?= $row['krs_pozycje_id'] ?>" target="_blank">dodane konta</a>)<br/>
                    Status: <?= $statusDict[$row['res_status']] ?><br/>
                    Kwota: <?= $row['amount'] ?> PLN<br/>
                    Imię i nazwisko: <?= $row['firstname'] . ' ' . $row['surname'] ?><br/>
                    E-mail: <?= $row['email'] ?><br/>
                    <?= $row['is_transferred'] == '0' ? 'Nie przekazana' : '<b>Przekazana</b>' ?>
                    <br/>
                    <small class="text-muted">
                        Wysłano <?= getDiff($row['form_send_at']) ?>
                        dnia <?= date('Y-m-d', strtotime($row['form_send_at'])) ?>
                        <?= $row['res_received_at'] != '0000-00-00 00:00:00' ? ', potwierdzono ' . getDiff($row['res_received_at']) : '' ?>
                    </small>
                </td>
                <td>
                    <form method="post">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>"/>
                        <select name="status" class="form-control input-sm"">
                        <? foreach(array('Nie przekazana', 'Przekazana') as $i => $val) { ?>
                            <option value="<?= $i ?>"<?= $row['is_transferred'] == $i ? ' selected' : '' ?>><?= $val ?></option>
                        <? } ?>
                        </select>
                        <input type="submit" class="btn btn-default btn-sm margin-top-5" value="Zapisz"/>
                    </form>
                </td>
            </tr>
        <? } ?>
    </table>
<? } else { ?>
    <p class="margin-top-20">Brak rekordów</p>
<? } ?>


<? if(isset($pages) && $pages > 1) { $u = '/admin/transactions?'.(isset($q) ? 'q=' . $q . '&' : '').'page='; ?>
    <nav>
        <ul class="pagination margin-top-0">
            <? if($pages > 10) { ?>
                <li<?= $page == 0 ? ' class="active"' : '' ?>>
                    <a href="<?= $u . '0' ?>">1</a>
                </li>

                <? for($p = $page - 5; $p < $page + 5; $p++) { if($p < 1) continue; ?>
                    <li<?= $page == $p ? ' class="active"' : '' ?>>
                        <a href="<?= $u . $p ?>"><?= ($p + 1) ?></a>
                    </li>
                <? } ?>

                <li<?= $page == $pages - 1 ? ' class="active"' : '' ?>>
                    <a href="<?= $u . ($pages - 1) ?>"><?= $pages ?></a>
                </li>
            <? } else { ?>
                <? for($p = 0; $p < $pages; $p++) { ?>
                    <li<?= $page == $p ? ' class="active"' : '' ?>>
                        <a href="<?= $u . $p ?>"><?= ($p + 1) ?></a>
                    </li>
                <? } ?>
            <? } ?>
        </ul>
    </nav>
<? } ?>

<a href="/admin/transactions/getMassCSV" class="btn btn-default">Pobierz CSV masowych (nie przekazanych) transakcji i oznacz je jako przekazane</a>

<?= $this->element('Admin.footer'); ?>
