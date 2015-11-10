<?php $this->Combinator->add_libs('js', 'Dane.bdl_opis'); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('bdl_opis', array('plugin' => 'Dane'))); ?>
<?php $this->Combinator->add_libs('js', 'Dane.bdl_useritem'); ?>

<div id="bdl_opis_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
   
            <div class="modal-body full">
                
                
				<div class="well bs-component mp-form">
					<form id="bdl_opis_form" action="<?= $object->getUrl() . '.json' ?>" method="post" class="form-horizontal">
						<input type="hidden" name="action" value="opis" />
						<fieldset>      
							<legend>Edytuj wskaźnik:</legend>
						
							<div class="form-group form-row">
								<label for="inp_nazwa" class="col-lg-12 control-label control-label-full">Nazwa</label>
								<div class="col-lg-12">
									<input id="inp_nazwa" type="text" class="form-control" name="nazwa" value="<?= $object->getData('bdl_wskazniki.tytul') ?>">
								</div>
							</div>
							
							<div class="form-group form-row">
								<label for="inp_opis" class="col-lg-12 control-label control-label-full">Opis</label>
								<div class="col-lg-12">
									<textarea class="form-control" rows="10" id="inp_opis" name="opis"></textarea>
								</div>
							</div>
							
							<div class="form-group form-row">
								<div class="col-lg-12">
									<button type="submit" class="btn btn-md btn-primary btn-icon" id="bdl_savebtn"><i
					                        class="icon glyphicon glyphicon-ok"></i>Zapisz
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



<div id="bdl_user_wskaznik_modal" class="modal fade">
    <div class="modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                <h4 class="modal-title">Dodaj do wskaźnika:</h4>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="hidden alert alert-success info"></div>
                    <div class="row">
                        <div class="col-sm-3">
                            <form><label class="pull-right">Wybierz wskaźnik: </label>
                        </div>
                        <div class="col-sm-9">
                            <select id="lista_wskaznikow" name="wskaznik" class="form-control">
                            </select>
                            </form>
                        </div>
                    </div>
                    <div class="row nazwa_wskaznika">
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="text-center">Licznik</h4>
                            <ul class="licznik_list skladniki_list list-group">

                            </ul>
                            <button type="button" class="btn btn-md btn-success btn-icon" id="bdl_temp_addbtn_l">
                                <i
                                    class="icon glyphicon glyphicon-plus"></i>Dodaj
                            </button>
                        </div>
                        <div class="col-sm-6">
                            <h4 class="text-center">Mianownik</h4>
                            <ul class="mianownik_list skladniki_list list-group">

                            </ul>
                            <button type="button" class="btn btn-md btn-success btn-icon" id="bdl_temp_addbtn_m">
                                <i
                                    class="icon glyphicon glyphicon-plus"></i>Dodaj
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-md btn-primary btn-icon btn-inline"
                            id="bdl_temp_savebtn"><i
                            class="icon glyphicon glyphicon-ok"></i>Zapisz
                    </button>
                    <div class="inline">
                        <a class="margintop" id="bdl_temp_cancelbtn" href="#">Anuluj</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
