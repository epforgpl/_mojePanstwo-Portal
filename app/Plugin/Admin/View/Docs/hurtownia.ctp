
<?= $this->element('Admin.header'); ?>
<h2>Hurtownia danych</h2>

<? foreach($map['categories'] as $catName => $cat) { ?>
    <h3 class="text-muted"><?= $catName ?></h3>
    <? if(count($cat['rows'])) { ?>
        <ul>
        <? foreach($cat['rows'] as $row) { ?>
            <li><a href="/admin/docs/tables/<?= $row['document_id'] ?>"><?= $row['year'] ?> <?= $row['filename'] ?></a> (<?= $row['count'] ?>)</li>
        <? } ?>
        </ul>
    <? } ?>
<? } ?>

<?= $this->element('Admin.footer'); ?>
