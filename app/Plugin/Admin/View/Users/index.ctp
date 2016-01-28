<?= $this->element('Admin.header'); ?>

<h2>Użytkownicy</h2>

<form class="form-inline" action="/admin/users" method="get">
    <div class="form-group">
        <input type="text" value="<?= isset($q) ? $q : '' ?>" class="form-control" name="q" placeholder="id, email lub nazwa">
    </div>
    <button type="submit" class="btn btn-default">Szukaj</button>
</form>

<p class="help-block margin-top-5 text-muted"><?= $count ?> rekordów.</p>

<? if(isset($rows) && count($rows)) { ?>
    <table class="table table-striped table-hover table-bordered margin-top-10">
        <tr>
            <th>Użytkownik</th>
            <th>Opcje</th>
        </tr>
        <? foreach($rows as $row) { $row = $row['AdminUser']; ?>
            <tr>
                <td>
                    <a href="/dane/uzytkownicy/<?= $row['id'] ?>">
                        <?= $row['username'] ?>
                    </a><br/>
                        <?= $row['email'] ?>
                    <br/>
                    <small class="text-muted">
                        Dołączył <?= getDiff($row['created']) ?>
                        dnia <?= date('Y-m-d', strtotime($row['created'])) ?>
                        <?= $row['logged_at'] != '0000-00-00 00:00:00' ? ', ostatnio aktywny ' . getDiff($row['logged_at']) : '' ?>
                    </small>
                </td>
                <td>
                    <a class="btn btn-default" href="/admin/users/login/<?= $row['id'] ?>" role="button">Zaloguj</a>
                </td>
            </tr>
        <? } ?>
    </table>
<? } else { ?>
    <p class="margin-top-20">Brak rekordów</p>
<? } ?>


<? if(isset($pages) && $pages > 1) { $u = '/admin/users?'.(isset($q) ? 'q=' . $q . '&' : '').'page='; ?>
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
