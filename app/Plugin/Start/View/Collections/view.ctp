<?

echo $this->element('Start.pageBegin'); ?>

<header>
    <h1>Kolekcja XXX</h1>
</header>

<p>Lorem ipsum</p>

<div class="block block-simple col-sm-12">
	<header class="nopadding">Dokumenty w tej kolekcji:</header>
</div>



<div class="row">
<?= $this->element('Dane.DataBrowser/browser-content', array(
	'displayAggs' => false,
	'app_chapters' => false,
	'forceHideAggs' => true,
	'beforeItemElement' => 'Dane.DataBrowser/checkbox',
)); ?>
</div>

<?= $this->element('Start.pageEnd'); ?>
