<?
	$this->Combinator->add_libs('css', $this->Less->css('finanse_opp', array('plugin' => 'Ngo')));
	$this->Combinator->add_libs('js', 'Ngo.finanse_opp');
	
	$aggs = $dataBrowser['aggs']['krs_podmioty']['sprawozdania_opp']['rocznik'];		
?>

</div></div>
	
	<div class="appBanner">
        <h1 class="appTitle">Finanse Organizacji Pożytku Publicznego</h1>
        <p class="appSubtitle">Sprawdź jakie przychody mają organizacje OPP w Polsce i jakie są ich źródła.</p>
    </div>
	
	<div id="rankModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
	
	<?= $this->element('finanse_opp/selectors'); ?>
	
	<div id="mp-sections">
	    
	    <? echo $this->element('finanse_opp/income', array('aggs' => $aggs)); ?>
	    <? echo $this->element('finanse_opp/outcome', array('aggs' => $aggs)); ?>
	    <? echo $this->element('finanse_opp/percent', array('aggs' => $aggs)); ?>
		
	</div>

<div><div>
	
<p class="main_msg">Liczba analizowanych sprawozdań: <b><?= $aggs['doc_count'] ?></b></p>
	
<div class="msg-link margin-top-40 margin-bottom-20">
	<p>Aplikacja powstała przy współpracy z <a href="http://www.mapa3sektora.org/" target="_blank">Strategiczną Mapą Drogową 3sektora</a>.</p>
	<a href="http://www.mapa3sektora.org/" target="_blank"><img style="width: 170px;" src="/img/dua.jpg" /></a>
</div>