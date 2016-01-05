<?= $this->element('Admin.header'); ?>
<? $this->Combinator->add_libs('js','Admin.public-content'); ?>

<h2>Treści publiczne</h2>

<? if(isset($types) && isset($type)) { ?>
    <ul class="nav nav-tabs">
        <? foreach($types as $t => $options) { ?>
            <li role="presentation" <? if($type == $t) echo 'class="active"'; ?>>
                <a href="/admin/public_content?type=<?= $t; ?>">
                    <?= $options['label']; ?>
                </a>
            </li>
        <? } ?>
    </ul>
<? } ?>

<? if(isset($rows) && count($rows) && isset($typeOptions)) { ?>
    <table class="table table-striped table-hover table-bordered margin-top-10">
        <tr>
            <th>Nazwa</th>
            <th>Opcje</th>
        </tr>
        <? foreach($rows as $row) { $row = $row[$typeOptions['model']]; ?>
            <tr>
                <td>
                    <a href="<?= $typeOptions['url'] . '/' . $row['id'] ?>">
                        <?= $row['name'] ?>
                    </a><br/>
                    <small class="text-muted">
                        Dodano <?= getDiff($row['created_at']) ?>
                        dnia <?= date('Y-m-d', strtotime($row['created_at'])) ?>
                    </small>
                </td>
                <td>
                    <div class="btn-group publicContentOptions" data-toggle="buttons">
                        <label class="btn promoted btn-default<?= $row['is_promoted'] ? ' active' : '' ?>">
                            <input
                                type="checkbox"
                                autocomplete="off"
                                data-type="<?= $type ?>"
                                data-id="<?= $row['id'] ?>"
                                <?= $row['is_promoted'] ? 'checked' : '' ?>
                            > Promuj
                        </label>
                    </div>
                </td>
            </tr>
        <? } ?>
    </table>
<? } else { ?>
    <p class="margin-top-20">Brak rekordów</p>
<? } ?>


<? if(isset($pages) && $pages > 1) { ?>
    <nav>
        <ul class="pagination margin-top-0">
            <? for($p = 0; $p < $pages; $p++) { ?>
                <li<?= $page == $p ? ' class="active"' : '' ?>>
                    <a href="/admin/public_content?type=<?= $type; ?>&page=<?= $p ?>"><?= ($p + 1) ?></a>
                </li>
            <? } ?>
        </ul>
    </nav>
<? } ?>

<?= $this->element('Admin.footer'); ?>
