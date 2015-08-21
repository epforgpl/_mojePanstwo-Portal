<?
$this->Combinator->add_libs('css', $this->Less->css('view-urzednicy_rejestr_korzysci', array('plugin' => 'Dane')));
echo $this->Element('dataobject/pageBegin');

if (isset($content_html)) {
    echo "<div id='rejestr-korzysci-html'>";
    echo $content_html;
    echo "</div>";
}

if (isset($dokument_id)) {
?>
<div class="row margin-top-10">
	<div class="col-md-9">
	    <?= $this->Document->place($dokument_id); ?>
	</div>
</div>
<?
}

echo $this->Element('dataobject/pageEnd');