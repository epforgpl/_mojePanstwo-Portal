<?
$this->Combinator->add_libs('css', $this->Less->css('view-urzednicy_rejestr_korzysci', array('plugin' => 'Dane')));
echo $this->Element('dataobject/pageBegin');
?>

<?
if (isset($dokument_id)) {
    echo $this->Document->place($dokument_id);

} else { //html
    echo "<div id='rejestr-korzysci-html'>";
    echo $content_html;
    echo "</div>";
}
?>

<?= $this->Element('dataobject/pageEnd'); ?>