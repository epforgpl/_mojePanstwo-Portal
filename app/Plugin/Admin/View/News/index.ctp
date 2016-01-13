<?= $this->element('Admin.header'); ?>

<h2>Aktualności</h2>

<form class="form-inline" action="/admin/news" method="get">
    <a class="btn btn-link pull-right" href="/admin/news/add">Dodaj</a>
    <div class="form-group">
        <input type="text" value="<?= isset($q) ? $q : '' ?>" class="form-control" name="q" placeholder="id lub nazwa">
    </div>
    <button type="submit" class="btn btn-default">Szukaj</button>
</form>

<? if(isset($rows) && count($rows)) { ?>
    <table class="table table-striped table-hover table-bordered margin-top-10">
        <tr>
            <th>Aktualność</th>
            <th>Opcje</th>
        </tr>
        <? foreach($rows as $row) { $row = $row['News']; ?>
            <tr>
                <td>
                    <?= $row['name'] ?>
                    <br/>
                    <small class="text-muted">
                        Dodano <?= getDiff($row['created_at']) ?>
                        dnia <?= date('Y-m-d', strtotime($row['created_at'])) ?>
                    </small>
                </td>
                <td>
                    <a class="btn btn-default" href="/admin/news/edit/<?= $row['id'] ?>" role="button">Edytuj</a>
                    <a class="btn btn-default deleteConfirm" href="/admin/news/delete/<?= $row['id'] ?>" role="button">Usuń</a>
                </td>
            </tr>
        <? } ?>
    </table>
<? } else { ?>
    <p class="margin-top-20">Brak rekordów</p>
<? } ?>


<? if(isset($pages) && $pages > 1) { $u = '/admin/news?'.(isset($q) ? 'q=' . $q . '&' : '').'page='; ?>
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

<script type="text/javascript">

    (function($) {

        $('.deleteConfirm').click(function() {
            if(!confirm('Czy na pewno chcesz usunąć ten rekord?'))
                return false;
        });

    })(jQuery);

</script>

<?= $this->element('Admin.footer'); ?>