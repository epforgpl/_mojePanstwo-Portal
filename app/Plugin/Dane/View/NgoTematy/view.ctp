<?

echo $this->Element('dataobject/pageBegin');

$this->Combinator->add_libs('css', $this->Less->css('temat', array('plugin' => 'Ngo')));
$this->Combinator->add_libs('js', 'Ngo.temat');

?>

</div></div>

<div class="hello">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<hr />
				<p>Uchodźca - osoba, która musiała opuścić teren, na którym mieszkała ze względu na zagrożenie życia, zdrowia, bądź wolności. Zagrożenie to jest najczęściej związane z walkami zbrojnymi, klęskami żywiołowymi, prześladowaniami religijnymi bądź z powodu rasy lub przekonań politycznych.</p>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="objectsPageContent main"
	
	

<?= $this->Element('dataobject/pageEnd'); ?>
