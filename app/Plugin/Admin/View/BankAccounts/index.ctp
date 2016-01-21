<?= $this->element('Admin.header'); ?>

<h2>Konta bankowe</h2>

<form class="form-inline" action="/admin/bank_accounts" method="get">
    <div class="form-group">
        <input type="text" value="<?= isset($q) ? $q : '' ?>" class="form-control" name="q" placeholder="krs_pozycja_id lub numer konta">
    </div>
    <button type="submit" class="btn btn-default">Szukaj</button>
</form>

<? if(isset($rows) && count($rows)) { ?>
    <table class="table table-striped table-hover table-bordered margin-top-10">
        <tr>
            <th>Informacje</th>
            <th>Opcje</th>
        </tr>
        <? foreach($rows as $row) { $row = $row['KrsBankAccount']; ?>
            <tr>
                <td>
                    <a href="/dane/uzytkownicy/<?= $row['user_id'] ?>">
                        Użytkownik
                    </a>,
                    <a href="/dane/krs_podmioty/<?= $row['krs_pozycje_id'] ?>">
                        Podmiot
                    </a><br/>
                    Numer konta: <?= $row['bank_account'] ?><br/>
                    Status: <?= $statusDict[$row['status']] ?>
                    <br/>
                    <small class="text-muted">
                        Dodano <?= getDiff($row['created_at']) ?>
                        dnia <?= date('Y-m-d', strtotime($row['created_at'])) ?>
                        <?= $row['updated_at'] != '0000-00-00 00:00:00' ? ', aktualizowano ' . getDiff($row['updated_at']) : '' ?>
                    </small>
                </td>
                <td>
                    <form method="post">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>"/>
                        <select name="status" class="form-control input-sm"">
                            <? foreach($statusDict as $i => $val) { ?>
                                <option value="<?= $i ?>"<?= $row['status'] == $i ? ' selected' : '' ?>><?= $val ?></option>
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


<? if(isset($pages) && $pages > 1) { $u = '/admin/bank_accounts?'.(isset($q) ? 'q=' . $q . '&' : '').'page='; ?>
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

<?= $this->element('Admin.footer'); ?>
