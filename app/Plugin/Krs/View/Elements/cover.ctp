<?
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
$this->Combinator->add_libs('css', $this->Less->css('view-krs-graph', array('plugin' => 'Dane')));
// $this->Combinator->add_libs('js', 'Dane.view-krspodmioty');
$this->Combinator->add_libs('js', 'graph-krs');

echo $this->Html->css($this->Less->css('krs-cover', array('plugin' => 'Krs')));

$options = array(
    'mode' => 'init',
);
?>


<div class="alert alert-registry text-center mt-4">
	<h3 class="alert-heading">Szukasz danych z Krajowego Rejestru Sądowego?</h3>
    <p>Przenieśliśmy je na nasz nowy portal <a href="https://rejestr.io">Rejestr.io</a></p>
    <p><a href="https://rejestr.io"><img src="https://rejestr.io/img/logo.svg" /></a></p>
    <p><a href="https://rejestr.io">Przejdź do portalu Rejestr.io &raquo;</a></p>
</div>

