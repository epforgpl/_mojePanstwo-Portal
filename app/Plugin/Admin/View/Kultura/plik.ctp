<?
	$this->Combinator->add_libs('css', $this->Less->css('culture_tab', array('plugin' => 'Admin')));
	$this->Combinator->add_libs('js', 'Admin.culture_tab');
?>

<? echo $this->Element('headers/main'); ?>

<div id="_TAB">
	
	<div class="modal" id="modal-preview">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Podgląd</h4>
				</div>
				<div class="modal-body">
					
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
					<button type="button" class="btn btn-primary btn-save">Zapisz</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="header">
		<div class="row">
			<div class="col-md-10">
				<input class="form-control" name="title" type="text" />					
			</div><div class="col-md-2">
				<button id="btn-preview" type="button" class="btn btn-primary">Podgląd</button>
			</div>
		</div>
	</div>
	<div class="table">
		<?= $plik['culture_tabs']['html']; ?>
	</div>
</div>

</div>
</div>
</div>

<script type="text/javascript">
	var _tab_id = '<?= $plik['culture_tabs']['id'] ?>';
</script>