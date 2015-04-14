<?
$this->Combinator->add_libs('css', $this->Less->css('view-urzednicy_rejestr_korzysci', array('plugin' => 'Dane')));
echo $this->Element('dataobject/pageBegin');
?>

<?
if (isset($content_html)) {
    echo "<div id='rejestr-korzysci-html'>";
    echo $content_html;
    echo "</div>";
}

if (isset($dokument_id)) {
    echo $this->Document->place($dokument_id);
}
?>

<?= $this->Element('dataobject/pageEnd'); ?>