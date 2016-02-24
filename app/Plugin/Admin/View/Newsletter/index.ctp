<?= $this->element('Admin.header'); ?>

<h2>NGO Newsletter</h2>

<p class="help-block">Ilość wpisów: <?= $count ?>, w tym <?= $newCount ?> nowych.</p>
<a href="/admin/newsletter/getAllRowsAsCSV" class="btn btn-default">Pobierz wszystko jako CSV</a>
<a href="/admin/newsletter/getNewAsCSV" class="btn btn-default">Pobierz tylko nowe jako CSV</a>

<?= $this->element('Admin.footer'); ?>
