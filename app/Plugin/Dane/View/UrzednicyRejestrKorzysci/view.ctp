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

if (isset($content_document)) {
    echo $this->Document->place($content_document);
}

?>

<?= $this->Element('dataobject/pageEnd'); ?>