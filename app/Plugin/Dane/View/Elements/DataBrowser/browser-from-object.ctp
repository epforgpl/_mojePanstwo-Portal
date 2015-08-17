<?= $this->Element('dataobject/pageBegin'); ?>
<?
$params = array();
if (isset($DataBrowserTitle)) {
    $params['title'] = $DataBrowserTitle;
}
?>
<?= $this->Element('Dane.DataBrowser/browser', $params); ?>
<?= $this->Element('dataobject/pageEnd'); ?>