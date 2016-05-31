<? $this->Combinator->add_libs('css', $this->Less->css('collections-index', array('plugin' => 'Start'))); ?>

<?
	echo $this->Html->css($this->Less->css('app'));

	echo $this->element('headers/main');
	echo $this->element('app/sidebar');
?>


<div class="app-content-wrap">
    <div class="objectsPage">		
		
		<div class="container">
			
			<div class="overflow-auto">
				<h1 class="pull-left">Moje kolekcje</h1>
			</div>
			
		
			<div class="app-banner banner-collection">
				<p>Dzięki tej usłudze możesz kolekcjonować interesującę Cię dane. Stworzone przez Ciebie kolekcje możesz organizować i udostępniać publicznie.</p>
				<p><a href="#" data-toggle="modal" data-target="#createCollection">Stwórz nową kolekcję &raquo;</a></p>
			</div>
			
			<div class="modal fade" id="createCollection" tabindex="-1" role="dialog" aria-labelledby="createCollection">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="well bs-component mp-form margin-top-0 margin-bottom-0">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Stwórz nową kolekcję</h4>
							</div>
							<div class="modal-body padding-bottom-0 margin-bottom-0">
								<form action="/moje-kolekcje/nowe" class="form-horizontal" method="post">
									<fieldset>
										<div class="form-group">
											<label class="col-lg-3 control-label">Tytuł</label>
											<div class="col-lg-9">
												<input maxlength="195" type="text" class="form-control" id="collectionName" name="name"/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-3 control-label">Dodaj jako</label>
											<div class="col-lg-9">
												<select class="form-control" name="object_id">
													<option value="0">
														<?= AuthComponent::user('username') ?>
													</option>
													<? if(isset($objects)) {
														foreach($objects as $obj) { ?>
														<option value="<?= $obj['objects']['id'] ?>">
															<?= $obj['objects']['slug'] ?>
														</option>
													<? } } ?>
												</select>
											</div>
										</div>
										<div class="form-group form-row">
											<div class="col-lg-9 col-lg-offset-3">
												<button type="reset" data-dismiss="modal" class="btn btn-default">Anuluj</button>
			                                    <button type="submit" class="createBtn btn btn-md btn-primary btn-icon"><span
			                                            class="icon glyphicon glyphicon-pencil"></span>Stwórz kolekcje
												</button>
											</div>
										</div>
									</fieldset>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
					
		</div>
		
		<?= $this->element('Dane.DataBrowser/browser-content', array(
			'displayAggs' => false,
			'app_chapters' => false,
			'forceHideAggs' => true,
			'noResultsPhrase' => 'Nie stworzyłeś jeszcze żadnych kolekcji',
			'paginatorPhrases' => array('kolekcja', 'kolekcje', 'kolekcji'),
		)); ?>
		
    </div>
</div>